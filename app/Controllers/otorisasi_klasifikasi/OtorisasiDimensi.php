<?php

namespace App\Controllers\otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\MasterDimensiModel;

class OtorisasiDimensi extends BaseController
{
    public function index()
    {
        $model = new MasterDimensiModel();
        $perPage = $this->request->getGet('per_page') ?? 10;
        $keyword = $this->request->getGet('q');
        $query = $model->select('id, name, otoritas');
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'dimensis' => $query->paginate($perPage),
            'pager' => $model->pager,
            'perPage' => $perPage,
            'q' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_dimensi', $data);
    }

    public function setOtorisasiDimensi()
    {
        $id = $this->request->getPost('dimensi_id');
        $otoritas = $this->request->getPost('otoritas');
        $model = new MasterDimensiModel();
        $model->update($id, ['otoritas' => $otoritas]);
        return redirect()->to(site_url('otorisasi_klasifikasi/otorisasi_dimensi'))->with('success', 'Status otorisasi berhasil diubah.');
    }
}
