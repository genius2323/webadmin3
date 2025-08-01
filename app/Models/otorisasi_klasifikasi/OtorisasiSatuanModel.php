<?php

namespace App\Models\otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiSatuanModel extends Model
{
    protected $table = 'satuan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'otoritas',
        'nama_ky',
        'batas_tanggal_sistem',
        'mode_batas_tanggal',
        'created_at',
        'updated_at',
        'deleted_at',
        'recovered_at'
    ];
    protected $useTimestamps = false;
    protected $DBGroup = 'default';
}
