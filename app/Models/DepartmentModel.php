<?php
namespace App\Models;

use Codeigniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'dep_id';
    protected $allowedFields = ['dep_name'];
}