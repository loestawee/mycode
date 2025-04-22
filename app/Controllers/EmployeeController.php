<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    public function index(): string
    {
        $model = new EmployeeModel();
        $data['emp_data'] = $model->findAll();

        $db = \Config\Database::connect();
        $dep_data = $db->query('SELECT * FROM department')->getResult();
        $data['dep_data'] = $dep_data;

        return view('employee/index', $data);
    }

    public function view()
    {
        $db = \Config\Database::connect();

        $department = $db->query('SELECT * FROM department')->getResult();

        $employeeData = [];

        foreach ($department as $dep) {
            $emp = $db->query('SELECT * FROM employee WHERE dep_id = ' . $dep->dep_id)->getResult();
            $employeeData[] = [
                'department' => $dep,
                'employees' => $emp
            ];
        }

        // ----- แบ่งหน้า -----
        $perPage = 2;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $total = count($employeeData);
        $start = ($page - 1) * $perPage;

        $pagedData = array_slice($employeeData, $start, $perPage);

        // เตรียม pager แบบ manual
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total, 'bootstrap');


        return view('employee/view', [
            'employeeData' => $pagedData,
            'pager' => $pager
        ]);
    }
}
