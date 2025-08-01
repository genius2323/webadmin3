<?php

namespace App\Controllers\Otorisasi_klasifikasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi_klasifikasi\OtorisasiJumlahMataModel;

class OtorisasiJumlahMata extends BaseController
{
    public function index()
    {
        $jumlahMataModel = new OtorisasiJumlahMataModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $jumlahMataModel->select('id, name, otoritas')
            ->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('name', $keyword);
        }
        $data = [
            'jumlahmata' => $query->paginate($perPage, 'default'),
            'pager' => $jumlahMataModel->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi_klasifikasi/otorisasi_jumlahmata', $data);
    }

    public function setOtorisasiJumlahMata()
    {
        $jumlahMataId = $this->request->getPost('jumlahmata_id');
        $otoritas = $this->request->getPost('otoritas');
        // Update di database default
        $jumlahMataModelDefault = new OtorisasiJumlahMataModel(\Config\Database::connect('default'));
        $jumlahMataModelDefault->update($jumlahMataId, [
            'otoritas' => $otoritas
        ]);
        // Update juga di database kedua (db2)
        $jumlahMataModelDb2 = new OtorisasiJumlahMataModel(\Config\Database::connect('db2'));
        $jumlahMataModelDb2->update($jumlahMataId, [
            'otoritas' => $otoritas
        ]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_jumlahmata')->with('success', 'Jumlah Mata berhasil diotorisasi di kedua database.');
        } else {
            return redirect()->to('/otorisasi_klasifikasi/otorisasi_jumlahmata')->with('success', 'Otorisasi jumlah mata dinonaktifkan di kedua database.');
        }
    }
}
