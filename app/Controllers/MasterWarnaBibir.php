<?php

namespace App\Controllers;

use App\Models\MasterWarnaBibirModel;
use CodeIgniter\Controller;

class MasterWarnaBibir extends Controller
{
    protected $masterWarnaBibirModel;
    protected $db2;
    public function __construct()
    {
        $this->masterWarnaBibirModel = new MasterWarnaBibirModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $search = $this->request->getGet('search') ?? $this->request->getGet('keyword');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $this->masterWarnaBibirModel->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['warnabibir'] = $builder->paginate($perPage);
        $data['pager'] = $this->masterWarnaBibirModel->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Warna Bibir';
        return view('master_warnabibir/index', $data);
    }
    public function create()
    {
        return view('master_warnabibir/create');
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
        $this->masterWarnaBibirModel->insert($data);
        $id = $this->masterWarnaBibirModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('warna_bibir')->insert($dataDb2);
        return redirect()->to('/masterwarnabibir')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'warnabibir' => $this->masterWarnaBibirModel->find($id)
        ];
        return view('master_warnabibir/edit', $data);
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
        $this->masterWarnaBibirModel->update($id, $data);
        $this->db2->table('warna_bibir')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnabibir')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterWarnaBibirModel->update($id, $data);
        $this->db2->table('warna_bibir')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnabibir')->with('success', 'Data berhasil dihapus.');
    }
}
