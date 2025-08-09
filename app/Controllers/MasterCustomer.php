<?php

namespace App\Controllers;

use App\Models\MasterCustomerModel;

class MasterCustomer extends BaseController
{
    public function index()
    {
        $model = new MasterCustomerModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->groupStart()
                ->like('kode_customer', $search)
                ->orLike('nama_customer', $search)
                ->orLike('alamat', $search)
                ->orLike('contact_person', $search)
                ->orLike('kota', $search)
                ->orLike('provinsi', $search)
                ->orLike('sales', $search)
                ->orLike('no_hp', $search)
                ->orLike('npwp_nomor', $search)
                ->orLike('npwp_atas_nama', $search)
                ->orLike('npwp_alamat', $search)
                ->groupEnd();
        }
        $data['customers'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Customer';
        return view('mastercustomer/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Customer';
        return view('mastercustomer/create', $data);
    }

    public function save()
    {
        $model = new MasterCustomerModel();
        $db2 = \Config\Database::connect('db2');
        $npwpNomorArr = $this->request->getPost('npwp_nomor');
        $npwpNomor = is_array($npwpNomorArr) ? implode('', $npwpNomorArr) : $npwpNomorArr;
        // Ambil dan parsing batas_piutang ke angka
        $batasPiutangInput = $this->request->getPost('batas_piutang');
        $batasPiutang = preg_replace('/[^0-9]/', '', $batasPiutangInput);
        $batasPiutang = $batasPiutang === '' ? 0 : (int)$batasPiutang;
        $data = [
            'kode_customer' => $this->request->getPost('kode_customer'),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat' => $this->request->getPost('alamat'),
            'contact_person' => $this->request->getPost('contact_person'),
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'sales' => $this->request->getPost('sales'),
            'no_hp' => $this->request->getPost('no_hp'),
            'batas_piutang' => $batasPiutang,
            'npwp_nomor' => $npwpNomor,
            'npwp_atas_nama' => $this->request->getPost('npwp_atas_nama'),
            'npwp_alamat' => $this->request->getPost('npwp_alamat'),
            'otoritas' => null,
        ];
        $model->insert($data);
        $id = $model->getInsertID();
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $exists = $db2->table('mastercustomer')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('mastercustomer')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('mastercustomer')->insert($dataDb2);
        }
        return redirect()->to(site_url('mastercustomer'))->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new MasterCustomerModel();
        $data['customer'] = $model->find($id);
        if (!$data['customer']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data customer tidak ditemukan');
        }
        $data['title'] = 'Edit Customer';
        return view('mastercustomer/edit', $data);
    }

    public function update($id)
    {
        $model = new MasterCustomerModel();
        $npwpNomorArr = $this->request->getPost('npwp_nomor');
        $npwpNomor = is_array($npwpNomorArr) ? implode('', $npwpNomorArr) : $npwpNomorArr;
        // Ambil dan parsing batas_piutang ke angka
        $batasPiutangInput = $this->request->getPost('batas_piutang');
        $batasPiutang = preg_replace('/[^0-9]/', '', $batasPiutangInput);
        $batasPiutang = $batasPiutang === '' ? 0 : (int)$batasPiutang;
        $data = [
            'kode_customer' => $this->request->getPost('kode_customer'),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat' => $this->request->getPost('alamat'),
            'contact_person' => $this->request->getPost('contact_person'),
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'sales' => $this->request->getPost('sales'),
            'no_hp' => $this->request->getPost('no_hp'),
            'batas_piutang' => $batasPiutang,
            'npwp_nomor' => $npwpNomor,
            'npwp_atas_nama' => $this->request->getPost('npwp_atas_nama'),
            'npwp_alamat' => $this->request->getPost('npwp_alamat'),
            'otoritas' => null,
        ];
        $model->update($id, $data);
        // Sync ke database kedua (db2)
        $db2 = \Config\Database::connect('db2');
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $exists = $db2->table('mastercustomer')->where('id', $id)->get()->getRow();
        if ($exists) {
            $db2->table('mastercustomer')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('mastercustomer')->insert($dataDb2);
        }
        return redirect()->to(site_url('mastercustomer'))->with('success', 'Customer berhasil diupdate.');
    }

    public function delete($id)
    {
        $model = new MasterCustomerModel();
        $model->update($id, ['otoritas' => null]); // null-kan otoritas sebelum soft delete di database utama
        $model->delete($id); // soft delete di database utama
        // Soft delete di database kedua (db2)
        $db2 = \Config\Database::connect('db2');
        $deletedAt = date('Y-m-d H:i:s');
        $db2->table('mastercustomer')->where('id', $id)->update(['otoritas' => null, 'deleted_at' => $deletedAt]);
        return redirect()->to(site_url('mastercustomer'))->with('success', 'Customer berhasil dihapus.');
    }
}
