<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Google extends BaseController
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    private string $url_google_accounts;
    private string $url_google_token;
    private string $url_google_userinfo;

    public function __construct()
    {
        $this->clientId     = env('GOOGLE_CLIENT_ID');
        $this->clientSecret = env('GOOGLE_CLIENT_SECRET');
        $this->redirectUri  = rtrim(base_url('auth/google/callback'), '/');

        $this->url_google_accounts = env('GOOGLE_ACCOUNTS');
        $this->url_google_token = env('GOOGLE_TOKEN');
        $this->url_google_userinfo = env('GOOGLE_USERINFO');
    }

    // ─────────────────────────────────────────────
    // STEP 1 : สร้าง URL แล้ว redirect ไป Google
    // ─────────────────────────────────────────────
    public function redirect()
    {
        log_message('error', '========== GOOGLE REDIRECT START ==========');

        // สร้าง state แบบ random เพื่อป้องกัน CSRF
        $state = bin2hex(random_bytes(16));
        session()->set('oauth_state', $state);

        $params = http_build_query([
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
            'access_type'   => 'online',
            // ไม่ส่ง code_challenge → ไม่ใช้ PKCE เลย
        ]);

        $authUrl = $this->url_google_accounts . $params;

        log_message('error', '→ Redirecting to: ' . $authUrl);
        log_message('error', '========== GOOGLE REDIRECT COMPLETE ==========');

        return redirect()->to($authUrl);
    }

    // ─────────────────────────────────────────────
    // STEP 2 : รับ code จาก Google แล้วแลก token
    // ─────────────────────────────────────────────
    public function callback()
    {
        try {
            log_message('error', '========== GOOGLE CALLBACK START ==========');
            log_message('error', 'GET params: ' . json_encode($_GET));

            // ── ตรวจ error จาก Google ──
            if (!empty($_GET['error'])) {
                throw new \Exception('Google error: ' . $_GET['error']);
            }

            // ── ตรวจ state ป้องกัน CSRF ──
            $savedState    = session()->get('oauth_state');
            $returnedState = $_GET['state'] ?? '';

            if (empty($savedState) || $savedState !== $returnedState) {
                throw new \Exception('State mismatch. savedState=' . $savedState . ' returnedState=' . $returnedState);
            }

            session()->remove('oauth_state');
            log_message('error', '✓ State verified');

            // ── ตรวจ code ──
            if (empty($_GET['code'])) {
                throw new \Exception('No authorization code received');
            }

            $code = $_GET['code'];
            log_message('error', '✓ Code received: ' . substr($code, 0, 20) . '...');

            // ── แลก code → access token ──
            $tokenData = $this->exchangeCodeForToken($code);
            log_message('error', '✓ Token received');

            // ── ดึง user info ──
            $userInfo = $this->fetchUserInfo($tokenData['access_token']);
            log_message('error', '✓ User info: ' . json_encode($userInfo));

            if (empty($userInfo['email'])) {
                throw new \Exception('No email in user info. Response: ' . json_encode($userInfo));
            }

            // ── บันทึก session ──
            $userData = [
                'google_id'  => $userInfo['id']      ?? $userInfo['sub'] ?? null,
                'email'      => $userInfo['email']    ?? null,
                'name'       => $userInfo['name']     ?? null,
                'avatar'     => $userInfo['picture']  ?? null,
                'login_type' => 'google',
                'login_at'   => date('Y-m-d H:i:s'),
            ];

            session()->set('user', $userData);

            log_message('info',  '✓✓✓ SUCCESS: ' . $userData['email']);
            log_message('error', '========== GOOGLE CALLBACK SUCCESS ==========');

            // return redirect()->to('/mysite')->with('status', 'Welcome ' . ($userData['name'] ?? 'User') . '!');
            return redirect()->to('/note')->with('status', 'Welcome ' . ($userData['name'] ?? 'User') . '!');

        } catch (\Exception $e) {
            log_message('error', '✗ CALLBACK ERROR: ' . $e->getMessage());
            log_message('error', '========== GOOGLE CALLBACK FAILED ==========');

            return redirect()->to('mysite#login')->with('error', 'Google auth failed: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    // STEP 3 : Logout — ล้าง session แล้ว redirect
    // ─────────────────────────────────────────────
    public function logout()
    {
        log_message('error', '========== GOOGLE LOGOUT START ==========');

        $userName = session()->get('user.name') ?? 'User';

        // ล้าง session ทั้งหมด
        session()->destroy();

        log_message('info',  '✓ Session destroyed for: ' . $userName);
        log_message('error', '========== GOOGLE LOGOUT COMPLETE ==========');

        return redirect()->to(base_url('mysite'))->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }

    // ─────────────────────────────────────────────
    // PRIVATE : แลก authorization code → token
    // ─────────────────────────────────────────────
    private function exchangeCodeForToken(string $code): array
    {
        $params = [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
            // ไม่ส่ง code_verifier → ไม่ใช้ PKCE
        ];

        $ch = curl_init($this->url_google_token);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('error', "Token endpoint HTTP: $httpCode | cURL error: $curlError");
        log_message('error', "Token response: $response");

        if ($curlError) {
            throw new \Exception('cURL error on token exchange: ' . $curlError);
        }

        $data = json_decode($response, true);

        if ($httpCode !== 200 || empty($data['access_token'])) {
            throw new \Exception('Token exchange failed (' . $httpCode . '): ' . ($data['error_description'] ?? $data['error'] ?? $response));
        }

        return $data;
    }

    // ─────────────────────────────────────────────
    // PRIVATE : ดึง user info จาก access token
    // ─────────────────────────────────────────────
    private function fetchUserInfo(string $accessToken): array
    {
        $ch = curl_init($this->url_google_userinfo);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $accessToken],
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('error', "UserInfo endpoint HTTP: $httpCode | cURL error: $curlError");

        if ($curlError) {
            throw new \Exception('cURL error on userinfo: ' . $curlError);
        }

        if ($httpCode !== 200) {
            throw new \Exception('UserInfo failed (' . $httpCode . '): ' . $response);
        }

        return json_decode($response, true) ?? [];
    }
}
