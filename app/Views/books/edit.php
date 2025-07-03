<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container my-5">

    <!-- Tombol Kembali di pojok kiri atas -->
    <div class="col-12 mb-3">
        <a href="<?= base_url('books') ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Koleksi
        </a>
    </div>

    <h1 class="section-header mb-4">✏️ Edit Buku</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?= base_url('/books/update/' . $book['id']) ?>" class="mx-auto" style="max-width: 700px;">
        <?= csrf_field(); ?>

        <!-- Judul -->
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku *</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', esc($book['title'])) ?>" required>
            <small id="judul-feedback" class="text-danger"></small>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Buku *</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi', esc($book['description'])) ?></textarea>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label for="category" class="form-label">Kategori *</label>
            <select class="form-select" id="category" name="category" required>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= old('category', $book['category']) == $k['id'] ? 'selected' : '' ?>><?= $k['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Penulis -->
        <div class="mb-3">
            <label for="authors" class="form-label">Penulis (maks. 5, tekan Enter untuk menambah) *</label>
            <input type="text" id="author-input" class="form-control" placeholder="Ketik nama penulis dan tekan Enter">
            <div id="author-tags" class="mt-2"></div>
            <ul id="suggestions" class="list-group mt-2"></ul>
            <input type="hidden" name="authors" id="authors-hidden" required value="<?= old('authors', esc($authorNames)) ?>">
            <small class="text-muted">Contoh: Liptia Venica, Aufa Zahron</small>
        </div>

        <!-- Bahasa -->
        <div class="mb-3">
            <label for="language" class="form-label">Bahasa *</label>
            <select class="form-select" id="language" name="language" required>
                <option value="id" <?= old('language', $book['language']) == 'id' ? 'selected' : '' ?>>Bahasa Indonesia</option>
                <option value="en" <?= old('language', $book['language']) == 'en' ? 'selected' : '' ?>>Bahasa Inggris</option>
            </select>
        </div>

        <!-- Penerbit -->
        <div class="mb-3">
            <label for="publisher" class="form-label">Penerbit *</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?= old('publisher', esc($book['publisher'])) ?>" required>
        </div>

        <!-- ISBN -->
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= old('isbn', esc($book['isbn'])) ?>">
        </div>

        <!-- Jumlah Halaman -->
        <div class="mb-3">
            <label for="number_of_pages" class="form-label">Jumlah Halaman</label>
            <input type="number" class="form-control" id="number_of_pages" name="number_of_pages" min="1" value="<?= old('number_of_pages', esc($book['number_of_pages'])) ?>">
        </div>

        <!-- Tahun -->
        <div class="mb-3">
            <label for="year" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="year" name="year" min="1000" max="<?= date('Y') ?>" value="<?= old('year', esc($book['year'])) ?>">
        </div>

        <!-- File Buku -->
        <div class="mb-3">
            <label for="file" class="form-label">File Buku (PDF)</label>
            <input class="form-control" type="file" name="file" id="file" accept="application/pdf">
            <small class="text-muted">Abaikan jika tidak ingin mengganti file buku.</small>
        </div>

        <!-- Cover Buku -->
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Buku (jpg/jpeg/png)</label>
            <input class="form-control" type="file" name="cover_image" id="cover_image" accept="image/png, image/jpeg">
            <small class="text-muted">Abaikan jika tidak ingin mengganti cover.</small>
        </div>

        <button type="submit" id="submit-button" class="btn btn-primary btn-lg w-100"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        <br><br>
        <div class="col-12 mb-3">
            <a href="<?= base_url('books/detail/' . $book['slug']) ?>" class="btn btn-outline-primary btn-lg w-100">
                <i class="bi bi-arrow-left me-2"></i>Batalkan
            </a>
        </div>
    </form>
</div>

<script>
    const input = document.getElementById('author-input');
    const tagContainer = document.getElementById('author-tags');
    const hiddenInput = document.getElementById('authors-hidden');
    const suggestionBox = document.getElementById('suggestions');
    let tags = [];

    // Load authors from hidden input on page load
    window.addEventListener('DOMContentLoaded', () => {
        const oldAuthors = hiddenInput.value;
        if (oldAuthors) {
            tags = oldAuthors.split(',').map(name => name.trim()).filter(name => name.length > 0);
            updateTags();
        }
    });

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

    // Title Validation
    const titleInput = document.getElementById('judul');
    const submitButton = document.getElementById('submit-button');
    const feedback = document.getElementById('judul-feedback');

    const originalTitle = '<?= esc($book['title']) ?>';
    const bookId = <?= $book['id'] ?>;

    titleInput.addEventListener('input', () => {
        const title = titleInput.value.trim();

        if (title.length < 3) {
            feedback.textContent = 'Judul minimal 3 karakter.';
            disableSubmit('Masukkan judul minimal 3 karakter.');
            return;
        }

        if (title === originalTitle) {
            feedback.textContent = '';
            enableSubmit();
            return;
        }

        fetch(`/books/checkTitle?title=${encodeURIComponent(title)}&exclude=${bookId}`)
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    feedback.textContent = 'Judul buku sudah digunakan, silakan gunakan judul lain.';
                    disableSubmit('Judul sudah digunakan.');
                } else {
                    feedback.textContent = '';
                    enableSubmit();
                }
            })
            .catch(err => {
                console.error('Error:', err);
                feedback.textContent = 'Terjadi kesalahan saat memeriksa judul.';
                disableSubmit('Terjadi kesalahan. Coba periksa kembali judul.');
            });
    });

    function disableSubmit(reason) {
        submitButton.setAttribute('disabled', 'disabled');
        submitButton.style.pointerEvents = 'none';
        submitButton.title = reason;
    }

    function enableSubmit() {
        submitButton.removeAttribute('disabled');
        submitButton.style.pointerEvents = 'auto';
        submitButton.title = '';
    }
</script>

<?= $this->endSection(); ?>
