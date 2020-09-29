<?= $this->extend('Layout/template'); ?>
<!-- membuat layout conten harus sama dengan section pada template -->
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-4">
            <h1 class="mt-2">Komik</h1>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukan " name="cari">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="/Komik/create" class="btn btn-primary mb-3">Tambah Data</a>
            <?php if (session('pesan')) {    ?>
                <div class="alert alert-success col-12" role="alert">
                    <?= session('pesan'); ?>
                </div>
            <?php } ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (6 * ($currentPage - 1)); ?>
                    <?php foreach ($komik as $k) : ?>
                        <tr>
                            <td scope="row"><?= $no++; ?></td>
                            <td><img src="/img/<?= $k['sampul']; ?>" alt="" class="sampul"></td>
                            <td><?= $k['judul']; ?></td>
                            <td><a href="/komik/<?= $k['slug']; ?>" class=" btn btn-success">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- membuat pagination -->
            <?= $pager->links('komik', 'komik_pagination'); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>