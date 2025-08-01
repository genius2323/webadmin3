<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiKakiModel;

class OtorisasiKaki extends BaseController
{
    protected $kakiModel;
    protected $pager;
    protected $db2;

    public function index()
    {
        $kakiModel = new OtorisasiKakiModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $kakiModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'kaki' => $query->paginate($perPage, 'default'),
            'pager' => $kakiModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_kaki', $data);
    }

    public function setOtorisasiKaki()
    {
        $kakiId = $this->request->getPost('kaki_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $kakiModelDefault = new OtorisasiKakiModel(\Config\Database::connect('default'));
        $kakiModelDefault->update($kakiId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $kakiModelDb2 = new OtorisasiKakiModel(\Config\Database::connect('db2'));
        $kakiModelDb2->update($kakiId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_kaki')->with('success', 'Kaki berhasil diotorisasi & batas tanggal disimpan di kedua database. Sekarang bisa diedit atau dihapus.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_kaki')->with('success', 'Otorisasi kaki dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
