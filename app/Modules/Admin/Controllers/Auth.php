<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController-

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
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\login', [
            'title'   => $data['title'],
            'content' => ''
        ]);
    }

    public function logout()
    {

        $session = session();
        $session->set('access_token');
        $session->set('refresh_token');
        return redirect()->to('/admin/login');

        // $data = [
        //     'title'      => 'Admin',
        //     'admin_name' => session()->get('admin_name') ?? 'Admin'
        // ];

        // return view('App\Admin\Views\logout', [
        //     'title'   => $data['title'],
        //     'content' => ''
        // ]);
    }

    public function checklogin()
    {
        $request = service('request'); // Get the request instance, if not already available via $this->request
        $post = $request->getPost();

        // print_r($post);
        // die("</br> isf >> Auth:Admin");

        $username = $post['username'];
        $password = $post['password'];

        // echo $username.'</br>';
        // echo $password.'</br>';

        $url_api = "https://conn.myexpress-api.click/api/auth/login";

        $data = [
            "email" => $username,
            "password" => $password
        ];

        try {
            $ch = curl_init($url_api);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            // echo $response;

            $result = json_decode($response, true);
            // print_r($result);

            $accessToken = $result['accessToken'] ?? null;
            $refreshToken = $result['refreshToken'] ?? null;

            // echo "accessToken >>> ".$accessToken;
            // echo "<br/>refreshToken >>> ".$refreshToken;

            $session = session();
            $session->set('access_token', $accessToken);
            $session->set('refresh_token', $refreshToken);

            // echo $session->get('access_token');
            // echo "<br/>";
            // echo $session->get('refresh_token');

            // print_r($session->get('admin')); die();
            
            // if login success
            if (!$session->get('access_token')) {
                return redirect()->to('/admin/login');
            }

            $data = [
                'title'      => 'Admin',
                'admin_name' => $session->get('admin_name') ?? 'Admin'
            ];

            return redirect()->to('/admin/');

            // return view('App\Admin\Views\layout', [
            //     'title'   => $data['title'],
            //     'content' => view('App\Admin\Views\dashboard', $data)
            // ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); // Output: Error: Cannot divide by zero
        }
        
    }
}