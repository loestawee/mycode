<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
แดชบอร์ด
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-3">Employee</h1>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#defaultModalSuccess">
    เพิ่มข้อมูล
</button>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">ตารางแสดงข้อมูล</h5>
            </div>
            <div class="card-body">
                <?php
                foreach ($employeeData as $row) {
                    echo 'หน่วยงาน' . $row['department']->dep_name;
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
                            foreach ($row['employees'] as $row_emp) {
                            ?>
                                <tr>
                                    <td><?php echo $row_emp->emp_id; ?></td>
                                    <td><?php echo $row_emp->emp_name; ?></td>
                                    <td><?php echo $row['department']->dep_name; ?></td>
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

<div class="modal fade" id="defaultModalSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ข้อมูลพนักงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form action="/employee/save" method="post">
                    <div class="form-group">
                        <label for="emp_id">รหัสพนักงาน</label>
                        <input type="text" class="form-control" id="emp_id" name="emp_id" required minlength="3">
                        <small id="emp_id_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="emp_name" placeholder="กรอกชื่อ นามสกุล" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">รหัสผ่าน</label>
                        <input type="text" class="form-control" id="emp_password" placeholder="กรอกรหัสผ่าน" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">หน่วยงาน</label>
                        <select id="dep_id" class="form-select" aria-label="Default select example">
                            <?php
                            foreach ($departments as $row) {
                                echo '<option value="' . $row->dep_id . '">' . $row->dep_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success">
        <?= session('message') ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#emp_id').keyup(function() {
            var emp_id = $(this).val();
            if (emp_id.length >= 1) {
                $.ajax({
                    url: '<?= site_url('employee/check_emp_id') ?>',
                    type: 'POST',
                    data: {
                        emp_id: emp_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'error') {
                            $('#emp_id_error').html(response.message).addClass('text-danger');
                            $('#submitBtn').prop('disabled', true);
                        } else {
                            $('#emp_id_error').html(response.message).removeClass('text-danger').addClass('text-success');
                            $('#submitBtn').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#emp_id').on('blur', function() {
            var emp_id = $(this).val();
            if (emp_id.length >= 3) {
                $.ajax({
                    url: '<?= site_url('employee/check_emp_id') ?>',
                    type: 'POST',
                    data: {
                        emp_id: emp_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'error') {
                            $('#emp_id_error').html(response.message).addClass('text-danger');
                            $('#submitBtn').prop('disabled', true);
                        } else {
                            $('#emp_id_error').html(response.message).removeClass('text-danger').addClass('text-success');
                            $('#submitBtn').prop('disabled', false);
                        }
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>