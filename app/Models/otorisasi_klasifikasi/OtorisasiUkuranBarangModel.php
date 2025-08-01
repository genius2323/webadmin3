<?php

namespace App\Models\otorisasi_klasifikasi;

use CodeIgniter\Model;

class OtorisasiUkuranBarangModel extends Model
{
    protected $table = 'ukuran_barang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'otoritas',
        'nama_ky',
        'created_at',
        'updated_at',
        'deleted_at',
        'recovered_at',
        'batas_tanggal_sistem',
        'mode_batas_tanggal'
    ];
    protected $useTimestamps = false;
    protected $DBGroup = 'default';
}
