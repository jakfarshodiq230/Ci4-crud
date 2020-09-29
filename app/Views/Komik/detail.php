<?= $this->extend('Layout/template'); ?>
<!-- membuat layout conten harus sama dengan section pada template -->
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Detail</h1>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text"><b>Penulis : </b> <?= $komik['penulis']; ?></p>
                            <p class="card-text"><b>Penerbit : </b><?= $komik['penerbit']; ?></p>
                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning ">Edit</a>
                            <form action="/komik/delete/<?= $komik['id']; ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELET">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Yakin Menghapus Data ini');">Delete</button>
                            </form>
                            <a href="/komik" class="btn btn-primary ">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>