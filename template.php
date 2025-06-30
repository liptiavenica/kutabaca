<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo-kutabaca.png') ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logo-kutabaca.png') ?>">

    <!-- Bootstrap CSS & Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.css') ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-shadow sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/img/logo-kutabaca.png') ?>" alt="Logo" style="height: 40px;" class="me-2">
                <span class="fw-bold text-dark">KutaBaca</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?= base_url('/') ?>"><i class="bi bi-house-door"></i> Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-journals"></i> Kategori Buku
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('books?kategori=1') ?>">Buku Pelajaran</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('books?kategori=2') ?>">Buku Cerita</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('books?kategori=3') ?>">Buku Pengetahuan Umum</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('books') ?>">Semua Kategori</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-info-circle"></i> Petunjuk
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('petunjuk/siswa') ?>">Untuk Siswa</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('petunjuk/guru') ?>">Untuk Guru</a></li>
                        </ul>
                    </li>
                    <!-- Tambahan opsi Tentang -->
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?= base_url('tentang') ?>"><i class="bi bi-people-fill"></i> Tentang</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-info" href="<?= base_url('login') ?>"><i class="bi bi-person-gear"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer border-top py-4">
        <div class="container small text-center">
            <div>KutaBaca - Perpustakaan Digital Offline untuk Desa Kutamanah</div>
            <div class="text-muted mt-1">
                Kontak kami: <a href="mailto:mkb.upi@upi.edu" class="text-decoration-none">mkb.upi@upi.edu</a>
            </div>
            <div class="mt-2">
                &copy; <?= date('Y') ?> KutaBaca. All rights reserved.
            </div>
            <div class="d-flex justify-content-center mt-3 gap-3">
                <img src="<?= base_url('assets/img/logo-upi.png') ?>" alt="Logo UPI" height="30">
                <img src="<?= base_url('assets/img/logo-kutamanah.png') ?>" alt="Logo Desa Kutamanah" height="30">
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle & Custom JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>