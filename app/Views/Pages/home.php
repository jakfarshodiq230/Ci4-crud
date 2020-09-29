<?= $this->extend('Layout/template'); ?>
<!-- membuat layout conten harus sama dengan section pada template -->
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>BELAJAR CI 4</h1>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>