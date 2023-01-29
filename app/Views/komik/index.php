<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="justify-content-end d-flex mt-3">
                <a href="/komik/create" class="btn btn-primary">Tambah Manhwa</a>
            </div>
            <h1 class="mt-2">Daftar Manhwa</h1>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (3 * ($currentPage - 1)); ?>
                    <?php foreach ($komik as $k) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $k['sampul']; ?>" alt="<?= $k['slug']; ?>" class="sampul"></td>
                            <td><?= $k['judul']; ?></td>
                            <td><?= $k['penulis']; ?></td>
                            <td><?= $k['penerbit']; ?></td>
                            <td><?= $k['genre']; ?></td>
                            <td>
                                <a href="/komik/<?= $k['slug']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?= $pager->links('komik', 'komik_pagination'); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>