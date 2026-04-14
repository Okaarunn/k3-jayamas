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
$routes->get('/induksi/export',       'Induksi::export', ['filter' => 'permission:export-report']);
$routes->get('/induksi/exportpdf',        'Induksi::exportPdf',  ['filter' => 'permission:export-report']);
$routes->get('/induksi/create',       'Induksi::create', ['filter' => 'permission:manage-data']);
$routes->post('/induksi/store',        'Induksi::store',  ['filter' => 'permission:manage-data']);
$routes->get('/induksi/edit/(:num)',  'Induksi::edit/$1',   ['filter' => 'permission:manage-data']);
$routes->post('/induksi/update/(:num)', 'Induksi::update/$1', ['filter' => 'permission:manage-data']);
$routes->get('/induksi/delete/(:num)', 'Induksi::delete/$1', ['filter' => 'permission:manage-data']);

// patrol
$routes->get('/patrol',               'Patrol::index',   ['filter' => 'login']);
$routes->get('/patrol/export',        'Patrol::export',  ['filter' => 'permission:export-report']);
$routes->get('/patrol/exportpdf',        'Patrol::exportPdf',  ['filter' => 'permission:export-report']);
$routes->get('/patrol/create',        'Patrol::create',  ['filter' => 'permission:manage-data']);
$routes->post('/patrol/store',         'Patrol::store',   ['filter' => 'permission:manage-data']);
$routes->get('/patrol/edit/(:num)',   'Patrol::edit/$1', ['filter' => 'permission:manage-data']);
$routes->post('/patrol/update/(:num)', 'Patrol::update/$1', ['filter' => 'permission:manage-data']);
$routes->get('/patrol/delete/(:num)', 'Patrol::delete/$1', ['filter' => 'permission:manage-data']);

// management roles
$routes->get('/admin/roles', 'Role::index', ['filter' => 'permission:manage-users']);
$routes->get('/admin/roles/create', 'Role::create', ['filter' => 'permission:manage-users']);
$routes->post('/admin/roles/store', 'Role::store', ['filter' => 'permission:manage-users']);
$routes->get('/admin/roles/edit/(:num)', 'Role::edit/$1', ['filter' => 'permission:manage-users']);
$routes->post('/admin/roles/update/(:num)', 'Role::update/$1', ['filter' => 'permission:manage-users']);
$routes->get('/admin/roles/delete/(:num)', 'Role::delete/$1', ['filter' => 'permission:manage-users']);

// management users
$routes->get('/admin/users', 'Admin::index', ['filter' => 'permission:manage-users']);
$routes->get('/admin/userlogs', 'Admin::userlogs', ['filter' => 'permission:manage-users']);
$routes->get('/admin/users/create', 'Admin::create', ['filter' => 'permission:manage-users']);
$routes->post('/admin/users/store', 'Admin::store', ['filter' => 'permission:manage-users']);
$routes->get('/admin/users/edit/(:num)', 'Admin::edit/$1', ['filter' => 'permission:manage-users']);
$routes->post('/admin/users/update/(:num)', 'Admin::update/$1', ['filter' => 'permission:manage-users']);
$routes->get('/admin/users/delete/(:num)', 'Admin::delete/$1', ['filter' => 'permission:manage-users']);
$routes->post('/admin/users/reset-password', 'Admin::resetPassword', ['filter' => 'permission:manage-users']);

// management plant
$routes->get('/admin/plant', 'Plant::index', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/create', 'Plant::create', ['filter' => 'permission:manage-users']);
$routes->post('/admin/plant/store', 'Plant::store', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/edit/(:num)', 'Plant::edit/$1', ['filter' => 'permission:manage-users']);
$routes->post('/admin/plant/update/(:num)', 'Plant::update/$1', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/delete/(:num)', 'Plant::delete/$1', ['filter' => 'permission:manage-users']);
