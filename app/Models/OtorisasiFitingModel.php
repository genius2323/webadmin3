<?php

namespace App\Models;

use CodeIgniter\Model;

class OtorisasiFitingModel extends Model
{
    protected $table = 'fiting';
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
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
