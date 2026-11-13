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

// Jurnal Memorial
$routes->group('jurnal_memorial', ['filter' => 'auth'], static function ($routes) {
    $routes->match(['get', 'post'], '/', 'Jurnal_memorial::index');
    $routes->post('ubah_debet', 'Jurnal_memorial::ubah_debet');
    $routes->post('ubah_kredit', 'Jurnal_memorial::ubah_kredit');
    $routes->get('cetak/(:segment)/(:segment)', 'Jurnal_memorial::cetak/$1/$2');
    $routes->get('konfersi/(:segment)/(:segment)', 'Jurnal_memorial::konfersi/$1/$2');
    $routes->get('export/(:segment)/(:segment)', 'Jurnal_memorial::export/$1/$2');
});

// Neraca
$routes->group('neraca', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Neraca::index');
    $routes->match(['get', 'post'], 'neraca_mutasi', 'Neraca::neraca_mutasi');
    $routes->match(['get', 'post'], 'neraca_penyesuaian', 'Neraca::neraca_penyesuaian');
    $routes->match(['get', 'post'], 'neraca_saldo', 'Neraca::neraca_saldo');
    $routes->get('cetak_mutasi/(:segment)/(:segment)', 'Neraca::cetak_mutasi/$1/$2');
    $routes->get('cetak_penyesuaian/(:segment)/(:segment)', 'Neraca::cetak_penyesuaian/$1/$2');
    $routes->get('cetak_saldo/(:segment)/(:segment)', 'Neraca::cetak_saldo/$1/$2');
    $routes->get('konfersi_mutasi/(:segment)/(:segment)', 'Neraca::konfersi_mutasi/$1/$2');
    $routes->get('konfersi_penyesuaian/(:segment)/(:segment)', 'Neraca::konfersi_penyesuaian/$1/$2');
    $routes->get('konfersi_saldo/(:segment)/(:segment)', 'Neraca::konfersi_saldo/$1/$2');
    $routes->get('export_mutasi/(:segment)/(:segment)', 'Neraca::export_mutasi/$1/$2');
    $routes->get('export_penyesuaian/(:segment)/(:segment)', 'Neraca::export_penyesuaian/$1/$2');
    $routes->get('export_saldo/(:segment)/(:segment)', 'Neraca::export_saldo/$1/$2');
    $routes->get('simpan_saldo/(:segment)/(:segment)', 'Neraca::simpan_saldo/$1/$2');
    $routes->post('update_penyesuaian', 'Neraca::update_penyesuaian');
    $routes->post('update_saldo', 'Neraca::update_saldo');
});

// Rugi Laba
$routes->group('rugi_laba', ['filter' => 'auth'], static function ($routes) {
    $routes->match(['get', 'post'], '/', 'Rugi_laba::index');
    $routes->get('cetak/(:segment)/(:segment)', 'Rugi_laba::cetak/$1/$2');
    $routes->get('konfersi/(:segment)/(:segment)', 'Rugi_laba::konfersi/$1/$2');
    $routes->get('export/(:segment)/(:segment)', 'Rugi_laba::export/$1/$2');
});
