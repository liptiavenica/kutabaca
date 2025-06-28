<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">

    <h1 class="text-center mb-4 text-danger">📚 Selamat Datang di KutaBaca: Perpustakaan Digital Offline</h1>

    <!-- Tombol Kategori -->
    <div class="d-flex justify-content-center gap-4 mb-4">
        <a href="<?= base_url('books?search=&kategori=1&bahasa=') ?>" class="btn btn-outline-success btn-lg">
            📘 Buku Pelajaran
        </a>
        <a href="<?= base_url('books?search=&kategori=2&bahasa=') ?>" class="btn btn-outline-info btn-lg">
            📚 Buku Cerita
        </a>
        <a href="<?= base_url('books?search=&kategori=3&bahasa=') ?>" class="btn btn-outline-warning btn-lg">
            📗 Buku Pengetahuan Umum
        </a>
    </div>

    <!-- Form Pencarian -->
    <form method="get" action="<?= base_url('books') ?>" class="d-flex justify-content-center">
        <input type="text" name="search" class="form-control w-50 me-2" placeholder="Cari judul, deskripsi, atau penerbit...">
        <button type="submit" class="btn btn-primary">🔍 Cari</button>
    </form>

</div>
<?= $this->endSection(); ?>