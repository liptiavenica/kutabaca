<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>
    <div class="content-wrapper flex-grow-1">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">KutaBaca</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori Buku
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Buku Pelajaran</a></li>
                                <li><a class="dropdown-item" href="#">Buku Cerita</a></li>
                                <li><a class="dropdown-item" href="#">Buku Pengetahuan Umum</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Petunjuk
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Untuk Siswa</a></li>
                                <li><a class="dropdown-item" href="#">Untuk Guru</a></li>
                            </ul>
                        </li>
                    </ul>
                    <a class="btn btn-outline-info d-flex" href="/login">Admin</a>

                </div>
            </div>
        </nav>

        <?= $this->renderSection('content'); ?>
        <!-- Isi konten kamu di sini -->
    </div>

    <footer class="bg-light text-center text-lg-start mt-5 border-top">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">KutaBaca: Perpustakaan Digital Offline</h5>
                    <p>Media belajar interaktif berbasis digital untuk Desa Kutamanah.</p>
                    <div class="footer-logos d-flex align-items-center">
                        <img src="<?= base_url('assets/img/logo-upi.png') ?>" alt="Logo UPI">
                        <img src="<?= base_url('assets/img/logo-kutamanah.png') ?>" alt="Logo Desa Kutamanah">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Menu</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/" class="text-dark">Beranda</a></li>
                        <li><a href="#" class="text-dark">Tentang</a></li>
                        <li><a href="#" class="text-dark">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Kontak</h5>
                    <p>Email: mkb@upi.edu</p>
                </div>
            </div>
        </div>

        <div class="text-center p-3 bg-danger text-white">
            &copy; <?= date('Y') ?> KutaBaca. All rights reserved.
        </div>
    </footer>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>