<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>

<!-- Contoh Artikel Sederhana -->
<div class="artikel">
    <h3>Judul Artikel 1</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <a href="#">Baca Selengkapnya</a>
</div>

<div class="artikel">
    <h3>Judul Artikel 2</h3>
    <p>Quisque vel purus ut orci aliquam facilisis.</p>
    <a href="#">Baca Selengkapnya</a>
</div>
<?= $this->endSection() ?>
