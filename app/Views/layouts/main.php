<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AppStack - Admin Template">
    <meta name="author" content="AppStack">
    <title><?= $this->renderSection('title') ?> </title>

    <!-- CSS -->
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/light.css') ?>" rel="stylesheet">

    <?= $this->renderSection('styles') ?>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
    <div class="wrapper">
        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <div class="main">
            <!-- Navbar -->
            <?= $this->include('partials/navbar') ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>

            <!-- Footer -->
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>