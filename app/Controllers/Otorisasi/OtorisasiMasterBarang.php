<?php

namespace App\Controllers\Otorisasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi\OtorisasiMasterBarangModel;

class OtorisasiMasterBarang extends BaseController
{
    public function index()
    {
        $model = new OtorisasiMasterBarangModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $model->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword)->orLike('kode', $keyword);
        }
        $data = [
            'list' => $query->paginate($perPage, 'default'),
            'pager' => $model->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi/otorisasi_masterbarang', $data);
    }

    public function setOtorisasiMasterBarang()
    {
        $barangId = $this->request->getPost('barang_id');
        $otoritas = $this->request->getPost('otoritas');
        // Update di database default
        $modelDefault = new OtorisasiMasterBarangModel(\Config\Database::connect('default'));
        $modelDefault->update($barangId, ['otoritas' => $otoritas]);
        // Update juga di database kedua (db2)
        $modelDb2 = new OtorisasiMasterBarangModel(\Config\Database::connect('db2'));
        $modelDb2->update($barangId, ['otoritas' => $otoritas]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi/otorisasi_masterbarang')->with('success', 'Barang berhasil diotorisasi di kedua database.');
        } else {
            return redirect()->to('/otorisasi/otorisasi_masterbarang')->with('success', 'Otorisasi barang dinonaktifkan di kedua database.');
        }
    }
}
