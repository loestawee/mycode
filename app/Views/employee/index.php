<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
แดชบอร์ด
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-3">Employee</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">ตารางแสดงข้อมูล</h5>
            </div>
            <div class="card-body">
                <?php
                foreach ($dep_data as $row) {
                    echo 'หน่วยงาน' . $row->dep_name;
                ?>

                    <table id="datatables-basic" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสพนักงาน</th>
                                <th>ชื่อ</th>
                                <th>หน่วยงาน</th>
                                <th>วันที่สร้าง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = \Config\Database::connect();
                            $emp_data = $db->query('SELECT * FROM employee WHERE dep_id = ' . $row->dep_id)->getResult();
                            foreach ($emp_data as $row_emp) {
                            ?>
                                <tr>
                                    <td><?php echo $row_emp->emp_id; ?></td>
                                    <td><?php echo $row_emp->emp_name; ?></td>
                                    <td><?php echo $row->dep_name; ?></td>
                                    <td><?php echo $row_emp->emp_createdate; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // เพิ่ม JavaScript เฉพาะหน้านี้ได้ที่นี่
    console.log("หน้าแดชบอร์ดถูกโหลด");
</script>
<?= $this->endSection() ?>