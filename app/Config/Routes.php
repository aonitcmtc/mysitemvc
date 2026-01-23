<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/powerby', 'Home::powerby');
$routes->get('/mysite', 'Mysite::index');

// Admin area
$routes->group('admin', ['namespace' => 'App\Admin\Controllers'], function($routes) {
    $routes->get('/',              'Dashboard::index');
    // $routes->get('dashboard',      'Dashboard::index');
    // $routes->get('users',          'Users::index');
    // $routes->match(['get', 'post'],'login', 'Auth::login');
    // $routes->get('logout',         'Auth::logout');

    $routes->post('checklogin',              'Auth::checklogin');

    $routes->get('login',              'Auth::login');
    $routes->get('logout',             'Auth::logout');
});


