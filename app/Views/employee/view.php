<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
แดชบอร์ด
<?= $this->endSection() ?>

<?= $this->section('styles')?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->endSection()?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">รายชื่อพนักงานตามหน่วยงาน</h1>

<div class="row">
    <?php foreach ($employeeData as $data): ?>
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">หน่วยงาน: <?= esc($data['department']->dep_name) ?></h5>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($data['employees'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>รหัสพนักงาน</th>
                                        <th>ชื่อ</th>
                                        <th>วันที่สร้าง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['employees'] as $emp): ?>
                                        <tr>
                                            <td><?= esc($emp->emp_id) ?></td>
                                            <td><?= esc($emp->emp_name) ?></td>
                                            <td><?= esc($emp->emp_createdate) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">ไม่มีพนักงานในหน่วยงานนี้</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($pager): ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php $pagi_path = 'employee/view'; ?>
        
        <?php $currentPage = $pager->getCurrentPage(); ?>
        <?php $pageCount = $pager->getPageCount(); ?>
        
        <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?= site_url($pagi_path . '?page=1') ?>" aria-label="First">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= site_url($pagi_path . '?page=' . ($currentPage - 1)) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = max(1, $currentPage - 2); $i <= min($pageCount, $currentPage + 2); $i++): ?>
            <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                <a class="page-link" href="<?= site_url($pagi_path . '?page=' . $i) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
        
        <?php if ($currentPage < $pageCount): ?>
            <li class="page-item">
                <a class="page-link" href="<?= site_url($pagi_path . '?page=' . ($currentPage + 1)) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= site_url($pagi_path . '?page=' . $pageCount) ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    console.log("โหลดหน้าแดชบอร์ดสำเร็จ");
</script>
<?= $this->endSection() ?>