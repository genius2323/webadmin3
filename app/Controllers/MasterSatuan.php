<?php

namespace App\Controllers;

use App\Models\MasterSatuanModel;
use CodeIgniter\Controller;

class MasterSatuan extends Controller
{
    protected $masterSatuanModel;
    protected $db2;
    public function __construct()
    {
        $this->masterSatuanModel = new MasterSatuanModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $model = $this->masterSatuanModel;
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['satuan'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Satuan';
        return view('master_satuan/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Satuan'
        ];
        return view('master_satuan/create', $data);
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
        $this->masterSatuanModel->insert($data);
        $id = $this->masterSatuanModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('satuan')->insert($dataDb2);
        return redirect()->to('/mastersatuan')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $satuan = $this->masterSatuanModel->find($id);
        if (!$satuan || $satuan['deleted_at'] || ($satuan['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/mastersatuan')->with('error', 'Tidak memiliki otoritas untuk edit data ini.');
        }
        $data = [
            'satuan' => $satuan,
            'title' => 'Edit Satuan'
        ];
        return view('master_satuan/edit', $data);
    }

    public function update($id)
    {
        $satuan = $this->masterSatuanModel->find($id);
        if (!$satuan || $satuan['deleted_at'] || ($satuan['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/mastersatuan')->with('error', 'Tidak memiliki otoritas untuk edit data ini.');
        }
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'name' => $this->request->getVar('name'),
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterSatuanModel->update($id, $data);
        $this->db2->table('satuan')->where('id', $id)->update($data);
        return redirect()->to('/mastersatuan')->with('success', 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $satuan = $this->masterSatuanModel->find($id);
        if (!$satuan || $satuan['deleted_at'] || ($satuan['otoritas'] ?? '') !== 'T') {
            return redirect()->to('/mastersatuan')->with('error', 'Tidak memiliki otoritas untuk hapus data ini.');
        }
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky,
        ];
        $this->masterSatuanModel->update($id, $data);
        $this->db2->table('satuan')->where('id', $id)->update($data);
        return redirect()->to('/mastersatuan')->with('success', 'Data berhasil dihapus.');
    }
}
