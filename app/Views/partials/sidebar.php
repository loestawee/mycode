<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url() ?>">
            <span class="align-middle">AppStack</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                เมนูหลัก
            </li>

            <?php
            // เรียกใช้งาน Model สำหรับเมนู
            $menuModel = new \App\Models\MenuModel();
            // ดึงข้อมูลเมนูทั้งหมดจากฐานข้อมูล
            $menus = $menuModel->findAll();
            
            // วนลูปแสดงเมนูทั้งหมด
            foreach ($menus as $menu) {
                // ตรวจสอบว่าเมนูปัจจุบันเป็นเมนูที่กำลังเปิดอยู่หรือไม่
                $active = (current_url() == base_url($menu['menu_link'])) ? 'active' : '';
            ?>
                <li class="sidebar-item <?= $active ?>">
                    <a class="sidebar-link" href="<?= base_url($menu['menu_link']) ?>">
                        <i class="fa fa-<?= $menu['menu_icon'] ?>"></i> <span class="align-middle"><?= $menu['menu_name'] ?></span>
                    </a>
                </li>
            <?php } ?>
            
        </ul>
    </div>
</nav>