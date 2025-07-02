<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Desktop Layout (Flipbook) -->
<div id="desktop-layout" class="d-none d-lg-block">
    <!-- Header untuk PDF Reader -->
    <div class="container-fluid py-3 bg-light border-bottom mb-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="<?= base_url('books/detail/' . $book['slug']) ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Kembali ke Detail Buku
            </a>
            <h5 class="m-0 text-primary"><?= esc($book['title']) ?></h5>
            <form class="d-inline-block" id="gotoForm">
                <div class="input-group">
                    <input type="number" id="pageNumber" class="form-control page-input" min="1" placeholder="Masukkan halaman...">
                    <button type="submit" class="btn btn-primary">Kunjungi</button>
                </div>
            </form>
            <div class="d-flex gap-2 align-items-center ms-3">
                <button id="zoomInBtn" class="btn btn-secondary" title="Perbesar"><i class="bi bi-zoom-in"></i></button>
                <button id="zoomOutBtn" class="btn btn-secondary" title="Perkecil"><i class="bi bi-zoom-out"></i></button>
                <button id="fullscreenBtn" class="btn btn-secondary" title="Buka Fullscreen"><i class="bi bi-arrows-fullscreen"></i></button>
                <button id="exitFullscreenBtn" class="btn btn-secondary d-none" title="Keluar Fullscreen"><i class="bi bi-fullscreen-exit"></i></button>
            </div>
        </div>
    </div>

    <!-- PDF Reader Container -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div id="flipbook" class="mx-auto"></div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Layout (Simple PDF Viewer) -->
<div id="mobile-layout" class="d-block d-lg-none">
    <!-- Mobile Header -->
    <div class="container-fluid py-3 bg-light border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="<?= base_url('books/detail/' . $book['slug']) ?>" class="btn btn-outline-primary" style="font-size: 0.8rem; padding: 0.25rem 0.5rem;">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h6 class="m-0 text-primary text-center flex-grow-1"><?= esc($book['title']) ?></h6>
                <div class="d-flex gap-1">
                    <button id="mobileZoomIn" class="btn btn-secondary btn-sm" title="Perbesar"><i class="bi bi-zoom-in"></i></button>
                    <button id="mobileZoomOut" class="btn btn-secondary btn-sm" title="Perkecil"><i class="bi bi-zoom-out"></i></button>
                </div>
            </div>
            
            <!-- Mobile Page Info -->
            <div class="text-center">
                <span id="pageInfo" class="text-muted small">Total <span id="totalPages">1</span> halaman</span>
            </div>
        </div>
    </div>

    <!-- Mobile PDF Container -->
    <div class="container-fluid p-0">
        <div id="mobile-pdf-container" class="text-center">
            <!-- Pages will be loaded here dynamically -->
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- Turn.js -->
<script src="<?= base_url('assets/flipbook/js/turn.min.js') ?>"></script>

<!-- PDF.js -->
<script src="<?= base_url('assets/flipbook/js/pdf.min.js') ?>"></script>
<script src="<?= base_url('assets/flipbook/js/pdf.worker.min.js') ?>"></script>

<!-- Flipbook CSS -->
<link rel="stylesheet" href="<?= base_url('assets/flipbook/css/flipbook.css') ?>">

<style>
    #flipbook {
        margin-left: auto;
        margin-right: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow-x: hidden;
    }
    #flipbook .page {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin: 0;
        padding: 0;
    }
    .container-fluid {
        overflow-x: hidden;
    }
</style>

<script>
    const url = "<?= base_url('uploads/books/' . $book['book_file']) ?>";
    const container = document.getElementById('flipbook');
    let currentScale = 1;
    const minScale = 0.5;
    const maxScale = 2.5;
    const scaleStep = 0.15;

    // Mobile variables
    let mobilePdf = null;
    let mobileCurrentPage = 1;
    let mobileTotalPages = 1;
    let mobileCurrentScale = 1;
    const mobileMinScale = 0.5;
    const mobileMaxScale = 3;
    const mobileScaleStep = 0.25;

    pdfjsLib.GlobalWorkerOptions.workerSrc = "<?= base_url('assets/flipbook/js/pdf.worker.min.js') ?>";

    // Check if mobile device
    function isMobile() {
        return window.innerWidth < 992; // Bootstrap lg breakpoint
    }

    // Initialize based on device type
    function initializeReader() {
        if (isMobile()) {
            initializeMobileReader();
        } else {
            initializeDesktopReader();
        }
    }

    // Mobile PDF Reader
    function initializeMobileReader() {
        pdfjsLib.getDocument(url).promise.then(pdf => {
            mobilePdf = pdf;
            mobileTotalPages = pdf.numPages;
            document.getElementById('totalPages').textContent = mobileTotalPages;
            
            // Load all pages for vertical scrolling
            loadAllMobilePages();
        });
    }

    function loadAllMobilePages() {
        if (!mobilePdf) return;
        
        const container = document.getElementById('mobile-pdf-container');
        container.innerHTML = ''; // Clear existing content
        
        // Create array to store page promises
        const pagePromises = [];
        
        // Load all pages in order
        for (let pageNum = 1; pageNum <= mobileTotalPages; pageNum++) {
            pagePromises.push(
                mobilePdf.getPage(pageNum).then(page => {
                    return { page, pageNum };
                })
            );
        }
        
        // Wait for all pages to load, then render them in order
        Promise.all(pagePromises).then(pageData => {
            pageData.forEach(({ page, pageNum }) => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                // Calculate scale to fit screen width
                const containerWidth = window.innerWidth - 20; // Account for padding
                const viewport = page.getViewport({ scale: 1 });
                const scale = containerWidth / viewport.width;
                const scaledViewport = page.getViewport({ scale: scale * mobileCurrentScale });
                
                canvas.width = scaledViewport.width;
                canvas.height = scaledViewport.height;
                canvas.className = 'img-fluid mb-3';
                canvas.style.maxWidth = '100%';
                canvas.style.height = 'auto';
                
                // Add page number indicator
                const pageDiv = document.createElement('div');
                pageDiv.className = 'text-center mb-4';
                pageDiv.innerHTML = `<small class="text-muted">Halaman ${pageNum}</small>`;
                pageDiv.appendChild(canvas);
                
                container.appendChild(pageDiv);
                
                page.render({
                    canvasContext: ctx,
                    viewport: scaledViewport
                });
            });
        });
    }

    // Desktop Flipbook Reader
    function initializeDesktopReader() {
        pdfjsLib.getDocument(url).promise.then(pdf => {
            const totalPages = pdf.numPages;

            pdf.getPage(1).then(page => {
                const viewport = page.getViewport({
                    scale: 1
                });
                const ratio = viewport.width / viewport.height;

                const screenW = Math.min(window.innerWidth * 0.98, 1200);
                const pageW = screenW / 2;
                const pageH = pageW / ratio;

                container.style.width = screenW + "px";
                container.style.height = pageH + "px";

                const canvasPages = new Array(totalPages);
                const renderPromises = [];

                for (let i = 1; i <= totalPages; i++) {
                    renderPromises.push(
                        pdf.getPage(i).then(p => {
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");
                            const v = p.getViewport({
                                scale: pageW / viewport.width
                            });

                            canvas.width = v.width;
                            canvas.height = v.height;

                            return p.render({
                                canvasContext: ctx,
                                viewport: v
                            }).promise.then(() => {
                                canvasPages[i - 1] = canvas;
                            });
                        })
                    );
                }

                Promise.all(renderPromises).then(() => {
                    canvasPages.forEach(c => {
                        const pageDiv = document.createElement("div");
                        pageDiv.className = "page";
                        pageDiv.appendChild(c);
                        container.appendChild(pageDiv);
                    });

                    if (totalPages % 2 !== 0) {
                        const dummy = document.createElement("div");
                        dummy.classList.add("page");
                        dummy.innerHTML = "&nbsp;";
                        container.appendChild(dummy);
                    }

                    $('#flipbook').turn({
                        width: screenW,
                        height: pageH,
                        autoCenter: true,
                        elevation: 50,
                        gradients: true
                    });
                    container.dataset.initWidth = screenW;
                    container.dataset.initHeight = pageH;
                });
            });
        });
    }

    // Mouse drag support (Desktop only)
    let isDragging = false;
    let dragStartX = 0;
    let dragEndX = 0;

    container.addEventListener('mousedown', e => {
        if (!isMobile()) {
            isDragging = true;
            dragStartX = e.clientX;
        }
    });

    container.addEventListener('mouseup', e => {
        if (!isDragging || isMobile()) return;
        isDragging = false;
        dragEndX = e.clientX;
        const diff = dragEndX - dragStartX;
        const threshold = 50;

        if (diff > threshold) {
            $('#flipbook').turn('previous');
        } else if (diff < -threshold) {
            $('#flipbook').turn('next');
        }
    });

    function handleSwipe() {
        const threshold = 50;
        const diff = touchEndX - touchStartX;

        if (diff > threshold) {
            if (!isMobile()) {
                $('#flipbook').turn('previous');
            }
        } else if (diff < -threshold) {
            if (!isMobile()) {
                $('#flipbook').turn('next');
            }
        }
    }

    // Desktop goto form
    document.getElementById("gotoForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const input = document.getElementById("pageNumber");
        const page = parseInt(input.value);
        
        if (isMobile()) {
            if (!isNaN(page) && page >= 1 && page <= mobileTotalPages) {
                // Scroll to the specific page in mobile view
                const pageElements = document.querySelectorAll('#mobile-pdf-container > div');
                if (pageElements[page - 1]) {
                    pageElements[page - 1].scrollIntoView({ behavior: 'smooth' });
                }
                input.value = '';
            } else {
                alert('Halaman tidak valid.');
            }
        } else {
            const total = $('#flipbook').turn('pages');
            if (!isNaN(page) && page >= 1 && page <= total) {
                $('#flipbook').turn('page', page);
                input.value = '';
            } else {
                alert('Halaman tidak valid.');
            }
        }
    });

    // Mobile zoom controls
    document.getElementById("mobileZoomIn").addEventListener("click", function() {
        if (mobileCurrentScale < mobileMaxScale) {
            mobileCurrentScale += mobileScaleStep;
            loadAllMobilePages();
        }
    });

    document.getElementById("mobileZoomOut").addEventListener("click", function() {
        if (mobileCurrentScale > mobileMinScale) {
            mobileCurrentScale -= mobileScaleStep;
            loadAllMobilePages();
        }
    });

    // Fullscreen logic (Desktop only)
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const exitFullscreenBtn = document.getElementById('exitFullscreenBtn');
    fullscreenBtn.addEventListener('click', function() {
        if (!isMobile() && container.requestFullscreen) {
            container.requestFullscreen();
        } else if (!isMobile() && container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        } else if (!isMobile() && container.msRequestFullscreen) {
            container.msRequestFullscreen();
        }
    });
    exitFullscreenBtn.addEventListener('click', function() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    });
    document.addEventListener('fullscreenchange', function() {
        if (document.fullscreenElement === container) {
            fullscreenBtn.classList.add('d-none');
            exitFullscreenBtn.classList.remove('d-none');
            // Perbesar flipbook saat fullscreen
            $('#flipbook').turn('size', Math.min(window.screen.width, 1600), window.screen.height * 0.97);
        } else {
            fullscreenBtn.classList.remove('d-none');
            exitFullscreenBtn.classList.add('d-none');
            // Kembalikan ke ukuran awal
            $('#flipbook').turn('size', parseInt(container.dataset.initWidth), parseInt(container.dataset.initHeight));
        }
    });

    // Desktop zoom logic
    document.getElementById('zoomInBtn').addEventListener('click', function() {
        if (!isMobile() && currentScale < maxScale) {
            currentScale += scaleStep;
            $('#flipbook .page canvas').css('transform', `scale(${currentScale})`);
        }
    });
    document.getElementById('zoomOutBtn').addEventListener('click', function() {
        if (!isMobile() && currentScale > minScale) {
            currentScale -= scaleStep;
            $('#flipbook .page canvas').css('transform', `scale(${currentScale})`);
        }
    });

    // Responsive resize for flipbook (Desktop only)
    function resizeFlipbook() {
        if (!isMobile()) {
            pdfjsLib.getDocument(url).promise.then(pdf => {
                pdf.getPage(1).then(page => {
                    const viewport = page.getViewport({ scale: 1 });
                    const ratio = viewport.width / viewport.height;
                    const screenW = Math.min(window.innerWidth * 0.98, 1200);
                    const pageW = screenW / 2;
                    const pageH = pageW / ratio;
                    container.style.width = screenW + "px";
                    container.style.height = pageH + "px";
                    if ($('#flipbook').data('turn')) {
                        $('#flipbook').turn('size', screenW, pageH);
                    }
                });
            });
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (isMobile()) {
            // Reload all pages on mobile resize
            if (mobilePdf) {
                loadAllMobilePages();
            }
        } else {
            resizeFlipbook();
        }
    });

    // Initialize reader when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeReader();
    });
</script>

<?= $this->endSection(); ?>