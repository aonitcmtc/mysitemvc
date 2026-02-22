<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $request    = service('request'); // ดึง Request Service ของ CI4
        
        // add log_visitor_landing
        $postData = [
            'path' => '/', // langing page
            'ip' => $request->getIPAddress(),
            'agent' => mb_convert_encoding($request->getUserAgent(), "UTF-8", "auto"),
            'url' => current_url(),
            'visited_at'=> date('Y-m-d H:i:s')
        ];
        // print_r($postData);die();

        $response = $this->curlRequest('logmysite/add', 'POST', $postData);
        $decode = json_decode($response, true);
        // add log_visitor_landing

        $get = $this->curlRequest('logmysite/countlanding', 'GET');
        $logmysite = json_decode($get, true);

        // print_r($logmysite['count']);die();
        $data = [
            'count_view' => $logmysite['count'] ?? 'wait...',
        ];

        return view('index', $data);
    }

    public function powerby(): string
    {
        return view('welcome_message');
    }
}
