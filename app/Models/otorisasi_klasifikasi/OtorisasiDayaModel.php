<?php

namespace App\Models\Otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiDayaModel extends Model
{
    protected $table = 'daya';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'batas_tanggal_sistem', 'mode_batas_tanggal'];
    protected $useTimestamps = false;
}
