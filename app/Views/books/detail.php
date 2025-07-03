<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<div class="container my-5">
    <div class="row">
        <!-- Tombol Kembali di pojok kiri atas -->
        <div class="col-12 mb-3">
            <a href="<?= base_url('books') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Koleksi
            </a>
        </div>

        <!-- Cover Buku dan Kategori -->
        <div class="col-lg-4 mb-4">
            <div class="book-detail-cover-container">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'default.jpg')) ?>"
                    alt="<?= esc($book['title']) ?>"
                    class="book-detail-cover">
                <div class="book-detail-overlay">
                    <i class="bi bi-book-open overlay-icon-large"></i>
                </div>
            </div>

            <!-- Kategori di bawah cover -->
            <div class="text-center mt-3">
                <span class="category-badge d-flex align-items-center justify-content-center gap-2 px-4 w-100">
                    <i class="bi bi-tag-fill me-1"></i>
                    <?= esc($book['category_name'] ?? 'Kategori Umum') ?>
                </span>
            </div>
        </div>

        <!-- Informasi Buku dan Tombol Baca -->
        <div class="col-lg-8">
            <div class="book-detail-info">
                <h1 class="book-detail-title"><?= esc($book['title']) ?></h1>

                <!-- Container Tombol -->
                <div class="mb-4 d-flex align-items-center gap-3">
                    <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                        <!-- Tombol Aksi Admin -->
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('books/edit/' . $book['id']) ?>"
                                class="btn btn-outline-primary d-flex align-items-center gap-2 px-3">
                                <i class="bi bi-pencil-fill"></i> Ubah
                            </a>

                            <!-- Button Trigger Modal -->
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 px-3" data-bs-toggle="modal" data-bs-target="#deleteBookModal">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 12px; border: none;">
                                        <div class="modal-header" style="border-bottom: none; padding: 1.5rem 1.5rem 0;">
                                            <h5 class="modal-title text-primary-brown fw-bold" id="deleteBookModalLabel">Konfirmasi Penghapusan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-4 pb-4 pt-0">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="bg-danger bg-opacity-10 p-2 rounded-circle">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Anda yakin ingin menghapus buku ini?</p>
                                                    <p class="text-muted small">"<?= esc($book['title']) ?>" akan dihapus permanen.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: none; padding: 0 1.5rem 1.5rem;">
                                            <form action="<?= base_url('books/delete/' . $book['id']) ?>" method="post" class="w-100">
                                                <?= csrf_field(); ?>
                                                <div class="d-flex gap-3">
                                                    <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger flex-grow-1">Ya, Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Tombol Baca -->
                    <a href="<?= base_url('books/read/' . $book['slug']) ?>" class="btn btn-primary text-center px-3 ms-auto" style="min-width: 120px;">
                        <i class="bi bi-book-open me-2"></i> Baca Buku
                    </a>
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