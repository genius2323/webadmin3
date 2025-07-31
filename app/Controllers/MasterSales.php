<?php
namespace App\Controllers;
use App\Models\MasterSalesModel;
use CodeIgniter\HTTP\RedirectResponse;

class MasterSales extends BaseController
{
    public function delete($id)
    {
        $model = new MasterSalesModel();
        $model->delete($id); // soft delete di database utama
        // Soft delete di database kedua (db2)
        $db2 = \Config\Database::connect('db2');
        $deletedAt = date('Y-m-d H:i:s');
        $db2->table('mastersales')->where('id', $id)->update(['deleted_at' => $deletedAt]);
        return redirect()->to(site_url('mastersales'))->with('success', 'Data sales berhasil dihapus di dua database.');
    }

    public function edit($id)
    {
        $model = new MasterSalesModel();
        $data['sales'] = $model->find($id);
        if (!$data['sales']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data sales tidak ditemukan');
        }
        $data['title'] = 'Edit Sales / Pegawai';
        return view('mastersales/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterSalesModel();
        $data = [
            'kode' => $this->request->getPost('kode'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'no_hp' => $this->request->getPost('no_hp'),
            'no_ktp' => $this->request->getPost('no_ktp'),
            'status' => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        // Sync ke database kedua (db2)
        $db2 = \Config\Database::connect('db2');
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $exists = $db2->table('mastersales')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('mastersales')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('mastersales')->insert($dataDb2);
        }
        return redirect()->to(site_url('mastersales'))->with('success', 'Data sales berhasil diupdate di dua database.');
    }
    public function create()
    {
        $data['title'] = 'Tambah Sales / Pegawai';
        return view('mastersales/create', $data);
    }
    public function index()
    {
        $model = new MasterSalesModel();
        $search = $this->request->getGet('search');
        if ($search) {
            $model->groupStart()
                ->like('kode', $search)
                ->orLike('nama', $search)
                ->orLike('alamat', $search)
                ->orLike('tempat_lahir', $search)
                ->orLike('no_hp', $search)
                ->orLike('no_ktp', $search)
                ->orLike('status', $search)
            ->groupEnd();
        }
        $data['sales'] = $model->findAll();
        $data['title'] = 'Data Sales / Pegawai';
        return view('mastersales/index', $data);
    }

    public function save()
    {
        $model = new MasterSalesModel();
        $db2 = \Config\Database::connect('db2');
        $data = [
            'kode' => $this->request->getPost('kode'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'no_hp' => $this->request->getPost('no_hp'),
            'no_ktp' => $this->request->getPost('no_ktp'),
            'status' => $this->request->getPost('status'),
        ];
        $model->insert($data);
        $id = $model->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $exists = $db2->table('mastersales')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('mastersales')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('mastersales')->insert($dataDb2);
        }
        return redirect()->to(site_url('mastersales'))->with('success', 'Data sales berhasil ditambahkan/diupdate di dua database.');
    }
}
