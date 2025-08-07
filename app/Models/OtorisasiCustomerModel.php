<?php

namespace App\Models;

use CodeIgniter\Model;

class OtorisasiCustomerModel extends Model
{
    protected $table = 'mastercustomer';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_customer',
        'nama_customer',
        'alamat',
        'sales',
        'otoritas'
    ];
    protected $DBGroup = 'default';

    /**
     * Update otoritas customer di dua database sekaligus
     */
    public function updateOtorisasiMultiDB($customer_id, $otoritas)
    {
        // Update di database utama
        $this->update($customer_id, ['otoritas' => $otoritas]);
        // Update di database kedua
        $db2 = \Config\Database::connect('db2');
        $db2->table($this->table)->where('id', $customer_id)->update(['otoritas' => $otoritas]);
    }

    /**
     * Get list customer dengan pencarian dan paginasi
     */
    public function getList($search = '', $perPage = 10)
    {
        if ($search) {
            $this->groupStart()
                ->like('kode_customer', $search)
                ->orLike('nama_customer', $search)
                ->orLike('alamat', $search)
                ->orLike('sales', $search)
                ->groupEnd();
        }
        return $this->paginate($perPage);
    }

    /**
     * Update otoritas customer di satu database
     */
    public function updateOtorisasi($customer_id, $otoritas)
    {
        return $this->update($customer_id, ['otoritas' => $otoritas]);
    }
}
