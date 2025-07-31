<?php
namespace App\Models;
use CodeIgniter\Model;
class MasterPelengkapModel extends Model
{
protected $table = 'pelengkap';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'nama_ky', 'otoritas', 'deleted_at'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    public function getData($keyword = null)
    {
        if ($keyword) {
            return $this->where('deleted_at', null)
                ->groupStart()
                ->like('name', $keyword)
                // ...existing code...
                ->groupEnd()
                ->findAll();
        }
        return $this->where('deleted_at', null)->findAll();
    }
}
