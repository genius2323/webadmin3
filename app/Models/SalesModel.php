<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_nota', 'tanggal_nota', 'customer', 'sales', 
        'total', 'discount', 'tax', 'grand_total', 
        'payment_a', 'payment_b', 'account_receivable', 'payment_system',
        'otoritas', 'batas_tanggal_sistem', 'mode_batas_tanggal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nomor_nota'   => 'required|string|max_length[32]|is_unique[sales.nomor_nota,id,{id}]',
        'tanggal_nota' => 'required|valid_date',
        'customer'     => 'required|string|max_length[100]',
        'sales'        => 'required|string|max_length[100]',
        'total'        => 'required|numeric',
        'grand_total'  => 'required|numeric',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
