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
        return view('books/create', [
            'kategori' => $this->categoryModel->findAll(),
            'penulis' => $this->authorModel->findAll()
        ]);
    }

    public function store()
    {
        $file = $this->request->getFile('file');
        $filename = $file->getRandomName();
        $file->move('uploads', $filename);

        $data = [
            'title' => $this->request->getPost('judul'),
            'description' => $this->request->getPost('deskripsi'),
            'book_file' => $filename,
            'uploaded_by' => session()->get('user')['id'] ?? null,
        ];

        $this->bookModel->save($data);
        $bookId = $this->bookModel->getInsertID();

        // Tangani penulis (otomatis add jika belum ada)
        $authorNames = explode(',', $this->request->getPost('authors'));
        $authorIds = [];

        foreach ($authorNames as $name) {
            $name = trim($name);
            if ($name === '') continue;
            $existing = $this->authorModel->where('name', $name)->first();
            if ($existing) {
                $authorIds[] = $existing['id'];
            } else {
                $this->authorModel->save(['name' => $name]);
                $authorIds[] = $this->authorModel->getInsertID();
            }
        }

        foreach ($authorIds as $id_author) {
            $this->bookAuthorModel->save(['id_book' => $bookId, 'id_author' => $id_author]);
        }

        return redirect()->to('/books');
    }

    public function delete($id)
    {
        $this->bookModel->delete($id);
        return redirect()->to('/books');
    }
}
