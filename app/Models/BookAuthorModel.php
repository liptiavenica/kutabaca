<?php

namespace App\Models;

use CodeIgniter\Model;

class BookAuthorModel extends Model
{
    protected $table = 'book_author';
    protected $allowedFields = ['id_book', 'id_author'];
    protected $useTimestamps = false;

    public function getAuthorsByBookId($bookId)
    {
        return $this->db->table('book_author ba')
            ->select('a.*')
            ->join('authors a', 'ba.id_author = a.id')
            ->where('ba.id_book', $bookId)
            ->get()
            ->getResultArray();
    }
}
