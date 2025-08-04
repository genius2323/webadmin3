<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MasterBarangModel;

class MasterBarang extends BaseController
{
    public function index()
    {
        $model = new MasterBarangModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model
            ->select('products.*, categories.name as category_name, satuan.name as satuan_name, jenis.name as jenis_name, merk.name as merk_name, daya.name as daya_name, dimensi.name as dimensi_name, fiting.name as fiting_name, gondola.name as gondola_name, jumlah_mata.name as jumlah_mata_name, kaki.name as kaki_name, model.name as model_name, pelengkap.name as pelengkap_name, ukuran_barang.name as ukuran_barang_name, voltase.name as voltase_name, warna_bibir.name as warna_bibir_name, warna_body.name as warna_body_name, warna_sinar.name as warna_sinar_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('satuan', 'satuan.id = products.satuan_id', 'left')
            ->join('jenis', 'jenis.id = products.jenis_id', 'left')
            ->join('merk', 'merk.id = products.merk_id', 'left')
            ->join('daya', 'daya.id = products.daya_id', 'left')
            ->join('dimensi', 'dimensi.id = products.dimensi_id', 'left')
            ->join('fiting', 'fiting.id = products.fiting_id', 'left')
            ->join('gondola', 'gondola.id = products.gondola_id', 'left')
            ->join('jumlah_mata', 'jumlah_mata.id = products.jumlah_mata_id', 'left')
            ->join('kaki', 'kaki.id = products.kaki_id', 'left')
            ->join('model', 'model.id = products.model_id', 'left')
            ->join('pelengkap', 'pelengkap.id = products.pelengkap_id', 'left')
            ->join('ukuran_barang', 'ukuran_barang.id = products.ukuran_barang_id', 'left')
            ->join('voltase', 'voltase.id = products.voltase_id', 'left')
            ->join('warna_bibir', 'warna_bibir.id = products.warna_bibir_id', 'left')
            ->join('warna_body', 'warna_body.id = products.warna_body_id', 'left')
            ->join('warna_sinar', 'warna_sinar.id = products.warna_sinar_id', 'left')
            ->where('products.deleted_at', null);
        if ($search) {
            $builder = $builder->groupStart()
                ->like('products.name', $search)
                ->orLike('categories.name', $search)
                ->orLike('satuan.name', $search)
                ->orLike('jenis.name', $search)
                ->groupEnd();
        }
        $products = $builder->paginate($perPage);
        $pager = $model->pager;
        return view('masterbarang/index', [
            'products' => $products,
            'pager' => $pager,
            'perPage' => $perPage,
            'search' => $search,
            'title' => 'Master Barang',
        ]);
    }
    public function create()
    {
        $categoryList = model('App\\Models\\MasterKategoriModel')->findAll();
        $satuanList = model('App\\Models\\MasterSatuanModel')->findAll();
        $jenisList = model('App\\Models\\MasterJenisModel')->findAll();
        $klasifikasiModels = [
            'pelengkap' => 'App\\Models\\MasterPelengkapModel',
            'gondola' => 'App\\Models\\MasterGondolaModel',
            'merk' => 'App\\Models\\MasterMerkModel',
            'warna_sinar' => 'App\\Models\\MasterWarnaSinarModel',
            'ukuran_barang' => 'App\\Models\\MasterUkuranBarangModel',
            'voltase' => 'App\\Models\\MasterVoltaseModel',
            'dimensi' => 'App\\Models\\MasterDimensiModel',
            'warna_body' => 'App\\Models\\MasterWarnaBodyModel',
            'warna_bibir' => 'App\\Models\\MasterWarnaBibirModel',
            'kaki' => 'App\\Models\\MasterKakiModel',
            'model' => 'App\\Models\\MasterModelModel',
            'fiting' => 'App\\Models\\MasterFitingModel',
            'daya' => 'App\\Models\\MasterDayaModel',
            'jumlah_mata' => 'App\\Models\\MasterJumlahMataModel',
        ];
        $klasifikasiData = [];
        foreach ($klasifikasiModels as $key => $modelClass) {
            $klasifikasiData[$key] = model($modelClass)->findAll();
        }
        return view('masterbarang/create', [
            'categoryList' => $categoryList,
            'satuanList' => $satuanList,
            'jenisList' => $jenisList,
            'klasifikasiData' => $klasifikasiData,
        ]);
    }

    public function store()
    {
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';
        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'satuan_id' => $this->request->getPost('satuan_id'),
            'jenis_id' => $this->request->getPost('jenis_id'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'nama_ky' => $nama_ky,
        ];
        $klasifikasi = [
            'pelengkap_id', 'gondola_id', 'merk_id', 'warna_sinar_id', 'ukuran_barang_id', 'voltase_id', 'dimensi_id',
            'warna_body_id', 'warna_bibir_id', 'kaki_id', 'model_id', 'fiting_id', 'daya_id', 'jumlah_mata_id'
        ];
        foreach ($klasifikasi as $field) {
            $val = $this->request->getPost($field);
            if ($val) $data[$field] = $val;
        }
        $model = new \App\Models\MasterBarangModel();
        $model->insert($data);
        $id = $model->getInsertID();
        // Update nama_ky jika belum tersimpan (CodeIgniter kadang tidak simpan field custom di insert)
        $model->update($id, ['nama_ky' => $nama_ky]);
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2 = \Config\Database::connect('db2');
        $exists = $db2->table('products')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('products')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('products')->insert($dataDb2);
        }
        return redirect()->to(site_url('masterbarang'))->with('success', 'Barang berhasil ditambahkan di dua database.');
    }

    public function edit($id)
    {
        $model = new \App\Models\MasterBarangModel();
        $barang = $model->find($id);
        if (!$barang) {
            return redirect()->to(site_url('masterbarang'))->with('error', 'Data barang tidak ditemukan.');
        }
        $categoryList = model('App\\Models\\MasterKategoriModel')->findAll();
        $satuanList = model('App\\Models\\MasterSatuanModel')->findAll();
        $jenisList = model('App\\Models\\MasterJenisModel')->findAll();
        $klasifikasiModels = [
            'pelengkap' => 'App\\Models\\MasterPelengkapModel',
            'gondola' => 'App\\Models\\MasterGondolaModel',
            'merk' => 'App\\Models\\MasterMerkModel',
            'warna_sinar' => 'App\\Models\\MasterWarnaSinarModel',
            'ukuran_barang' => 'App\\Models\\MasterUkuranBarangModel',
            'voltase' => 'App\\Models\\MasterVoltaseModel',
            'dimensi' => 'App\\Models\\MasterDimensiModel',
            'warna_body' => 'App\\Models\\MasterWarnaBodyModel',
            'warna_bibir' => 'App\\Models\\MasterWarnaBibirModel',
            'kaki' => 'App\\Models\\MasterKakiModel',
            'model' => 'App\\Models\\MasterModelModel',
            'fiting' => 'App\\Models\\MasterFitingModel',
            'daya' => 'App\\Models\\MasterDayaModel',
            'jumlah_mata' => 'App\\Models\\MasterJumlahMataModel',
        ];
        $klasifikasiData = [];
        foreach ($klasifikasiModels as $key => $modelClass) {
            $klasifikasiData[$key] = model($modelClass)->findAll();
        }
        $klasifikasi = [
            'pelengkap' => 'Pelengkap',
            'gondola' => 'Gondola',
            'merk' => 'Merk',
            'warna_sinar' => 'Warna Sinar',
            'ukuran_barang' => 'Ukuran Barang',
            'voltase' => 'Voltase',
            'dimensi' => 'Dimensi',
            'warna_body' => 'Warna Body',
            'warna_bibir' => 'Warna Bibir',
            'kaki' => 'Kaki',
            'model' => 'Model',
            'fiting' => 'Fiting',
            'daya' => 'Daya',
            'jumlah_mata' => 'Jumlah Mata',
        ];
        return view('masterbarang/edit', [
            'barang' => $barang,
            'categoryList' => $categoryList,
            'satuanList' => $satuanList,
            'jenisList' => $jenisList,
            'klasifikasiData' => $klasifikasiData,
            'klasifikasi' => $klasifikasi,
        ]);
    }

    public function update($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';
        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'satuan_id' => $this->request->getPost('satuan_id'),
            'jenis_id' => $this->request->getPost('jenis_id'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'nama_ky' => $nama_ky,
        ];
        $klasifikasi = [
            'pelengkap_id', 'gondola_id', 'merk_id', 'warna_sinar_id', 'ukuran_barang_id', 'voltase_id', 'dimensi_id',
            'warna_body_id', 'warna_bibir_id', 'kaki_id', 'model_id', 'fiting_id', 'daya_id', 'jumlah_mata_id'
        ];
        foreach ($klasifikasi as $field) {
            $val = $this->request->getPost($field);
            $data[$field] = $val;
        }
        $model = new \App\Models\MasterBarangModel();
        $model->update($id, $data);
        // Pastikan nama_ky juga tersimpan setelah update
        $model->update($id, ['nama_ky' => $nama_ky]);
        $db2 = \Config\Database::connect('db2');
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $exists = $db2->table('products')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('products')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('products')->insert($dataDb2);
        }
        return redirect()->to(site_url('masterbarang'))->with('success', 'Barang berhasil diupdate di dua database.');
    }

    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama') ?? $session->get('user_username') ?? $session->get('nama') ?? $session->get('username') ?? 'unknown';
        $model = new \App\Models\MasterBarangModel();
        $model->delete($id); // soft delete di database utama
        // Update nama_ky setelah soft delete (karena soft delete CodeIgniter tidak update kolom lain)
        $model->update($id, ['nama_ky' => $nama_ky]);
        $db2 = \Config\Database::connect('db2');
        $deletedAt = date('Y-m-d H:i:s');
        $db2->table('products')->where('id', $id)->update([
            'deleted_at' => $deletedAt,
            'nama_ky' => $nama_ky
        ]);
        return redirect()->to(site_url('masterbarang'))->with('success', 'Barang berhasil dihapus di dua database.');
    }
}
