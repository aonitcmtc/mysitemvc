<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Login extends BaseController
{
    public function index()
    {
        // Simple protection (you can also use Filter - recommended)
        $data = [
            'title'      => 'see you agin.',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\login', [
            'title'   => $data['title'],
            'content' => ''
        ]);
    }
}