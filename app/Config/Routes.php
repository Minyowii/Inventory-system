<?php
use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Login::index'); 
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

$routes->group('', ['filter' => 'role'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('profile', 'Profile::index');

    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    
    $routes->get('inventory', 'Inventory::index');
    $routes->get('inventory/show/(:num)', 'Inventory::show/$1');
    $routes->get('inventory/add', 'Inventory::add');
    $routes->post('inventory/store', 'Inventory::store');
    $routes->get('inventory/edit/(:num)', 'Inventory::edit/$1');
    $routes->post('inventory/update/(:num)', 'Inventory::update/$1');
    $routes->get('inventory/delete/(:num)', 'Inventory::delete/$1');

    // Kategori (Admin)
    $routes->get('categories', 'Category::index');
    $routes->get('categories/add', 'Category::add');
    $routes->post('categories/store', 'Category::store');
    $routes->get('categories/edit/(:num)', 'Category::edit/$1');
    $routes->post('categories/update/(:num)', 'Category::update/$1');
    $routes->get('categories/delete/(:num)', 'Category::delete/$1');

    // Suppliers (Admin)
    $routes->get('suppliers', 'Suppliers::index');
    $routes->get('suppliers/add', 'Suppliers::add');
    $routes->post('suppliers/store', 'Suppliers::store');
    $routes->get('suppliers/edit/(:num)', 'Suppliers::edit/$1');
    $routes->post('suppliers/update/(:num)', 'Suppliers::update/$1');
    $routes->get('suppliers/delete/(:num)', 'Suppliers::delete/$1');

    // Keranjang & Orders (User)
    $routes->get('orders', 'Orders::index');
    $routes->get('orders/cart', 'Orders::cart');
    $routes->post('orders/add_to_cart', 'Orders::addToCart');
    $routes->get('orders/remove_cart/(:num)', 'Orders::removeCart/$1');
    $routes->post('orders/checkout', 'Orders::checkout');

    // Admin Kelola Order
    $routes->get('orders/manage', 'Orders::manage');
    $routes->post('orders/update_status/(:num)', 'Orders::updateStatus/$1');
});