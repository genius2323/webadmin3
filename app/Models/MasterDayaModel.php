<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterDayaModel extends Model
{
    protected $table = 'daya';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'nama_ky', 'deleted_at', 'created_at', 'updated_at', 'recovered_at'];
}
