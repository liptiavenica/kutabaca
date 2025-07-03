<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'slug',
        'description',
        'book_file',
        'cover_image',
        'uploaded_by',
        'language',
        'category',
        'publisher',
        'isbn',
        'number_of_pages',
        'year'
    ];
    protected $useTimestamps = true;

    public function getBooksWithCategoryAndLanguage($keyword = null, $kategoriId = null, $language = null)
    {
        $builder = $this->db->table('books b')
            ->select('b.*, c.name AS category_name')
            ->join('category c', 'b.category = c.id', 'left')
            ->orderBy('b.created_at', 'DESC');

        if ($keyword) {
            $builder->groupStart()
                ->like('b.title', $keyword)
                ->orLike('b.description', $keyword)
                ->orLike('b.publisher', $keyword)
                ->groupEnd();
        }

        if ($kategoriId) {
            $builder->where('b.category', $kategoriId);
        }

        if ($language) {
            $builder->where('b.language', $language);
        }

        return $builder->get()->getResultArray();
    }

    public function getBookBySlug($slug)
    {
        return $this->db->table('books b')
            ->select('b.*, c.name AS category_name')
            ->join('category c', 'b.category = c.id', 'left')
            ->where('b.slug', $slug)
            ->get()
            ->getRowArray();
    }
    public function countBooksByCategory($categoryId)
    {
        return $this->db->table('books')
            ->where('category', $categoryId)
            ->countAllResults();
    }
    public function countBooks()
    {
        return $this->db->table('books')
            ->countAllResults();
    }
    public function getRecentBooks($limit = 8)
    {
        return $this->db->table('books b')
            ->select('b.*, c.name AS category_name')
            ->join('category c', 'b.category = c.id', 'left')
            ->orderBy('b.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
    
}
