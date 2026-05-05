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

// vendor
$routes->get('/work-permit-request', 'WorkPermit::index');
$routes->post('/work-permit-request/store', 'WorkPermit::store');

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
$routes->get('/admin/datalogs', 'Admin::datalogs', ['filter' => 'permission:manage-users']);

// management plant
$routes->get('/admin/plant', 'Plant::index', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/create', 'Plant::create', ['filter' => 'permission:manage-users']);
$routes->post('/admin/plant/store', 'Plant::store', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/edit/(:num)', 'Plant::edit/$1', ['filter' => 'permission:manage-users']);
$routes->post('/admin/plant/update/(:num)', 'Plant::update/$1', ['filter' => 'permission:manage-users']);
$routes->get('/admin/plant/delete/(:num)', 'Plant::delete/$1', ['filter' => 'permission:manage-users']);

// pekerjaan
$routes->post('/kategori-pekerjaan/store', 'KategoriPekerjaan::store');

// approval k3
$routes->get('/approval-k3', 'ApprovalK3::index', ['filter' => 'permission:manage-data']);
$routes->get('/approvalk3/preview/(:num)', 'ApprovalK3::preview/$1', ['filter' => 'permission:manage-data']);
$routes->post('/approval-k3/approve/(:num)', 'ApprovalK3::approvek3/$1', ['filter' => 'permission:manage-data']);
$routes->post('/approval-k3/reject/(:num)', 'ApprovalK3::rejectk3/$1', ['filter' => 'permission:manage-data']);
$routes->post('/approval-k3/delete/(:num)', 'ApprovalK3::delete/$1', ['filter' => 'permission:manage-data']);

// approval p2k3
$routes->get('/approval-p2k3', 'ApprovalP2K3::index', ['filter' => 'role:administrator,p2k3']);
$routes->post('/approval-p2k3/approve/(:num)', 'ApprovalP2K3::approvep2k3/$1', ['filter' => 'permission:manage-approval']);
$routes->post('/approval-p2k3/reject/(:num)', 'ApprovalP2K3::rejectp2k3/$1', ['filter' => 'permission:manage-approval']);
$routes->post('/approval-p2k3/delete/(:num)', 'ApprovalP2K3::delete/$1', ['filter' => 'permission:manage-data']);

// progress pengerjaan
$routes->get('/progress-pengerjaan', 'ProgressPengerjaan::index', ['filter' => 'permission:manage-data']);
$routes->post('progress-pengerjaan/finish-batch', 'ProgressPengerjaan::finishBatch', ['filter' => 'permission:manage-data']);
$routes->post('progress-pengerjaan/finish-single', 'ProgressPengerjaan::finishSingle', ['filter' => 'permission:manage-data']);

// document center
$routes->get('/document-center', 'DocumentCenter::index', ['filter' => 'login']);
