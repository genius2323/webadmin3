<?php
namespace App\Controllers;
use App\Models\MasterJenisModel;
use CodeIgniter\Controller;
class MasterJenis extends Controller
{
    protected $masterJenisModel;
    protected $db2;
    public function __construct()
    {
        $this->masterJenisModel = new MasterJenisModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Jenis',
            'jenis' => $this->masterJenisModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_jenis/index', $data);
    }
    public function create()
    {
        return view('master_jenis/create');
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
        $this->masterJenisModel->insert($data);
        $id = $this->masterJenisModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('jenis')->insert($dataDb2);
        return redirect()->to('/masterjenis')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'jenis' => $this->masterJenisModel->find($id)
        ];
        return view('master_jenis/edit', $data);
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
        $this->masterJenisModel->update($id, $data);
        $this->db2->table('jenis')->where('id', $id)->update($data);
        return redirect()->to('/masterjenis')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterJenisModel->update($id, $data);
        $this->db2->table('jenis')->where('id', $id)->update($data);
        return redirect()->to('/masterjenis')->with('success', 'Data berhasil dihapus.');
    }
}
