<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi_klasifikasi\OtorisasiKategoriModel;

class OtorisasiKategori extends BaseController
{
    // Tampilkan halaman otorisasi kategori
    public function index()
    {
        $categoryModel = new OtorisasiKategoriModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $categoryModel->select('id, name, description, otoritas');
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'categories' => $query->paginate($perPage, 'default'),
            'pager' => $categoryModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_kategori', $data);
    }

    // Proses set otorisasi kategori
    public function setOtorisasiKategori()
    {
        $kategoriId = $this->request->getPost('kategori_id');
        $otoritas = $this->request->getPost('otoritas');
        $batasTanggal = $this->request->getPost('batas_tanggal_sistem');
        $modeBatas = $this->request->getPost('mode_batas_tanggal');
        // Update di database default
        $categoryModelDefault = new OtorisasiKategoriModel(\Config\Database::connect('default'));
        $categoryModelDefault->update($kategoriId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        // Update juga di database kedua (db2)
        $categoryModelDb2 = new OtorisasiKategoriModel(\Config\Database::connect('db2'));
        $categoryModelDb2->update($kategoriId, [
            'otoritas' => $otoritas,
            'batas_tanggal_sistem' => $batasTanggal,
            'mode_batas_tanggal' => $modeBatas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_kategori')->with('success', 'Kategori berhasil diotorisasi & batas tanggal disimpan di kedua database. Sekarang bisa diedit atau dihapus.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_kategori')->with('success', 'Otorisasi kategori dinonaktifkan & batas tanggal disimpan di kedua database.');
        }
    }
}
