<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $dep_data = $db->query('SELECT * FROM department')->getResult();
        $data['dep_data'] = $dep_data;

        return view('employee/index', $data);
    }
}
