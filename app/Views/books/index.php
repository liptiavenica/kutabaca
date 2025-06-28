<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">

    <h1 class="section-header">📚 Selamat Datang di KutaBaca: Perpustakaan Digital Offline</h1>

    <!-- Tombol Kategori -->
    <div class="d-flex justify-content-center gap-4 mb-4 flex-wrap">
        <?php foreach ($categories as $category): ?>
            <a href="<?= base_url('books?search=&kategori=' . $category['id'] . '&bahasa=') ?>" 
               class="btn btn-outline-primary btn-lg">
                <?php if ($category['id'] == 1): ?>
                    📘 <?= esc($category['name']) ?>
                <?php elseif ($category['id'] == 2): ?>
                    📚 <?= esc($category['name']) ?>
                <?php else: ?>
                    📗 <?= esc($category['name']) ?>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
        <a href="<?= base_url('books') ?>" class="btn btn-outline-secondary btn-lg">
            📖 Semua Kategori
        </a>
    </div>

    <!-- Form Pencarian -->
    <form method="get" action="<?= base_url('books') ?>" class="d-flex justify-content-center mb-5">
        <input type="text" name="search" class="form-control w-50 me-2" placeholder="🔍 Cari judul, deskripsi, atau penerbit...">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search me-1"></i>Cari
        </button>
    </form>

    <!-- Buku Terbaru -->
    <?php if (!empty($recentBooks)): ?>
    <div class="mt-5">
        <h2 class="section-header">🆕 Buku Terbaru</h2>
        <div class="row">
            <?php foreach ($recentBooks as $book): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= base_url('books/detail/' . $book['slug']) ?>" class="text-decoration-none">
                    <div class="card h-100 shadow-sm book-card">
                        <div class="book-cover-container">
                            <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'default.jpg')) ?>" 
                                 class="card-img-top book-cover" alt="<?= esc($book['title']) ?>">
                            <div class="book-overlay">
                                <i class="bi bi-book-open overlay-icon"></i>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold book-title"><?= esc($book['title']) ?></h5>
                            <p class="card-text text-muted book-category">
                                <i class="bi bi-tag-fill me-1"></i>
                                <?= esc($book['category_name'] ?? 'Kategori Umum') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('books') ?>" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-collection me-2"></i>Lihat Semua Buku
            </a>
        </div>
    </div>
    <?php endif; ?>

</div>
<?= $this->endSection(); ?>