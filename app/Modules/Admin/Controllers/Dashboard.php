<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Dashboard extends BaseController
{
    public function index()
    {
        // Simple protection (you can also use Filter - recommended)
        if (!session()->get('access_token')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\dashboard', $data)
        ]);
    }
}