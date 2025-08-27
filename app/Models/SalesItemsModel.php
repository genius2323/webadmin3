<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesItemsModel extends Model
{
    protected $table            = 'sales_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sales_id',
        'product_id',
        'product_code',
        'product_name',
        'qty',
        'unit',
        'price',
        'discount',
        'total',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function calculateTotal(int $salesId): float
    {
        $items = $this->where('sales_id', $salesId)->findAll();
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['total'];
        }
        return $total;
    }
}
