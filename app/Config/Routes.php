<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::index');

// Auth routes
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/ubah_password', 'Auth::ubah_password', ['filter' => 'auth']);
$routes->post('auth/update_password', 'Auth::update_password', ['filter' => 'auth']);
$routes->get('auth/logout', 'Auth::logout');

// Dashboard
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Users (super_user)
$routes->group('users', ['filter' => 'auth:super_user'], static function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('list', 'Users::list');
    $routes->post('tambah', 'Users::tambah');
    $routes->post('reset', 'Users::reset');
    $routes->get('activity', 'Users::activity');
});

// Data Master
$routes->group('data_master', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Data_master::index');
    $routes->get('jenis_akun', 'Data_master::jenis_akun');
    $routes->post('tambah_jenis', 'Data_master::tambah_jenis');
    $routes->post('ubah_jenis', 'Data_master::ubah_jenis');
    $routes->post('hapus_jenis', 'Data_master::hapus_jenis');
    $routes->get('item_akun', 'Data_master::item_akun');
    $routes->post('tambah_item', 'Data_master::tambah_item');
    $routes->post('ubah_item', 'Data_master::ubah_item');
    $routes->post('hapus_item', 'Data_master::hapus_item');
});
