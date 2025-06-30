<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">
    <div class="row">

        <!-- Cover Buku -->
        <div class="col-lg-4 mb-4">
            <div class="book-detail-cover-container">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'default.jpg')) ?>"
                     alt="<?= esc($book['title']) ?>"
                     class="book-detail-cover">
                <div class="book-detail-overlay">
                    <i class="bi bi-book-open overlay-icon-large"></i>
                </div>
            </div>
        </div>

        <!-- Informasi Buku -->
        <div class="col-lg-8">
            <div class="book-detail-info">
                <h1 class="book-detail-title"><?= esc($book['title']) ?></h1>

                <!-- Kategori -->
                <div class="book-detail-category mb-3">
                    <span class="category-badge">
                        <i class="bi bi-tag-fill me-1"></i>
                        <?= esc($book['category_name'] ?? 'Kategori Umum') ?>
                    </span>
                </div>

                <!-- Informasi Dasar -->
                <div class="book-detail-meta mb-3">
                    <?php if ($book['publisher']): ?>
                        <div class="meta-item">
                            <i class="bi bi-building text-primary"></i>
                            <span><strong>Penerbit:</strong> <?= esc($book['publisher']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($book['isbn']): ?>
                        <div class="meta-item">
                            <i class="bi bi-upc text-success"></i>
                            <span><strong>ISBN:</strong> <?= esc($book['isbn']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($book['year']): ?>
                        <div class="meta-item">
                            <i class="bi bi-calendar text-warning"></i>
                            <span><strong>Tahun:</strong> <?= esc($book['year']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($book['number_of_pages']): ?>
                        <div class="meta-item">
                            <i class="bi bi-file-text text-info"></i>
                            <span><strong>Halaman:</strong> <?= esc($book['number_of_pages']) ?> halaman</span>
                        </div>
                    <?php endif; ?>

                    <div class="meta-item">
                        <i class="bi bi-translate text-secondary"></i>
                        <span><strong>Bahasa:</strong> <?= esc($book['language'] == 'id' ? 'Indonesia' : 'English') ?></span>
                    </div>
                </div>

                <!-- Penulis -->
                <?php if (!empty($authors)): ?>
                    <div class="book-detail-authors mb-3">
                        <h5><i class="bi bi-person-fill text-primary me-2"></i>Penulis:</h5>
                        <div class="authors-list">
                            <?php foreach ($authors as $author): ?>
                                <span class="author-badge"><?= esc($author['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Deskripsi -->
                <?php if ($book['description']): ?>
                    <div class="book-detail-description mb-4">
                        <h5><i class="bi bi-file-text-fill text-primary me-2"></i>Deskripsi:</h5>
                        <p class="description-text"><?= nl2br(esc($book['description'])) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Tombol Aksi -->
                <div class="book-detail-actions d-flex flex-wrap gap-2 mb-4">
                    <a href="<?= base_url('books/read/' . $book['slug']) ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-book-open me-2"></i>Baca Buku
                    </a>

                    <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                        <a href="<?= base_url('books/edit/' . $book['id']) ?>" class="btn btn-outline-warning btn-lg">
                            <i class="bi bi-pencil-square me-1"></i> Ubah Buku
                        </a>
                        <form action="<?= base_url('books/delete/' . $book['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus buku ini?');" style="display: inline;">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger btn-lg">
                                <i class="bi bi-trash me-1"></i> Hapus Buku
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="<?= base_url('books') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Koleksi
                    </a>
                </div>

                <!-- Informasi Tambahan -->
                <div class="book-detail-footer">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Buku ini tersedia untuk dibaca secara offline di perpustakaan digital KutaBaca
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
