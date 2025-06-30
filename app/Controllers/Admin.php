<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $bookModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Cek login dan role
        $user = session()->get('user');
        if (!$user || $user['role'] !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        // Hitung jumlah buku per kategori
        $kategori1Count = $this->bookModel->countBooksByCategory(1);
        $kategori2Count = $this->bookModel->countBooksByCategory(2);
        $kategori3Count = $this->bookModel->countBooksByCategory(3);

        $data = [
            'title' => 'Dashboard Admin',
            'user' => $user,
            'kategori1Count' => $kategori1Count,
            'kategori2Count' => $kategori2Count,
            'kategori3Count' => $kategori3Count,
        ];

        return view('admin/dashboard', $data);
    }
}
