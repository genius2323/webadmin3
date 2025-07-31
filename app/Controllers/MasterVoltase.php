<?php

namespace App\Controllers;

use App\Models\MasterVoltaseModel;
use CodeIgniter\Controller;

class MasterVoltase extends Controller
{
    protected $masterVoltaseModel;
    protected $db2;
    public function __construct()
    {
        $this->masterVoltaseModel = new MasterVoltaseModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $model = $this->masterVoltaseModel;
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['voltase'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Voltase';
        return view('master_voltase/index', $data);
    }
    public function create()
    {
        return view('master_voltase/create');
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
        $this->masterVoltaseModel->insert($data);
        $id = $this->masterVoltaseModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('voltase')->insert($dataDb2);
        return redirect()->to('/mastervoltase')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'voltase' => $this->masterVoltaseModel->find($id)
        ];
        return view('master_voltase/edit', $data);
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
        $this->masterVoltaseModel->update($id, $data);
        $this->db2->table('voltase')->where('id', $id)->update($data);
        return redirect()->to('/mastervoltase')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterVoltaseModel->update($id, $data);
        $this->db2->table('voltase')->where('id', $id)->update($data);
        return redirect()->to('/mastervoltase')->with('success', 'Data berhasil dihapus.');
    }
}
