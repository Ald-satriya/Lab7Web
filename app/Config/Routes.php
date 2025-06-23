<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/tos', 'Page::tos');
$routes->get('/home', 'Home::home');


// Artikel routes
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');


$routes->group('admin', function ($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

$routes->get('/admin/artikel', 'Artikel::admin_index');



// Routes Login & Logout
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// Route admin yang diproteksi filter auth
$routes->get('/admin/artikel', 'Admin\Artikel::index', ['filter' => 'auth']);

// AJAX routes
$routes->get('/ajax', 'AjaxController::index');
$routes->get('/ajax/getData', 'AjaxController::getData');
$routes->get('/ajax/edit/(:num)', 'AjaxController::edit/$1');
$routes->post('/ajax/save', 'AjaxController::save');
$routes->post('/ajax/update/(:num)', 'AjaxController::update/$1');
$routes->delete('/ajax/delete/(:num)', 'AjaxController::delete/$1');

$routes->get('/api/post', 'Artikel::postApi');

$routes->resource('post', ['controller' => 'PostApi']);
$routes->options('post', 'PostApi::options');
$routes->options('post/(:any)', 'PostApi::options');





