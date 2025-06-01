<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// Static pages
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::home');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/tos', 'Page::tos');

// Artikel routes
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// User routes
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// Admin artikel dengan filter login
$routes->get('/admin/artikel', 'Admin\Artikel::index', ['filter' => 'auth']);

// ✅ Final: AJAX routes (rapi & konsisten)
$routes->group('ajax', function($routes) {
    $routes->get('/', 'AjaxController::index');
    $routes->get('get', 'AjaxController::getPaginatedData');
    $routes->post('save', 'AjaxController::save');
    $routes->get('edit/(:num)', 'AjaxController::edit/$1');
    $routes->post('update/(:num)', 'AjaxController::update/$1');
    $routes->delete('delete/(:num)', 'AjaxController::delete/$1');
});
