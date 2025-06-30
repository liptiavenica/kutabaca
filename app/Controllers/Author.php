<?php

namespace App\Controllers;

use App\Models\AuthorModel;
use CodeIgniter\Controller;

class Author extends Controller
{
    public function search()
    {
        $term = $this->request->getGet('term');

        $authorModel = new AuthorModel();
        $authors = $authorModel->like('name', $term)->findAll(); 

        return $this->response->setJSON($authors);
    }
}
