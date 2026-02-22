<?php

namespace App\Controllers;

class Mysite extends BaseController
{
    public function index(): string
    {
        $request    = service('request'); // ดึง Request Service ของ CI4

        // add log_visitor_landing
        $postData = [
            'path' => '/mysite', // langing page
            'ip' => $request->getIPAddress(),
            'agent' => mb_convert_encoding($request->getUserAgent(), "UTF-8", "auto"),
            'url' => current_url(),
            'visited_at'=> date('Y-m-d H:i:s')
        ];
        $response = $this->curlRequest('logmysite/add', 'POST', $postData);
        $decode = json_decode($response, true);
        // add log_visitor_landing

        $get = $this->curlRequest('logmysite/countmysite', 'GET');
        $logmysite = json_decode($get, true);

        // print_r($logmysite['count']);die();
        $data = [
            'count_view' => $logmysite['count'] ?? 'wait...',
            'title'      => 'mySite',
            'favicon' => 'homemysite.ico'
        ];
        
        return view('App\Views\layout', [
            'title'   => $data['title'],
            'content' => view('App\Views\mysite', $data)
        ]);
    }

}
