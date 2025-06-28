<?php

namespace App\Controllers;

use App\Models\AuthorModel;
use CodeIgniter\RESTful\ResourceController;

class Author extends ResourceController
{
    public function search()
    {
        $term = $this->request->getGet('term');
        $authorModel = new AuthorModel();
        $results = $authorModel->like('name', $term)->findAll(10);
        return $this->response->setJSON($results);
    }
}
