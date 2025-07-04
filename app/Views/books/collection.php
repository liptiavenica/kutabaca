<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="section-header">📚 Daftar Buku</h2>

            <form method="get" class="mb-4 d-flex flex-wrap gap-2 align-items-center justify-content-center">
                <input type="text" name="search" value="<?= esc($keyword) ?>" placeholder="🔍 Cari judul/deskripsi/penerbit" class="form-control" style="max-width: 250px;">

                <select name="kategori" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
                    <option value="">📂 Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($selected_kategori == $k['id']) ? 'selected' : '' ?>>
                            <?= $k['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="bahasa" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
                    <option value="">🌍 Semua Bahasa</option>
                    <option value="id" <?= ($selected_language == 'id') ? 'selected' : '' ?>>🇮🇩 Indonesia</option>
                    <option value="en" <?= ($selected_language == 'en') ? 'selected' : '' ?>>🇺🇸 English</option>
                </select>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </form>

            <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                <div class="mt-4 text-center">
                    <a href="<?= base_url('books/create') ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
                    </a>
                </div>
                <br>
            <?php endif; ?>

            <?php if (!empty($books)): ?>
                <div class="row">
                    <?php foreach ($books as $b): ?>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm book-card">
                                <div class="position-relative book-cover-container">
                                    <a href="<?= base_url('books/detail/' . $b['slug']) ?>" class="text-decoration-none">
                                        <img src="<?= base_url('uploads/covers/' . ($b['cover_image'] ?? 'default.jpg')) ?>"
                                            alt="<?= esc($b['title']) ?>"
                                            class="card-img-top book-cover">
                                        <div class="book-overlay d-flex justify-content-center align-items-center">
                                            <i class="bi bi-book-open overlay-icon"></i>
                                        </div>
                                    </a>

                                    <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                                        <div class="admin-controls d-flex gap-2 position-absolute top-0 end-0 m-2" style="display: none;">
                                            <a href="<?= base_url('books/edit/' . $b['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="<?= base_url('books/delete/' . $b['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold book-title"><?= esc($b['title']) ?></h5>
                                    <p class="card-text text-muted book-category">
                                        <i class="bi bi-tag-fill me-1"></i> <?= esc($b['category_name'] ?? 'Tanpa Kategori') ?>
                                    </p>
                                    <p class="card-text text-muted small">
                                        <i class="bi bi-translate me-1"></i> <?= esc($b['language'] == 'id' ? 'Indonesia' : 'English') ?>
                                        <?php if ($b['publisher']): ?>
                                            <br><i class="bi bi-building me-1"></i> <?= esc($b['publisher']) ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center" style="background: linear-gradient(135deg, var(--primary-pink-light) 0%, var(--accent-yellow) 100%); border: 2px solid var(--primary-pink); border-radius: 15px;">
                    <i class="bi bi-info-circle me-2" style="font-size: 1.5rem;"></i>
                    <strong>Buku tidak ditemukan dengan filter yang dipilih.</strong>
                    <br>
                    <small>Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.</small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top">
<i class="bi bi-arrow-up">Kembali Ke Atas
</i></button>
<script>// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}</script>

<?= $this->endSection(); ?>
