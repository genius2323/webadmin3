<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;

class Penjualan extends BaseController
{
    // ...existing code...

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
        } catch (\Throwable $e) {}
        return $this->response->setJSON(['success' => true]);
    }

    public function delete($id)
    {
        // Soft delete di database utama
        $this->penjualanModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        // Soft delete di database kedua
        $db2 = \Config\Database::connect('db2');
        $db2->table('sales')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        session()->setFlashdata('success', 'Data penjualan berhasil dihapus (soft delete) di dua database.');
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
        $customerModel = new \App\Models\MasterCustomerModel();
        $salesModel = new \App\Models\MasterSalesModel();
        $systemDateLimitsModel = new \App\Models\SystemDateLimitsModel();
        $batas = $systemDateLimitsModel->where('menu', 'penjualan')->orderBy('id', 'desc')->first();
        $batas_tanggal_sistem = $batas['batas_tanggal'] ?? '';
        $mode_batas_tanggal = $batas['mode_batas_tanggal'] ?? 'manual';
        $data = [
            'title' => 'Daftar Penjualan',
            'penjualan' => $this->penjualanModel->findAll(),
            'nomor_nota' => $nomor_nota,
            'customers' => $customerModel->findAll(),
            'sales' => $salesModel->findAll(),
            'batas_tanggal_sistem' => $batas_tanggal_sistem,
            'mode_batas_tanggal' => $mode_batas_tanggal,
        ];
        return view('penjualan/index', $data);
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

            session()->setFlashdata('success', 'Data penjualan berhasil dibuat di dua database. Silakan tambahkan rincian barang.');
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
}
