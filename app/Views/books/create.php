<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">

        <!-- Tombol Kembali di pojok kiri atas -->
        <div class="col-12 mb-3">
            <a href="<?= base_url('books') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Koleksi
            </a>
        </div>
    <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
        <h1 class="section-header mb-4">➕ Tambah Buku Baru</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" action="<?= base_url('/books/store') ?>" class="mx-auto" style="max-width: 700px;">
            <?= csrf_field(); ?>

            <!-- Judul -->
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku *</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Buku *</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>

            <!-- Penulis -->
            <div class="mb-3">
                <label for="authors" class="form-label">Penulis (maks. 5, tekan Enter untuk menambah) *</label>
                <input type="text" id="author-input" class="form-control" placeholder="Ketik nama penulis dan tekan Enter">
                <div id="author-tags" class="mt-2"></div>
                <ul id="suggestions" class="list-group mt-2"></ul>
                <input type="hidden" name="authors" id="authors-hidden" required>
                <small class="text-muted">Contoh: Liptia Venica, Aufa Zahron</small>
            </div>


            <!-- Kategori -->
            <div class="mb-3">
                <label for="category" class="form-label">Kategori *</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>"><?= $k['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Bahasa -->
            <div class="mb-3">
                <label for="language" class="form-label">Bahasa *</label>
                <select class="form-select" id="language" name="language" required>
                    <option value="id">Bahasa Indonesia</option>
                    <option value="en">Bahasa Inggris</option>
                </select>
            </div>

            <!-- Publisher -->
            <div class="mb-3">
                <label for="publisher" class="form-label">Penerbit *</label>
                <input type="text" class="form-control" id="publisher" name="publisher" required>
            </div>

            <!-- ISBN -->
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>

            <!-- Jumlah Halaman -->
            <div class="mb-3">
                <label for="number_of_pages" class="form-label">Jumlah Halaman</label>
                <input type="number" class="form-control" id="number_of_pages" name="number_of_pages" min="1">
            </div>

            <!-- Tahun -->
            <div class="mb-3">
                <label for="year" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" id="year" name="year" min="1000" max="<?= date('Y') ?>">
            </div>

            <!-- File Buku -->
            <div class="mb-3">
                <label for="file" class="form-label">File Buku (PDF maks. 50MB) *</label>
                <input class="form-control" type="file" name="file" id="file" accept="application/pdf" required>
            </div>

            <!-- Cover Buku -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Buku (jpg/jpeg/png) *</label>
                <input class="form-control" type="file" name="cover_image" id="cover_image" accept="image/png, image/jpeg" required>
            </div>

            <button type="submit" class="btn btn-success w-100"><i class="bi bi-upload me-1"></i> Upload Buku</button>
        </form>

        <script>
    const input = document.getElementById('author-input');
    const tagContainer = document.getElementById('author-tags');
    const hiddenInput = document.getElementById('authors-hidden');
    const suggestionBox = document.getElementById('suggestions');
    let tags = [];

    input.addEventListener('input', function () {
        const keyword = this.value.trim();

        if (keyword.length < 2) {
            suggestionBox.innerHTML = '';
            return;
        }

        fetch('/authors/search?term=' + encodeURIComponent(keyword))
            .then(res => res.json())
            .then(data => {
                suggestionBox.innerHTML = '';
                if (data.length === 0) {
                    const li = document.createElement('li');
                    li.textContent = 'Penulis tidak ditemukan';
                    li.classList.add('list-group-item', 'disabled');
                    suggestionBox.appendChild(li);
                    return;
                }

                data.forEach(author => {
                    const li = document.createElement('li');
                    li.textContent = author.name;
                    li.style.cursor = 'pointer';
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.onclick = () => addTag(author.name);
                    suggestionBox.appendChild(li);
                });
            });
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (input.value.trim() !== '') {
                addTag(input.value.trim());
            }
        }
    });

    function addTag(name) {
        if (tags.length >= 5) {
            alert('Maksimal 5 penulis');
            input.value = '';
            suggestionBox.innerHTML = '';
            return;
        }

        if (tags.includes(name)) {
            alert('Penulis sudah ditambahkan');
            input.value = '';
            suggestionBox.innerHTML = '';
            return;
        }

        tags.push(name);
        updateTags();
        input.value = '';
        suggestionBox.innerHTML = '';
    }

    function updateTags() {
        tagContainer.innerHTML = '';
        tags.forEach((tag, index) => {
            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-primary me-2 mb-2';
            tagElement.style.cursor = 'pointer';
            tagElement.innerHTML = `${tag} <i class="bi bi-x" style="font-size: 0.8rem;"></i>`;
            tagElement.onclick = () => removeTag(index);
            tagContainer.appendChild(tagElement);
        });
        hiddenInput.value = tags.join(', ');
    }

    function removeTag(index) {
        tags.splice(index, 1);
        updateTags();
    }

    document.addEventListener('click', function (e) {
        if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.innerHTML = '';
        }
    });
</script>



    <?php else: ?>
        <div class="alert alert-danger text-center">
            <strong>Akses Ditolak!</strong> Hanya admin yang dapat menambah buku.
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection(); ?>
