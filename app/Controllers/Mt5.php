<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * MT5Controller  — File-based (ไม่ใช้ DB / Model เลย)
 * =====================================================
 * ทุกอย่างเก็บใน writable/mt5/ เป็น JSON + log files
 *
 *  writable/mt5/
 *  ├── queue.json        — pending/executed orders (FIFO queue)
 *  ├── positions.json    — open positions (EA push มาเขียนทับ)
 *  ├── account.json      — account info  (EA push)
 *  ├── prices.json       — latest bid/ask ทุก symbol (EA push)
 *  └── logs/
 *      └── YYYY-MM-DD.log  — plain text log ต่อวัน
 *
 * Routes (app/Config/Routes.php):
 *   // จาก Browser
 *   $routes->group('api/mt5', function($r) {
 *       $r->post('order',        'Mt5::order');
 *       $r->post('close',        'Mt5::close');
 *       $r->get('positions',     'Mt5::positions');
 *       $r->get('account',       'Mt5::account');
 *       $r->get('margin',        'Mt5::margin');
 *       $r->get('history',       'Mt5::history');
 *       $r->get('order_status',  'Mt5::orderStatus');
 *       $r->get('queue',         'Mt5::queue');
 *       $r->get('prices_raw',    'Mt5::pricesRaw');
 *   });
 *   // จาก MT5 EA
 *   $routes->group('api/mt5ea', function($r) {
 *       $r->get('pending',    'Mt5::eaPending');
 *       $r->post('ack',       'Mt5::eaAck');
 *       $r->post('positions', 'Mt5::eaPositions');
 *   });
 */
class Mt5 extends ResourceController
{
    protected $format = 'json';

    private string $eaSecret = 'YOUR_EA_SECRET_HERE'; // ต้องตรงกับ EA input

    // ── File paths ──────────────────────────────────────────────
    private string $dir;
    private string $queueFile;
    private string $positionsFile;
    private string $accountFile;
    private string $pricesFile;
    private string $logsDir;
    private string $candlesFile;


    public function __construct()
    {
        $this->dir           = WRITEPATH . 'mt5/';
        $this->queueFile     = $this->dir . 'queue.json';
        $this->positionsFile = $this->dir . 'positions.json';
        $this->accountFile   = $this->dir . 'account.json';
        $this->pricesFile    = $this->dir . 'prices.json';
        $this->candlesFile   = $this->dir . 'candles.json';
        $this->logsDir       = $this->dir . 'logs/';

        $this->eaSecret       = env('MT5_EA_SECRET');

        // สร้าง directory อัตโนมัติ
        if (!is_dir($this->dir))     mkdir($this->dir,     0755, true);
        if (!is_dir($this->logsDir)) mkdir($this->logsDir, 0755, true);
    }


    // ════════════════════════════════════════════════════════════
    //  ── BROWSER ENDPOINTS ──
    // ════════════════════════════════════════════════════════════

    /**
     * POST /api/mt5/order
     * รับคำสั่งจาก HTML → validate → เพิ่มลง queue.json
     */
    public function order(): ResponseInterface
    {
        // ── AJAX-only guard ──────────────────────────────────────
        if (!$this->request->isAJAX()) {
            return $this->fail('AJAX requests only', 403);
        }

        // รองรับทั้ง form-encoded และ JSON body
        $isJson = str_contains($this->request->getHeaderLine('Content-Type'), 'application/json');
        $data   = $isJson
            ? ($this->request->getJSON(true) ?? [])
            : $this->request->getPost();

        if (empty($data)) {
            return $this->fail('Empty request body', 400);
        }

        // ── Validation ──────────────────────────────────────────
        $rules = [
            'symbol'     => 'required|in_list[XAUUSD,GOLD,XAGUSD,XAUEUR,BTCUSD,ETHUSD]',
            'direction'  => 'required|in_list[buy,sell]',
            'volume'     => 'required|decimal|greater_than[0]|less_than_equal_to[100]',
            'order_type' => 'required|in_list[market,limit,stop]',
        ];
        if (!$this->validate($rules, $data)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $symbol    = strtoupper($data['symbol']);
        $direction = strtolower($data['direction']);
        $volume    = (float)$data['volume'];
        $orderType = $data['order_type'];
        $price     = (float)($data['price'] ?? 0);
        $sl        = (float)($data['sl'] ?? 0);
        $tp        = (float)($data['tp'] ?? 0);

        // ── Margin Check ─────────────────────────────────────────
        $marginCheck = $this->checkMargin($symbol, $volume);
        if (!$marginCheck['ok']) {
            return $this->fail($marginCheck['error'], 422);
        }

        // ── สร้าง Order record ───────────────────────────────────
        $orderId = uniqid('ORD_', true);
        $order   = [
            'order_id'   => $orderId,
            'symbol'     => $symbol,
            'direction'  => $direction,
            'volume'     => $volume,
            'order_type' => $orderType,
            'price'      => $price,
            'sl'         => $sl,
            'tp'         => $tp,
            'status'     => 'pending',   // pending → processing → executed/failed
            'ticket'     => null,
            'error'      => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];

        // ── เพิ่มลง queue.json ───────────────────────────────────
        $queue   = $this->readJson($this->queueFile, []);
        $queue[] = $order;
        $this->writeJson($this->queueFile, $queue);

        // ── Log บรรทัดเดียว ──────────────────────────────────────
        $this->writeLog('ORDER_QUEUED', $orderId,
            "{$direction} {$volume} {$symbol} type:{$orderType} sl:{$sl} tp:{$tp} ip:" . $this->request->getIPAddress()
        );

        return $this->respondCreated([
            'success'  => true,
            'order_id' => $orderId,
            'message'  => 'Order queued — EA will execute within 2 seconds',
            'margin'   => $marginCheck,
        ]);
    }


    /**
     * POST /api/mt5/close
     * Body: { ticket: "12345678" }
     * หา position จาก positions.json แล้ว queue คำสั่ง close
     */
    public function close(): ResponseInterface
    {
        $isJson = str_contains($this->request->getHeaderLine('Content-Type'), 'application/json');
        $ticket = $isJson
            ? (string)($this->request->getJSON()->ticket ?? '')
            : (string)($this->request->getPost('ticket') ?? '');

        if (!$ticket) {
            return $this->failValidationErrors(['ticket' => 'required']);
        }

        // หา position จาก positions.json
        $positions = $this->readJson($this->positionsFile, []);
        $pos       = null;
        foreach ($positions as $p) {
            if ((string)($p['ticket'] ?? '') === $ticket) {
                $pos = $p;
                break;
            }
        }

        if (!$pos) {
            return $this->failNotFound("Position #{$ticket} not found");
        }

        // Queue close order (direction กลับด้าน)
        $orderId = uniqid('CLS_', true);
        $order   = [
            'order_id'   => $orderId,
            'symbol'     => $pos['symbol'],
            'direction'  => strtolower($pos['type']) === 'buy' ? 'sell' : 'buy',
            'volume'     => $pos['volume'],
            'order_type' => 'close',
            'price'      => 0,
            'sl'         => 0,
            'tp'         => 0,
            'ticket_ref' => $ticket,   // ticket ของ position ที่ต้องการปิด
            'status'     => 'pending',
            'ticket'     => null,
            'error'      => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];

        $queue   = $this->readJson($this->queueFile, []);
        $queue[] = $order;
        $this->writeJson($this->queueFile, $queue);

        $this->writeLog('CLOSE_QUEUED', $orderId,
            "CLOSE ticket_ref:{$ticket} {$pos['symbol']} vol:{$pos['volume']}"
        );

        return $this->respond([
            'success'  => true,
            'order_id' => $orderId,
            'message'  => 'Close order queued',
        ]);
    }


    /**
     * POST /api/mt5/close_all      — ปิดทุก position
     */
    public function closeAll(): ResponseInterface
    {
        return $this->queueBulkClose('close_all', 'CLOSE_ALL');
    }

    /**
     * POST /api/mt5/close_all_buy  — ปิด BUY ทั้งหมด
     */
    public function closeAllBuy(): ResponseInterface
    {
        return $this->queueBulkClose('close_all_buy', 'CLOSE_ALL_BUY');
    }

    /**
     * POST /api/mt5/close_all_sell — ปิด SELL ทั้งหมด
     */
    public function closeAllSell(): ResponseInterface
    {
        return $this->queueBulkClose('close_all_sell', 'CLOSE_ALL_SELL');
    }

    private function queueBulkClose(string $orderType, string $logAction): ResponseInterface
    {
        $orderId = uniqid('BCL_', true);
        $order   = [
            'order_id'   => $orderId,
            'symbol'     => 'GOLD',
            'direction'  => 'sell',
            'volume'     => 0,
            'order_type' => $orderType,
            'price'      => 0,
            'sl'         => 0,
            'tp'         => 0,
            'ticket_ref' => null,
            'status'     => 'pending',
            'ticket'     => null,
            'error'      => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];
        $queue   = $this->readJson($this->queueFile, []);
        $queue[] = $order;
        $this->writeJson($this->queueFile, $queue);
        $this->writeLog($logAction, $orderId, 'ip:' . $this->request->getIPAddress());
        return $this->respond([
            'success'  => true,
            'order_id' => $orderId,
            'message'  => $orderType . ' queued — EA will execute within 2s',
        ]);
    }


    /**
     * GET /api/mt5/positions
     * อ่าน positions.json (EA push มาเขียนทับทุก 10s)
     */
    public function positions(): ResponseInterface
    {
        $positions = $this->readJson($this->positionsFile, []);
        return $this->respond([
            'success'   => true,
            'positions' => $positions,
            'count'     => count($positions),
        ]);
    }


    /**
     * GET /api/mt5/account
     * อ่าน account.json (EA push)
     */
    public function account(): ResponseInterface
    {
        $account = $this->readJson($this->accountFile, [
            'balance'      => 0,
            'equity'       => 0,
            'margin'       => 0,
            'free_margin'  => 0,
            'margin_level' => 0,
            'profit'       => 0,
        ]);
        return $this->respond(['success' => true, 'account' => $account]);
    }


    // ── EA push candles ──────────────────────────
    public function eaCandles(): ResponseInterface
    {
        $this->checkEASecret();
        $data = $this->request->getJSON(true);
        if (!isset($data['candles'])) {
            return $this->fail('No candles data');
        }
        $this->writeJson($this->candlesFile, $data);
        $this->writeLog('CANDLES_UPDATED', $data['symbol'],
            'tf:' . $data['timeframe'] . ' count:' . count($data['candles']));
        return $this->respond(['success' => true]);
    }

    // ── Browser GET candles ───────────────────────
    public function candles(): ResponseInterface
    {
        $data = $this->readJson($this->candlesFile, null);
        if (!$data) {
            return $this->respond(['success' => false, 'candles' => []]);
        }
        // EA v2.0 บันทึก symbol="XAUUSD" เสมอ — normalize ให้ตรงกับ broker
        $sym = $data['symbol'] ?? 'XAUUSD';
        return $this->respond([
            'success'   => true,
            'candles'   => $data['candles'],
            'symbol'    => $sym,
            'timeframe' => $data['timeframe'] ?? 'M15',
        ]);
    }


    /**
     * GET /api/mt5/margin?symbol=XAUUSD&volume=0.10
     * คำนวณ Required Margin + Pip Value จาก prices.json
     */
    public function margin(): ResponseInterface
    {
        $symbol = $this->request->getGet('symbol') ?? 'XAUUSD';
        $volume = (float)($this->request->getGet('volume') ?? 0.01);
        $result = $this->checkMargin($symbol, $volume);
        return $this->respond(['success' => true] + $result);
    }


    /**
     * GET /api/mt5/history?days=7
     * อ่าน log files ย้อนหลัง N วัน แล้วส่งกลับเป็น array of strings
     */
    public function history(): ResponseInterface
    {
        $days  = min((int)($this->request->getGet('days') ?? 7), 30);
        $lines = [];

        for ($i = 0; $i < $days; $i++) {
            $date    = date('Y-m-d', strtotime("-{$i} days"));
            $logFile = $this->logsDir . "{$date}.log";
            if (!file_exists($logFile)) continue;

            $raw = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach (array_reverse($raw) as $line) {
                $lines[] = $line;
            }
        }

        return $this->respond([
            'success' => true,
            'history' => $lines,
            'count'   => count($lines),
        ]);
    }


    /**
     * GET /api/mt5/queue
     * ส่ง queue.json ทั้งหมดกลับ (สำหรับแสดงตาราง)
     */
    public function queue(): ResponseInterface
    {
        $queue = $this->readJson($this->queueFile, []);
        return $this->respond([
            'success' => true,
            'orders'  => $queue,
            'count'   => count($queue),
        ]);
    }


    /**
     * GET /api/mt5/prices_raw
     * ส่ง prices.json + GOLD↔XAUUSD alias อัตโนมัติ
     */
    public function pricesRaw(): ResponseInterface
    {
        $prices = $this->readJson($this->pricesFile, []);
        if (is_array($prices)) {
            // EA ส่ง XAUUSD → เพิ่ม GOLD alias
            if (isset($prices['XAUUSD']) && !isset($prices['GOLD'])) {
                $prices['GOLD'] = $prices['XAUUSD'];
            }
            // EA ส่ง GOLD → เพิ่ม XAUUSD alias
            if (isset($prices['GOLD']) && !isset($prices['XAUUSD'])) {
                $prices['XAUUSD'] = $prices['GOLD'];
            }
        }
        return $this->respond($prices);
    }


    /**
     * GET /api/mt5/order_status?id=ORD_xxx
     * jQuery poll สถานะ order หลัง place
     */
    public function orderStatus(): ResponseInterface
    {
        $orderId = $this->request->getGet('id') ?? '';
        if (!$orderId) {
            return $this->fail('id required');
        }

        $queue = $this->readJson($this->queueFile, []);
        foreach ($queue as $order) {
            if ($order['order_id'] === $orderId) {
                return $this->respond([
                    'success' => true,
                    'status'  => $order['status'],
                    'ticket'  => $order['ticket'],
                    'error'   => $order['error'],
                ]);
            }
        }

        return $this->failNotFound("Order {$orderId} not found");
    }


    // ════════════════════════════════════════════════════════════
    //  ── EA ENDPOINTS (เรียกจาก MT5 EA เท่านั้น) ──
    // ════════════════════════════════════════════════════════════

    /**
     * GET /api/mt5ea/pending
     * EA ดึง 1 order ที่ status=pending (FIFO) แล้วเปลี่ยนเป็น processing
     */
    public function eaPending(): ResponseInterface
    {
        $this->checkEASecret();

        $queue = $this->readJson($this->queueFile, []);
        $found = null;

        foreach ($queue as &$order) {
            if ($order['status'] === 'pending') {
                $order['status'] = 'processing'; // lock ป้องกัน EA หยิบซ้ำ
                $found           = $order;
                break;
            }
        }
        unset($order);

        $this->writeJson($this->queueFile, $queue);

        if (!$found) {
            return $this->respond(['success' => true, 'orders' => [], 'count' => 0]);
        }

        return $this->respond([
            'success' => true,
            'orders'  => [$found],
            'count'   => 1,
        ]);
    }


    /**
     * POST /api/mt5ea/ack
     * EA ส่งผลการ execute กลับมา
     * Body: { order_id, success, ticket, error }
     */
    public function eaAck(): ResponseInterface
    {
        $this->checkEASecret();
        $data = $this->request->getJSON(true);

        $orderId = $data['order_id'] ?? '';
        $success = (bool)($data['success'] ?? false);
        $ticket  = $data['ticket'] ?? null;
        $error   = $data['error'] ?? '';

        if (!$orderId) {
            return $this->fail('order_id required');
        }

        // อัปเดตสถานะใน queue.json
        $queue = $this->readJson($this->queueFile, []);
        foreach ($queue as &$order) {
            if ($order['order_id'] === $orderId) {
                $order['status']     = $success ? 'executed' : 'failed';
                $order['ticket']     = $ticket;
                $order['error']      = $error ?: null;
                $order['updated_at'] = date('Y-m-d H:i:s');
                break;
            }
        }
        unset($order);

        // Trim: เก็บแค่ 500 records ล่าสุดใน queue.json
        if (count($queue) > 500) {
            $queue = array_slice($queue, -500);
        }
        $this->writeJson($this->queueFile, $queue);

        // Log
        $detail = $success ? "ticket:{$ticket}" : "error:{$error}";
        $this->writeLog($success ? 'ORDER_EXECUTED' : 'ORDER_FAILED', $orderId, $detail);

        return $this->respond(['success' => true]);
    }


    /**
     * POST /api/mt5ea/positions
     * EA push ข้อมูลล่าสุดทั้งหมดกลับมา CI4
     * Body: {
     *   positions: [...],
     *   account:   { balance, equity, margin, free_margin, margin_level, profit },
     *   prices:    { XAUUSD: { bid, ask }, ... }
     * }
     */
    public function eaPositions(): ResponseInterface
    {
        $this->checkEASecret();
        $data = $this->request->getJSON(true);

        // เขียนทับไฟล์แต่ละอัน (EA ส่งมาครบก็เขียนครบ)
        if (isset($data['positions'])) {
            $this->writeJson($this->positionsFile, $data['positions']);
        }
        if (isset($data['account'])) {
            $this->writeJson($this->accountFile, $data['account']);
        }
        if (isset($data['prices'])) {
            $this->writeJson($this->pricesFile, $data['prices']);
        }

        return $this->respond(['success' => true, 'received' => date('H:i:s')]);
    }


    // ════════════════════════════════════════════════════════════
    //  ── PRIVATE HELPERS ──
    // ════════════════════════════════════════════════════════════

    /** อ่าน JSON file → array/value, คืน $default ถ้าไม่มีไฟล์ */
    private function readJson(string $file, mixed $default = []): mixed
    {
        if (!file_exists($file)) return $default;
        $raw = file_get_contents($file);
        return json_decode($raw, true) ?? $default;
    }

    /**
     * เขียน array/value → JSON file
     * ใช้ atomic write (เขียน .tmp แล้ว rename) ป้องกัน race condition
     */
    private function writeJson(string $file, mixed $data): void
    {
        $tmp = $file . '.tmp';
        file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        rename($tmp, $file);
    }

    /**
     * เขียน log 1 บรรทัด → writable/mt5/logs/YYYY-MM-DD.log
     * รูปแบบ: HH:MM:SS | ACTION | order_id | detail
     */
    private function writeLog(string $action, string $orderId, string $detail): void
    {
        $file = $this->logsDir . date('Y-m-d') . '.log';
        $line = sprintf("%s | %-18s | %-24s | %s\n",
            date('H:i:s'), $action, $orderId, $detail
        );
        file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }

    /** ตรวจ X-EA-Secret header จาก EA */
    private function checkEASecret(): void
    {
        if ($this->request->getHeaderLine('X-EA-Secret') !== $this->eaSecret) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }
    }

    /** คำนวณ Required Margin + Pip Value */
    private function calculateMargin(string $symbol, float $volume, float $price): array
    {
        $contractSize = match ($symbol) {
            'XAUUSD', 'GOLD' => 100,
            'XAGUSD' => 5000,
            'BTCUSD' => 1,
            'ETHUSD' => 1,
            default  => 100,
        };
        $leverage = match ($symbol) {
            'BTCUSD' => 100,
            'ETHUSD' => 100,
            default  => 500,
        };

        return [
            'required_margin' => round(($price * $volume * $contractSize) / $leverage, 2),
            'pip_value'       => round($volume * $contractSize * 0.01, 2),
            'contract_size'   => $contractSize,
            'leverage'        => "1:{$leverage}",
            'ok'              => true,
        ];
    }

    /** ตรวจ Free Margin จาก account.json + prices.json */
    private function checkMargin(string $symbol, float $volume): array
    {
        $account = $this->readJson($this->accountFile, null);
        $prices  = $this->readJson($this->pricesFile, []);

        // EA v2.0 ส่งราคาใน key มาตรฐาน XAUUSD เสมอ แม้ broker ใช้ชื่อ GOLD
        $priceKey = ($symbol === 'GOLD') ? 'XAUUSD' : $symbol;
        $price    = (float)($prices[$priceKey]['ask'] ?? $prices[$symbol]['ask'] ?? 2384.0);
        $calc    = $this->calculateMargin($symbol, $volume, $price);

        // ถ้ายังไม่มีข้อมูล account → ผ่านพร้อม warning
        if ($account === null) {
            return array_merge($calc, ['ok' => true, 'warning' => 'Account data not yet available']);
        }

        $free = (float)($account['free_margin'] ?? 0);
        if ($calc['required_margin'] > $free) {
            return [
                'ok'    => false,
                'error' => "Insufficient margin. Required: \${$calc['required_margin']}, Free: \${$free}",
            ];
        }

        return $calc;
    }
}