<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['menu_name', 'menu_icon', 'menu_link'];
        
    // ถ้าต้องการเรียงลำดับเมนู สามารถเพิ่มเมธอดสำหรับดึงข้อมูลเมนูตามลำดับได้
    public function getOrderedMenus()
    {
        return $this->orderBy('id', 'ASC')->findAll();
    }
}