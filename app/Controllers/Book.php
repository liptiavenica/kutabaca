<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\CategoryModel;
use App\Models\BookAuthorModel;
use CodeIgniter\Controller;

class Book extends Controller
{
    protected $bookModel;
    protected $categoryModel;
    protected $bookAuthorModel;
    protected $authorModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
        $this->bookAuthorModel = new BookAuthorModel();
        $this->authorModel = new AuthorModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        $recentBooks = $this->bookModel->getBooksWithCategoryAndLanguage(null, null, null);
        // Ambil hanya 6 buku terbaru
        $recentBooks = array_slice($recentBooks, 0, 6);

        return view('books/index', [
            'categories' => $categories,
            'recentBooks' => $recentBooks,
            'title' => 'KutaBaca - Koleksi Buku',
        ]);
    }

    public function showCollection()
    {
        $keyword = $this->request->getGet('search');
        $selected_kategori = $this->request->getGet('kategori');
        $selected_language = $this->request->getGet('bahasa');

        $books = $this->bookModel->getBooksWithCategoryAndLanguage($keyword, $selected_kategori, $selected_language);
        $kategori = $this->categoryModel->findAll();

        return view('books/collection', [
            'books' => $books,
            'kategori' => $kategori,
            'keyword' => $keyword,
            'selected_kategori' => $selected_kategori,
            'selected_language' => $selected_language,
            'title' => 'KutaBaca - Koleksi Buku'
        ]);
    }

    public function detail($slug)
    {
        // Ambil buku berdasarkan slug dengan join kategori
        $book = $this->bookModel->getBookBySlug($slug);

        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan.");
        }

        // Ambil data penulis (jika ada)
        $authors = [];
        try {
            $authors = $this->bookAuthorModel->getAuthorsByBookId($book['id']);
        } catch (\Exception $e) {
            // Jika tidak ada penulis, gunakan array kosong
            $authors = [];
        }

        return view('books/detail', [
            'book' => $book,
            'authors' => $authors,
            'title' => 'KutaBaca - Detail ' . $book['title']
        ]);
    }

    public function read($slug)
    {
        $book = $this->bookModel->where('slug', $slug)->first();

        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan.");
        }
        return view('books/read', [
            'book' => $book,
            'title' => 'KutaBaca - ' . $book['title']
        ]);
    }

    public function create()
{
    if (!session()->get('user') || session()->get('user')['role'] !== 'admin') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
    }

    return view('books/create', [
        'kategori' => $this->categoryModel->findAll(),
        'penulis' => $this->authorModel->findAll(),
        'title' => 'Tambah Buku'
    ]);
}

public function edit($id)
{
    if (!session()->get('user') || session()->get('user')['role'] !== 'admin') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
    }

    $book = $this->bookModel->find($id);
    if (!$book) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan.");
    }

    // Ambil semua kategori
    $kategori = $this->categoryModel->findAll();

    // Ambil semua penulis (untuk auto-suggestion)
    $allAuthors = $this->authorModel->findAll();

    // Ambil penulis yang sudah terkait dengan buku ini
    $authors = $this->bookAuthorModel->getAuthorsByBookId($id);
    $authorNames = implode(', ', array_column($authors, 'name'));

    return view('books/edit', [
        'book' => $book,
        'kategori' => $kategori,
        'authorNames' => $authorNames,
        'allAuthors' => $allAuthors,
        'title' => 'Edit Buku'
    ]);
}

public function update($id)
{
    if (!session()->get('user') || session()->get('user')['role'] !== 'admin') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
    }

    $book = $this->bookModel->find($id);
    if (!$book) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan.");
    }

    // Data dasar
    $data = [
        'id' => $id,
        'title' => $this->request->getPost('judul'),
        'description' => $this->request->getPost('deskripsi'),
        'category' => $this->request->getPost('category'),
        'language' => $this->request->getPost('language'),
        'publisher' => $this->request->getPost('publisher'),
        'isbn' => $this->request->getPost('isbn') ?: null,
        'number_of_pages' => $this->request->getPost('number_of_pages') ?: null,
        'year' => $this->request->getPost('year') ?: null,
    ];

    // Cek dan update file buku
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Hapus file lama
        if (file_exists('uploads/books/' . $book['book_file'])) {
            unlink('uploads/books/' . $book['book_file']);
        }
        $filename = $file->getRandomName();
        $file->move('uploads/books', $filename);
        $data['book_file'] = $filename;
    }

    // Cek dan update cover buku
    $cover = $this->request->getFile('cover_image');
    if ($cover && $cover->isValid()) {
        // Hapus cover lama
        if (file_exists('uploads/covers/' . $book['cover_image'])) {
            unlink('uploads/covers/' . $book['cover_image']);
        }
        $coverName = $cover->getRandomName();
        $cover->move('uploads/covers', $coverName);
        $data['cover_image'] = $coverName;
    }

    // Simpan update buku
    $this->bookModel->save($data);

    // Update penulis
    $authorNames = explode(',', $this->request->getPost('authors'));
    $authorIds = [];

    foreach ($authorNames as $name) {
        $name = trim($name);
        if ($name === '') continue;

        $existingAuthor = $this->authorModel->where('name', $name)->first();

        if ($existingAuthor) {
            $authorIds[] = $existingAuthor['id'];
        } else {
            // Jika penulis belum ada, tambahkan
            $this->authorModel->save(['name' => $name]);
            $authorIds[] = $this->authorModel->getInsertID();
        }
    }

    // Hapus relasi lama dan masukkan yang baru
    $this->bookAuthorModel->where('id_book', $id)->delete();

    foreach ($authorIds as $id_author) {
        $this->bookAuthorModel->save(['id_book' => $id, 'id_author' => $id_author]);
    }

    return redirect()->to('/books')->with('success', 'Buku berhasil diupdate.');
}


public function delete($id)
{
    if (!session()->get('user') || session()->get('user')['role'] !== 'admin') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
    }

    $book = $this->bookModel->find($id);
    if ($book) {
        // Hapus file PDF jika ada
        $pdfPath = FCPATH . 'uploads/books/' . $book['book_file'];
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        // Hapus cover jika ada
        $coverPath = FCPATH . 'uploads/covers/' . $book['cover_image'];
        if (file_exists($coverPath)) {
            unlink($coverPath);
        }

        // Hapus data buku
        $this->bookModel->delete($id);
    }

    return redirect()->to('/books')->with('success', 'Buku berhasil dihapus.');
}


public function store()
{
    $validation = \Config\Services::validation();

    // Validasi file PDF
    $pdf = $this->request->getFile('file');
    if (!$pdf->isValid() || $pdf->getSize() > 50 * 1024 * 1024 || $pdf->getClientMimeType() !== 'application/pdf') {
        return redirect()->back()->with('error', 'File PDF tidak valid atau melebihi ukuran 50MB.');
    }

    // Validasi cover image
    $coverImage = $this->request->getFile('cover_image');
    $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!$coverImage->isValid() || !in_array($coverImage->getClientMimeType(), $allowedImageTypes)) {
        return redirect()->back()->with('error', 'Cover harus berupa gambar jpg, jpeg, atau png.');
    }

    // Buat slug otomatis
    helper('text');
    $slug = url_title($this->request->getPost('judul'), '-', true);

    // Simpan file PDF dengan nama slug.pdf
    $pdfName = $slug . '.' . $pdf->getClientExtension();
    $pdf->move('uploads/books', $pdfName);

    // Simpan cover image dengan nama slug.[ext]
    $coverExtension = $coverImage->getClientExtension();
    $coverName = $slug . '.' . $coverExtension;
    $coverImage->move('uploads/covers', $coverName);

    // Simpan ke tabel books
    $this->bookModel->save([
        'title' => $this->request->getPost('judul'),
        'slug' => $slug,
        'description' => $this->request->getPost('deskripsi'),
        'book_file' => $pdfName,
        'cover_image' => $coverName,
        'uploaded_by' => session()->get('user')['id'] ?? null,
        'language' => $this->request->getPost('language'),
        'category' => $this->request->getPost('category'),
        'publisher' => $this->request->getPost('publisher'),
        'isbn' => $this->request->getPost('isbn') ?: null,
        'number_of_pages' => $this->request->getPost('number_of_pages') ?: null,
        'year' => $this->request->getPost('year') ?: null,
    ]);

    $bookId = $this->bookModel->getInsertID();

    // Proses multiple authors
    $authorNames = explode(',', $this->request->getPost('authors'));
    $authorIds = [];

    foreach ($authorNames as $name) {
        $name = trim($name);
        if ($name === '') continue;

        // Cek apakah author sudah ada
        $existingAuthor = $this->authorModel->where('name', $name)->first();

        if ($existingAuthor) {
            $authorIds[] = $existingAuthor['id'];
        } else {
            // Insert author baru
            $this->authorModel->save(['name' => $name]);
            $authorIds[] = $this->authorModel->getInsertID();
        }
    }

    // Simpan relasi book-author
    foreach ($authorIds as $id_author) {
        $this->bookAuthorModel->save(['id_book' => $bookId, 'id_author' => $id_author]);
    }

    return redirect()->to('/books')->with('success', 'Buku berhasil ditambahkan.');
}



}
