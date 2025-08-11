<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;

class Penjualan extends BaseController
{
    // AJAX endpoint untuk pembayaran tunai
    public function paymentTunai($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        $penjualan = $this->penjualanModel->find($id);
        if (!$penjualan) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Data penjualan tidak ditemukan']);
        }
        $json = $this->request->getJSON();
        $uangTunai = (float)($json->uang_tunai ?? 0);
        $kembalian = (string)($json->kembalian ?? '');
        $total = (float)($json->total ?? 0);
        // Update kolom payment_a, payment_system, account_receivable, grand_total
        $updateData = [
            'payment_a' => $uangTunai,
            'payment_system' => 'tunai',
            'account_receivable' => 0,
            'grand_total' => $total,
        ];
        $this->penjualanModel->update($id, $updateData);
        // Jika ada db2, update juga
        try {
            $db2 = \Config\Database::connect('db2');
            $db2->table('sales')->where('id', $id)->update($updateData);
        } catch (\Throwable $e) {
        }
        return $this->response->setJSON(['success' => true]);
    }

    public function delete($id)
    {
        // Soft delete di database utama
        $this->penjualanModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        // Soft delete di database kedua
        $db2 = \Config\Database::connect('db2');
        $db2->table('sales')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        session()->setFlashdata('success', 'Data penjualan berhasil dihapus (soft delete).');
        return redirect()->to('/datapenjualan');
    }
    public function datapenjualan()
    {
        $keyword = $this->request->getGet('keyword');
        $penjualan = $this->penjualanModel->getData($keyword);
        $data = [
            'title' => 'Data Penjualan',
            'penjualan' => $penjualan,
        ];
        return view('penjualan/datapenjualan', $data);
    }
    protected $penjualanModel;

    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
    }

    public function index()
    {
        $nomor_nota = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        $db = \Config\Database::connect();
        $customerList = $db->table('mastercustomer c')
            ->select('c.*, s.id as sales_id, s.nama as sales_nama')
            ->join('mastersales s', 's.id = c.sales', 'left')
            ->where('c.deleted_at', null)
            ->get()->getResultArray();
        $salesList = $db->table('mastersales')->where('deleted_at', null)->get()->getResultArray();
        $systemDateLimitsModel = new \App\Models\SystemDateLimitsModel();
        $batas = $systemDateLimitsModel->where('menu', 'penjualan')->orderBy('id', 'desc')->first();
        $batas_tanggal_sistem = $batas['batas_tanggal'] ?? '';
        $mode_batas_tanggal = $batas['mode_batas_tanggal'] ?? 'manual';
        $data = [
            'title' => 'Daftar Penjualan',
            'penjualan' => $this->penjualanModel->findAll(),
            'nomor_nota' => $nomor_nota,
            'customerList' => $customerList,
            'salesList' => $salesList,
            'batas_tanggal_sistem' => $batas_tanggal_sistem,
            'mode_batas_tanggal' => $mode_batas_tanggal,
        ];
        return view('penjualan/pos', $data);
    }

    public function new()
    {
        $nomor_nota = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));

        $data = [
            'title' => 'Tambah Penjualan',
            'nomor_nota' => $nomor_nota,
        ];
        return view('penjualan/form', $data);
    }

    public function create()
    {
        $rules = [
            'tanggal_nota' => 'required',
            'nomor_nota'   => 'required|is_unique[sales.nomor_nota]',
            'customer'     => 'required|string|max_length[100]',
            'sales'        => 'required|string|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $tanggal_nota_db = \DateTime::createFromFormat('d/m/Y', $this->request->getPost('tanggal_nota'))->format('Y-m-d');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Format tanggal tidak valid.');
        }

        $data = [
            'nomor_nota'   => $this->request->getPost('nomor_nota'),
            'tanggal_nota' => $tanggal_nota_db,
            'customer'     => $this->request->getPost('customer'),
            'sales'        => $this->request->getPost('sales'),
            'status'       => 'draft',
            'grand_total'  => 0,
            'nama_ky'      => session('user_nama'),
        ];

        $penjualanId = $this->penjualanModel->insert($data, true);

        if ($penjualanId) {
            // Simpan juga ke database kedua (db2)
            $db2 = \Config\Database::connect('db2');
            $dataDb2 = $data;
            $dataDb2['id'] = $penjualanId;
            $db2->table('sales')->insert($dataDb2);

            session()->setFlashdata('success', 'Data penjualan berhasil dibuat. Silakan tambahkan rincian barang.');
            return redirect()->to('/penjualan/detail/' . $penjualanId);
        }

        session()->setFlashdata('error', 'Gagal menyimpan data penjualan.');
        return redirect()->back()->withInput();
    }

    public function detail($id)
    {
        $penjualan = $this->penjualanModel->find($id);
        if (!$penjualan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data penjualan tidak ditemukan.');
        }
        $items = [];
        // Ambil data master barang
        $masterBarangModel = new \App\Models\MasterBarangModel();
        $masterBarang = $masterBarangModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.deleted_at', null)
            ->findAll();
        $data = [
            'title' => 'Detail Penjualan: ' . $penjualan['nomor_nota'],
            'penjualan' => $penjualan,
            'items' => $items,
            'masterBarang' => $masterBarang,
        ];

        return view('penjualan/detail', $data);
    }



    public function finalize($penjualanId)
    {
        $penjualan = $this->penjualanModel->find($penjualanId);

        if ($penjualan && $penjualan['status'] === 'draft') {
            if ($this->penjualanModel->update($penjualanId, ['status' => 'completed'])) {
                session()->setFlashdata('success', 'Penjualan telah diselesaikan.');
            } else {
                session()->setFlashdata('error', 'Gagal menyelesaikan penjualan.');
            }
        } else {
            session()->setFlashdata('error', 'Penjualan tidak ditemukan atau sudah diselesaikan.');
        }

        return redirect()->to('/penjualan/detail/' . $penjualanId);
    }

    // --- POS SBAdmin ---
    public function pos()
    {
        // Ambil data sales, customer, barang, dan batas tanggal
        $db = \Config\Database::connect();
        $salesList = $db->table('mastersales')->where('deleted_at', null)->get()->getResultArray();
        $customerList = $db->table('mastercustomer c')
            ->select('c.*, s.id as sales_id, s.nama as sales_nama')
            ->join('mastersales s', 's.kode = c.sales', 'left')
            ->where('c.deleted_at', null)
            ->get()->getResultArray();
        $barangList = $db->table('products')->where('deleted_at', null)->get()->getResultArray();
        $batasTanggal = model('App\Models\SystemDateLimitsModel')->getBatasTanggal();
        return view('penjualan/pos', [
            'salesList' => $salesList,
            'customerList' => $customerList,
            'barangList' => $barangList,
            'batasTanggal' => $batasTanggal,
        ]);
    }

    public function posBooking()
    {
        $db = \Config\Database::connect();
        $db2 = \Config\Database::connect('db2');
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';
        $data = [
            'nomor_nota'   => $this->request->getPost('nomor_nota'),
            'tanggal_nota' => $this->request->getPost('tanggal_nota'),
            'sales'        => $this->request->getPost('sales_id'),
            'customer'     => $this->request->getPost('customer_id'),
            'payment_system' => $this->request->getPost('metode_bayar'),
            'status'       => 'booking',
            'otoritas'     => null,
            'nama_ky'      => $nama_ky,
        ];
        $salesModel = new \App\Models\SalesModel();
        $salesId = $salesModel->insert($data, true);
        if (!$salesId) {
            return redirect()->back()->with('error', 'Gagal menyimpan data penjualan.');
        }
        // Simpan ke db2
        $dataDb2 = $data;
        $dataDb2['id'] = $salesId;
        $db2->table('sales')->insert($dataDb2);

        // Simpan item hanya jika salesId valid
        $barangIds = $this->request->getPost('barang_id');
        $qtys = $this->request->getPost('qty');
        $barangModel = new \App\Models\MasterBarangModel();
        $salesItemModel = new \App\Models\SalesItemsModel();
        for ($i = 0; $i < count($barangIds); $i++) {
            $barang = $barangModel->find($barangIds[$i]);
            if (!$barang) continue;
            $item = [
                'sales_id'     => $salesId,
                'product_id'   => $barang['id'],
                'product_code' => $barang['kode_barang'] ?? '',
                'product_name' => $barang['name'],
                'qty'          => $qtys[$i],
                'unit'         => $barang['satuan_name'] ?? '',
                'price'        => $barang['price'],
                'discount'     => 0,
                'total'        => $barang['price'] * $qtys[$i],
                'nama_ky'      => $nama_ky,
            ];
            $itemId = $salesItemModel->insert($item, true);
            if ($itemId) {
                // Simpan ke db2 dengan id item yang sama (opsional, atau biarkan auto-increment di db2)
                $itemDb2 = $item;
                $itemDb2['id'] = $itemId;
                $itemDb2['sales_id'] = $salesId; // asumsikan id sales sama di db2
                $db2->table('sales_items')->insert($itemDb2);
            }
        }
        return redirect()->to('penjualan/detail/' . $salesId)->with('success', 'Nota berhasil dibooking!');
    }
}
