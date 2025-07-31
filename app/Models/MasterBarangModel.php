<?php
namespace App\Models;
use CodeIgniter\Model;

class MasterBarangModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $allowedFields = [
        'category_id', 'satuan_id', 'jenis_id', 'pelengkap_id', 'gondola_id', 'merk_id', 'warna_sinar_id',
        'ukuran_barang_id', 'voltase_id', 'dimensi_id', 'warna_body_id', 'warna_bibir_id', 'kaki_id',
        'model_id', 'fiting_id', 'daya_id', 'jumlah_mata_id', 'name', 'price', 'stock', 'nama_ky', 'deleted_at'
    ];
}
