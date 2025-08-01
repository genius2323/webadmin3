<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiWarnaBibirModel;

class OtorisasiWarnaBibir extends BaseController
{
    public function index()
    {
        $warnaBibirModel = new OtorisasiWarnaBibirModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $warnaBibirModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'warnabibir' => $query->paginate($perPage, 'default'),
            'pager' => $warnaBibirModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_warnabibir', $data);
    }

    public function setOtorisasiWarnaBibir()
    {
        $warnaBibirId = $this->request->getPost('warnabibir_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $warnaBibirModelDefault = new OtorisasiWarnaBibirModel(\Config\Database::connect('default'));
        $warnaBibirModelDefault->update($warnaBibirId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $warnaBibirModelDb2 = new OtorisasiWarnaBibirModel(\Config\Database::connect('db2'));
        $warnaBibirModelDb2->update($warnaBibirId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnabibir')->with('success', 'Warna bibir berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_warnabibir')->with('success', 'Otorisasi warna bibir dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
