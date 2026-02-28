<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController

class Users extends BaseController
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
        $getUserActive = $this->curlRequestAuth('users/getusers', 'GET');
        $userActive = json_decode($getUserActive, true);

        $data = [
            'users'      => $userActive,
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];
        // print_r($data); die();

        // $urlImg = $this->getImage();
        // die($urlImg);

        return view('App\Admin\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Admin\Views\users', $data)
        ]);
    }

    public function getImg($img_default = 'user_not_image.png')
    {
        // $img = 'user_not_image.png';
        // $json = $this->request->getGet('img');
        // $img  = $json->img ?? 'null22';
        $img = $this->request->getGet('img') ?? $img_default;

        $urlImg = $this->getImage($img);
        // die($urlImg);

        return json_encode($urlImg);
    }
}