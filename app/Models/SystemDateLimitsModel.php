<?php
namespace App\Models;
use CodeIgniter\Model;

class SystemDateLimitsModel extends Model
{
    protected $table = 'system_date_limits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['menu', 'batas_tanggal', 'mode_batas_tanggal', 'created_at', 'updated_at'];
    // Default group, bisa diubah di instance
    public $DBGroup = 'default';
}
