<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk Halaman Utama / Homepage
$routes->get('/', 'Home::index');

// Rute BARU untuk Halaman Katalog
$routes->get('/katalog', 'Home::katalog');

// Rute Detail Produk tetap sama
$routes->get('/product/(:num)', 'Home::show/$1');


// Rute untuk MENAMPILKAN halaman checkout dari detail produk
$routes->get('/checkout/(:num)', 'Checkout::index/$1');

// Rute untuk MEMPROSES data dari form checkout
$routes->post('/checkout/process', 'Checkout::process');

// Rute untuk halaman sukses setelah checkout
$routes->get('/checkout/success/(:num)', 'Checkout::success/$1');

/*
 * --------------------------------------------------------------------
 * AUTHENTICATION ROUTES
 * --------------------------------------------------------------------
 */
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

// Rute untuk halaman riwayat pesanan
$routes->get('/my-orders', 'Pesanan::index');
// Rute untuk halaman detail satu pesanan
$routes->get('/my-orders/(:num)', 'Pesanan::show/$1');
// Rute untuk membatalkan pesanan
$routes->post('/my-orders/(:num)/cancel', 'Pesanan::cancel/$1');
// Rute untuk konfirmasi pembayaran
$routes->get('/my-orders/confirm-payment/(:num)', 'Pesanan::confirmPayment/$1');
$routes->post('/my-orders/process-payment/(:num)', 'Pesanan::processPayment/$1');

/*
 * --------------------------------------------------------------------
 * ADMIN ROUTES
 * --------------------------------------------------------------------
 */

$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->resource('papanbunga', ['controller' => 'Admin\PapanBunga']);
    $routes->resource('pengguna', ['controller' => 'Admin\Pengguna']);
    $routes->resource('pesanan', ['controller' => 'Admin\Pesanan']);
    $routes->resource('pembayaran', ['controller' => 'Admin\Pembayaran']);
});