<?php

namespace App\Controllers;

use App\Models\MasterWarnasinarModel;
use CodeIgniter\Controller;

class MasterWarnasinar extends Controller
{
    protected $warnasinarModel;
    protected $db2;
    public function __construct()
    {
        $this->warnasinarModel = new MasterWarnasinarModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = $this->request->getGet('perPage') ?? 10;
        $model = $this->warnasinarModel;
        if ($search) {
            $model = $model->like('name', $search);
        }
        $data = [
            'warnasinar' => $model->where('deleted_at', null)->paginate($perPage, 'default'),
            'pager' => $model->pager,
            'search' => $search,
            'perPage' => $perPage,
        ];
        return view('master_warnasinar/index', $data);
    }
    public function create()
    {
        return view('master_warnasinar/create');
    }
    public function save()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'otoritas' => null,
        ];
        $id = $this->warnasinarModel->insert($data);
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('master_warnasinar')->insert($dataDb2);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id)
    {
        $warnasinar = $this->warnasinarModel->find($id);
        if (!$warnasinar || $warnasinar['deleted_at']) {
            return redirect()->to('/masterwarnasinar')->with('error', 'Data tidak ditemukan');
        }
        return view('master_warnasinar/edit', ['warnasinar' => $warnasinar]);
    }
    public function update($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
        ];
        $this->warnasinarModel->update($id, $data);
        $this->db2->table('master_warnasinar')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil diubah');
    }
    public function delete($id)
    {
        $row = $this->warnasinarModel->find($id);
        if (!$row || $row['deleted_at']) {
            return redirect()->to('/masterwarnasinar')->with('error', 'Data tidak ditemukan');
        }
        $this->warnasinarModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        $this->db2->table('master_warnasinar')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/masterwarnasinar')->with('success', 'Data berhasil dihapus');
    }
}
