<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="header">
        <h1>About Me</h1>
    </div><!-- end header-->
    <div class="image">
        <img src="/img/AgungFebryanto.jpg" class="agung">
    </div><!-- end image-->
    <div class="intro column">
        <h2>Agung Febryanto</h2>
        <h4>20200801430</h4>
        <h4>Teknik Informatika</h4>
        <h4>UAS Pemrograman Web</h4>
        <h4>Universitas Esa Unggul</h4>
    </div><!--end container-->

    <?= $this->endSection(); ?>