<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiSatuanModel;

class OtorisasiSatuan extends BaseController
{
    public function index()
    {
        $satuanModel = new OtorisasiSatuanModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $satuanModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'satuan' => $query->paginate($perPage, 'default'),
            'pager' => $satuanModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_satuan', $data);
    }

    public function setOtorisasiSatuan()
    {
        $satuanId = $this->request->getPost('satuan_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $satuanModelDefault = new OtorisasiSatuanModel(\Config\Database::connect('default'));
        $satuanModelDefault->update($satuanId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $satuanModelDb2 = new OtorisasiSatuanModel(\Config\Database::connect('db2'));
        $satuanModelDb2->update($satuanId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_satuan')->with('success', 'Satuan berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_satuan')->with('success', 'Otorisasi satuan dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
