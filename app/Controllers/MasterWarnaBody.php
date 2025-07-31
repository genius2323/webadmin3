<?php
namespace App\Controllers;
use App\Models\MasterWarnaBodyModel;
use CodeIgniter\Controller;
class MasterWarnaBody extends Controller
{
    protected $masterWarnaBodyModel;
    protected $db2;
    public function __construct()
    {
        $this->masterWarnaBodyModel = new MasterWarnaBodyModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Warna Body',
            'warnabody' => $this->masterWarnaBodyModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_warnabody/index', $data);
    }
    public function create()
    {
        return view('master_warnabody/create');
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
        $this->masterWarnaBodyModel->insert($data);
        $id = $this->masterWarnaBodyModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('warna_body')->insert($dataDb2);
        return redirect()->to('/masterwarnabody')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'warnabody' => $this->masterWarnaBodyModel->find($id)
        ];
        return view('master_warnabody/edit', $data);
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
        $this->masterWarnaBodyModel->update($id, $data);
        $this->db2->table('warna_body')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnabody')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterWarnaBodyModel->update($id, $data);
        $this->db2->table('warna_body')->where('id', $id)->update($data);
        return redirect()->to('/masterwarnabody')->with('success', 'Data berhasil dihapus.');
    }
}
