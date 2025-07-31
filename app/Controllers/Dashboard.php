<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $departmentId = session()->get('department_id');
        // Routing ke view sesuai departemen
        switch ($departmentId) {
            case 1:
                return view('dashboard/pos');
            case 2:
                return view('dashboard/backoffice');
            case 3:
                return view('dashboard/general');
            default:
                return view('dashboard/general');
        }
    }
}
