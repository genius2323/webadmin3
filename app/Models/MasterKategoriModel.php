<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterKategoriModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_cat', 'name', 'description', 'otoritas', 'nama_ky', 'batas_tanggal_sistem', 'mode_batas_tanggal', 'created_at', 'updated_at', 'deleted_at', 'recovered_at'];
}
