<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'password',
        'nama',
        'alamat',
        'noktp',
        'otoritas',
        'profile_image',
        'birthday',
        'deleted_at',
        'recovered_at',
        'created_at',
        'updated_at'
    ];
}
