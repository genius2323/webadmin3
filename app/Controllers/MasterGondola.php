<?php
namespace App\Controllers;
use App\Models\MasterGondolaModel;
use CodeIgniter\Controller;
class MasterGondola extends Controller
{
    protected $masterGondolaModel;
    protected $db2;
    public function __construct()
    {
        $this->masterGondolaModel = new MasterGondolaModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Gondola',
            'gondola' => $this->masterGondolaModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_gondola/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Gondola'
        ];
        return view('master_gondola/create', $data);
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
        // Insert into the first database
        $this->masterGondolaModel->insert($data);

        // Get the ID from the first insert
        $id = $this->masterGondolaModel->getInsertID();

        // Add the ID to the data for the second database to ensure sync
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('gondola')->insert($dataDb2);
        return redirect()->to('mastergondola')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'gondola' => $this->masterGondolaModel->find($id),
            'title' => 'Edit Gondola'
        ];
        return view('master_gondola/edit', $data);
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
        $this->masterGondolaModel->update($id, $data);
        $this->db2->table('gondola')->where('id', $id)->update($data);
        return redirect()->to('mastergondola')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterGondolaModel->update($id, $data);
        $this->db2->table('gondola')->where('id', $id)->update($data);
        return redirect()->to('mastergondola')->with('success', 'Data berhasil dihapus.');
    }
}
