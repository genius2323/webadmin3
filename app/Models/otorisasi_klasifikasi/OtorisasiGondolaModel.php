<?php

namespace App\Models\Otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiGondolaModel extends Model
{
    protected $table = 'gondola';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'nama_ky', 'batas_tanggal_sistem', 'mode_batas_tanggal'];
    protected $useTimestamps = false;
}
