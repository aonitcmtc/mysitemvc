<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/powerby', 'Home::powerby');
$routes->get('/mysite', 'Mysite::index');
$routes->get('/navleft', 'Mysite::navleft');
$routes->get('/navleftelectic', 'Mysite::navleftelectic');
$routes->get('/member', 'Mysite::member');
$routes->get('/mytemp', 'Mysite::mytemp'); // page tempage copy index
$routes->get('/chart/xauusd', 'Chart::xauusd');

// Admin area
$routes->group('admin', ['namespace' => 'App\Admin\Controllers', 'filter' => 'adminAuth'], static function($routes) {
    
    // $routes->match(['get', 'post'],'login', 'Auth::login');
    $routes->get('/',              'Index::index');
    $routes->get('devcode',          'Index::devcode');
    $routes->get('dashboard',      'Dashboard::index');
    $routes->get('users',          'Users::index');
    $routes->get('userimg',          'Users::getImg');
    

    $routes->post('checklogin',    'Auth::checklogin');
    $routes->get('register',          'Auth::register');
    $routes->get('login',          'Auth::login');
    $routes->get('logout',         'Auth::logout');

    $routes->get('framsv1',         'Funny::framsv1');
    $routes->get('mario',         'Funny::mario');
    $routes->get('snake',         'Funny::snake');

    // chart
    $routes->get('chartlist',         'Trading::index');
    $routes->get('chart/xauusd',         'Trading::xauusd');
    $routes->get('chart/xauusdclassic',         'Trading::xauusdclassic');
    $routes->get('chart/chartgoldthai',         'Trading::chartgoldthai');

    // Tools
    $routes->get('tools',         'Tools::index');
    $routes->get('tools/apitest',         'Tools::apitest');


    

    
});



