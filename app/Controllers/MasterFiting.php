<?php

namespace App\Controllers;

use App\Models\MasterFitingModel;
use CodeIgniter\Controller;

class MasterFiting extends \App\Controllers\BaseController
{
    public function index()
    {
        $model = new MasterFitingModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['fiting'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Fiting';
        return view('master_fiting/index', $data);
    }
    // ...existing code for create, save, edit, update, delete...
}
