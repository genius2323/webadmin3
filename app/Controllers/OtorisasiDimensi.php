<?php
namespace App\Controllers;

use App\Models\OtorisasiDimensiModel;
use CodeIgniter\Controller;

class OtorisasiDimensi extends Controller
{
    public function index()
    {
        $model = new OtorisasiDimensiModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $model->where('deleted_at', null);
        if ($search) {
            $builder = $builder->like('name', $search);
        }
        $data['dimensi'] = $builder->paginate($perPage);
        $data['pager'] = $model->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Otorisasi Dimensi';
        return view('otorisasi_klasifikasi/otorisasi_dimensi', $data);
    }

    public function setOtorisasiDimensi()
    {
        $model = new OtorisasiDimensiModel();
        $id = $this->request->getPost('dimensi_id');
        $otoritas = $this->request->getPost('otoritas');
        $model->update($id, ['otoritas' => $otoritas]);
        return redirect()->to('otorisasi_klasifikasi/otorisasi_dimensi')->with('success', 'Status otorisasi dimensi berhasil diubah.');
    }
}
