<?php

namespace App\Admin\Controllers;

use App\Controllers\BaseController;   // ← or your own Admin\BaseController-

class Auth extends BaseController
{
    public function index()
    {
       // index
    }

    public function register()
    {
        // Simple protection (you can also use Filter - recommended)
        $data = [
            'title'      => 'Admin',
            'admin_name' => session()->get('admin_name') ?? 'Admin'
        ];

        return view('App\Admin\Views\register', [
            'title'   => $data['title'],
            'content' => ''
        ]);
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
        // $session->destroy(); //not active route login
        $session->set('access_token', "session-login");
        $session->set('refresh_token', "token");
        $session->set('last_activity', time());
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

        $email = $post['email'];
        $password = $post['password'];

        // echo $email.'</br>';
        // echo $password.'</br>';

        $url_api = "https://conn.myexpress-api.click/api/auth/login";

        $data = [
            "email" => $email,
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

            // echo "<pre>";
            // print_r($response); 
            // echo "</pre>";
            // die();

            $result = json_decode($response, true);
            // print_r($result); die();

            $accessToken = $result['accessToken'] ?? null;
            $refreshToken = $result['refreshToken'] ?? null;
            $timestamp = time();

            // user_data
            $member_id = $result['user_data']['id'] ?? null;
            $email = $result['user_data']['email'] ?? null;
            $name = $result['user_data']['name'] ?? null;
            $img_profile = $result['user_data']['profile'] ?? null;
            $sex = $result['user_data']['sex'] ?? null;
            $membergroup = $result['user_data']['membergroup'] ?? null;
            $status = $result['user_data']['status'] ?? null;

            // echo "accessToken >>> ".$accessToken;
            // echo "<br/>refreshToken >>> ".$refreshToken;
            // echo "<br/>member_id >>> ".$member_id;
            // echo "<br/>email >>> ".$email;
            // echo "<br/>name >>> ".$name;
            // echo "<br/>img_profile >>> ".$img_profile;
            // echo "<br/>sex >>> ".$sex;
            // echo "<br/>membergroup >>> ".$membergroup;
            // echo "<br/>status >>> ".$status;
            // die();

            $session = session();
            $session->set('access_token', $accessToken);
            $session->set('refresh_token', $refreshToken);
            $session->set('last_activity', $timestamp);

            $session->set('member_id', $member_id);
            $session->set('member_email', $email);
            $session->set('member_name', $name);
            $session->set('member_img', $img_profile);
            $session->set('member_sex', $sex);
            $session->set('member_group', $membergroup);
            $session->set('member_status', $status);
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