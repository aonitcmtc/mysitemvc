<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Inactivity timeout: 15 minutes = 900 seconds
        $timeout = 15 * 60;

        $timenow = time();
        $last_activity = $session->get('last_activity');
        $access_token = $session->get('access_token');
        $refresh_token = $session->get('refresh_token');
        $caltimeout = $timenow-$last_activity;

        // echo "timenow >> ".$timenow;
        // echo "<br/>last_activity >> ".$last_activity;
        // echo "<br/>access_token >> ".$access_token;
        // echo "<br/>refresh_token >> ".$refresh_token;
        // echo "<br/>cal >> ".$caltimeout;
        // die();

        $router = service('router');
        $controllerName = $router->controllerName();
        // die($controllerName);
        
        if($controllerName == "\App\Admin\Controllers\Auth") {
            $session = session();
            $session->set('access_token', "session-login");
            $session->set('refresh_token', "token");
            $session->set('last_activity', time());
        } else {
            if($session->get('access_token') == "session-login") {
                return redirect()->to('/admin/login');
            }
        }

        if ($caltimeout > $timeout) {
            $session = session();
            $session->set('access_token', "session-login");
            $session->set('refresh_token', "token");
            $session->set('last_activity', time());
            return redirect()
                ->to('/admin/login')
                ->with('error', 'Session timeout due to inactivity (15 minutes). Please login again.');
        }

        // Option A – most common & recommended
        if (!$session->get('access_token') || !$session->get('refresh_token')) {
            return redirect()->to('/admin/login');
        }

        // Option B – more explicit (recommended if access_token can be empty string)
        if (!$session->has('access_token') || empty($session->get('access_token'))) {
            return redirect()->to('/admin/login');
        }

        // Option C – if you also store admin ID or role
        // if (!$session->has('admin_id') || !$session->get('is_admin')) {
        //     return redirect()->to('/admin/login');
        // }

        // Optional: you can also update last activity here (for timeout)
        $session->set('last_activity', time());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed usually
    }
}