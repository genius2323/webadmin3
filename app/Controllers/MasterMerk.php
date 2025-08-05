<?php

namespace App\Controllers;

use App\Models\MasterMerkModel;

class MasterMerk extends BaseController
{
    public function index()
    {
        $model = new MasterMerkModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['merk'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Merk';
        return view('master_merk/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Merk';
        return view('master_merk/create', $data);
    }

    public function save()
    {
        $model = new MasterMerkModel();
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
        $db2->table('merk')->insert($dataDb2);
        return redirect()->to('mastermerk')->with('success', 'Merk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new MasterMerkModel();
        $merk = $model->find($id);
        if (!$merk || $merk['deleted_at']) {
            return redirect()->to('mastermerk')->with('error', 'Merk tidak ditemukan.');
        }
        $data = [
            'merk' => $merk,
            'title' => 'Edit Merk',
        ];
        return view('master_merk/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterMerkModel();
        $db2 = \Config\Database::connect('db2');
        $merk = $model->find($id);
        if (!$merk || $merk['deleted_at']) {
            return redirect()->to('mastermerk')->with('error', 'Merk tidak ditemukan.');
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
        $db2->table('merk')->where('id', $id)->update($dataDb2);
        return redirect()->to('mastermerk')->with('success', 'Merk berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new MasterMerkModel();
        $db2 = \Config\Database::connect('db2');
        $merk = $model->find($id);
        if (!$merk || $merk['deleted_at']) {
            return redirect()->to('mastermerk')->with('error', 'Merk tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ]);
        $db2->table('merk')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ]);
        return redirect()->to('mastermerk')->with('success', 'Merk berhasil dihapus');
    }
}
