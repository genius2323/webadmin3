<?php

namespace App\Controllers\otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\MasterDimensiModel;

class OtorisasiDimensi extends BaseController
{
    public function index()
    {
        $model = new MasterDimensiModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $model->select('id, name, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'dimensi' => $query->paginate($perPage, 'default'),
            'pager' => $model->pager,
            'perPage' => $perPage,
            'search' => $keyword,
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
