<?php
namespace App\Controllers;
use App\Models\MasterUkuranBarangModel;
use CodeIgniter\Controller;
class MasterUkuranBarang extends Controller
{
    protected $masterUkuranBarangModel;
    protected $db2;
    public function __construct()
    {
        $this->masterUkuranBarangModel = new MasterUkuranBarangModel();
        $this->db2 = \Config\Database::connect('db2');
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Master Ukuran Barang',
            'ukuranbarang' => $this->masterUkuranBarangModel->getData($keyword),
            'keyword' => $keyword
        ];
        return view('master_ukuranbarang/index', $data);
    }
    public function create()
    {
        return view('master_ukuranbarang/create');
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
        $this->masterUkuranBarangModel->insert($data);
        $id = $this->masterUkuranBarangModel->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $this->db2->table('ukuran_barang')->insert($dataDb2);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $data = [
            'ukuranbarang' => $this->masterUkuranBarangModel->find($id)
        ];
        return view('master_ukuranbarang/edit', $data);
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
        $this->masterUkuranBarangModel->update($id, $data);
        $this->db2->table('ukuran_barang')->where('id', $id)->update($data);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil diubah.');
    }
    public function delete($id)
    {
        $session = session();
        $nama_ky = $session->get('user_nama');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'nama_ky' => $nama_ky
        ];
        $this->masterUkuranBarangModel->update($id, $data);
        $this->db2->table('ukuran_barang')->where('id', $id)->update($data);
        return redirect()->to('/masterukuranbarang')->with('success', 'Data berhasil dihapus.');
    }
}
