<?php
namespace App\Models;
use CodeIgniter\Model;

class MasterCustomerModel extends Model
{
    protected $table = 'mastercustomer';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_customer', 'nama_customer', 'alamat', 'contact_person', 'kota', 'provinsi', 'sales', 'no_hp', 'batas_piutang',
        'npwp_nomor', 'npwp_atas_nama', 'npwp_alamat', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $returnType = 'array';
    protected $DBGroup = 'default';
}
