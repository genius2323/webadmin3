<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi_klasifikasi\OtorisasiGondolaModel;

class OtorisasiGondola extends BaseController
{
    // Tampilkan halaman otorisasi gondola
    public function index()
    {
        $gondolaModel = new OtorisasiGondolaModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $gondolaModel->select('id, name, description, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'gondolas' => $query->paginate($perPage, 'default'),
            'pager' => $gondolaModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_gondola', $data);
    }

    // Proses set otorisasi gondola
    public function setOtorisasiGondola()
    {
        $gondolaId = $this->request->getPost('gondola_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $gondolaModelDefault = new OtorisasiGondolaModel(\Config\Database::connect('default'));
        $gondolaModelDefault->update($gondolaId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $gondolaModelDb2 = new OtorisasiGondolaModel(\Config\Database::connect('db2'));
        $gondolaModelDb2->update($gondolaId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_gondola')->with('success', 'Gondola berhasil diotorisasi & batas tanggal disimpan di kedua database. Sekarang bisa diedit atau dihapus.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_gondola')->with('success', 'Otorisasi gondola dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
