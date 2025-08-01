<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi_klasifikasi\OtorisasiDayaModel;

class OtorisasiDaya extends BaseController
{
    // Tampilkan halaman otorisasi daya
    public function index()
    {
        $dayaModel = new OtorisasiDayaModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $dayaModel->select('id, name, description, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'dayas' => $query->paginate($perPage, 'default'),
            'pager' => $dayaModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_daya', $data);
    }

    // Proses set otorisasi daya
    public function setOtorisasiDaya()
    {
        $dayaId = $this->request->getPost('daya_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $dayaModelDefault = new OtorisasiDayaModel(\Config\Database::connect('default'));
        $dayaModelDefault->update($dayaId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $dayaModelDb2 = new OtorisasiDayaModel(\Config\Database::connect('db2'));
        $dayaModelDb2->update($dayaId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_daya')->with('success', 'Daya berhasil diotorisasi & batas tanggal disimpan di kedua database. Sekarang bisa diedit atau dihapus.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_daya')->with('success', 'Otorisasi daya dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
