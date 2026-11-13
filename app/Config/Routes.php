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

// Rincian & Rangkuman
$routes->group('rincian_dan_rangkuman', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Rincian_dan_rangkuman::index');
    $routes->get('uang_masuk', 'Rincian_dan_rangkuman::uang_masuk');
    $routes->post('tambah_uang_masuk', 'Rincian_dan_rangkuman::tambah_uang_masuk');
    $routes->post('ubah_uang_masuk', 'Rincian_dan_rangkuman::ubah_uang_masuk');
    $routes->post('hapus_uang_masuk', 'Rincian_dan_rangkuman::hapus_uang_masuk');
    $routes->get('uang_keluar', 'Rincian_dan_rangkuman::uang_keluar');
    $routes->post('tambah_uang_keluar', 'Rincian_dan_rangkuman::tambah_uang_keluar');
    $routes->post('ubah_uang_keluar', 'Rincian_dan_rangkuman::ubah_uang_keluar');
    $routes->post('hapus_uang_keluar', 'Rincian_dan_rangkuman::hapus_uang_keluar');
});

// Kas Harian
$routes->group('kas_harian', ['filter' => 'auth'], static function ($routes) {
    $routes->match(['get', 'post'], '/', 'Kas_harian::index');
    $routes->get('cetak/(:segment)/(:segment)', 'Kas_harian::cetak/$1/$2');
    $routes->get('konfersi/(:segment)/(:segment)', 'Kas_harian::konfersi/$1/$2');
    $routes->get('export/(:segment)/(:segment)', 'Kas_harian::export/$1/$2');
});

// Laporan Kas
$routes->group('laporan_kas', ['filter' => 'auth'], static function ($routes) {
    $routes->match(['get', 'post'], '/', 'Laporan_kas::index');
    $routes->get('cetak/(:segment)/(:segment)', 'Laporan_kas::cetak/$1/$2');
    $routes->get('konfersi/(:segment)/(:segment)', 'Laporan_kas::konfersi/$1/$2');
    $routes->get('export/(:segment)/(:segment)', 'Laporan_kas::export/$1/$2');
});

// Arus Kas
$routes->group('arus_kas', ['filter' => 'auth'], static function ($routes) {
    $routes->match(['get', 'post'], '/', 'Arus_kas::index');
    $routes->get('cetak/(:segment)/(:segment)', 'Arus_kas::cetak/$1/$2');
    $routes->get('konfersi/(:segment)/(:segment)', 'Arus_kas::konfersi/$1/$2');
    $routes->get('export/(:segment)/(:segment)', 'Arus_kas::export/$1/$2');
    $routes->get('simpan_jurnal/(:segment)/(:segment)', 'Arus_kas::simpan_jurnal/$1/$2');
});
