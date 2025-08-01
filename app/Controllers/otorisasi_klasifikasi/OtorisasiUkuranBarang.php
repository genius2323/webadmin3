<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\otorisasi_klasifikasi\OtorisasiUkuranBarangModel;

class OtorisasiUkuranBarang extends BaseController
{
    public function index()
    {
        $ukuranBarangModel = new OtorisasiUkuranBarangModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $ukuranBarangModel->select('id, name, description, otoritas, batas_tanggal_sistem, mode_batas_tanggal')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'ukuranbarang' => $query->paginate($perPage, 'default'),
            'pager' => $ukuranBarangModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_ukuranbarang', $data);
    }

    public function setOtorisasiUkuranBarang()
    {
        $ukuranBarangId = $this->request->getPost('ukuranbarang_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $ukuranBarangModelDefault = new OtorisasiUkuranBarangModel(\Config\Database::connect('default'));
        $ukuranBarangModelDefault->update($ukuranBarangId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $ukuranBarangModelDb2 = new OtorisasiUkuranBarangModel(\Config\Database::connect('db2'));
        $ukuranBarangModelDb2->update($ukuranBarangId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_ukuranbarang')->with('success', 'Ukuran barang berhasil diotorisasi & batas tanggal disimpan di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_ukuranbarang')->with('success', 'Otorisasi ukuran barang dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
