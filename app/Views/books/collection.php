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
                <div class="mb-3 text-center">
                    <a href="<?= base_url('/books/create') ?>" class="btn btn-success btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!empty($books)): ?>
                <div class="row">
                    <?php foreach ($books as $b): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <a href="<?= base_url('books/detail/' . $b['slug']) ?>" class="text-decoration-none">
                                <div class="card h-100 shadow-sm book-card">
                                    <div class="book-cover-container">
                                        <img src="<?= base_url('uploads/covers/' . ($b['cover_image'] ?? 'default.jpg')) ?>"
                                            alt="<?= esc($b['title']) ?>"
                                            class="card-img-top book-cover">
                                        <div class="book-overlay">
                                            <i class="bi bi-book-open overlay-icon"></i>
                                        </div>
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
                                    <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                                        <div class="card-footer bg-transparent border-0 text-center">
                                            <a href="<?= base_url('books/delete/' . $b['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
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
<?= $this->endSection(); ?>