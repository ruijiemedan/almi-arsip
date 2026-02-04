<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::index');

// ============================================================
// AUTH ROUTES
// ============================================================
$routes->group('auth', function($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

// ============================================================
// PROTECTED ROUTES (Require Login)
// ============================================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard
    $routes->get('home', 'Home::index');
    $routes->get('dashboard', 'Home::index');
    
    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->post('profile/change-password', 'Profile::changePassword');
    
    // ============================================================
    // ARSIP ROUTES
    // ============================================================
    $routes->group('arsip', function($routes) {
        $routes->get('/', 'Arsip::index');
        $routes->get('add', 'Arsip::add');
        $routes->post('save', 'Arsip::save');
        $routes->get('view/(:num)', 'Arsip::view/$1');
        $routes->get('edit/(:num)', 'Arsip::edit/$1');
        $routes->post('update/(:num)', 'Arsip::update/$1');
        $routes->get('delete/(:num)', 'Arsip::delete/$1');
        $routes->get('download/(:num)', 'Arsip::download/$1');
    });
    
    // ============================================================
    // ADMIN ONLY ROUTES
    // ============================================================
    $routes->group('', ['filter' => 'admin'], function($routes) {
        
        // Kategori
        $routes->group('kategori', function($routes) {
            $routes->get('/', 'Kategori::index');
            $routes->get('add', 'Kategori::add');
            $routes->post('save', 'Kategori::save');
            $routes->get('edit/(:num)', 'Kategori::edit/$1');
            $routes->post('update/(:num)', 'Kategori::update/$1');
            $routes->get('delete/(:num)', 'Kategori::delete/$1');
        });
        
        // Departemen
        $routes->group('departemen', function($routes) {
            $routes->get('/', 'Departemen::index');
            $routes->get('add', 'Departemen::add');
            $routes->post('save', 'Departemen::save');
            $routes->get('edit/(:num)', 'Departemen::edit/$1');
            $routes->post('update/(:num)', 'Departemen::update/$1');
            $routes->get('delete/(:num)', 'Departemen::delete/$1');
        });
        
        // User Management
        $routes->group('user', function($routes) {
            $routes->get('/', 'User::index');
            $routes->get('add', 'User::add');
            $routes->post('save', 'User::save');
            $routes->get('edit/(:num)', 'User::edit/$1');
            $routes->post('update/(:num)', 'User::update/$1');
            $routes->get('delete/(:num)', 'User::delete/$1');
            $routes->get('toggle-status/(:num)', 'User::toggleStatus/$1');
        });
        
        // Activity Logs
        $routes->group('logs', function($routes) {
            $routes->get('/', 'Logs::index');
            $routes->get('delete/(:num)', 'Logs::delete/$1');
            $routes->get('clear', 'Logs::clear');
        });
    });
});

// ============================================================
// ERROR ROUTES
// ============================================================
$routes->set404Override(function() {
    echo view('errors/html/error_404');
});
