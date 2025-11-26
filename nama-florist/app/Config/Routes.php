<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// == PUBLIC ROUTES ==
$routes->get('/', 'Home::index');
$routes->get('/katalog', 'Home::katalog');
$routes->get('/product/(:num)', 'Home::show/$1');

// == AUTHENTICATION ROUTES ==
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

// == CUSTOMER CHECKOUT & ORDER ROUTES ==
// $routes->get('/checkout/(:num)', 'Checkout::index/$1', ['filter' => 'login']);
// $routes->post('/checkout/process', 'Checkout::process', ['filter' => 'login']);
// $routes->get('/my-orders', 'Pesanan::index', ['filter' => 'login']);
// $routes->get('/my-orders/(:num)', 'Pesanan::show/$1', ['filter' => 'login']);
$routes->get('checkout/(:num)', 'PesananController::checkout/$1');
$routes->post('checkout/process', 'PesananController::process');

$routes->get('order/confirm/(:num)', 'PesananController::confirm/$1');
// Pesanan system
$routes->get('order/checkout/(:num)', 'PesananController::checkout/$1');
$routes->post('order/process', 'PesananController::process');
$routes->get('order/confirm/(:num)', 'PesananController::confirm/$1');
$routes->get('order/payment/(:num)', 'PesananController::payment/$1');
$routes->post('order/upload-payment', 'PesananController::uploadPayment');
$routes->get('order/finish/(:num)', 'PesananController::finish/$1');





// == ADMIN ROUTES ==
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    $routes->resource('papanbunga', ['controller' => 'Admin\PapanBunga']);
    $routes->resource('pengguna', ['controller' => 'Admin\Pengguna']);
    $routes->resource('pesanan', ['controller' => 'Admin\Pesanan']);
    $routes->resource('pembayaran', ['controller' => 'Admin\Pembayaran']);
});