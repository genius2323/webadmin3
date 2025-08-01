<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiMerkModel;

class OtorisasiMerk extends BaseController
{
    public function index()
    {
        $merkModel = new OtorisasiMerkModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $merkModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'merk' => $query->paginate($perPage, 'default'),
            'pager' => $merkModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_merk', $data);
    }

    public function setOtorisasiMerk()
    {
        $merkId = $this->request->getPost('merk_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $merkModelDefault = new OtorisasiMerkModel(\Config\Database::connect('default'));
        $merkModelDefault->update($merkId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $merkModelDb2 = new OtorisasiMerkModel(\Config\Database::connect('db2'));
        $merkModelDb2->update($merkId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_merk')->with('success', 'Merk berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_merk')->with('success', 'Otorisasi merk dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
