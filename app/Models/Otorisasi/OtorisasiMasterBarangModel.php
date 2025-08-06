<?php

namespace App\Models\Otorisasi;

use CodeIgniter\Model;

class OtorisasiMasterBarangModel extends Model
{
    protected $table = 'products'; // ambil dari master barang
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode',
        'name',
        'category_id',
        'satuan_id',
        'jenis_id',
        'price',
        'stock',
        'otoritas',
        // tambahkan field lain dari tabel products jika perlu
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
