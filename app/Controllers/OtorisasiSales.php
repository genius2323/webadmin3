<?php

namespace App\Controllers;

use App\Models\OtorisasiSalesModel;
use CodeIgniter\Controller;

class OtorisasiSales extends Controller
{
    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $model = new OtorisasiSalesModel();
        $list = $model->getSalesList($search, $perPage);
        $pager = $model->pager;
        return view('otorisasi/otorisasi_sales', compact('list', 'search', 'pager'));
    }

    public function setOtorisasiSales()
    {
        $id = $this->request->getPost('sales_id');
        $otoritas = $this->request->getPost('otoritas');
        $model = new OtorisasiSalesModel();
        $model->updateOtorisasi($id, $otoritas);
        return redirect()->back()->with('success', 'Otorisasi sales berhasil diubah.');
    }
}
