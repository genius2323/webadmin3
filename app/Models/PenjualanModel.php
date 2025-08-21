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
        $builder = $this->db->table('sales')
            ->select('sales.*, mastercustomer.nama_customer, mastersales.nama as nama_sales')
            // Join tetap left agar nota draft tanpa customer/sales tetap tampil
            ->join('mastercustomer', 'mastercustomer.id = sales.customer', 'left')
            ->join('mastersales', 'mastersales.id = sales.sales', 'left')
            ->where('sales.deleted_at', null);
        if ($keyword) {
            $builder->groupStart()
                ->like('sales.nomor_nota', $keyword)
                ->orLike('mastercustomer.nama_customer', $keyword)
                ->orLike('mastersales.nama', $keyword)
                ->groupEnd();
        }
        return $builder->get()->getResultArray();
    }
}
