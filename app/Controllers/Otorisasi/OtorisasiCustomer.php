<?php

namespace App\Controllers\Otorisasi;

use App\Controllers\BaseController;
use App\Models\OtorisasiCustomerModel;

class OtorisasiCustomer extends BaseController
{
    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $model = new OtorisasiCustomerModel();
        $list = $model->getList($search, $perPage);
        $pager = $model->pager;
        return view('otorisasi/otorisasi_customer', compact('list', 'search', 'pager'));
    }

    public function setOtorisasiCustomer()
    {
        $customer_id = $this->request->getPost('customer_id');
        $otoritas = $this->request->getPost('otoritas');
        $model = new OtorisasiCustomerModel();
        $model->updateOtorisasi($customer_id, $otoritas);
        // Update juga di database kedua (db2)
        $db2 = \Config\Database::connect('db2');
        $db2->table('mastercustomer')->where('id', $customer_id)->update(['otoritas' => $otoritas]);
        return redirect()->to(site_url('otorisasi/otorisasi_customer'))->with('success', 'Status otorisasi customer berhasil diubah.');
    }
}
