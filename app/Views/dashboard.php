<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
แดชบอร์ด
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-3">แดชบอร์ด</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">ยินดีต้อนรับ</h5>
                <h6 class="card-subtitle text-muted">นี่คือตัวอย่างหน้าแดชบอร์ดที่ใช้ AppStack กับ CodeIgniter 4</h6>
            </div>
            <div class="card-body">
                <p>คุณสามารถปรับแต่งหน้านี้ได้ตามต้องการ</p>
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