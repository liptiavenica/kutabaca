<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\BookModel;

class Home extends BaseController
{
    protected $categoryModel;
    protected $bookModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->bookModel = new BookModel();
    }

    public function index(): string
    {
        $categories = $this->categoryModel->findAll();
        $recentBooks = $this->bookModel->getBooksWithCategoryAndLanguage(null, null, null);
        // Ambil hanya 6 buku terbaru
        $recentBooks = array_slice($recentBooks, 0, 6);
        
        return view('home', [
            'title' => 'KutaBaca - Perpustakaan Digital Offline',
            'categories' => $categories,
            'recentBooks' => $recentBooks
        ]);
    }
}
