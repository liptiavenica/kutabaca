<!-- <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
    <h2>Tambah Buku</h2>
    <form method="post" enctype="multipart/form-data" action="<?= base_url('/books/store') ?>">
        <p><label>Judul: <input type="text" name="judul" required></label></p>
        <p><label>Deskripsi: <textarea name="deskripsi" required></textarea></label></p>
        <p><label>Penulis: <input type="text" id="author-input" name="authors" placeholder="Ketik dan pilih..." required></label></p>
        <ul id="suggestions" style="list-style: none; padding-left: 0;"></ul>
        <p><label>Kategori:<br>
                <?php foreach ($kategori as $k): ?>
                    <label><input type="checkbox" name="id_kategori[]" value="<?= $k['id'] ?>"> <?= $k['name'] ?></label><br>
                <?php endforeach; ?>
            </label></p>
        <p><label>File (PDF): <input type="file" name="file" accept="application/pdf" required></label></p>
        <button type="submit">Upload Buku</button>
    </form>
    <script>
        const input = document.getElementById('author-input');
        const suggestionBox = document.getElementById('suggestions');

        input.addEventListener('input', function() {
            const keyword = this.value;
            if (keyword.length < 2) {
                suggestionBox.innerHTML = '';
                return;
            }

            fetch('/authors/search?term=' + encodeURIComponent(keyword))
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    data.forEach(author => {
                        const li = document.createElement('li');
                        li.textContent = author.name;
                        li.style.cursor = 'pointer';
                        li.onclick = () => {
                            input.value = author.name;
                            suggestionBox.innerHTML = '';
                        };
                        suggestionBox.appendChild(li);
                    });
                });
        });
    </script>
<?php else: ?>
    <p>Akses ditolak. Hanya admin yang dapat menambah buku.</p>
<?php endif; ?> -->