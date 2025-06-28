<?php

namespace App\Models;

use CodeIgniter\Model;

class BookAuthorModel extends Model
{
    protected $table = 'book_author';
    protected $allowedFields = ['id_book', 'id_author'];
    protected $useTimestamps = false;
}
