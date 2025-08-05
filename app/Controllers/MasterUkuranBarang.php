<?php

namespace App\Controllers;

use App\Models\MasterUkuranBarangModel;
use CodeIgniter\Controller;

class MasterUkuranBarang extends Controller
{
    protected $masterUkuranBarangModel;
    protected $db2;
    public function __construct()
    {
        $this->masterUkuranBarangModel = new MasterUkuranBarangModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $model = $this->masterUkuranBarangModel;
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['ukuranbarang'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Ukuran Barang';
        return view('master_ukuranbarang/index', $data);
    }
    public function create()
    {
        return view('master_ukuranbarang/create');
    }
    public function save()
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterUkuranBarangModel->insert($data);
        $id = $this->masterUkuranBarangModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('ukuran_barang')->insert($dataDb2);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $ukuranbarang = $this->masterUkuranBarangModel->find($id);
        if (!$ukuranbarang || $ukuranbarang['deleted_at'] || ($ukuranbarang['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/masterukuranbarang')->with('error', 'Tidak memiliki otoritas untuk edit data ini.');
        }
        $data = [
            'ukuranbarang' => $ukuranbarang
        ];
        return view('master_ukuranbarang/edit', $data);
    }

    public function update($id)
    {
        $ukuranbarang = $this->masterUkuranBarangModel->find($id);
        if (!$ukuranbarang || $ukuranbarang['deleted_at'] || ($ukuranbarang['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/masterukuranbarang')->with('error', 'Tidak memiliki otoritas untuk edit data ini.');
        }
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterUkuranBarangModel->update($id, $data);
        $this->db2->table('ukuran_barang')->where('id', $id)->update($data);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $ukuranbarang = $this->masterUkuranBarangModel->find($id);
        if (!$ukuranbarang || $ukuranbarang['deleted_at'] || ($ukuranbarang['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/masterukuranbarang')->with('error', 'Tidak memiliki otoritas untuk hapus data ini.');
        }
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterUkuranBarangModel->update($id, $data);
        $this->db2->table('ukuran_barang')->where('id', $id)->update($data);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil dihapus.');
    }
}
