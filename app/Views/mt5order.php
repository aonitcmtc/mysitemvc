<!-- <title>MT5 — Orders & History</title> -->
<meta name="base-url"        content="<?= base_url() ?>">
<meta name="csrf-token-name" content="csrf_token">
<meta name="csrf-token"      content="<?= csrf_hash() ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600&family=Cormorant+Garamond:wght@400;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root {
  --gold:       #C9A84C;
  --gold-light: #E8C96B;
  --gold-dim:   rgba(201,168,76,0.12);
  --black:      #090909;
  --dark:       #101010;
  --dark2:      #181818;
  --dark3:      #202020;
  --dark4:      #2a2a2a;
  --gray:       #555;
  --gray2:      #3a3a3a;
  --light:      #bbb;
  --white:      #f0ede8;
  --green:      #4caf7a;
  --green-dim:  rgba(76,175,122,0.15);
  --red:        #e05050;
  --red-dim:    rgba(224,80,80,0.15);
  --blue:       #5b8dee;
  --blue-dim:   rgba(91,141,238,0.15);
  --amber:      #f0a050;
  --amber-dim:  rgba(240,160,80,0.15);
  --btc:        #F7931A;
  --btc-dim:    rgba(247,147,26,0.12);
  --eth:        #627EEA;
  --eth-dim:    rgba(98,126,234,0.12);
  --r:          3px;
  --mono:       'JetBrains Mono', monospace;
  --serif:      'Cormorant Garamond', serif;
  --sans:       'Sarabun', sans-serif;
}

*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{font-size:14px}
body{background:var(--black);color:var(--white);font-family:var(--sans);min-height:100vh;overflow-x:hidden}
body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");pointer-events:none;z-index:9999}

/* ══ LAYOUT ══ */
.page{display:grid;grid-template-columns:400px 1fr;grid-template-rows:52px auto 1fr;min-height:100vh}

/* ══ TOPBAR ══ */
.topbar{grid-column:1/-1;display:flex;align-items:center;justify-content:space-between;padding:0 24px;border-bottom:1px solid rgba(201,168,76,0.15);background:rgba(9,9,9,0.96);backdrop-filter:blur(16px);position:sticky;top:0;z-index:100}
.brand{font-family:var(--serif);font-size:19px;font-weight:700;letter-spacing:4px;color:var(--gold);text-transform:uppercase;display:flex;align-items:baseline;gap:10px}
.brand-sub{font-family:var(--mono);font-size:8px;letter-spacing:2px;color:var(--gray);font-weight:300}
.live-dot{display:flex;align-items:center;gap:6px;font-family:var(--mono);font-size:8px;letter-spacing:2px;color:var(--gray)}
.live-dot::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--green);box-shadow:0 0 8px var(--green);animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.3}}

/* ══ SYMBOL TICKER BAR ══ */
.ticker-bar{
  grid-column:1/-1;
  display:flex;
  align-items:stretch;
  background:var(--dark2);
  border-bottom:1px solid rgba(255,255,255,0.05);
  overflow-x:auto;
}
.ticker-bar::-webkit-scrollbar{height:0}

.sym-tile{
  display:flex;
  flex-direction:column;
  justify-content:center;
  padding:10px 20px;
  cursor:pointer;
  border-right:1px solid rgba(255,255,255,0.04);
  border-bottom:2px solid transparent;
  transition:all 0.2s;
  min-width:140px;
  gap:3px;
  flex-shrink:0;
}
.sym-tile:hover{background:rgba(255,255,255,0.03)}
.sym-tile.active{border-bottom-color:var(--gold);background:var(--gold-dim)}
.sym-tile.active-btc{border-bottom-color:var(--btc);background:var(--btc-dim)}
.sym-tile.active-eth{border-bottom-color:var(--eth);background:var(--eth-dim)}

.st-row1{display:flex;align-items:center;justify-content:space-between;gap:8px}
.st-name{font-family:var(--mono);font-size:9px;letter-spacing:2px;color:var(--light);text-transform:uppercase}
.st-badge{font-family:var(--mono);font-size:7px;letter-spacing:1px;padding:1px 5px;border-radius:2px;text-transform:uppercase}
.st-badge.gold{background:var(--gold-dim);color:var(--gold)}
.st-badge.btc{background:var(--btc-dim);color:var(--btc)}
.st-badge.eth{background:var(--eth-dim);color:var(--eth)}
.st-badge.silver{background:rgba(180,180,180,0.1);color:#aaa}

.st-price{font-family:var(--mono);font-size:14px;font-weight:500;color:var(--white);letter-spacing:-0.3px}
.st-sub{display:flex;align-items:center;justify-content:space-between}
.st-chg{font-family:var(--mono);font-size:9px;padding:1px 5px;border-radius:2px}
.st-chg.up{background:var(--green-dim);color:var(--green)}
.st-chg.dn{background:var(--red-dim);color:var(--red)}
.st-spread{font-family:var(--mono);font-size:8px;color:var(--gray)}

/* ══ ORDER PANEL (left) ══ */
.order-panel{background:var(--dark);border-right:1px solid rgba(201,168,76,0.08);padding:20px 20px 28px;overflow-y:auto;display:flex;flex-direction:column;gap:16px}

.sec-label{font-family:var(--serif);font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--gold);display:flex;align-items:center;gap:10px}
.sec-label::after{content:'';flex:1;height:1px;background:linear-gradient(to right,rgba(201,168,76,0.4),transparent)}

/* selected symbol display */
.sym-display{
  background:var(--dark3);
  border:1px solid rgba(255,255,255,0.06);
  border-radius:var(--r);
  padding:10px 14px;
  display:flex;
  align-items:center;
  justify-content:space-between;
}
.sd-left{display:flex;flex-direction:column;gap:2px}
.sd-sym{font-family:var(--mono);font-size:13px;font-weight:600;color:var(--gold-light)}
.sd-desc{font-family:var(--mono);font-size:8px;color:var(--gray);letter-spacing:1px}
.sd-right{font-family:var(--mono);font-size:10px;color:var(--gray);text-align:right}
.sd-price{font-family:var(--mono);font-size:15px;color:var(--white);display:block}

/* dir tabs */
.dir-tabs{display:grid;grid-template-columns:1fr 1fr;gap:4px;background:var(--dark3);padding:3px;border-radius:var(--r)}
.dir-tab{padding:10px;text-align:center;cursor:pointer;font-family:var(--mono);font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--gray);border-radius:2px;border:none;background:transparent;transition:all 0.2s}
.dir-tab.buy.active{background:var(--green-dim);color:var(--green);border:1px solid rgba(76,175,122,0.4)}
.dir-tab.sell.active{background:var(--red-dim);color:var(--red);border:1px solid rgba(224,80,80,0.4)}
.dir-tab:not(.active):hover{color:var(--light)}

/* bid/ask */
.ba-row{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.ba-card{background:var(--dark2);border:1px solid rgba(255,255,255,0.05);border-radius:var(--r);padding:10px 14px;text-align:center}
.ba-lbl{font-family:var(--mono);font-size:8px;letter-spacing:3px;color:var(--gray);margin-bottom:4px}
.ba-val{font-family:var(--mono);font-size:17px;font-weight:500}
.ba-val.bid{color:var(--red)}
.ba-val.ask{color:var(--green)}
.spread-line{text-align:center;font-family:var(--mono);font-size:9px;color:var(--gray);letter-spacing:2px;margin-top:-6px}
.spread-line span{color:var(--gold)}

/* field */
.field{display:flex;flex-direction:column;gap:5px}
.field-label{font-family:var(--mono);font-size:8px;letter-spacing:2px;text-transform:uppercase;color:var(--gray)}
.field-input{width:100%;background:var(--dark3);border:1px solid rgba(255,255,255,0.1);color:var(--white);font-family:var(--mono);font-size:13px;padding:9px 12px;border-radius:var(--r);outline:none;transition:border-color 0.2s;-webkit-appearance:none}
.field-input:focus{border-color:var(--gold)}
.field-input::placeholder{color:var(--dark4)}
select.field-input{cursor:pointer}

/* lot row */
.lot-row{display:flex;align-items:center;gap:4px}
.lot-btn{width:36px;height:38px;background:var(--dark3);border:1px solid rgba(255,255,255,0.1);color:var(--gold);cursor:pointer;font-size:16px;border-radius:var(--r);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.15s}
.lot-btn:hover{background:var(--gold-dim);border-color:var(--gold)}
.quick-lots{display:grid;grid-template-columns:repeat(4,1fr);gap:4px;margin-top:4px}
.ql-btn{font-family:var(--mono);font-size:9px;padding:4px 0;background:var(--dark4);border:1px solid rgba(255,255,255,0.07);color:var(--gray);cursor:pointer;border-radius:2px;text-align:center;transition:all 0.15s}
.ql-btn:hover{background:var(--gold-dim);border-color:var(--gold);color:var(--gold)}

/* sl/tp toggle */
.sltp-row{display:flex;align-items:center;justify-content:space-between}
.sltp-label{font-family:var(--mono);font-size:9px;letter-spacing:2px;color:var(--gray);text-transform:uppercase}
.toggle{position:relative;width:38px;height:20px;cursor:pointer}
.toggle input{display:none}
.toggle-track{position:absolute;inset:0;background:var(--dark4);border-radius:10px;border:1px solid rgba(255,255,255,0.1);transition:all 0.2s}
.toggle-track::after{content:'';position:absolute;width:14px;height:14px;background:var(--gray2);border-radius:50%;top:2px;left:2px;transition:all 0.2s}
.toggle input:checked + .toggle-track{background:rgba(201,168,76,0.2);border-color:var(--gold)}
.toggle input:checked + .toggle-track::after{transform:translateX(18px);background:var(--gold)}

.divider{height:1px;background:rgba(255,255,255,0.05)}

/* submit */
.submit-btn{width:100%;padding:13px;font-family:var(--serif);font-size:16px;font-weight:600;letter-spacing:4px;text-transform:uppercase;cursor:pointer;border-radius:var(--r);border:none;transition:all 0.2s}
.submit-btn.buy{background:linear-gradient(135deg,#1e5c38,#4caf7a);color:#fff;box-shadow:0 4px 20px rgba(76,175,122,0.25)}
.submit-btn.sell{background:linear-gradient(135deg,#6e1818,#e05050);color:#fff;box-shadow:0 4px 20px rgba(224,80,80,0.25)}
.submit-btn:hover{transform:translateY(-1px);filter:brightness(1.1)}
.submit-btn:active{transform:none}
.submit-btn:disabled{opacity:0.5;cursor:not-allowed;transform:none}

/* margin box */
.margin-box{background:var(--dark2);border:1px solid rgba(255,255,255,0.05);border-radius:var(--r);padding:11px 14px;display:flex;flex-direction:column;gap:6px}
.margin-row{display:flex;justify-content:space-between;align-items:center}
.m-lbl{font-family:var(--mono);font-size:8px;letter-spacing:2px;color:var(--gray);text-transform:uppercase}
.m-val{font-family:var(--mono);font-size:11px;color:var(--light)}
.m-val.gold{color:var(--gold-light)}

/* ══ RIGHT PANEL ══ */
.right-panel{background:var(--dark);display:flex;flex-direction:column;overflow:hidden}

.tab-bar{display:flex;align-items:center;border-bottom:1px solid rgba(255,255,255,0.05);padding:0 20px;background:var(--dark2);flex-shrink:0}
.tab-item{font-family:var(--mono);font-size:8px;letter-spacing:2px;text-transform:uppercase;color:var(--gray);padding:14px 16px;cursor:pointer;border-bottom:2px solid transparent;transition:all 0.2s;white-space:nowrap;background:none;border-left:none;border-right:none;border-top:none}
.tab-item:hover{color:var(--light)}
.tab-item.active{color:var(--gold);border-bottom-color:var(--gold)}
.tab-actions{margin-left:auto;display:flex;align-items:center;gap:8px}
.day-select{font-family:var(--mono);font-size:8px;background:var(--dark3);border:1px solid rgba(255,255,255,0.1);color:var(--gray);padding:4px 8px;border-radius:2px;outline:none;cursor:pointer}
.day-select:focus{border-color:var(--gold);color:var(--gold)}
.refresh-btn{font-family:var(--mono);font-size:8px;letter-spacing:1px;background:transparent;border:1px solid rgba(255,255,255,0.1);color:var(--gray);padding:4px 12px;border-radius:2px;cursor:pointer;transition:all 0.15s}
.refresh-btn:hover{border-color:var(--gold);color:var(--gold)}

.tab-content{display:none;flex:1;overflow:hidden;flex-direction:column}
.tab-content.active{display:flex}

/* queue / positions table */
.tbl-wrap{flex:1;overflow-y:auto;padding:16px 20px}
.data-table{width:100%;border-collapse:collapse}
.data-table th{font-family:var(--mono);font-size:8px;letter-spacing:2px;text-transform:uppercase;color:var(--gray);padding:7px 10px;text-align:left;border-bottom:1px solid rgba(201,168,76,0.12);background:rgba(201,168,76,0.03);position:sticky;top:0;white-space:nowrap}
.data-table td{font-family:var(--mono);font-size:10px;color:var(--light);padding:8px 10px;border-bottom:1px solid rgba(255,255,255,0.03);white-space:nowrap}
.data-table tr:hover td{background:rgba(201,168,76,0.025)}

.tag{display:inline-block;font-size:7px;letter-spacing:1px;padding:2px 6px;border-radius:2px;text-transform:uppercase;font-weight:600}
.tag.buy      {background:var(--green-dim);color:var(--green)}
.tag.sell     {background:var(--red-dim);color:var(--red)}
.tag.pending  {background:var(--amber-dim);color:var(--amber)}
.tag.processing{background:var(--blue-dim);color:var(--blue)}
.tag.executed {background:var(--green-dim);color:var(--green)}
.tag.failed   {background:var(--red-dim);color:var(--red)}
.tag.close    {background:rgba(255,255,255,0.07);color:var(--light)}
.tag.market   {background:rgba(255,255,255,0.05);color:var(--gray)}
.tag.limit    {background:var(--blue-dim);color:var(--blue)}
.tag.stop     {background:var(--amber-dim);color:var(--amber)}

/* symbol color in table */
.sym-xau{color:var(--gold)!important}
.sym-btc{color:var(--btc)!important}
.sym-eth{color:var(--eth)!important}
.sym-xag{color:#aaa!important}

/* log viewer */
.log-wrap{flex:1;overflow:hidden;display:flex;flex-direction:column}
.log-toolbar{padding:10px 20px;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,0.04);flex-shrink:0;background:var(--dark2)}
.search-input{flex:1;background:var(--dark3);border:1px solid rgba(255,255,255,0.1);color:var(--white);font-family:var(--mono);font-size:11px;padding:6px 12px;border-radius:var(--r);outline:none;transition:border-color 0.2s}
.search-input:focus{border-color:var(--gold)}
.search-input::placeholder{color:var(--gray2)}
.filter-pills{display:flex;gap:4px;flex-wrap:wrap}
.pill{font-family:var(--mono);font-size:7px;letter-spacing:1px;padding:4px 9px;border-radius:20px;border:1px solid rgba(255,255,255,0.1);color:var(--gray);cursor:pointer;background:transparent;transition:all 0.15s;text-transform:uppercase}
.pill:hover{border-color:var(--gold);color:var(--gold)}
.pill.active{background:var(--gold-dim);border-color:var(--gold);color:var(--gold)}
.log-stats{font-family:var(--mono);font-size:8px;color:var(--gray);letter-spacing:1px;white-space:nowrap;flex-shrink:0}
.log-body{flex:1;overflow-y:auto}
.log-line{display:grid;grid-template-columns:60px 128px 150px 1fr;gap:0;padding:5px 20px;border-bottom:1px solid rgba(255,255,255,0.02);font-family:var(--mono);font-size:9px;line-height:1.5;transition:background 0.1s;cursor:default}
.log-line:hover{background:rgba(201,168,76,0.025)}
.ll-time{color:var(--gray)}
.ll-action{font-weight:500}
.ll-action.queued  {color:var(--amber)}
.ll-action.executed{color:var(--green)}
.ll-action.failed  {color:var(--red)}
.ll-action.close   {color:var(--blue)}
.ll-id{color:var(--gray);font-size:8px;overflow:hidden;text-overflow:ellipsis}
.ll-detail{color:var(--light);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.hl{background:rgba(201,168,76,0.25);color:var(--gold);border-radius:1px}

.empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;height:180px;gap:8px;color:var(--gray2);font-family:var(--mono);font-size:9px;letter-spacing:2px}
.loading-row td{text-align:center!important;color:var(--gray)!important;padding:28px!important;font-size:9px!important;letter-spacing:2px}

/* toast */
#toast{position:fixed;bottom:20px;right:20px;background:var(--dark2);border-radius:var(--r);padding:12px 16px;font-family:var(--mono);font-size:10px;color:var(--gold);z-index:9000;transform:translateY(70px);opacity:0;transition:all 0.3s cubic-bezier(0.16,1,0.3,1);box-shadow:0 8px 28px rgba(0,0,0,0.6);max-width:300px;border-left:2px solid var(--gold)}
#toast.show{transform:translateY(0);opacity:1}
#toast.success{border-left-color:var(--green);color:var(--green)}
#toast.error{border-left-color:var(--red);color:var(--red)}
#toast-title{font-size:7px;letter-spacing:2px;color:var(--gray);margin-bottom:3px;text-transform:uppercase}

::-webkit-scrollbar{width:3px;height:3px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:var(--dark4);border-radius:2px}

@keyframes fadeIn{from{opacity:0;transform:translateY(5px)}to{opacity:1;transform:translateY(0)}}
.fade-in{animation:fadeIn 0.25s ease both}
</style>

<div class="page">

<!-- ══ TOPBAR ══ -->
<header class="topbar">
  <div class="brand">
    BIBarahctap
    <span class="brand-sub">MT5 TRADING DESK</span>
  </div>
  <div style="display:flex;align-items:center;gap:16px">
    <span style="font-family:var(--mono);font-size:9px;color:var(--gray)" id="account-info">—</span>
    <span class="live-dot">LIVE</span>
  </div>
</header>

<!-- ══ SYMBOL TICKER BAR ══ -->
<div class="ticker-bar mt-2" id="ticker-bar">

  <div class="sym-tile active" data-sym="XAUUSD" data-active-class="active" onclick="pickSymbol(this)">
    <div class="st-row1">
      <span class="st-name">XAU/USD</span>
      <span class="st-badge gold">GOLD</span>
    </div>
    <span class="st-price" id="tp-XAUUSD">—</span>
    <div class="st-sub">
      <span class="st-chg" id="tc-XAUUSD">—</span>
      <span class="st-spread" id="ts-XAUUSD">spd —</span>
    </div>
  </div>

  <div class="sym-tile" data-sym="XAGUSD" data-active-class="active" onclick="pickSymbol(this)">
    <div class="st-row1">
      <span class="st-name">XAG/USD</span>
      <span class="st-badge silver">SILVER</span>
    </div>
    <span class="st-price" id="tp-XAGUSD">—</span>
    <div class="st-sub">
      <span class="st-chg" id="tc-XAGUSD">—</span>
      <span class="st-spread" id="ts-XAGUSD">spd —</span>
    </div>
  </div>

  <div class="sym-tile" data-sym="BTCUSD" data-active-class="active-btc" onclick="pickSymbol(this)">
    <div class="st-row1">
      <span class="st-name">BTC/USD</span>
      <span class="st-badge btc">CRYPTO</span>
    </div>
    <span class="st-price" id="tp-BTCUSD">—</span>
    <div class="st-sub">
      <span class="st-chg" id="tc-BTCUSD">—</span>
      <span class="st-spread" id="ts-BTCUSD">spd —</span>
    </div>
  </div>

  <div class="sym-tile" data-sym="ETHUSD" data-active-class="active-eth" onclick="pickSymbol(this)">
    <div class="st-row1">
      <span class="st-name">ETH/USD</span>
      <span class="st-badge eth">CRYPTO</span>
    </div>
    <span class="st-price" id="tp-ETHUSD">—</span>
    <div class="st-sub">
      <span class="st-chg" id="tc-ETHUSD">—</span>
      <span class="st-spread" id="ts-ETHUSD">spd —</span>
    </div>
  </div>

  <div class="sym-tile" data-sym="XAUEUR" data-active-class="active" onclick="pickSymbol(this)">
    <div class="st-row1">
      <span class="st-name">XAU/EUR</span>
      <span class="st-badge gold">GOLD</span>
    </div>
    <span class="st-price" id="tp-XAUEUR">—</span>
    <div class="st-sub">
      <span class="st-chg" id="tc-XAUEUR">—</span>
      <span class="st-spread" id="ts-XAUEUR">spd —</span>
    </div>
  </div>

</div>

<!-- ══ LEFT: ORDER FORM ══ -->
<aside class="order-panel">

  <div class="sec-label">New Order</div>

  <!-- Selected Symbol Display -->
  <div class="sym-display" id="sym-display">
    <div class="sd-left">
      <span class="sd-sym" id="sd-sym">XAUUSD</span>
      <span class="sd-desc" id="sd-desc">Gold vs US Dollar</span>
    </div>
    <div class="sd-right">
      <span style="font-size:8px;color:var(--gray)">MID</span>
      <span class="sd-price" id="sd-price">—</span>
    </div>
  </div>

  <!-- Direction -->
  <div class="dir-tabs">
    <button class="dir-tab buy active" id="tab-buy"  onclick="setDir('buy')">BUY</button>
    <button class="dir-tab sell"       id="tab-sell" onclick="setDir('sell')">SELL</button>
  </div>

  <!-- Bid / Ask -->
  <div class="ba-row">
    <div class="ba-card">
      <div class="ba-lbl">BID</div>
      <div class="ba-val bid" id="bid-val">—</div>
    </div>
    <div class="ba-card">
      <div class="ba-lbl">ASK</div>
      <div class="ba-val ask" id="ask-val">—</div>
    </div>
  </div>
  <div class="spread-line">SPREAD <span id="spread-val">—</span> pts</div>

  <!-- Order Type -->
  <div class="field">
    <span class="field-label">Order Type</span>
    <select class="field-input" id="f-type" onchange="togglePrice()">
      <option value="market">Market Order</option>
      <option value="limit">Limit Order</option>
      <option value="stop">Stop Order</option>
    </select>
  </div>

  <!-- Pending Price -->
  <div class="field" id="price-group" style="display:none">
    <span class="field-label">Price</span>
    <input type="number" class="field-input" id="f-price" placeholder="0.00" step="0.01">
  </div>

  <!-- Volume -->
  <div class="field">
    <span class="field-label">Volume (Lots)</span>
    <div class="lot-row">
      <button class="lot-btn" onclick="adjLot(-0.01)">−</button>
      <input type="number" class="field-input" id="f-volume" value="0.01" step="0.01" min="0.01" max="100" oninput="updateMargin()">
      <button class="lot-btn" onclick="adjLot(+0.01)">+</button>
    </div>
    <div class="quick-lots">
      <button class="ql-btn" onclick="setLot(0.01)">0.01</button>
      <button class="ql-btn" onclick="setLot(0.10)">0.10</button>
      <button class="ql-btn" onclick="setLot(0.50)">0.50</button>
      <button class="ql-btn" onclick="setLot(1.00)">1.00</button>
    </div>
  </div>

  <div class="divider"></div>

  <!-- SL -->
  <div class="sltp-row">
    <span class="sltp-label">Stop Loss</span>
    <label class="toggle"><input type="checkbox" id="sl-chk" onchange="toggleSL()"><span class="toggle-track"></span></label>
  </div>
  <div id="sl-group" style="display:none">
    <input type="number" class="field-input" id="f-sl" placeholder="SL Price" step="0.01" style="margin-top:6px">
  </div>

  <!-- TP -->
  <div class="sltp-row">
    <span class="sltp-label">Take Profit</span>
    <label class="toggle"><input type="checkbox" id="tp-chk" onchange="toggleTP()"><span class="toggle-track"></span></label>
  </div>
  <div id="tp-group" style="display:none">
    <input type="number" class="field-input" id="f-tp" placeholder="TP Price" step="0.01" style="margin-top:6px">
  </div>

  <div class="divider"></div>

  <!-- Submit -->
  <button class="submit-btn buy" id="submit-btn" onclick="placeOrder()">BUY XAUUSD</button>

  <!-- Margin Info -->
  <div class="margin-box">
    <div class="margin-row"><span class="m-lbl">Required Margin</span><span class="m-val gold" id="req-margin">—</span></div>
    <div class="margin-row"><span class="m-lbl">Pip Value</span>      <span class="m-val"      id="pip-val">—</span></div>
    <div class="margin-row"><span class="m-lbl">Free Margin</span>    <span class="m-val"      id="free-margin">—</span></div>
    <div class="margin-row"><span class="m-lbl">Margin Level</span>   <span class="m-val gold" id="margin-level">—</span></div>
  </div>

</aside>

<!-- ══ RIGHT: TABS ══ -->
<main class="right-panel">

  <div class="tab-bar">
    <button class="tab-item active" data-tab="queue">Order Queue</button>
    <button class="tab-item"        data-tab="log">History Log</button>
    <button class="tab-item"        data-tab="pos">Positions</button>
    <div class="tab-actions">
      <select class="day-select" id="day-select" onchange="loadLog()">
        <option value="1">Today</option>
        <option value="3">3 days</option>
        <option value="7" selected>7 days</option>
        <option value="14">14 days</option>
        <option value="30">30 days</option>
      </select>
      <button class="refresh-btn" onclick="refreshAll()">↺ REFRESH</button>
    </div>
  </div>

  <!-- Queue -->
  <div class="tab-content active" id="tab-queue">
    <div class="tbl-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Date / Time</th><th>Order ID</th><th>Symbol</th>
            <th>Dir</th><th>Type</th><th>Volume</th>
            <th>Price</th><th>SL</th><th>TP</th>
            <th>Status</th><th>Ticket</th><th>Error</th>
          </tr>
        </thead>
        <tbody id="queue-tbody"><tr class="loading-row"><td colspan="12">LOADING...</td></tr></tbody>
      </table>
    </div>
  </div>

  <!-- Log -->
  <div class="tab-content" id="tab-log">
    <div class="log-wrap">
      <div class="log-toolbar">
        <input type="text" class="search-input" id="log-search" placeholder="Search…" oninput="renderLog()">
        <div class="filter-pills">
          <button class="pill active" onclick="setFilter(this,'all')">ALL</button>
          <button class="pill" onclick="setFilter(this,'QUEUED')">QUEUED</button>
          <button class="pill" onclick="setFilter(this,'EXECUTED')">EXECUTED</button>
          <button class="pill" onclick="setFilter(this,'FAILED')">FAILED</button>
          <button class="pill" onclick="setFilter(this,'CLOSE')">CLOSE</button>
        </div>
        <span class="log-stats" id="log-stats">— lines</span>
      </div>
      <div class="log-body" id="log-body"></div>
    </div>
  </div>

  <!-- Positions -->
  <div class="tab-content" id="tab-pos">
    <div class="tbl-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Ticket</th><th>Symbol</th><th>Type</th><th>Volume</th>
            <th>Open</th><th>Current</th><th>P&amp;L</th>
            <th>SL</th><th>TP</th><th>Updated</th>
          </tr>
        </thead>
        <tbody id="pos-tbody"><tr class="loading-row"><td colspan="10">LOADING...</td></tr></tbody>
      </table>
    </div>
  </div>

</main>
</div>

<div id="toast"><div id="toast-title">NOTICE</div><div id="toast-msg">—</div></div>

<script src="<?=base_url();?>asset/mt5_api.js"></script>
<script>
// ══════════════════════════════════════════════════
//  CONFIG
// ══════════════════════════════════════════════════
const BASE_URL = window.location.origin;
const API      = BASE_URL + '/api/mt5';
const CSRF_NAME = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_token';
const CSRF_HASH = $('meta[name="csrf-token"]').attr('content') || '';

// ── Symbol master ──────────────────────────────────
const SYMBOLS = {
  XAUUSD: { desc:'Gold vs US Dollar',    contract:100,   leverage:500,  pip:0.01,  decimals:2 },
  XAGUSD: { desc:'Silver vs US Dollar',  contract:5000,  leverage:500,  pip:0.001, decimals:3 },
  XAUEUR: { desc:'Gold vs Euro',         contract:100,   leverage:500,  pip:0.01,  decimals:2 },
  BTCUSD: { desc:'Bitcoin vs US Dollar', contract:1,     leverage:100,  pip:1,     decimals:2 },
  ETHUSD: { desc:'Ethereum vs US Dollar',contract:1,     leverage:100,  pip:0.1,   decimals:2 },
};

// ── Previous prices for % change display ──────────
const prevPrices = {};

let curSym      = 'XAUUSD';
let curDir      = 'buy';
let curPrices   = {};
let activeFilter= 'all';
let allLogLines = [];

// ══════════════════════════════════════════════════
//  AJAX HELPER — removed, using $.ajax standalone
// ══════════════════════════════════════════════════

// ══════════════════════════════════════════════════
//  TOAST
// ══════════════════════════════════════════════════
function toast(title, msg, type='') {
  $('#toast-title').text(title); $('#toast-msg').text(msg);
  $('#toast').attr('class','show '+ type);
  clearTimeout(window._tt);
  window._tt = setTimeout(() => $('#toast').attr('class',''), 4000);
}

// ══════════════════════════════════════════════════
//  SYMBOL PICKER (ticker click)
// ══════════════════════════════════════════════════
function pickSymbol(el) {
  const sym = $(el).data('sym');
  curSym = sym;

  // update ticker active state
  $('.sym-tile').removeClass('active active-btc active-eth');
  const cls = $(el).data('active-class') || 'active';
  $(el).addClass(cls);

  // update sym display box
  const meta = SYMBOLS[sym] || {};
  $('#sd-sym').text(sym);
  $('#sd-desc').text(meta.desc || sym);

  // refresh bid/ask from cached prices
  refreshBidAsk();
  updateMargin();
  setDir(curDir); // update submit button label
}

function refreshBidAsk() {
  const p = curPrices[curSym];
  if (!p) { $('#bid-val,#ask-val,#spread-val,#sd-price').text('—'); return; }

  const meta    = SYMBOLS[curSym] || { pip:0.01, decimals:2 };
  const dec     = meta.decimals;
  const bid     = parseFloat(p.bid).toFixed(dec);
  const ask     = parseFloat(p.ask).toFixed(dec);
  const spread  = ((p.ask - p.bid) / meta.pip).toFixed(1);
  const mid     = ((parseFloat(p.bid) + parseFloat(p.ask)) / 2).toFixed(dec);

  $('#bid-val').text(bid);
  $('#ask-val').text(ask);
  $('#spread-val').text(spread);
  $('#sd-price').text(mid);
}

// ══════════════════════════════════════════════════
//  FETCH PRICES (poll prices.json)
// ══════════════════════════════════════════════════
function fetchPrices() {
  $.getJSON(API + '/prices_raw')
    .done(res => {
      curPrices = res;

      // Update each ticker tile
      Object.keys(SYMBOLS).forEach(sym => {
        const p = res[sym];
        if (!p) return;

        const meta  = SYMBOLS[sym];
        const dec   = meta.decimals;
        const bid   = parseFloat(p.bid);
        const ask   = parseFloat(p.ask);
        const mid   = ((bid + ask) / 2).toFixed(dec);
        const spd   = ((ask - bid) / meta.pip).toFixed(1);

        $(`#tp-${sym}`).text(mid);
        $(`#ts-${sym}`).text('spd ' + spd);

        // % change vs prev
        if (prevPrices[sym] !== undefined) {
          const prev = prevPrices[sym];
          const pct  = ((bid - prev) / prev * 100).toFixed(2);
          const $chg = $(`#tc-${sym}`);
          $chg.text((pct >= 0 ? '+' : '') + pct + '%')
              .attr('class', 'st-chg ' + (pct >= 0 ? 'up' : 'dn'));
        }
        prevPrices[sym] = bid;
      });

      refreshBidAsk();
      updateMargin();
    });

  // Account info
  $.ajax({
    url: API + '/account',
    method: 'GET',
    dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => {
    if (!res.success) return;
    const a = res.account;
    $('#free-margin').text(a.free_margin
      ? '$' + parseFloat(a.free_margin).toLocaleString('en-US',{minimumFractionDigits:2}) : '—');
    $('#margin-level').text(a.margin_level ? a.margin_level + '%' : '—');
    if (a.balance) {
      $('#account-info').text(
        'Balance: $' + parseFloat(a.balance).toLocaleString('en-US',{minimumFractionDigits:2})
        + '  Equity: $' + parseFloat(a.equity||0).toLocaleString('en-US',{minimumFractionDigits:2})
      );
    }
  });
}

// ══════════════════════════════════════════════════
//  MARGIN CALC (client-side)
// ══════════════════════════════════════════════════
function updateMargin() {
  const meta   = SYMBOLS[curSym] || { contract:100, leverage:500, pip:0.01 };
  const vol    = parseFloat($('#f-volume').val()) || 0.01;
  const p      = curPrices[curSym];
  const price  = p ? parseFloat(p.ask) : 2384;
  const margin = (price * vol * meta.contract) / meta.leverage;
  const pipVal = vol * meta.contract * meta.pip;

  $('#req-margin').text('$' + margin.toLocaleString('en-US',{minimumFractionDigits:2}));
  $('#pip-val').text('$' + pipVal.toFixed(2));
}

// ══════════════════════════════════════════════════
//  LOAD QUEUE
// ══════════════════════════════════════════════════
function loadQueue() {
  $.getJSON(API + '/queue').done(res => {
    const $tb = $('#queue-tbody').empty();
    const orders = (res.orders || []).slice().reverse();

    if (!orders.length) {
      $tb.html('<tr class="loading-row"><td colspan="12">NO ORDERS</td></tr>');
      return;
    }

    orders.forEach(o => {
      const symClass = symColorClass(o.symbol);
      const dt = (o.created_at || '').split(' ');
      $tb.append(`
        <tr class="fade-in">
          <td><span style="color:var(--light)">${dt[0]||'—'}</span><br>
              <span style="color:var(--gray);font-size:8px">${dt[1]||''}</span></td>
          <td style="color:var(--gray);font-size:8px;max-width:100px;overflow:hidden;text-overflow:ellipsis">${o.order_id}</td>
          <td class="${symClass}">${o.symbol}</td>
          <td><span class="tag ${o.direction}">${o.direction.toUpperCase()}</span></td>
          <td><span class="tag ${o.order_type}">${o.order_type}</span></td>
          <td>${parseFloat(o.volume).toFixed(2)}</td>
          <td>${o.price > 0 ? parseFloat(o.price).toFixed(2) : '<span style="color:var(--gray)">MKT</span>'}</td>
          <td>${o.sl > 0 ? parseFloat(o.sl).toFixed(2) : '<span style="color:var(--gray2)">—</span>'}</td>
          <td>${o.tp > 0 ? parseFloat(o.tp).toFixed(2) : '<span style="color:var(--gray2)">—</span>'}</td>
          <td><span class="tag ${o.status}">${o.status}</span></td>
          <td>${o.ticket ? '#'+o.ticket : '<span style="color:var(--gray2)">—</span>'}</td>
          <td style="color:var(--red);font-size:8px;max-width:100px;overflow:hidden;text-overflow:ellipsis">${o.error||''}</td>
        </tr>`);
    });
  }).fail(() => $('#queue-tbody').html('<tr class="loading-row"><td colspan="12">FAILED TO LOAD</td></tr>'));
}

// ══════════════════════════════════════════════════
//  LOAD + RENDER LOG
// ══════════════════════════════════════════════════
function loadLog() {
  const days = $('#day-select').val() || 7;
  $('#log-body').html('<div style="text-align:center;padding:36px;font-family:var(--mono);font-size:9px;color:var(--gray);letter-spacing:2px">LOADING...</div>');
  $.ajax({
    url: API + '/history?days=' + days,
    method: 'GET',
    dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => { allLogLines = res.history || []; renderLog(); })
    .fail(() => $('#log-body').html('<div class="empty-state">FAILED TO LOAD</div>'));
}

function renderLog() {
  const $body  = $('#log-body').empty();
  const search = $('#log-search').val().toLowerCase().trim();
  const filter = activeFilter;
  let   vis    = 0;

  allLogLines.forEach(raw => {
    const parts  = raw.split(' | ');
    const time   = (parts[0] || '').trim();
    const action = (parts[1] || '').trim();
    const id     = (parts[2] || '').trim();
    const detail = parts.slice(3).join(' | ');

    if (filter !== 'all' && !action.toUpperCase().includes(filter)) return;
    if (search && !raw.toLowerCase().includes(search)) return;

    vis++;
    const ac = action.includes('EXECUTED') ? 'executed'
             : action.includes('FAILED')   ? 'failed'
             : action.includes('CLOSE')    ? 'close'
             : 'queued';

    const hl = search
      ? s => s.replace(new RegExp(`(${search.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi'), '<span class="hl">$1</span>')
      : s => s;

    $body.append(`
      <div class="log-line fade-in">
        <span class="ll-time">${hl(time)}</span>
        <span class="ll-action ${ac}">${hl(action)}</span>
        <span class="ll-id">${hl(id)}</span>
        <span class="ll-detail">${hl(detail)}</span>
      </div>`);
  });

  if (!vis) $body.html('<div class="empty-state"><div style="font-size:24px;opacity:0.3">◈</div>NO ENTRIES</div>');
  $('#log-stats').text(`${vis} / ${allLogLines.length} lines`);
}

function setFilter(el, val) {
  activeFilter = val;
  $('.pill').removeClass('active');
  $(el).addClass('active');
  renderLog();
}

// ══════════════════════════════════════════════════
//  LOAD POSITIONS
// ══════════════════════════════════════════════════
function loadPositions() {
  $.ajax({
    url: API + '/positions',
    method: 'GET',
    dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => {
    const $tb = $('#pos-tbody').empty();
    const list = res.positions || [];

    if (!list.length) {
      $tb.html('<tr class="loading-row"><td colspan="10">NO OPEN POSITIONS</td></tr>');
      return;
    }

    list.forEach(p => {
      const pnl    = parseFloat(p.profit || 0);
      const pnlCol = pnl >= 0 ? 'var(--green)' : 'var(--red)';
      const pnlStr = (pnl >= 0 ? '+' : '') + '$' + Math.abs(pnl).toFixed(2);
      const sym    = p.symbol || '';
      const dec    = (SYMBOLS[sym] || {decimals:2}).decimals;

      $tb.append(`
        <tr class="fade-in">
          <td style="color:var(--gold)">#${p.ticket}</td>
          <td class="${symColorClass(sym)}">${sym}</td>
          <td><span class="tag ${p.type.toLowerCase()}">${p.type}</span></td>
          <td>${parseFloat(p.volume).toFixed(2)}</td>
          <td>${parseFloat(p.open_price).toFixed(dec)}</td>
          <td>${parseFloat(p.current).toFixed(dec)}</td>
          <td style="color:${pnlCol};font-weight:500">${pnlStr}</td>
          <td>${p.sl > 0 ? parseFloat(p.sl).toFixed(dec) : '—'}</td>
          <td>${p.tp > 0 ? parseFloat(p.tp).toFixed(dec) : '—'}</td>
          <td style="font-size:8px;color:var(--gray)">${(p.updated_at||'').split(' ')[1]||'—'}</td>
        </tr>`);
    });
  });
}

// ══════════════════════════════════════════════════
//  PLACE ORDER
// ══════════════════════════════════════════════════
function placeOrder() {
  const otype = $('#f-type').val();
  const vol   = parseFloat($('#f-volume').val());
  const price = otype !== 'market' ? parseFloat($('#f-price').val()) : 0;
  const sl    = $('#sl-chk').is(':checked') ? parseFloat($('#f-sl').val()) : 0;
  const tp    = $('#tp-chk').is(':checked') ? parseFloat($('#f-tp').val()) : 0;

  if (!vol || vol <= 0)                        { toast('VALIDATION','Volume must be > 0','error'); return; }
  if (otype !== 'market' && (!price || price <= 0)) { toast('VALIDATION','Price required','error'); return; }

  const $btn = $('#submit-btn').prop('disabled', true);
  const orig = $btn.text();
  $btn.text('SENDING...');

  $.ajax({
    url: API + '/order',
    method: 'POST',
    dataType: 'json',
    contentType: 'application/json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    data: JSON.stringify({ symbol:curSym, direction:curDir, volume:vol,
      order_type:otype, price:price, sl:sl, tp:tp, [CSRF_NAME]: CSRF_HASH })
  }).done(res => {
      if (res.success) {
        toast('ORDER QUEUED', '#' + res.order_id + ' · EA จะ execute ภายใน 2s', 'success');
        setTimeout(() => { loadQueue(); loadLog(); }, 2500);
      } else {
        toast('REJECTED', res.error || 'Error', 'error');
      }
    })
    .fail(xhr => toast('ERROR', (xhr.responseJSON && xhr.responseJSON.messages && xhr.responseJSON.messages.error) || xhr.statusText, 'error'))
    .always(() => { $btn.prop('disabled', false).text(orig); });
}

// ══════════════════════════════════════════════════
//  UI HELPERS
// ══════════════════════════════════════════════════
function setDir(dir) {
  curDir = dir;
  $('#tab-buy').toggleClass('active',  dir === 'buy');
  $('#tab-sell').toggleClass('active', dir === 'sell');
  $('#submit-btn').attr('class', `submit-btn ${dir}`).text(`${dir.toUpperCase()} ${curSym}`);
}

function togglePrice() {
  const show = $('#f-type').val() !== 'market';
  $('#price-group').toggle(show);
  if (show) {
    const p = curPrices[curSym];
    const dec = (SYMBOLS[curSym]||{decimals:2}).decimals;
    $('#f-price').val(p ? (curDir==='buy' ? p.ask : p.bid).toFixed(dec) : '');
  }
}

function toggleSL() {
  const show = $('#sl-chk').is(':checked');
  $('#sl-group').toggle(show);
  if (show) {
    const p   = curPrices[curSym];
    const dec = (SYMBOLS[curSym]||{decimals:2}).decimals;
    const ref = p ? (curDir==='buy' ? parseFloat(p.bid) : parseFloat(p.ask)) : 2384;
    const offset = curSym.includes('BTC') ? 500 : curSym.includes('ETH') ? 50 : 20;
    $('#f-sl').val((curDir==='buy' ? ref - offset : ref + offset).toFixed(dec));
  }
}

function toggleTP() {
  const show = $('#tp-chk').is(':checked');
  $('#tp-group').toggle(show);
  if (show) {
    const p   = curPrices[curSym];
    const dec = (SYMBOLS[curSym]||{decimals:2}).decimals;
    const ref = p ? (curDir==='buy' ? parseFloat(p.ask) : parseFloat(p.bid)) : 2384;
    const offset = curSym.includes('BTC') ? 1000 : curSym.includes('ETH') ? 100 : 30;
    $('#f-tp').val((curDir==='buy' ? ref + offset : ref - offset).toFixed(dec));
  }
}

function adjLot(d) {
  let v = Math.round((parseFloat($('#f-volume').val()) + d) * 100) / 100;
  if (v < 0.01) v = 0.01;
  if (v > 100)  v = 100;
  $('#f-volume').val(v.toFixed(2));
  updateMargin();
}

function setLot(v) { $('#f-volume').val(v.toFixed(2)); updateMargin(); }

function symColorClass(sym) {
  if (!sym) return '';
  if (sym.startsWith('BTC')) return 'sym-btc';
  if (sym.startsWith('ETH')) return 'sym-eth';
  if (sym.startsWith('XAG')) return 'sym-xag';
  return 'sym-xau';
}

// Tab switching
$('.tab-item').on('click', function() {
  const name = $(this).data('tab');
  $('.tab-item').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').removeClass('active');
  $(`#tab-${name}`).addClass('active');
  if (name === 'log')   loadLog();
  if (name === 'pos')   loadPositions();
  if (name === 'queue') loadQueue();
});

function refreshAll() {
  fetchPrices();
  loadQueue();
  loadPositions();
  const active = $('.tab-content.active').attr('id');
  if (active === 'tab-log') loadLog();
  toast('REFRESHED', 'Data updated', 'success');
}

// ══════════════════════════════════════════════════
//  INIT
// ══════════════════════════════════════════════════
$(document).ready(function() {
  setDir('buy');
  updateMargin();
  fetchPrices();
  loadQueue();

  setInterval(fetchPrices, 3000);
  setInterval(() => {
    const a = $('.tab-content.active').attr('id');
    if (a === 'tab-queue') loadQueue();
    if (a === 'tab-pos')   loadPositions();
  }, 5000);
});
</script>