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
        // Sinkronisasi status otomatis sebelum ambil data        
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
            ->join('mastersales s', 's.id = c.sales_id', 'left')
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
        $nomor_nota = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        $tanggal_nota = date('Y-m-d');
        // Insert nomor nota ke database dengan status draft
        $salesModel = new \App\Models\SalesModel();
        $draftData = [
            'nomor_nota' => $nomor_nota,
            'tanggal_nota' => $tanggal_nota,
            'status' => 'draft',
        ];
        // Simpan draft nota ke database tanpa validasi field wajib
        $salesModel->skipValidation(true);
        $draftId = $salesModel->insert($draftData);
        $salesModel->skipValidation(false);
        if (!$draftId) {
            $errorMsg = $salesModel->errors() ? json_encode($salesModel->errors()) : 'Gagal insert draft nota.';
            file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "CREATE-ERROR: " . $errorMsg . "\n", FILE_APPEND);
            return redirect()->back()->with('error', 'Gagal menyimpan draft nota: ' . $errorMsg);
        }
        $db = \Config\Database::connect();
        $db2 = \Config\Database::connect('db2');
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';

        $barangIds = $this->request->getPost('barang_id');
        $qtys = $this->request->getPost('qty');
        $barangModel = new \App\Models\MasterBarangModel();
        $total = 0;
        $items = [];
        for ($i = 0; $i < count($barangIds); $i++) {
            $barang = $barangModel->find($barangIds[$i]);
            $subtotal = $barang ? $barang['price'] * $qtys[$i] : 0;
            $total += $subtotal;
            $items[] = [
                'product_id'   => $barangIds[$i],
                'product_code' => $barang['kode_barang'] ?? '',
                'product_name' => $barang['name'] ?? '',
                'qty'          => $qtys[$i],
                'unit'         => $barang['satuan_name'] ?? '',
                'price'        => $barang['price'] ?? 0,
                'discount'     => 0,
                'total'        => $subtotal
            ];
        }
        $grand_total = $total;
        $tanggal_nota = $this->request->getPost('tanggal_nota');
        if (strpos($tanggal_nota, '/') !== false) {
            $tanggal_nota = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_nota)));
        }
        $nomor_nota = $this->request->getPost('nomor_nota');
        $sales_id = $this->request->getPost('sales_id');
        if (empty($sales_id)) {
            $sales_id = $this->request->getPost('sales');
        }
        $customer_id = $this->request->getPost('customer_id');
        if (empty($customer_id)) {
            $customer_id = $this->request->getPost('customer');
        }
        $metode_bayar = $this->request->getPost('metode_bayar');
        $barang_valid = is_array($barangIds) && count(array_filter($barangIds)) > 0;
        $status = (!empty($nomor_nota) && !empty($tanggal_nota) && !empty($sales_id) && !empty($customer_id) && !empty($metode_bayar) && $barang_valid) ? 'selesai' : 'draft';
        $data = [
            'nomor_nota'      => !empty($nomor_nota) ? $nomor_nota : null,
            'tanggal_nota'    => !empty($tanggal_nota) ? $tanggal_nota : null,
            'sales'           => !empty($sales_id) ? $sales_id : null,
            'customer'        => !empty($customer_id) ? $customer_id : null,
            'payment_system'  => $metode_bayar,
            'metode_bayar'    => $metode_bayar,
            'tenor'           => !empty($this->request->getPost('tenor')) ? $this->request->getPost('tenor') : null,
            'dp'              => !empty($this->request->getPost('dp')) ? $this->request->getPost('dp') : null,
            'catatan_kredit'  => $this->request->getPost('catatan_kredit'),
            'total'           => !empty($total) ? $total : null,
            'grand_total'     => !empty($grand_total) ? $grand_total : null,
            'status'          => $status,
            'otoritas'        => null,
            'nama_ky'         => $nama_ky,
        ];
        // Patch otomatis untuk semua field integer dan tanggal di item
        foreach ($items as &$item) {
            $item['product_id'] = !empty($item['product_id']) ? $item['product_id'] : null;
            $item['qty'] = !empty($item['qty']) ? $item['qty'] : null;
            $item['price'] = !empty($item['price']) ? $item['price'] : null;
            $item['discount'] = !empty($item['discount']) ? $item['discount'] : null;
            $item['total'] = !empty($item['total']) ? $item['total'] : null;
            if (isset($item['tanggal']) && $item['tanggal'] === '') {
                $item['tanggal'] = null;
            }
        }
        // Patch otomatis untuk semua field integer di item
        foreach ($items as &$item) {
            $item['product_id'] = !empty($item['product_id']) ? $item['product_id'] : null;
            $item['qty'] = !empty($item['qty']) ? $item['qty'] : null;
            $item['price'] = !empty($item['price']) ? $item['price'] : null;
            $item['discount'] = !empty($item['discount']) ? $item['discount'] : null;
            $item['total'] = !empty($item['total']) ? $item['total'] : null;
        }
        // Logging untuk debug status
        file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "DB1: " . json_encode($data) . "\n", FILE_APPEND);
        $salesModel = new \App\Models\SalesModel();
        $salesId = $salesModel->insert($data, true);
        // Pastikan status di DB1 benar
        if ($data['status'] === 'selesai') {
            $db->table('sales')->where('id', $salesId)->update(['status' => 'selesai']);
        }
        // Simpan ke db2
        $dataDb2 = $data;
        $dataDb2['id'] = $salesId;
        file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "DB2: " . json_encode($dataDb2) . "\n", FILE_APPEND);
        $db2->table('sales')->insert($dataDb2);

        // Simpan item
        $salesItemModel = new \App\Models\SalesItemsModel();
        foreach ($items as $item) {
            $item['sales_id'] = $salesId;
            $itemId = $salesItemModel->insert($item, true);
            if ($itemId) {
                $itemDb2 = $item;
                $itemDb2['id'] = $itemId;
                $itemDb2['sales_id'] = $salesId;
                $db2->table('sales_items')->insert($itemDb2);
            }
        }
        // Redirect ke halaman data penjualan
        return redirect()->to('/datapenjualan')->with('success', 'Nota berhasil disimpan!');
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

        if ($penjualan && strtolower($penjualan['status']) === 'draft') {
            $updateStatus = ['status' => 'selesai'];
            $this->penjualanModel->update($penjualanId, $updateStatus);
            // Update juga di db2
            $db2 = \Config\Database::connect('db2');
            $db2->table('sales')->where('id', $penjualanId)->update($updateStatus);
            session()->setFlashdata('success', 'Penjualan telah diselesaikan.');
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
            ->join('mastersales s', 's.id = c.sales_id', 'left')
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
        $nomor_nota = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        $tanggal_nota = date('Y-m-d');
        // Insert nomor nota ke database dengan status draft
        $salesModel = new \App\Models\SalesModel();
        $draftData = [
            'nomor_nota' => $nomor_nota,
            'tanggal_nota' => $tanggal_nota,
            'status' => 'draft',
        ];
        $db = \Config\Database::connect();
        $db2 = \Config\Database::connect('db2');
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';

        // Ambil data dari form tanpa validasi tambahan
        $barangIds = $this->request->getPost('barang_id');
        $qtys = $this->request->getPost('qty');
        $barangModel = new \App\Models\MasterBarangModel();
        $total = 0;
        $items = [];
        for ($i = 0; $i < count($barangIds); $i++) {
            $barang = $barangModel->find($barangIds[$i]);
            $subtotal = $barang ? $barang['price'] * $qtys[$i] : 0;
            $total += $subtotal;
            $items[] = [
                'product_id'   => $barangIds[$i],
                'product_code' => $barang['kode_barang'] ?? '',
                'product_name' => $barang['name'] ?? '',
                'qty'          => $qtys[$i],
                'unit'         => $barang['satuan_name'] ?? '',
                'price'        => $barang['price'] ?? 0,
                'discount'     => 0,
                'total'        => $subtotal
            ];
        }
        $grand_total = $total;
        // Format tanggal ke Y-m-d jika perlu
        $tanggal_nota = $this->request->getPost('tanggal_nota');
        if (strpos($tanggal_nota, '/') !== false) {
            $tanggal_nota = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_nota)));
        }
        $nomor_nota = $this->request->getPost('nomor_nota');
        $tanggal_nota = $tanggal_nota;
        $sales_id = $this->request->getPost('sales_id');
        $customer_id = $this->request->getPost('customer_id');
        $metode_bayar = $this->request->getPost('metode_bayar');
        $barang_valid = is_array($barangIds) && count($barangIds) > 0;
        $status = (!empty($nomor_nota) && !empty($tanggal_nota) && !empty($sales_id) && !empty($customer_id) && !empty($metode_bayar) && $barang_valid) ? 'selesai' : 'draft';
        $data = [
            'nomor_nota'      => !empty($nomor_nota) ? $nomor_nota : null,
            'tanggal_nota'    => !empty($tanggal_nota) ? $tanggal_nota : null,
            'sales'           => !empty($sales_id) ? $sales_id : null,
            'customer'        => !empty($customer_id) ? $customer_id : null,
            'payment_system'  => $metode_bayar,
            'metode_bayar'    => $metode_bayar,
            'tenor'           => !empty($this->request->getPost('tenor')) ? $this->request->getPost('tenor') : null,
            'dp'              => !empty($this->request->getPost('dp')) ? $this->request->getPost('dp') : null,
            'catatan_kredit'  => $this->request->getPost('catatan_kredit'),
            'total'           => !empty($total) ? $total : null,
            'grand_total'     => !empty($grand_total) ? $grand_total : null,
            'status'          => $status,
            'otoritas'        => null,
            'nama_ky'         => $nama_ky,
        ];
        // Patch otomatis untuk semua field integer dan tanggal di item
        foreach ($items as &$item) {
            $item['product_id'] = !empty($item['product_id']) ? $item['product_id'] : null;
            $item['qty'] = !empty($item['qty']) ? $item['qty'] : null;
            $item['price'] = !empty($item['price']) ? $item['price'] : null;
            $item['discount'] = !empty($item['discount']) ? $item['discount'] : null;
            $item['total'] = !empty($item['total']) ? $item['total'] : null;
            if (isset($item['tanggal']) && $item['tanggal'] === '') {
                $item['tanggal'] = null;
            }
        }
        // Logging untuk debug status
        file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "POS-DB1: " . json_encode($data) . "\n", FILE_APPEND);
        $salesModel = new \App\Models\SalesModel();
        $salesId = $salesModel->insert($data, true);
        if (!$salesId) {
            $errorMsg = $salesModel->errors() ? json_encode($salesModel->errors()) : 'Gagal insert draft nota.';
            file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "POS-ERROR: " . $errorMsg . "\n", FILE_APPEND);
            return redirect()->back()->with('error', 'Gagal menyimpan draft nota: ' . $errorMsg);
        }
        // Pastikan status di DB1 benar
        if ($data['status'] === 'selesai') {
            $db->table('sales')->where('id', $salesId)->update(['status' => 'selesai']);
        }
        // Simpan ke db2
        $dataDb2 = $data;
        $dataDb2['id'] = $salesId;
        file_put_contents(ROOTPATH . 'writable/logs/penjualan_status.log', "POS-DB2: " . json_encode($dataDb2) . "\n", FILE_APPEND);
        $db2->table('sales')->insert($dataDb2);

        // Simpan item
        $salesItemModel = new \App\Models\SalesItemsModel();
        foreach ($items as $item) {
            $item['sales_id'] = $salesId;
            $itemId = $salesItemModel->insert($item, true);
            if ($itemId) {
                $itemDb2 = $item;
                $itemDb2['id'] = $itemId;
                $itemDb2['sales_id'] = $salesId;
                $db2->table('sales_items')->insert($itemDb2);
            }
        }
        // Redirect ke halaman data penjualan
        return redirect()->to('/datapenjualan')->with('success', 'Nota berhasil disimpan!');
    }
}
