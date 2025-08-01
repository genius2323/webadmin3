<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiWarnaBodyModel;

class OtorisasiWarnaBody extends BaseController
{
    public function index()
    {
        $warnaBodyModel = new OtorisasiWarnaBodyModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $warnaBodyModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'warnabody' => $query->paginate($perPage, 'default'),
            'pager' => $warnaBodyModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_warnabody', $data);
    }

    public function setOtorisasiWarnaBody()
    {
        $warnaBodyId = $this->request->getPost('warnabody_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $warnaBodyModelDefault = new OtorisasiWarnaBodyModel(\Config\Database::connect('default'));
        $warnaBodyModelDefault->update($warnaBodyId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $warnaBodyModelDb2 = new OtorisasiWarnaBodyModel(\Config\Database::connect('db2'));
        $warnaBodyModelDb2->update($warnaBodyId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnabody')->with('success', 'Warna body berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnabody')->with('success', 'Otorisasi warna body dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
