<?php

namespace App\Models;

use CodeIgniter\Model;

class OtorisasiKakiModel extends Model
{
    protected $table = 'kaki';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'otoritas',
        'nama_ky',
        'created_at',
        'updated_at',
        'deleted_at',
        'recovered_at',
        'batas_tanggal_sistem',
        'mode_batas_tanggal'
    ];
    protected $useTimestamps = false;
    // 2 database support
    protected $DBGroup = 'default';
}
