<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterWarnaSinarModel extends Model
{
    protected $table = 'warna_sinar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'otoritas', 'deleted_at'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $returnType = 'array';
}
