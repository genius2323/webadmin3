<?php
namespace App\Controllers;
use App\Models\MasterSalesModel;
use CodeIgniter\RESTful\ResourceController;

class SalesApi extends ResourceController
{
    public function index()
    {
        $model = new MasterSalesModel();
        $search = $this->request->getGet('search');
        if ($search) {
            $model->groupStart()
                ->like('kode', $search)
                ->orLike('nama', $search)
            ->groupEnd();
        }
        $sales = $model->select('id, kode, nama')->where('deleted_at', null)->findAll();
        return $this->respond($sales);
    }
}
