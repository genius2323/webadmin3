<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiVoltaseModel;

class OtorisasiVoltase extends BaseController
{
    public function index()
    {
        $voltaseModel = new OtorisasiVoltaseModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $voltaseModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'voltase' => $query->paginate($perPage, 'default'),
            'pager' => $voltaseModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_voltase', $data);
    }

    public function setOtorisasiVoltase()
    {
        $voltaseId = $this->request->getPost('voltase_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $voltaseModelDefault = new OtorisasiVoltaseModel(\Config\Database::connect('default'));
        $voltaseModelDefault->update($voltaseId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $voltaseModelDb2 = new OtorisasiVoltaseModel(\Config\Database::connect('db2'));
        $voltaseModelDb2->update($voltaseId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_voltase')->with('success', 'Voltase berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_voltase')->with('success', 'Otorisasi voltase dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
