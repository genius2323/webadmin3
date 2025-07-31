<?php
namespace App\Controllers;
use App\Models\MasterFitingModel;
use CodeIgniter\Controller;
class MasterFiting extends Controller
{
    protected $masterFitingModel;
    protected $db2;
    public function __construct()
    {
        $this->masterFitingModel = new MasterFitingModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Fiting',
            'fiting' => $this->masterFitingModel->getData($keyword),
            'keyword' => $keyword
        ];
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
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterFitingModel->insert($data);
        $id = $this->masterFitingModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('fiting')->insert($dataDb2);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'fiting' => $this->masterFitingModel->find($id),
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
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterFitingModel->update($id, $data);
        $this->db2->table('fiting')->where('id', $id)->update($data);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterFitingModel->update($id, $data);
        $this->db2->table('fiting')->where('id', $id)->update($data);
        return redirect()->to('/masterfiting')->with('success', 'Data berhasil dihapus.');
    }
}
