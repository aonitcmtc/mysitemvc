<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session      = session();
        $timeout      = 15 * 60; // 900 seconds
        $timenow      = time();
        $last_activity = $session->get('last_activity');
        $access_token  = $session->get('access_token');

        // ── ยังไม่ login เลย ────────────────────────────────────
        // access_token ที่ถูก set หลัง login สำเร็จคือ "session-active"
        // (ไม่ใช่ "session-login" ซึ่ง Auth controller ใช้เป็น placeholder)
        if (empty($access_token) || $access_token === 'session-login') {
            return redirect()->to('/admin/login');
        }

        // ── Session timeout ─────────────────────────────────────
        if (!empty($last_activity) && ($timenow - $last_activity) > $timeout) {
            $session->destroy();
            return redirect()
                ->to('/admin/login')
                ->with('error', 'Session หมดอายุ (15 นาที) กรุณา login ใหม่');
        }

        // ── ผ่าน — อัปเดต last_activity ──────────────────────────
        $session->set('last_activity', $timenow);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}