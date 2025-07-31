<?php

namespace App\Controllers;

use App\Models\MasterDimensiModel;
use CodeIgniter\Controller;

class MasterDimensi extends Controller
{
    protected $masterDimensiModel;
    protected $db2;
    public function __construct()
    {
        $this->masterDimensiModel = new MasterDimensiModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $this->masterDimensiModel->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['dimensi'] = $builder->paginate($perPage);
        $data['pager'] = $this->masterDimensiModel->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Dimensi';
        return view('master_dimensi/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Dimensi'
        ];
        return view('master_dimensi/create', $data);
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
        $this->masterDimensiModel->insert($data);
        $id = $this->masterDimensiModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('dimensi')->insert($dataDb2);
        return redirect()->to('/masterdimensi')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'dimensi' => $this->masterDimensiModel->find($id),
            'title' => 'Edit Dimensi'
        ];
        return view('master_dimensi/edit', $data);
    }
    public function update($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterDimensiModel->update($id, $data);
        $this->db2->table('dimensi')->where('id', $id)->update($data);
        return redirect()->to('/masterdimensi')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterDimensiModel->update($id, $data);
        $this->db2->table('dimensi')->where('id', $id)->update($data);
        return redirect()->to('/masterdimensi')->with('success', 'Data berhasil dihapus.');
    }
}
