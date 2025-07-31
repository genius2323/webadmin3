<?php
namespace App\Controllers;
use App\Models\MasterMerkModel;
use CodeIgniter\Controller;
class MasterMerk extends Controller
{
    protected $masterMerkModel;
    protected $db2;
    public function __construct()
    {
        $this->masterMerkModel = new MasterMerkModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Merk',
            'merk' => $this->masterMerkModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_merk/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Merk'
        ];
        return view('master_merk/create', $data);
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
        $this->masterMerkModel->insert($data);
        $id = $this->masterMerkModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('merk')->insert($dataDb2);
        return redirect()->to('/mastermerk')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'merk' => $this->masterMerkModel->find($id),
            'title' => 'Edit Merk'
        ];
        return view('master_merk/edit', $data);
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
        $this->masterMerkModel->update($id, $data);
        $this->db2->table('merk')->where('id', $id)->update($data);
        return redirect()->to('/mastermerk')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterMerkModel->update($id, $data);
        $this->db2->table('merk')->where('id', $id)->update($data);
        return redirect()->to('/mastermerk')->with('success', 'Data berhasil dihapus.');
    }
}
