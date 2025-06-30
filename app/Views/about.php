<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">

<style>
    :root {
        --primary-pink-light: #FFD6E0;
        --accent-yellow: #FFF9C4;
        --accent-purple: #E1BEE7;
    }
    
    .about-section {
        padding: 3rem 0;
        background: linear-gradient(135deg, var(--primary-pink-light) 0%, var(--accent-yellow) 50%, var(--accent-purple) 100%);
    }
    
    .about-description {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #495057;
    }
    
    .about-description p {
        margin-bottom: 1.2rem;
    }
    
    .text-primary-brown {
        color: #5D4037;
    }
    
    .btn-primary {
        background-color: #5D4037;
        border-color: #5D4037;
    }
    
    .btn-outline-primary {
        color: #5D4037;
        border-color: #5D4037;
    }
    
    .btn-outline-primary:hover {
        background-color: #5D4037;
        color: white;
    }
    
    .content-card {
        background-color: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(5px);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Team Slider Styles */
    .team-slider {
        margin: 2rem 0;
    }
    
    .team-member {
        text-align: center;
        padding: 1rem;
    }
    
    .team-member-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin: 0 auto 1rem;
    }
    
    .team-member-name {
        font-weight: 600;
        color: #5D4037;
        margin-bottom: 0.25rem;
    }
    
    .team-member-role {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .tns-nav {
        text-align: center;
        margin-top: 1rem;
    }
    
    .tns-nav button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ccc;
        border: none;
        margin: 0 5px;
        padding: 0;
    }
    
    .tns-nav button.tns-nav-active {
        background: #5D4037;
    }
</style>

<section class="about-section rounded">
    <div class="container-fluid px-lg-5 py-4">
        <!-- Judul & Subjudul -->
        <div class="row justify-content-center text-center mb-5 py-4">
            <div class="col-12">
                <h1 class="display-4 fw-bold text-primary-brown">Tentang KutaBaca</h1>
                <p class="lead text-muted">Membaca adalah jembatan menuju peradaban.</p>
            </div>
        </div>

        <!-- Logo -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 text-center">
                <img src="<?= base_url('assets/img/logo-kutabaca.png') ?>" alt="Logo KutaBaca" class="img-fluid hero-logo" style="max-height: 200px;">
            </div>
        </div>

        <!-- Konten utama -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- Apa itu KutaBaca -->
                <div class="mb-5 p-4 content-card">
                    <h2 class="fw-bold text-primary-brown mb-4">Apa itu KutaBaca?</h2>
                    <div class="about-description">
                        <p class="mb-4">
                            <strong>KutaBaca</strong> adalah inisiatif perpustakaan digital <strong>offline</strong> yang hadir untuk menjawab rendahnya akses literasi di wilayah 3T (Terdepan, Terluar, Tertinggal). Kami menyadari bahwa keterbatasan infrastruktur internet tidak seharusnya menjadi penghalang untuk mendapatkan akses pengetahuan.
                        </p>
                        <p>
                            Platform ini dirancang sebagai <em>pustaka digital lokal</em> yang dapat diakses tanpa koneksi internet, berisi koleksi buku pelajaran, cerita rakyat, pengetahuan umum, dan materi pendidikan lainnya yang relevan dengan kebutuhan masyarakat di daerah terpencil.
                        </p>
                    </div>
                </div>

                <!-- Misi Kami -->
                <div class="mb-5 p-4 content-card">
                    <h2 class="fw-bold text-primary-brown mb-4">Misi Kami</h2>
                    <div class="about-description">
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Menyediakan akses literasi yang adil dan merata bagi semua lapisan masyarakat, terutama di daerah yang sulit terjangkau jaringan internet.</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Mengembangkan solusi teknologi tepat guna yang sederhana namun efektif untuk mendukung pendidikan di daerah terpencil.</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Menumbuhkan minat baca sejak dini melalui konten yang menarik, edukatif, dan sesuai dengan konteks lokal.</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Membangun jaringan kolaborasi antara relawan, pemerintah, dan masyarakat untuk pengembangan literasi berkelanjutan.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Siapa di Balik KutaBaca -->
                <div class="mb-5 p-4 content-card">
                    <h2 class="fw-bold text-primary-brown mb-4">Tim Pengabdian</h2>
                    <div class="about-description text-justify">
                        <p class="mb-4 text-justify">
                            <strong>KutaBaca</strong> digerakkan oleh tim pengabdian masyarakat dari <strong>Program Studi Mekatronika dan Kecerdasan Buatan (MKB)</strong> Universitas Pendidikan Indonesia Kampus Purwakarta, bekerja sama dengan <strong>Program Studi Pendidikan Sistem dan Teknologi Informasi (PSTI)</strong>.
                        </p>
                        <p class="mb-4 text-justify">
                            Tim ini terdiri dari <strong>mahasiswa dan dosen</strong> dari kedua program studi yang memiliki kepedulian terhadap akses pendidikan di daerah terpencil. Kolaborasi lintas keilmuan ini mencakup pengembang perangkat lunak, desainer antarmuka, praktisi pendidikan, serta relawan literasi, yang bersatu dalam visi memajukan pemerataan akses informasi dan teknologi di Indonesia.
                        </p>
                        <p class="mb-4 text-justify">
                            Kami meyakini bahwa teknologi yang dikembangkan dengan memahami konteks lokal dapat menjadi kunci untuk membuka jendela ilmu bagi masyarakat yang selama ini belum terjangkau oleh sumber belajar modern.
                        </p>
                    </div>

                    <!-- Team Member Slider -->
                    <div class="team-slider mt-5">
                        <h4 class="text-center mb-4 fw-bold text-primary-brown">Anggota Tim</h4>
                        <div class="team-slider-container">
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team1.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Dosen</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team2.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team3.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team4.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team5.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team6.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team7.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team8.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                            <div class="team-member">
                                <img src="<?= base_url('assets/img/team/team9.jpg') ?>" alt="Nama Anggota" class="team-member-img">
                                <h5 class="team-member-name">Nama</h5>
                                <p class="team-member-role">Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center py-4">
                    <a href="<?= base_url('kontak') ?>" class="btn btn-primary btn-lg px-4 me-3">
                        <i class="bi bi-envelope me-2"></i> Hubungi Kami
                    </a>
                    <a href="<?= base_url('buku') ?>" class="btn btn-primary btn-lg px-4 me-3">
                        <i class="bi bi-book me-2"></i> Jelajahi Koleksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var slider = tns({
            container: '.team-slider-container',
            items: 3,
            slideBy: 1,
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            controls: false,
            nav: true,
            navPosition: 'bottom',
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
    });
</script>

<?= $this->endSection(); ?>