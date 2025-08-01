<?php

namespace App\Controllers\otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\OtorisasiFitingModel;

class OtorisasiFiting extends BaseController
{
    public function index()
    {
        $fitingModel = new OtorisasiFitingModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $fitingModel->select('id, name, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'fitings' => $query->paginate($perPage, 'default'),
            'pager' => $fitingModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_fiting', $data);
    }
    public function setOtorisasiFiting()
    {
        $id = $this->request->getPost('fiting_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $fitingModelDefault = new OtorisasiFitingModel(\Config\Database::connect('default'));
        $fitingModelDefault->update($id, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $fitingModelDb2 = new OtorisasiFitingModel(\Config\Database::connect('db2'));
        $fitingModelDb2->update($id, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        return redirect()->to(site_url('otorisasi_klasifikasi/otorisasi_fiting'))->with('success', 'Status otorisasi fiting berhasil diubah di kedua database.');
    }
}
