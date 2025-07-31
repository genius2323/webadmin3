<?php

namespace App\Models;

use CodeIgniter\Model;

class OtorisasiDayaModel extends Model
{
    protected $table = 'master_daya';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'otoritas'];
}
