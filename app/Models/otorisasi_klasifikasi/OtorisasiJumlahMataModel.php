<?php

namespace App\Models\Otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiJumlahMataModel extends Model
{
    protected $table = 'jumlah_mata';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'otoritas', 'nama_ky', 'batas_tanggal_sistem', 'mode_batas_tanggal'];
    protected $useTimestamps = false;
}
