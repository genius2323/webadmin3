<?php

namespace App\Controllers;

use App\Models\MasterFitingModel;
use CodeIgniter\Controller;

class MasterFiting extends \App\Controllers\BaseController
{
    public function index()
    {
        $model = new MasterFitingModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['fiting'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Fiting';
        return view('master_fiting/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Fiting'
        ];
        return view('master_fiting/create', $data);
    }

    public function save()
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $model = new MasterFitingModel();
        $model->insert($data);
        $id = $model->getInsertID();
        $db2 = \Config\Database::connect('db2');
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('fiting')->insert($dataDb2);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new MasterFitingModel();
        $data = [
            'fiting' => $model->find($id),
            'title' => 'Edit Fiting'
        ];
        return view('master_fiting/edit', $data);
    }

    public function update($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $model = new MasterFitingModel();
        $model->update($id, $data);
        $db2 = \Config\Database::connect('db2');
        $db2->table('fiting')->where('id', $id)->update($data);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $model = new MasterFitingModel();
        $model->update($id, $data);
        $db2 = \Config\Database::connect('db2');
        $db2->table('fiting')->where('id', $id)->update($data);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil dihapus.');
    }
}
