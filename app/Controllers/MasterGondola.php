<?php

namespace App\Controllers;

use App\Models\MasterGondolaModel;
use CodeIgniter\Controller;

class MasterGondola extends \App\Controllers\BaseController
{
    public function index()
    {
        $model = new \App\Models\MasterGondolaModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['gondola'] = $builder->paginate($perPage, 'default');
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Master Gondola';
        return view('master_gondola/index', $data);
    }
    // ...existing code for create, save, edit, update, delete...
}
