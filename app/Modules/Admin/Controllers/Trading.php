<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Trading extends BaseController
{
    public function index()
    {
        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }

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

    public function xauusdclassic()
    {
        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }

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
        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }

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
        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }

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
}