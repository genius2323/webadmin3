<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiPelengkapModel;

class OtorisasiPelengkap extends BaseController
{
    public function index()
    {
        $pelengkapModel = new OtorisasiPelengkapModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $pelengkapModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'pelengkap' => $query->paginate($perPage, 'default'),
            'pager' => $pelengkapModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_pelengkap', $data);
    }

    public function setOtorisasiPelengkap()
    {
        $pelengkapId = $this->request->getPost('pelengkap_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $pelengkapModelDefault = new OtorisasiPelengkapModel(\Config\Database::connect('default'));
        $pelengkapModelDefault->update($pelengkapId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $pelengkapModelDb2 = new OtorisasiPelengkapModel(\Config\Database::connect('db2'));
        $pelengkapModelDb2->update($pelengkapId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_pelengkap')->with('success', 'Pelengkap berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_pelengkap')->with('success', 'Otorisasi pelengkap dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
