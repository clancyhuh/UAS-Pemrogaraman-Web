<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Manhwa</h2>
            <div class="card mb-3" style="max-width: 600px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text"><b>Penulis: </b><?= $komik['penulis']; ?></p>
                            <p class="card-text"><b>Penerbit: </b><?= $komik['penerbit']; ?></p>
                            <p class="card-text"><b>Genre: </b><?= $komik['genre']; ?></p>
                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning">Edit</a>
                            <form action="/komik/<?= $komik['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin?');">Delete</button>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/komik/">Kembali Ke Daftar Komik</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>