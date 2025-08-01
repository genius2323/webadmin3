<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiModelModel;

class OtorisasiModel extends BaseController
{
    public function index()
    {
        $modelModel = new OtorisasiModelModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $modelModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'model' => $query->paginate($perPage, 'default'),
            'pager' => $modelModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_model', $data);
    }

    public function setOtorisasiModel()
    {
        $modelId = $this->request->getPost('model_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $modelModelDefault = new OtorisasiModelModel(\Config\Database::connect('default'));
        $modelModelDefault->update($modelId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $modelModelDb2 = new OtorisasiModelModel(\Config\Database::connect('db2'));
        $modelModelDb2->update($modelId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_model')->with('success', 'Model berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_model')->with('success', 'Otorisasi model dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
