<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected $helpers = [];

    protected function curlRequest($url, $method = 'GET', $data = [], $headers = [])
    {
        $session = session();
        
        $access_token = $session->get('access_token');
        if (empty($access_token) || $access_token == 'session-login') {
            $this->getTokenAPI();
            $access_token = $session->get('access_token');
            // die($access_token);
        }

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://conn.myexpress-api.click/api/'.$url); // prod
        // curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/api/'.$url); //dev 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ".$access_token,
        ];

        // ตั้งค่า Method
        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif (in_array(strtoupper($method), ['PUT','DELETE'])) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        // Default Header สำหรับ JSON
        // if (empty($headers)) {
        //     $headers = [
        //         "Content-Type: application/json",
        //     ];
        // }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return ['error' => $error_msg];
        }
        curl_close($ch);
        $decode = json_decode($response, true);

        $message = $decode['message'] ?? '';
        if($message == 'Invalid token') {
            $this->getTokenAPI();
            $access_token = $session->get('access_token');
        } 
        return $response;
    }

    protected function getTokenAPI()
    {
        try {
            $url = 'https://conn.myexpress-api.click/api/auth/gettoken'; // prod
            // $url = 'http://localhost:3000/api/auth/gettoken'; // dev
            $ch = curl_init();

            $api_token = env('API_TOKEN_PUBLIC');
            // die($api_token);

            $body = [ 'apikey' => $api_token];
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            $headers = [
                "Content-Type: application/json",
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response, true);
            // print_r($response); die('res');
            $access_token = $data['accessToken'] ?? 'session-login';
            $refresh_token = $data['refreshToken'] ?? 'session-login';

            // if($access_token == 'session-login'){
            //     echo 'Error :: access_token is not define!!! Plese your check api or database connecting.......';
            //     die();
            // }
            
            $session = session();
            $session->set('access_token', $access_token);
            $session->set('refresh_token', $refresh_token);
            // print_r($data);
            // die('data');
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); // Output: Error: Cannot divide by zero
        }
    }

}


