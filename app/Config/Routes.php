<?php namespace Config;
$routes = Services::routes(true);

$routes->get('/', 'Home::index');
$routes->get('products', 'Product::browse');
$routes->get('product/(:segment)', 'Product::view/$1');
$routes->get('category/(:segment)', 'Product::category/$1');

$routes->post('cart/add', 'Cart::add');
$routes->get('cart', 'Cart::index');
$routes->post('cart/update', 'Cart::update');
$routes->post('cart/remove', 'Cart::remove');

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerPost');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('logout', 'Auth::logout');

$routes->get('profile', 'User::profile');
$routes->post('profile/update', 'User::updateProfile');
$routes->post('profile/change-password', 'User::changePassword');

$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/place', 'Checkout::placeOrder');
$routes->get('checkout/thanks/(:num)', 'Checkout::thanks/$1');

// Temporary: seed products (remove after testing)
$routes->get('seed-products', 'Seed::products');
$routes->get('mark-featured', 'Featured::markFeatured');

$routes->group('admin', ['filter' => 'adminAuth'], function($routes){
  $routes->get('/', 'Admin::dashboard');
  $routes->get('products', 'Admin::products');
  $routes->post('products/store', 'Admin::store');
  $routes->get('products/create', 'Admin::create');
  $routes->get('orders', 'Admin::orders');
});
