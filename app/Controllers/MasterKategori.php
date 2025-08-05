<?php

namespace App\Controllers;

use App\Models\MasterKategoriModel;

class MasterKategori extends BaseController
{
    public function index()
    {
        $model = new MasterKategoriModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['kategori'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Kategori';
        return view('master_kategori/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Kategori';
        return view('master_kategori/create', $data);
    }

    public function store()
    {
        $model = new MasterKategoriModel();
        $db2 = \Config\Database::connect('db2');
        $nama_ky = session()->get('user_nama');
        $data = [
            'kode_cat' => $this->request->getPost('kode_cat'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->insert($data);
        $id = $model->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('categories')->insert($dataDb2);
        return redirect()->to('masterkategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new MasterKategoriModel();
        $kategori = $model->find($id);
        if (!$kategori || $kategori['deleted_at']) {
            return redirect()->to('masterkategori')->with('error', 'Kategori tidak ditemukan.');
        }
        $data = [
            'kategori' => $kategori,
            'title' => 'Edit Kategori'
        ];
        return view('master_kategori/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterKategoriModel();
        $db2 = \Config\Database::connect('db2');
        $kategori = $model->find($id);
        if (!$kategori || $kategori['deleted_at']) {
            return redirect()->to('masterkategori')->with('error', 'Kategori tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $data = [
            'kode_cat' => $this->request->getPost('kode_cat'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->update($id, $data);
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('categories')->where('id', $id)->update($dataDb2);
        return redirect()->to('masterkategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new MasterKategoriModel();
        $db2 = \Config\Database::connect('db2');
        $kategori = $model->find($id);
        if (!$kategori || $kategori['deleted_at']) {
            return redirect()->to('masterkategori')->with('error', 'Kategori tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ]);
        $db2->table('categories')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ]);
        return redirect()->to('masterkategori')->with('success', 'Kategori berhasil dihapus (soft delete) di dua database');
    }
}
