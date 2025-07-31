<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $DBGroup = 'default'; // default ke database utama
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nomor_nota',
        'tanggal_nota',
        'customer',
        'sales',
        'total',
        'discount',
        'status',
        'grand_total',
        'nama_ky',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    public function getData($keyword = null)
    {
        if ($keyword) {
            return $this->where('deleted_at', null)
                ->groupStart()
                    ->like('nomor_nota', $keyword)
                    ->orLike('customer', $keyword)
                    ->orLike('sales', $keyword)
                ->groupEnd()
                ->findAll();
        }
        return $this->where('deleted_at', null)->findAll();
    }
}
