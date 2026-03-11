<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Trading extends BaseController
{

    public function __construct()
    {
        // die("__construct::func() >>> first step before run public function.");

        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index()
    {

        $data = [
            'title'      => 'Admin',
            'favicon'      => 'favicon-default.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\chartlist', $data)
        ]);
    }

    public function mt5goldai()
    {

        $data = [
            'title'      => 'BIB Gold AI trading',
            'favicon'      => 'mt5gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\mt5goldai', $data)
        ]);
    }

    public function connectmt5()
    {

        $data = [
            'title'      => 'BIB mt5 connect...',
            'favicon'      => 'mt5gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\connectmt5', $data)
        ]);
    }

    public function mt5order()
    {

        $data = [
            'title'      => 'BIB mt5 connect...',
            'favicon'      => 'mt5gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\mt5order', $data)
        ]);
    }

    public function mt5orderai()
    {

        $data = [
            'title'      => 'BIB AI trading',
            'favicon'      => 'mt5gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\mt5orderai', $data)
        ]);
    }

    public function tenserflow()
    {

        $data = [
            'title'      => 'TensorFlow',
            'favicon'      => 'favicon.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\tenserflow', $data)
        ]);
    }

    public function xauusdclassic()
    {

        $data = [
            'title'      => 'Gold',
            'favicon'      => 'favicon-default.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\chartxauusdclassic', $data)
        ]);
    }

    public function xauusd()
    {

        $data = [
            'title'      => 'Gold',
            'favicon'      => 'favicon-default.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\chartxauusd', $data)
        ]);
    }

    public function chartgoldthai()
    {

        $data = [
            'title'      => 'Gold 96.5%',
            'favicon'      => 'gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\chartgoldthai', $data)
        ]);
    }

    public function swissgoldexport()
    {

        $data = [
            'title'      => 'SWISS Gold',
            'favicon'      => 'gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin',
            'users'      => [],
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\swissgoldexport', $data)
        ]);
    }

    public function swissgoldimport()
    {

        $data = [
            'title'      => 'Gold 96.5%',
            'favicon'      => 'gold.ico',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\swissgoldimport', $data)
        ]);
    }
}