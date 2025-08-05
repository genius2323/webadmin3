<?php

namespace App\Controllers;

use App\Models\MasterModelModel;

class MasterModel extends BaseController
{
    public function index()
    {
        $model = new MasterModelModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['model'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Model';
        return view('master_model/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Model';
        return view('master_model/create', $data);
    }

    public function save()
    {
        $model = new MasterModelModel();
        $db2 = \Config\Database::connect('db2');
        $nama_ky = session()->get('user_nama');
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->insert($data);
        $id = $model->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('model')->insert($dataDb2);
        return redirect()->to('mastermodel')->with('success', 'Model berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new MasterModelModel();
        $modelData = $model->find($id);
        if (!$modelData || $modelData['deleted_at']) {
            return redirect()->to('mastermodel')->with('error', 'Model tidak ditemukan.');
        }
        $data = [
            'model' => $modelData,
            'title' => 'Edit Model',
        ];
        return view('master_model/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterModelModel();
        $db2 = \Config\Database::connect('db2');
        $modelData = $model->find($id);
        if (!$modelData || $modelData['deleted_at']) {
            return redirect()->to('mastermodel')->with('error', 'Model tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->update($id, $data);
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('model')->where('id', $id)->update($dataDb2);
        return redirect()->to('mastermodel')->with('success', 'Model berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new MasterModelModel();
        $db2 = \Config\Database::connect('db2');
        $modelData = $model->find($id);
        if (!$modelData || $modelData['deleted_at']) {
            return redirect()->to('mastermodel')->with('error', 'Model tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ]);
        $db2->table('model')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ]);
        return redirect()->to('mastermodel')->with('success', 'Model berhasil dihapus');
    }
}
