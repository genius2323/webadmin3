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

    public function getBatasTanggal()
    {
        $row = $this->orderBy('id', 'desc')->first();
        if (!$row) return null;
        // Asumsi batas_tanggal format: YYYY-MM-DD, mode_batas_tanggal: 'range' atau lain
        $min = $row['batas_tanggal'] ?? date('Y-m-01');
        $max = date('Y-m-d');
        return [
            'min' => $min,
            'max' => $max,
            'mode' => $row['mode_batas_tanggal'] ?? null
        ];
    }
}
