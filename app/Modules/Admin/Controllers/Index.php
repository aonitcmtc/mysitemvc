<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Index extends BaseController
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
        // check session member
        // die(session()->get('member_img'));

        $data = [
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\index', $data)
        ]);
    }

    public function devcode()
    {
        $data = [
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\devcode', $data)
        ]);
    }
}