<?php

namespace App\Controllers;

use App\Models\MasterJumlahMataModel;
use CodeIgniter\Controller;

class MasterJumlahMata extends Controller
{
    protected $masterJumlahMataModel;
    protected $db2;
    public function __construct()
    {
        $this->masterJumlahMataModel = new MasterJumlahMataModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $model = new \App\Models\MasterJumlahMataModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['jumlahmata'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Jumlah Mata';
        return view('master_jumlahmata/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Jumlah Mata'
        ];
        return view('master_jumlahmata/create', $data);
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
        $this->masterJumlahMataModel->insert($data);
        $id = $this->masterJumlahMataModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('jumlah_mata')->insert($dataDb2);
        return redirect()->to('/masterjumlahmata')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'jumlahmata' => $this->masterJumlahMataModel->find($id),
            'title' => 'Edit Jumlah Mata'
        ];
        return view('master_jumlahmata/edit', $data);
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
        $this->masterJumlahMataModel->update($id, $data);
        $this->db2->table('jumlah_mata')->where('id', $id)->update($data);
        return redirect()->to('/masterjumlahmata')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterJumlahMataModel->update($id, $data);
        $this->db2->table('jumlah_mata')->where('id', $id)->update($data);
        return redirect()->to('/masterjumlahmata')->with('success', 'Data berhasil dihapus.');
    }
}
