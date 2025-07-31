<?php

namespace App\Controllers;

use App\Models\MasterKakiModel;
use CodeIgniter\Controller;

class MasterKaki extends Controller
{
    protected $masterKakiModel;
    public function __construct()
    {
        $this->masterKakiModel = new MasterKakiModel();
    }

    public function index()
    {
        $model = $this->masterKakiModel;
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['kaki'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Kaki';
        return view('master_kaki/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kaki'
        ];
        return view('master_kaki/create', $data);
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
        $this->masterKakiModel->insert($data);
        return redirect()->to('/masterkaki')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'kaki' => $this->masterKakiModel->find($id),
            'title' => 'Edit Kaki'
        ];
        return view('master_kaki/edit', $data);
    }

    public function update($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'nama_ky' => $nama_ky
        ];
        $this->masterKakiModel->update($id, $data);
        return redirect()->to('/masterkaki')->with('success', 'Data berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->masterKakiModel->delete($id);
        return redirect()->to('/masterkaki')->with('success', 'Data berhasil dihapus.');
    }
}
