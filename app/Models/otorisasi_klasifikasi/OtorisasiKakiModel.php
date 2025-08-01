<?php

namespace App\Models\Otorisasi_klasifikasi;

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
    protected $DBGroup = 'default';
}
