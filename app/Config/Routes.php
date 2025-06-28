<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Book::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/books', 'Book::showCollection');
$routes->get('/books/read/(:any)', 'Book::read/$1');
$routes->get('/books/create', 'Book::create');
$routes->post('/books/store', 'Book::store');
$routes->get('/books/delete/(:num)', 'Book::delete/$1');
$routes->get('/authors/search', 'Author::search');
