<?php
namespace App\Controllers;
use App\Models\MasterPelengkapModel;
use CodeIgniter\Controller;
class MasterPelengkap extends Controller
{
    protected $masterPelengkapModel;
    protected $db2;
    public function __construct()
    {
        $this->masterPelengkapModel = new MasterPelengkapModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Pelengkap',
            'pelengkap' => $this->masterPelengkapModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_pelengkap/index', $data);
    }
    public function create()
    {
        return view('master_pelengkap/create');
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
        $this->masterPelengkapModel->insert($data);
        $id = $this->masterPelengkapModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('pelengkap')->insert($dataDb2);
        return redirect()->to('/masterpelengkap')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'pelengkap' => $this->masterPelengkapModel->find($id)
        ];
        return view('master_pelengkap/edit', $data);
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
        $this->masterPelengkapModel->update($id, $data);
        $this->db2->table('pelengkap')->where('id', $id)->update($data);
        return redirect()->to('/masterpelengkap')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterPelengkapModel->update($id, $data);
        $this->db2->table('pelengkap')->where('id', $id)->update($data);
        return redirect()->to('/masterpelengkap')->with('success', 'Data berhasil dihapus.');
    }
}
