<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">Daftar Buku</h2>

            <form method="get" class="mb-4 d-flex flex-wrap gap-2 align-items-center">
                <input type="text" name="search" value="<?= esc($keyword) ?>" placeholder="Cari judul/deskripsi/penerbit" class="form-control" style="max-width: 250px;">

                <select name="kategori" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($selected_kategori == $k['id']) ? 'selected' : '' ?>>
                            <?= $k['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="bahasa" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
                    <option value="">Semua Bahasa</option>
                    <?php foreach ($list_bahasa as $b): ?>
                        <option value="<?= $b ?>" <?= ($selected_language == $b) ? 'selected' : '' ?>>
                            <?= $b ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                <div class="mb-3">
                    <a href="<?= base_url('/books/create') ?>" class="btn btn-success">➕ Tambah Buku</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($books)): ?>
                <ul class="list-group">
                    <?php foreach ($books as $b): ?>
                        <li class="list-group-item d-flex">
                            <!-- Cover Image -->
                            <img src="<?= base_url('uploads/covers/' . ($b['cover_image'] ?? 'default.jpg')) ?>"
                                alt="<?= esc($b['title']) ?>"
                                class="me-3"
                                style="width: 6em; height: 9em; object-fit: cover; border-radius: 4px;">

                            <!-- Book Info -->
                            <div>
                                <strong><?= esc($b['title']) ?></strong><br>
                                <small class="text-muted">
                                    <?= esc($b['category_name'] ?? 'Tanpa Kategori') ?> |
                                    Bahasa: <?= esc($b['language']) ?> |
                                    Penerbit: <?= esc($b['publisher']) ?>
                                </small><br>
                                <p class="mb-2"><?= esc($b['description']) ?></p>
                                <a href="<?= base_url('books/read/' . $b['slug']) ?>" class="btn btn-sm btn-outline-primary">📖 Baca</a>
                                <?php if (session()->get('user') && session()->get('user')['role'] === 'admin'): ?>
                                    <a href="<?= base_url('books/delete/' . $b['id']) ?>" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Yakin ingin hapus?')">🗑️ Hapus</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="alert alert-info">Buku tidak ditemukan.</div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>