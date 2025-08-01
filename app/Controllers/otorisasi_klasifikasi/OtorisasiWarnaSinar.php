<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiWarnaSinarModel;

class OtorisasiWarnaSinar extends BaseController
{
    public function index()
    {
        $warnaSinarModel = new OtorisasiWarnaSinarModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $warnaSinarModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'warnasinar' => $query->paginate($perPage, 'default'),
            'pager' => $warnaSinarModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_warnasinar', $data);
    }

    public function setOtorisasiWarnaSinar()
    {
        $warnaSinarId = $this->request->getPost('warnasinar_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $warnaSinarModelDefault = new OtorisasiWarnaSinarModel(\Config\Database::connect('default'));
        $warnaSinarModelDefault->update($warnaSinarId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $warnaSinarModelDb2 = new OtorisasiWarnaSinarModel(\Config\Database::connect('db2'));
        $warnaSinarModelDb2->update($warnaSinarId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnasinar')->with('success', 'Warna sinar berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnasinar')->with('success', 'Otorisasi warna sinar dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
