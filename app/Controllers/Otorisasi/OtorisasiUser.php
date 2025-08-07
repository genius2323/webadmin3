<?php

namespace App\Controllers\Otorisasi;

use App\Controllers\BaseController;
use App\Models\Otorisasi\OtorisasiUserModel;

class OtorisasiUser extends BaseController
{
    public function index()
    {
        $model = new OtorisasiUserModel();
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $keyword = $this->request->getGet('search');
        $query = $model->where('deleted_at', null);
        if ($keyword) {
            $query = $query->like('username', $keyword)->orLike('email', $keyword)->orLike('name', $keyword);
        }
        $data = [
            'list' => $query->paginate($perPage, 'default'),
            'pager' => $model->pager,
            'perPage' => $perPage,
            'search' => $keyword,
        ];
        return view('otorisasi/otorisasi_user', $data);
    }

    public function setOtorisasiUser()
    {
        $userId = $this->request->getPost('user_id');
        $otoritas = $this->request->getPost('otoritas');
        // Update di database default
        $modelDefault = new OtorisasiUserModel(\Config\Database::connect('default'));
        $modelDefault->update($userId, ['otoritas' => $otoritas]);
        // Update juga di database kedua (db2)
        $modelDb2 = new OtorisasiUserModel(\Config\Database::connect('db2'));
        $modelDb2->update($userId, ['otoritas' => $otoritas]);
        if ($otoritas === 'T') {
            return redirect()->to('/otorisasi/otorisasi_user')->with('success', 'User berhasil diotorisasi di kedua database.');
        } else {
            return redirect()->to('/otorisasi/otorisasi_user')->with('success', 'Otorisasi user dinonaktifkan di kedua database.');
        }
    }
}
