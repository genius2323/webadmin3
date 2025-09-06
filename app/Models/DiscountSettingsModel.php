<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscountSettingsModel extends Model
{
    protected $table = 'discount_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'discount_type',
        'active',
        'value_nominal',
        'value_percent',
        'tier_json',
        'customer_type',
        'nota_nominal',
        'nota_percent',
        'updated_at'
    ];
    protected $useTimestamps = false;
}
