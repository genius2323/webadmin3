<?php

namespace App\Controllers;

use App\Models\MasterModelModel;
use CodeIgniter\Controller;

class MasterModel extends Controller
{
    protected $masterModelModel;
    protected $db2;
    public function __construct()
    {
        $this->masterModelModel = new MasterModelModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $model = $this->masterModelModel;
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['model'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Model';
        return view('master_model/index', $data);
    }
    public function create()
    {
        return view('master_model/create');
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
        $this->masterModelModel->insert($data);
        $id = $this->masterModelModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('model')->insert($dataDb2);
        return redirect()->to('/mastermodel')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'model' => $this->masterModelModel->find($id)
        ];
        return view('master_model/edit', $data);
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
        $this->masterModelModel->update($id, $data);
        $this->db2->table('model')->where('id', $id)->update($data);
        return redirect()->to('/mastermodel')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterModelModel->update($id, $data);
        $this->db2->table('model')->where('id', $id)->update($data);
        return redirect()->to('/mastermodel')->with('success', 'Data berhasil dihapus.');
    }
}
