<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle d-flex">
        <i class="hamburger align-self-center"></i>
    </a>

    <form class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <input type="text" class="form-control" placeholder="ค้นหา..." aria-label="Search">
            <button class="btn" type="button">
                <i class="align-middle" data-feather="search"></i>
            </button>
        </div>
    </form>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <!-- เพิ่มเมนู navbar ตามต้องการ -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="<?= base_url('assets/images/avatars/avatar.jpg') ?>" class="avatar img-fluid rounded me-1" alt="User" /> <span class="text-dark">ชื่อผู้ใช้</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> โปรไฟล์</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">ออกจากระบบ</a>
                </div>
            </li>
        </ul>
    </div>
</nav>