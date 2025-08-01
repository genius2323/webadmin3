<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi_klasifikasi\OtorisasiJenisModel;

class OtorisasiJenis extends BaseController
{
    public function index()
    {
        $jenisModel = new OtorisasiJenisModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $jenisModel->select('id, name, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'jenis' => $query->paginate($perPage, 'default'),
            'pager' => $jenisModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_jenis', $data);
    }

    public function setOtorisasiJenis()
    {
        $jenisId = $this->request->getPost('jenis_id');
        $otoritas = $this->request->getPost('otoritas');
        // Update di database default
        $jenisModelDefault = new OtorisasiJenisModel(\Config\Database::connect('default'));
        $jenisModelDefault->update($jenisId, [
            'otoritas' => $otoritas
        ]);
        // Update juga di database kedua (db2)
        $jenisModelDb2 = new OtorisasiJenisModel(\Config\Database::connect('db2'));
        $jenisModelDb2->update($jenisId, [
            'otoritas' => $otoritas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_jenis')->with('success', 'Jenis berhasil diotorisasi di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_jenis')->with('success', 'Otorisasi jenis dinonaktifkan di kedua database.');
        }
    }
}
