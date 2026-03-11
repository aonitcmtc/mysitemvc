<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('auth', 'Auth::index');
$routes->get('auth/google', 'Google::redirect');
$routes->get('auth/google/callback', 'Google::callback');
$routes->get('auth/logout', 'Google::logout');

$routes->get('/powerby', 'Home::powerby');
$routes->get('/mysite', 'Mysite::index');
$routes->get('/navleft', 'Mysite::navleft');
$routes->get('/navleftelectic', 'Mysite::navleftelectic');
$routes->get('/member', 'Mysite::member');
$routes->get('/note', 'Mysite::note');
$routes->get('/mytemp', 'Mysite::mytemp'); // page tempage copy index
$routes->get('/chart/xauusd', 'Chart::xauusd');

// MT5 -> Tradepanal
// $routes->get('/mt5order', 'Tradepanal::mt5order');


// ********************** MT5 API **********************

// จาก Browser
$routes->group('api/mt5', function($r) {
    $r->post('order',          'Mt5::order');
    $r->post('close',          'Mt5::close');
    $r->post('close_all',      'Mt5::closeAll');
    $r->post('close_all_buy',  'Mt5::closeAllBuy');
    $r->post('close_all_sell', 'Mt5::closeAllSell');
    $r->get('positions',       'Mt5::positions');
    $r->get('account',         'Mt5::account');
    $r->get('margin',          'Mt5::margin');
    $r->get('history',         'Mt5::history');
    $r->get('order_status',    'Mt5::orderStatus');
    $r->get('queue',           'Mt5::queue');
    $r->get('prices_raw',      'Mt5::pricesRaw');
    $r->get('candles',         'Mt5::candles');
});

// จาก MT5 EA
$routes->group('api/mt5ea', function($r) {
    $r->get('pending',    'Mt5::eaPending');
    $r->post('ack',       'Mt5::eaAck');
    $r->post('positions', 'Mt5::eaPositions');

    $r->post('candles', 'Mt5::eaCandles');
});
// ********************** MT5 API **********************

// Admin area
$routes->group('admin', ['namespace' => 'App\Admin\Controllers', 'filter' => 'adminAuth'], static function($routes) {
    
    // $routes->match(['get', 'post'],'login', 'Auth::login');
    $routes->get('/',              'Index::index');
    $routes->get('devcode',        'Index::devcode');
    $routes->get('dashboard',      'Dashboard::index');
    $routes->get('users',          'Users::index');
    $routes->get('userimg',        'Users::getImg');
    

    $routes->post('checklogin',    'Auth::checklogin');
    $routes->get('register',       'Auth::register');
    $routes->get('login',          'Auth::login');
    $routes->get('logout',         'Auth::logout');

    $routes->get('framsv1',       'Funny::framsv1');
    $routes->get('mario',         'Funny::mario');
    $routes->get('snake',         'Funny::snake');

    // chart
    $routes->get('chartlist',           'Trading::index');
    $routes->get('chart/xauusd',        'Trading::xauusd');
    $routes->get('chart/xauusdclassic',     'Trading::xauusdclassic');
    $routes->get('chart/chartgoldthai',     'Trading::chartgoldthai');

    // connect mt5
    // $routes->get('mt5',         'Trading::connectmt5');
    $routes->get('mt5/order',      'Trading::mt5order');
    $routes->get('mt5/orderai',    'Trading::mt5orderai');
    $routes->get('mt5/goldai',     'Trading::mt5goldai');
    $routes->get('mt5/tenserflow', 'Trading::tenserflow');


    $routes->get('chart/swiss_gold_export',         'Trading::swissgoldexport');
    $routes->get('chart/swiss_gold_import',         'Trading::swissgoldimport');
    // $routes->get('chart/chartgoldthai',         'Trading::chartgoldthai');
    // $routes->get('chart/chartgoldthai',         'Trading::chartgoldthai');

    // Tools
    $routes->get('tools',               'Tools::index');
    $routes->get('tools/apitest',       'Tools::apitest');


    

    
});