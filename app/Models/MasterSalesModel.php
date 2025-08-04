<?php
namespace App\Models;
use CodeIgniter\Model;

class MasterSalesModel extends Model
{
    protected $table = 'mastersales';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode', 'nama', 'alamat', 'tempat_lahir', 'no_hp', 'no_ktp', 'status', 'otoritas',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    // Gunakan koneksi database kedua
protected $DBGroup = 'default';
}
