<?php

namespace App\Controllers;

use App\Models\OtorisasiKakiModel;
use CodeIgniter\Controller;

class OtorisasiKaki extends Controller
{
    protected $kakiModel;
    protected $pager;
    protected $db2;

    public function __construct()
    {
        $this->kakiModel = new OtorisasiKakiModel();
        $this->pager = \Config\Services::pager();
        // 2 database support
        $this->db2 = \Config\Database::connect('db2');
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $query = $this->kakiModel;
        if ($search) {
            $query = $query->like('name', $search);
        }
        $data['kaki'] = $query->paginate($perPage, 'default');
        $data['pager'] = $this->kakiModel->pager;
        return view('otorisasi_klasifikasi/otorisasi_kaki', $data);
    }

    // Tambah, edit, delete, otorisasi, dsb bisa ditambahkan sesuai kebutuhan
}
