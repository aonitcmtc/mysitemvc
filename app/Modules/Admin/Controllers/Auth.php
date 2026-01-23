<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Auth extends BaseController
{
    public function index()
    {
       // index
    }

    public function login()
    {
        // Simple protection (you can also use Filter - recommended)
        $data = [
            'title'      => 'แดชบอร์ดผู้ดูแลระบบ',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\login', [
            'title'   => $data['title'],
            'content' => ''
        ]);
    }

    public function logout()
    {
        // Simple protection (you can also use Filter - recommended)
        $data = [
            'title'      => 'แดชบอร์ดผู้ดูแลระบบ',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\logout', [
            'title'   => $data['title'],
            'content' => ''
        ]);
    }

    public function checklogin()
    {
        $request = service('request'); // Get the request instance, if not already available via $this->request
        $post = $request->getPost();
        // print_r($post);

        $username = $post['username'];
        $password = $post['password'];

        // echo $username.'</br>';
        // echo $password.'</br>';

        // if login success
        if (! session()->get('admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title'      => 'แดชบอร์ดผู้ดูแลระบบ',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\dashboard', $data)
        ]);
    }
}