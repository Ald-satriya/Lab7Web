<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// ===============================
// 🔷 Static Pages
// ===============================
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::home');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/tos', 'Page::tos');

// ===============================
// 📰 Artikel Routes (Frontend)
// ===============================
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

// ===============================
// 🛠️ Admin Routes (Backend Manual - Artikel)
// ===============================
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// ===============================
// 👤 User Authentication
// ===============================
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// ===============================
// 🔒 Protected Admin Route
// ===============================
$routes->get('/admin/artikel', 'Admin\Artikel::index', ['filter' => 'auth']);

// ===============================
// ⚙️ AJAX CRUD + Pagination Routes
// ===============================
$routes->group('ajax', function($routes) {
    $routes->get('/', 'AjaxController::index');                // Halaman AJAX
    $routes->get('get', 'AjaxController::get');                // Ambil data (pagination)
    $routes->post('save', 'AjaxController::save');             // Simpan baru
    $routes->get('edit/(:num)', 'AjaxController::edit/$1');    // Ambil data 1 artikel
    $routes->post('update/(:num)', 'AjaxController::update/$1'); // Update
    $routes->delete('delete/(:num)', 'AjaxController::delete/$1'); // Hapus
});

// ===============================
// 🔁 RESTful API Resource (Contoh)
// ===============================
$routes->resource('post'); // Hanya jika kamu memang buat controller Post.php sebagai REST API
