<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

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

<!-- jQuery -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- Turn.js -->
<script src="<?= base_url('assets/flipbook/js/turn.min.js') ?>"></script>

<!-- PDF.js -->
<script src="<?= base_url('assets/flipbook/js/pdf.min.js') ?>"></script>
<script src="<?= base_url('assets/flipbook/js/pdf.worker.min.js') ?>"></script>

<!-- Flipbook CSS -->
<link rel="stylesheet" href="<?= base_url('assets/flipbook/css/flipbook.css') ?>">

<script>
    const url = "<?= base_url('uploads/books/' . $book['book_file']) ?>";
    const container = document.getElementById('flipbook');
    let currentScale = 1;
    const minScale = 0.5;
    const maxScale = 2.5;
    const scaleStep = 0.15;

    pdfjsLib.GlobalWorkerOptions.workerSrc = "<?= base_url('assets/flipbook/js/pdf.worker.min.js') ?>";

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

    // Mouse drag support
    let isDragging = false;
    let dragStartX = 0;
    let dragEndX = 0;

    container.addEventListener('mousedown', e => {
        isDragging = true;
        dragStartX = e.clientX;
    });

    container.addEventListener('mouseup', e => {
        if (!isDragging) return;
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
            $('#flipbook').turn('previous');
        } else if (diff < -threshold) {
            $('#flipbook').turn('next');
        }
    }

    document.getElementById("gotoForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const input = document.getElementById("pageNumber");
        const page = parseInt(input.value);
        const total = $('#flipbook').turn('pages');

        if (!isNaN(page) && page >= 1 && page <= total) {
            $('#flipbook').turn('page', page);
            input.value = '';
        } else {
            alert('Halaman tidak valid.');
        }
    });

    // Fullscreen logic
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const exitFullscreenBtn = document.getElementById('exitFullscreenBtn');
    fullscreenBtn.addEventListener('click', function() {
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        } else if (container.msRequestFullscreen) {
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

    // Zoom logic
    document.getElementById('zoomInBtn').addEventListener('click', function() {
        if (currentScale < maxScale) {
            currentScale += scaleStep;
            $('#flipbook .page canvas').css('transform', `scale(${currentScale})`);
        }
    });
    document.getElementById('zoomOutBtn').addEventListener('click', function() {
        if (currentScale > minScale) {
            currentScale -= scaleStep;
            $('#flipbook .page canvas').css('transform', `scale(${currentScale})`);
        }
    });
</script>

<?= $this->endSection(); ?>