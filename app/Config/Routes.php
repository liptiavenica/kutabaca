<?php

use CodeIgniter\Debug\Toolbar\Collectors\Views;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 */
$routes->get('/', 'Home::index');
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('admin', 'Admin::index');
$routes->get('/books', 'Book::showCollection');
$routes->get('/books/index', 'Book::index');
$routes->get('/books/detail/(:any)', 'Book::detail/$1');
$routes->get('/books/read/(:any)', 'Book::read/$1');
$routes->get('/books/create', 'Book::create');
$routes->post('/books/store', 'Book::store');
$routes->get('books/create', 'Book::create');
$routes->post('books/store', 'Book::store');
$routes->get('books/edit/(:num)', 'Book::edit/$1');
$routes->post('books/update/(:num)', 'Book::update/$1');
$routes->post('books/delete/(:num)', 'Book::delete/$1');
$routes->get('/authors/search', 'Author::search');
$routes->get('about', 'Home::about');