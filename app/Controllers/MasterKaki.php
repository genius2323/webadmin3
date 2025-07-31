<?php
namespace App\Controllers;
use App\Models\MasterKakiModel;
use CodeIgniter\Controller;
class MasterKaki extends Controller
{
    protected $masterKakiModel;
    protected $db2;
    public function __construct()
    {
        $this->masterKakiModel = new MasterKakiModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Kaki',
            'kaki' => $this->masterKakiModel->getData($keyword),
            'keyword' => $keyword
        ];
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
        $id = $this->masterKakiModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('kaki')->insert($dataDb2);
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
            'nama_ky' => $nama_ky,
            'otoritas' => null
        ];
        $this->masterKakiModel->update($id, $data);
        $this->db2->table('kaki')->where('id', $id)->update($data);
        return redirect()->to('/masterkaki')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterKakiModel->update($id, $data);
        $this->db2->table('kaki')->where('id', $id)->update($data);
        return redirect()->to('/masterkaki')->with('success', 'Data berhasil dihapus.');
    }
}
