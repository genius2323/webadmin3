<?php

namespace App\Models\Otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiJenisModel extends Model
{
    protected $table = 'jenis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'nama_ky', 'batas_tanggal_sistem', 'mode_batas_tanggal'];
    protected $useTimestamps = false;
}
