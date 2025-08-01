<?php

namespace App\Controllers;

use App\Models\MasterWarnaSinarModel;
use CodeIgniter\Controller;

class MasterWarnaSinar extends Controller
{
    protected $masterWarnaSinarModel;
    protected $db2;
    public function __construct()
    {
        $this->masterWarnaSinarModel = new MasterWarnaSinarModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $search = $this->request->getGet('search') ?? $this->request->getGet('keyword');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $this->masterWarnaSinarModel->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['warnasinar'] = $builder->paginate($perPage);
        $data['pager'] = $this->masterWarnaSinarModel->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Warna Sinar';
        return view('master_warnasinar/index', $data);
    }
    public function create()
    {
        return view('master_warnasinar/create');
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
        $this->masterWarnaSinarModel->insert($data);
        $id = $this->masterWarnaSinarModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('warna_sinar')->insert($dataDb2);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'warnasinar' => $this->masterWarnaSinarModel->find($id)
        ];
        return view('master_warnasinar/edit', $data);
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
        $this->masterWarnaSinarModel->update($id, $data);
        $this->db2->table('warna_sinar')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterWarnaSinarModel->update($id, $data);
        $this->db2->table('warna_sinar')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil dihapus.');
    }
}
