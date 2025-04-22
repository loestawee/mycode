<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $dep_data = $db->query('SELECT * FROM department')->getResult();

        $employeeData = [];

        foreach ($dep_data as $dep) {
            $emp = $db->query('SELECT * FROM employee WHERE dep_id = ' . $dep->dep_id)->getResult();
            $employeeData[] = [
                'department' => $dep,
                'employees' => $emp
            ];
        }

        return view('employee/index', [
            'employeeData' => $employeeData,
            'departments' => $dep_data
        ]);
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

    public function check_emp_id()
    {
        $emp_id = $this->request->getPost('emp_id');
        
        $db = \Config\Database::connect();
        $result = $db->table('employee')
                    ->where('emp_id', $emp_id)
                    ->countAllResults();
        
        if ($result > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'รหัสพนักงานนี้มีอยู่ในระบบแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'success', 'message' => 'รหัสพนักงานนี้สามารถใช้งานได้']);
        }
    }


    public function save()
    {
        // กำหนดกฎการตรวจสอบข้อมูล
        $rules = [
            'emp_id' => [
                'rules' => 'required|min_length[3]|is_unique[employee.emp_id]',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสพนักงาน',
                    'min_length' => 'รหัสพนักงานต้องมีอย่างน้อย 3 ตัวอักษร',
                    'is_unique' => 'รหัสพนักงานนี้มีอยู่ในระบบแล้ว'
                ]
            ],
            'emp_name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อพนักงาน',
                    'min_length' => 'ชื่อพนักงานต้องมีอย่างน้อย 3 ตัวอักษร'
                ]
            ],
            'emp_password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสผ่าน',
                    'min_length' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร'
                ]
            ],
            'dep_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณาเลือกหน่วยงาน',
                    'numeric' => 'รหัสหน่วยงานไม่ถูกต้อง'
                ]
            ]
        ];

        // ตรวจสอบข้อมูลตามกฎที่กำหนด
        if (!$this->validate($rules)) {
            // ถ้าข้อมูลไม่ผ่านการตรวจสอบ ส่งกลับไปยังฟอร์มพร้อมข้อความผิดพลาด
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // ถ้าข้อมูลผ่านการตรวจสอบแล้ว ดำเนินการบันทึก
        $db = \Config\Database::connect();
        $emp_id = $this->request->getPost('emp_id');
        $emp_name = $this->request->getPost('emp_name');
        $emp_password = $this->request->getPost('emp_password');
        $dep_id = $this->request->getPost('dep_id');

        // เข้ารหัสรหัสผ่านด้วย password_hash
        $hashed_password = password_hash($emp_password, PASSWORD_DEFAULT);

        $data = [
            'emp_id' => $emp_id,
            'emp_name' => $emp_name,
            'emp_password' => $hashed_password,
            'dep_id' => $dep_id,
        ];

        $db->table('employee')->insert($data);
        return redirect()->to('/employee')->with('message', 'บันทึกข้อมูลพนักงานเรียบร้อยแล้ว');
    }
}
