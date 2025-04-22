<?php
namespace App\Models;

use Codeigniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'emp_id';
    protected $allowedFields = ['emp_name', 'emp_password', 'emp_createdate', 'dep_id'];
}