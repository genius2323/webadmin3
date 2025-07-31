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
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Satuan',
            'satuan' => $this->masterSatuanModel->getData($keyword),
            'keyword' => $keyword
        ];
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
        $data = [
            'satuan' => $this->masterSatuanModel->find($id),
            'title' => 'Edit Satuan'
        ];
        return view('master_satuan/edit', $data);
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
        $this->masterSatuanModel->update($id, $data);
        $this->db2->table('satuan')->where('id', $id)->update($data);
        return redirect()->to('/mastersatuan')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterSatuanModel->update($id, $data);
        $this->db2->table('satuan')->where('id', $id)->update($data);
        return redirect()->to('/mastersatuan')->with('success', 'Data berhasil dihapus.');
    }
}
