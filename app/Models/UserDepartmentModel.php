<?php
namespace App\Models;

use CodeIgniter\Model;

class UserDepartmentModel extends Model
{
    protected $table = 'user_departments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'department_id', 'deleted_at'
    ];
    protected $useSoftDeletes = true;
}
