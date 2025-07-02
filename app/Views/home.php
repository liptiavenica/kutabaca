<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Hero Section -->
<div class="hero-section py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="hero-greeting">Selamat Datang di</span>
                        <span class="hero-brand">KutaBaca!</span>
                        <span class="hero-emoji">📖</span>
                    </h1>
                    <p class="hero-description">
                        Perpustakaan Digital Offline untuk Desa Kutamanah. 
                        Temukan <?= $bookCount; ?> buku menarik untuk menambah pengetahuan 
                        dan wawasan kamu!
                    </p>

                    <!-- Search Bar -->
                    <form method="get" action="<?= base_url('books') ?>" class="search-container">
                        <div class="input-group input-group-lg">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="🔍 Cari buku favoritmu..."
                                aria-label="Cari buku">
                            <button class="btn btn-light search-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image-container">
                    <img src="<?= base_url('assets/img/logo-kutabaca.png') ?>" alt="KutaBaca Logo" class="hero-logo">
                    <div class="hero-decoration">
                        <div class="floating-element element-1">📚</div>
                        <div class="floating-element element-2">📖</div>
                        <div class="floating-element element-3">⭐</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="container mb-5">
    <h2 class="section-header"> Kategori Buku</h2>
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= base_url('books?kategori=' . $category['id']) ?>" class="text-decoration-none">
                    <div class="card h-100 shadow-sm category-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if ($category['id'] == 1): ?>
                                    <i class="bi bi-book text-primary" style="font-size: 4rem;"></i>
                                <?php elseif ($category['id'] == 2): ?>
                                    <i class="bi bi-journal-text text-success" style="font-size: 4rem;"></i>
                                <?php else: ?>
                                    <i class="bi bi-lightbulb text-warning" style="font-size: 4rem;"></i>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title"><?= esc($category['name']) ?></h5>
                            <p class="card-text">
                                <?php if ($category['id'] == 1): ?>
                                    📖 Kumpulan buku pelajaran untuk mendukung pembelajaran di sekolah
                                <?php elseif ($category['id'] == 2): ?>
                                    📚 Koleksi cerita menarik untuk mengembangkan imajinasi
                                <?php else: ?>
                                    💡 Buku pengetahuan umum untuk memperluas wawasan
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recent Books Section -->
<?php if (!empty($recentBooks)): ?>
    <div class="container mb-5">
        <h2 class="section-header">Buku Terbaru</h2>
        <div class="row">
            <?php
            $bookCount = 0;
            foreach ($recentBooks as $book):
                if ($bookCount >= 8) break; // Hanya tampilkan 8 buku (2 baris x 4 buku)
            ?>
                <div class="col-md-6 col-lg-3 mb-4">
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
            <?php
                $bookCount++;
            endforeach;
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('books') ?>" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-collection me-2"></i>Lihat Semua Buku
            </a>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>