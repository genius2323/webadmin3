<?php

namespace App\Models\Otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiKategoriModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'batas_tanggal_sistem', 'mode_batas_tanggal'];
    protected $useTimestamps = false;
}
