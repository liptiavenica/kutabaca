<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">
    <h1 class="section-header mb-4">📊 Dashboard Admin</h1>

    <?php if (session()->getFlashdata('welcome')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('welcome'); ?>
        </div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="<?= base_url('books/create') ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg me-1"></i> Tambah Buku
        </a>
    </div>
    <div class="text-center mt-4">
            <a href="<?= base_url('books') ?>" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-collection me-2"></i>Lihat Semua Buku
            </a>
        </div>
    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">📘 Buku Pelajaran</h5>
                    <p class="display-4 fw-bold"><?= $kategori1Count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">📚 Buku Cerita</h5>
                    <p class="display-4 fw-bold"><?= $kategori2Count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">📗 Buku Pengetahuan Umum</h5>
                    <p class="display-4 fw-bold"><?= $kategori3Count; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
