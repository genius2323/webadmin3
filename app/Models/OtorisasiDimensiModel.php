<?php
namespace App\Models;

use CodeIgniter\Model;

class OtorisasiDimensiModel extends Model
{
    protected $table = 'dimensi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'otoritas', 'nama_ky', 'deleted_at',
        'created_at', 'updated_at', 'description',
        'batas_tanggal_sistem', 'mode_batas_tanggal', 'recovered_at'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
