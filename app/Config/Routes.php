<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Dashboard user biasa
// $routes->get('/', 'User::index', ['filter' => 'login']);

// // Dashboard admin
// $routes->get('/admin',       'Admin::index', ['filter' => 'role:administrator']);
// $routes->get('/admin/index', 'Admin::index', ['filter' => 'role:administrator']);

// Dashboard
$routes->get('/', 'Dashboard::index', ['filter' => 'login']);

// induksi
$routes->get('/induksi',              'Induksi::index',  ['filter' => 'login']);
$routes->get('/induksi/export',       'Induksi::export', ['filter' => 'login']);

$routes->get('/induksi/create',       'Induksi::create', ['filter' => 'role:administrator,editor']);
$routes->post('/induksi/store',        'Induksi::store',  ['filter' => 'role:administrator,editor']);
$routes->get('/induksi/edit/(:num)',  'Induksi::edit/$1',   ['filter' => 'role:administrator,editor']);
$routes->post('/induksi/update/(:num)', 'Induksi::update/$1', ['filter' => 'role:administrator,editor']);
$routes->get('/induksi/delete/(:num)', 'Induksi::delete/$1', ['filter' => 'role:administrator,editor']);


// patrol
$routes->get('/patrol',               'Patrol::index',   ['filter' => 'login']);
$routes->get('/patrol/export',        'Patrol::export',  ['filter' => 'login']);

$routes->get('/patrol/create',        'Patrol::create',  ['filter' => 'role:administrator,editor']);
$routes->post('/patrol/store',         'Patrol::store',   ['filter' => 'role:administrator,editor']);
$routes->get('/patrol/edit/(:num)',   'Patrol::edit/$1', ['filter' => 'role:administrator,editor']);
$routes->post('/patrol/update/(:num)', 'Patrol::update/$1', ['filter' => 'role:administrator,editor']);
$routes->get('/patrol/delete/(:num)', 'Patrol::delete/$1', ['filter' => 'role:administrator,editor']);


// management users
$routes->get('/admin/users', 'Admin::users', ['filter' => 'role:administrator']);
$routes->get('/admin/users/create', 'Admin::create', ['filter' => 'role:administrator']);
$routes->post('/admin/users/store', 'Admin::store', ['filter' => 'role:administrator']);
$routes->get('/admin/users/edit/(:num)', 'Admin::edit/$1', ['filter' => 'role:administrator']);
$routes->post('/admin/users/update/(:num)', 'Admin::update/$1', ['filter' => 'role:administrator']);
$routes->get('/admin/users/delete/(:num)', 'Admin::delete/$1', ['filter' => 'role:administrator']);
$routes->post('/admin/users/reset-password', 'Admin::resetPassword', ['filter' => 'role:administrator']);
