<?php

namespace App\Models;

use CodeIgniter\Model;

class OtorisasiSalesModel extends Model
{
    protected $table = 'mastersales';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode', 'nama', 'alamat', 'tempat_lahir', 'no_hp', 'no_ktp', 'status', 'otoritas', 'deleted_at'];
    protected $DBGroup = 'default';

    public function getSalesList($search = '', $perPage = 10)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $builder = $db->table($this->table);
        if ($search) {
            $builder->like('nama', $search);
        }
        $builder->select('*');
        $builder->orderBy('nama', 'ASC');
        $page = (int)(isset($_GET['page']) ? $_GET['page'] : 1);
        $offset = ($page - 1) * $perPage;
        $list = $builder->get($perPage, $offset)->getResultArray();
        // Simulasi pager sederhana
        $total = $builder->countAllResults(false);
        $pager = service('pager');
        $pager->makeLinks($page, $perPage, $total);
        $this->pager = $pager;
        return $list;
    }

    public function updateOtorisasi($id, $otoritas)
    {
        // Update di database default
        $this->set('otoritas', $otoritas)->where('id', $id)->update();
        // Update di database kedua
        $db2 = \Config\Database::connect('db2');
        $db2->table($this->table)->set('otoritas', $otoritas)->where('id', $id)->update();
    }
}
