<?php

namespace App\Controllers;

use App\Models\MasterDayaModel;

class MasterDaya extends BaseController
{
    public function index()
    {
        $model = new MasterDayaModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['daya'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Daya';
        return view('master_daya/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Daya'
        ];
        return view('master_daya/create', $data);
    }

    public function save()
    {
        $model = new MasterDayaModel();
        $db2 = \Config\Database::connect('db2');
        $nama_ky = session()->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->insert($data);
        $id = $model->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('daya')->insert($dataDb2);
        return redirect()->to('masterdaya')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new MasterDayaModel();
        $dataItem = $model->find($id);
        if (!$dataItem || $dataItem['deleted_at']) {
            return redirect()->to('masterdaya')->with('error', 'Data tidak ditemukan.');
        }
        $data = [
            'daya' => $dataItem,
            'title' => 'Edit Daya'
        ];
        return view('master_daya/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterDayaModel();
        $db2 = \Config\Database::connect('db2');
        $dataItem = $model->find($id);
        if (!$dataItem || $dataItem['deleted_at']) {
            return redirect()->to('masterdaya')->with('error', 'Data tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'otoritas' => null,
            'nama_ky' => $nama_ky,
        ];
        $model->update($id, $data);
        $db2->table('daya')->where('id', $id)->update($data);
        return redirect()->to('masterdaya')->with('success', 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $model = new MasterDayaModel();
        $db2 = \Config\Database::connect('db2');
        $dataItem = $model->find($id);
        if (!$dataItem || $dataItem['deleted_at']) {
            return redirect()->to('masterdaya')->with('error', 'Data tidak ditemukan.');
        }
        $nama_ky = session()->get('user_nama');
        $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ]);
        $db2->table('daya')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ]);
        return redirect()->to('masterdaya')->with('success', 'Data berhasil dihapus.');
    }
}
