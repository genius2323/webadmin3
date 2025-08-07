<?php

namespace App\Models\Otorisasi;

use CodeIgniter\Model;

class OtorisasiUserModel extends Model
{
    protected $table = 'users'; // asumsikan tabel user
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'password',
        'nama',
        'alamat',
        'noktp',
        'profile_image',
        'birthday',
        'deleted_at',
        'recovered_at',
        'otoritas',
        'created_at',
        'updated_at',
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
