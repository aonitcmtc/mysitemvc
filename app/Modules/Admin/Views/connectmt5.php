<!-- <title>BIBarahctap — MT5 Gold Trading</title> -->
<style>
  :root {
    --gold: #C9A84C;
    --gold-light: #E8C96B;
    --gold-dark: #8B6914;
    --gold-pale: #F5E6B8;
    --black: #0A0A0A;
    --dark: #111111;
    --dark2: #1A1A1A;
    --dark3: #242424;
    --dark4: #2E2E2E;
    --gray: #888888;
    --light: #CCCCCC;
    --white: #F5F5F0;
    --green: #4CAF7A;
    --red: #E05050;
    --green-dim: #4caf7a26;
    --red-dim: #e0505026;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: var(--black);
    color: var(--white);
    font-family: 'Sarabun', sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 1000;
  }

  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 32px;
    border-bottom: 1px solid #c9a84c33;
    background: #0a0a0af2;
    backdrop-filter: blur(20px);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  #footer { border-top: 1px solid #c9a84c33; background: #2f2b2bf2; }

  .logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 6px;
    color: var(--gold);
    text-transform: uppercase;
  }
  .logo span {
    color: var(--white);
    opacity: 0.4;
    font-weight: 300;
    font-size: 12px;
    letter-spacing: 3px;
    display: block;
    font-family: 'JetBrains Mono', monospace;
    margin-top: -2px;
  }

  .header-status { display: flex; align-items: center; gap: 24px; }

  .status-dot {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-family: 'JetBrains Mono', monospace;
    color: var(--gray);
    letter-spacing: 1px;
  }
  .status-dot::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 8px var(--green);
    animation: pulse 2s infinite;
  }

  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

  .account-info { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--gray); text-align: right; }
  .account-info strong { color: var(--gold); font-size: 13px; display: block; }

  .app {
    display: grid;
    grid-template-columns: 1fr 380px;
    min-height: calc(100vh - 73px);
  }

  .price-bar {
    grid-column: 1 / -1;
    background: var(--dark2);
    border-bottom: 1px solid #c9a84c26;
    padding: 12px 32px;
    display: flex;
    align-items: center;
    gap: 40px;
    overflow-x: auto;
  }

  .price-symbol { display: flex; align-items: baseline; gap: 10px; white-space: nowrap; }
  .price-name { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--gray); letter-spacing: 2px; }
  .price-value { font-family: 'JetBrains Mono', monospace; font-size: 22px; font-weight: 500; color: var(--gold-light); letter-spacing: -0.5px; transition: color 0.3s; }
  .price-change { font-family: 'JetBrains Mono', monospace; font-size: 11px; padding: 2px 6px; border-radius: 3px; }
  .price-change.up { background: var(--green-dim); color: var(--green); }
  .price-change.down { background: var(--red-dim); color: var(--red); }
  .price-divider { width: 1px; height: 30px; background: #ffffff14; }

  .chart-area { padding: 24px 32px; background: var(--dark); border-right: 1px solid #c9a84c1f; }

  .section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 13px;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .section-title::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, #c9a84c4d, transparent); }

  /* ── CHART TOOLBAR ── */
  .chart-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    gap: 12px;
    flex-wrap: wrap;
  }

  .chart-timeframes { display: flex; gap: 4px; }

  .tf-btn {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
    padding: 5px 12px;
    background: transparent;
    border: 1px solid #ffffff1a;
    color: var(--gray);
    cursor: pointer;
    border-radius: 2px;
    letter-spacing: 1px;
    transition: all 0.2s;
  }
  .tf-btn:hover, .tf-btn.active { background: #c9a84c1a; border-color: var(--gold); color: var(--gold); }

  /* Chart type toggle */
  .chart-type-toggle {
    display: flex;
    gap: 4px;
    background: var(--dark3);
    padding: 3px;
    border-radius: 3px;
  }

  .ct-btn {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    padding: 5px 12px;
    background: transparent;
    border: none;
    color: var(--gray);
    cursor: pointer;
    border-radius: 2px;
    letter-spacing: 1px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .ct-btn.active {
    background: rgba(201,168,76,0.15);
    color: var(--gold);
    border: 1px solid rgba(201,168,76,0.3);
  }
  .ct-btn svg { flex-shrink: 0; }

  /* ── CHART CONTAINER ── */
  .chart-container {
    background: var(--dark2);
    border: 1px solid #c9a84c1a;
    border-radius: 4px;
    height: 280px;
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
  }

  #main-chart {
    width: 100%;
    height: 100%;
    display: block;
  }

  /* Crosshair tooltip */
  .chart-tooltip {
    position: absolute;
    top: 10px;
    right: 12px;
    background: rgba(26,26,26,0.92);
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 3px;
    padding: 8px 12px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    color: var(--light);
    pointer-events: none;
    display: none;
    line-height: 1.8;
  }
  .chart-tooltip .tt-o { color: var(--gold); }
  .chart-tooltip .tt-h { color: var(--green); }
  .chart-tooltip .tt-l { color: var(--red); }
  .chart-tooltip .tt-c { color: var(--gold-light); }

  /* Crosshair lines */
  .crosshair-x, .crosshair-y {
    position: absolute;
    pointer-events: none;
    display: none;
  }
  .crosshair-x { width: 100%; height: 1px; background: rgba(201,168,76,0.2); left: 0; }
  .crosshair-y { height: 100%; width: 1px; background: rgba(201,168,76,0.2); top: 0; }

  /* price label on right axis */
  .price-label-right {
    position: absolute;
    right: 0;
    font-family: 'JetBrains Mono', monospace;
    font-size: 9px;
    background: var(--gold);
    color: var(--black);
    padding: 2px 5px;
    border-radius: 2px 0 0 2px;
    pointer-events: none;
    display: none;
    transform: translateY(-50%);
  }

  .symbol-selector { display: flex; gap: 8px; margin-bottom: 16px; }
  .sym-btn {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
    padding: 7px 14px;
    background: var(--dark3);
    border: 1px solid #ffffff14;
    color: var(--gray);
    cursor: pointer;
    border-radius: 2px;
    letter-spacing: 1px;
    transition: all 0.2s;
  }
  .sym-btn.active { background: #c9a84c1f; border-color: var(--gold); color: var(--gold-light); }

  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
  .stat-card {
    background: var(--dark2);
    border: 1px solid #ffffff0f;
    border-radius: 4px;
    padding: 14px;
    transition: border-color 0.2s;
    animation: fadeUp 0.5s ease backwards;
  }
  .stat-card:nth-child(1){animation-delay:0.1s}
  .stat-card:nth-child(2){animation-delay:0.15s}
  .stat-card:nth-child(3){animation-delay:0.2s}
  .stat-card:nth-child(4){animation-delay:0.25s}
  .stat-card:hover { border-color: #c9a84c4d; }
  .stat-label { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 6px; }
  .stat-value { font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 500; color: var(--white); }
  .stat-value.gold { color: var(--gold-light); }
  .stat-value.green { color: var(--green); }
  .stat-value.red { color: var(--red); }

  .positions-table { background: var(--dark2); border: 1px solid #ffffff0f; border-radius: 4px; overflow: hidden; }
  .table-header { display: grid; grid-template-columns: 80px 70px 90px 100px 100px 90px 1fr; padding: 10px 16px; background: #c9a84c0f; border-bottom: 1px solid #c9a84c26; }
  .th { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
  .table-row { display: grid; grid-template-columns: 80px 70px 90px 100px 100px 90px 1fr; padding: 12px 16px; border-bottom: 1px solid #ffffff0a; align-items: center; transition: background 0.2s; }
  .table-row:hover { background: rgba(201,168,76,0.04); }
  .td { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--light); }
  .td.symbol { color: var(--gold); font-weight: 500; }
  .td.buy { color: var(--green); }
  .td.sell { color: var(--red); }
  .td.profit-pos { color: var(--green); }
  .td.profit-neg { color: var(--red); }
  .close-btn { font-family: 'JetBrains Mono', monospace; font-size: 10px; padding: 4px 8px; background: #e050501a; border: 1px solid #e050504d; color: var(--red); cursor: pointer; border-radius: 2px; letter-spacing: 1px; transition: all 0.2s; width: fit-content; }
  .close-btn:hover { background: #e0505040; }

  .order-panel { background: var(--dark2); padding: 24px; overflow-y: auto; }
  .order-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; margin-bottom: 24px; background: var(--dark3); padding: 4px; border-radius: 4px; }
  .order-tab { padding: 10px; text-align: center; cursor: pointer; font-family: 'JetBrains Mono', monospace; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: var(--gray); border-radius: 2px; transition: all 0.2s; border: none; background: transparent; }
  .order-tab.buy.active { background: #4caf7a33; color: var(--green); border: 1px solid #4caf7a66; }
  .order-tab.sell.active { background: #e0505033; color: var(--red); border: 1px solid #e0505066; }
  .order-tab:not(.active):hover { color: var(--light); }

  .bid-ask { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 20px; }
  .ba-card { background: var(--dark3); border-radius: 4px; padding: 14px; text-align: center; border: 1px solid rgba(255,255,255,0.06); }
  .ba-label { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--gray); margin-bottom: 6px; }
  .ba-price { font-family: 'JetBrains Mono', monospace; font-size: 20px; font-weight: 500; }
  .ba-price.bid { color: var(--red); }
  .ba-price.ask { color: var(--green); }
  .spread-display { text-align: center; margin-bottom: 20px; font-family: 'JetBrains Mono', monospace; font-size: 10px; color: var(--gray); letter-spacing: 2px; }
  .spread-display span { color: var(--gold); }

  .form-group { margin-bottom: 16px; }
  .form-label { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 6px; display: block; }
  .form-input { width: 100%; background: var(--dark3); border: 1px solid #ffffff1a; color: var(--white); font-family: 'JetBrains Mono', monospace; font-size: 14px; padding: 12px 14px; border-radius: 3px; outline: none; transition: border-color 0.2s; }
  .form-input:focus { border-color: var(--gold); }
  .form-input::placeholder { color: var(--dark4); }
  .form-select { appearance: none; cursor: pointer; }

  .input-with-controls { display: flex; align-items: center; gap: 4px; }
  .qty-btn { width: 40px; height: 44px; background: var(--dark3); border: 1px solid #ffffff1a; color: var(--gold); cursor: pointer; font-size: 18px; border-radius: 3px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
  .qty-btn:hover { background: #c9a84c26; border-color: var(--gold); }

  .sltp-toggle { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .toggle-label { font-family: 'JetBrains Mono', monospace; font-size: 10px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
  .toggle-switch { position: relative; width: 40px; height: 22px; cursor: pointer; }
  .toggle-switch input { display: none; }
  .toggle-track { position: absolute; inset: 0; background: var(--dark4); border-radius: 11px; border: 1px solid #ffffff1a; transition: all 0.2s; }
  .toggle-track::after { content: ''; position: absolute; width: 16px; height: 16px; background: var(--gray); border-radius: 50%; top: 2px; left: 2px; transition: all 0.2s; }
  .toggle-switch input:checked + .toggle-track { background: #c9a84c33; border-color: var(--gold); }
  .toggle-switch input:checked + .toggle-track::after { transform: translateX(18px); background: var(--gold); }

  .order-submit { width: 100%; padding: 16px; font-family: 'Cormorant Garamond', serif; font-size: 18px; font-weight: 600; letter-spacing: 4px; text-transform: uppercase; cursor: pointer; border-radius: 3px; border: none; transition: all 0.25s; margin-bottom: 20px; }
  .order-submit.buy { background: linear-gradient(135deg, #2d7a52, #4CAF7A); color: #fff; box-shadow: 0 4px 20px #4caf7a40; }
  .order-submit.sell { background: linear-gradient(135deg, #8B2020, #E05050); color: #fff; box-shadow: 0 4px 20px #e0505040; }
  .order-submit:hover { transform: translateY(-1px); filter: brightness(1.1); }
  .order-submit:active { transform: translateY(0); }

  .margin-info { background: var(--dark3); border: 1px solid #ffffff0f; border-radius: 4px; padding: 14px; }
  .margin-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
  .margin-row:last-child { margin-bottom: 0; }
  .margin-label { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
  .margin-value { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--light); }
  .margin-value.gold { color: var(--gold-light); }

  .divider { height: 1px; background: #ffffff0f; margin: 20px 0; }

  .quick-lots { display: grid; grid-template-columns: repeat(4,1fr); gap: 4px; margin-top: 6px; }
  .quick-lot-btn { font-family: 'JetBrains Mono', monospace; font-size: 10px; padding: 5px; background: var(--dark4); border: 1px solid #ffffff14; color: var(--gray); cursor: pointer; border-radius: 2px; text-align: center; transition: all 0.15s; }
  .quick-lot-btn:hover { background: #c9a84c1a; border-color: var(--gold); color: var(--gold); }

  .notification { position: fixed; top: 90px; right: 24px; background: var(--dark2); border: 1px solid var(--gold); border-radius: 4px; padding: 14px 20px; font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--gold); z-index: 999; transform: translateX(120%); transition: transform 0.3s cubic-bezier(0.16,1,0.3,1); box-shadow: 0 8px 32px #00000080; max-width: 300px; }
  .notification.show { transform: translateX(0); }
  .notification-title { font-size: 10px; letter-spacing: 2px; color: var(--gray); margin-bottom: 4px; text-transform: uppercase; }

  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  @keyframes flash-green { 0%{color:var(--gold-light)} 50%{color:var(--green)} 100%{color:var(--gold-light)} }
  @keyframes flash-red   { 0%{color:var(--gold-light)} 50%{color:var(--red)}   100%{color:var(--gold-light)} }
  .flash-up   { animation: flash-green 0.5s; }
  .flash-down { animation: flash-red   0.5s; }

  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: var(--dark); }
  ::-webkit-scrollbar-thumb { background: var(--dark4); border-radius: 2px; }
</style>

<!-- HEADER -->
<header>
  <div class="logo">
    BIBarahctap connect MT5
    <span>MT5 GOLD TRADING DESK</span>
  </div>
  <div class="header-status">
    <div class="status-dot">MT5 CONNECTED</div>
    <div class="account-info">
      <strong>#8821047</strong>
      XAU/USD · ICMarkets
    </div>
  </div>
</header>

<!-- PRICE BAR -->
<div class="price-bar">
  <div class="price-symbol">
    <span class="price-name">XAUUSD</span>
    <span class="price-value" id="xauusd-price">2,384.45</span>
    <span class="price-change up" id="xauusd-chg">+0.42%</span>
  </div>
  <div class="price-divider"></div>
  <div class="price-symbol">
    <span class="price-name">XAGUSD</span>
    <span class="price-value">28.341</span>
    <span class="price-change up">+0.18%</span>
  </div>
  <div class="price-divider"></div>
  <div class="price-symbol">
    <span class="price-name">USDTHB</span>
    <span class="price-value">36.421</span>
    <span class="price-change down">-0.05%</span>
  </div>
  <div class="price-divider"></div>
  <div class="price-symbol">
    <span class="price-name">DXY</span>
    <span class="price-value">104.21</span>
    <span class="price-change down">-0.12%</span>
  </div>
  <div class="price-divider"></div>
  <div class="price-symbol">
    <span class="price-name">US10Y</span>
    <span class="price-value">4.284</span>
    <span class="price-change down">-0.09%</span>
  </div>
</div>

<div class="app">
  <!-- CHART + POSITIONS -->
  <div class="chart-area">
    <div class="symbol-selector">
      <button class="sym-btn active">XAUUSD</button>
    </div>

    <!-- CHART TOOLBAR: timeframes + chart type -->
    <div class="chart-toolbar">
      <div class="chart-timeframes">
        <button class="tf-btn">M1</button>
        <button class="tf-btn">M5</button>
        <button class="tf-btn">M15</button>
        <button class="tf-btn active">H1</button>
        <button class="tf-btn">H4</button>
        <button class="tf-btn">D1</button>
        <button class="tf-btn">W1</button>
      </div>

      <!-- Chart Type Toggle -->
      <div class="chart-type-toggle">
        <button class="ct-btn active" id="btn-candle" onclick="setChartType('candle')">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <rect x="5" y="3" width="4" height="8" rx="0.5" fill="currentColor" opacity="0.9"/>
            <line x1="7" y1="1" x2="7" y2="3" stroke="currentColor" stroke-width="1.2"/>
            <line x1="7" y1="11" x2="7" y2="13" stroke="currentColor" stroke-width="1.2"/>
          </svg>
          CANDLE
        </button>
        <button class="ct-btn" id="btn-line" onclick="setChartType('line')">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <polyline points="1,11 4,7 7,9 10,4 13,5" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
          </svg>
          LINE
        </button>
      </div>
    </div>

    <!-- CHART -->
    <div class="chart-container" id="chart-wrap">
      <canvas id="main-chart"></canvas>
      <div class="crosshair-x" id="ch-x"></div>
      <div class="crosshair-y" id="ch-y"></div>
      <div class="price-label-right" id="price-label"></div>
      <div class="chart-tooltip" id="chart-tooltip"></div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card"><div class="stat-label">Balance</div><div class="stat-value gold">$25,420</div></div>
      <div class="stat-card"><div class="stat-label">Equity</div><div class="stat-value gold" id="equity-val">$26,180</div></div>
      <div class="stat-card"><div class="stat-label">Floating P&L</div><div class="stat-value green" id="floating-pnl">+$760.00</div></div>
      <div class="stat-card"><div class="stat-label">Margin Used</div><div class="stat-value">$2,384</div></div>
    </div>

    <!-- Open Positions -->
    <div class="section-title">Open Positions</div>
    <div class="positions-table">
      <div class="table-header">
        <span class="th">Symbol</span><span class="th">Type</span><span class="th">Volume</span>
        <span class="th">Open Price</span><span class="th">Current</span><span class="th">P&L</span><span class="th">Action</span>
      </div>
      <div class="table-row" id="pos-1">
        <span class="td symbol">XAUUSD</span><span class="td buy">BUY</span><span class="td">0.50</span>
        <span class="td">2,368.20</span><span class="td" id="pos1-cur">2,384.45</span>
        <span class="td profit-pos" id="pos1-pnl">+$812.50</span>
        <button class="close-btn" onclick="closePosition('pos-1','+$812.50')">CLOSE</button>
      </div>
      <div class="table-row" id="pos-2">
        <span class="td symbol">XAUUSD</span><span class="td sell">SELL</span><span class="td">0.25</span>
        <span class="td">2,392.10</span><span class="td" id="pos2-cur">2,384.45</span>
        <span class="td profit-pos" id="pos2-pnl">+$191.25</span>
        <button class="close-btn" onclick="closePosition('pos-2','+$191.25')">CLOSE</button>
      </div>
    </div>
  </div>

  <!-- ORDER PANEL -->
  <div class="order-panel">
    <div class="section-title">New Order</div>
    <div class="order-tabs">
      <button class="order-tab buy active" id="tab-buy" onclick="setDirection('buy')">BUY</button>
      <button class="order-tab sell" id="tab-sell" onclick="setDirection('sell')">SELL</button>
    </div>
    <div class="bid-ask">
      <div class="ba-card"><div class="ba-label">BID</div><div class="ba-price bid" id="bid-price">2,384.20</div></div>
      <div class="ba-card"><div class="ba-label">ASK</div><div class="ba-price ask" id="ask-price">2,384.70</div></div>
    </div>
    <div class="spread-display">SPREAD <span id="spread-val">0.50</span> pts</div>

    <div class="form-group">
      <label class="form-label">Symbol</label>
      <select class="form-input form-select" id="symbol-select">
        <option>XAUUSD — Gold vs USD</option>
        <option>XAUEUR — Gold vs EUR</option>
        <option>XAGUSD — Silver vs USD</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Order Type</label>
      <select class="form-input form-select" id="order-type" onchange="togglePendingPrice()">
        <option value="market">Market Order</option>
        <option value="limit">Buy/Sell Limit</option>
        <option value="stop">Buy/Sell Stop</option>
      </select>
    </div>
    <div class="form-group" id="pending-price-group" style="display:none;">
      <label class="form-label">Price</label>
      <input type="number" class="form-input" id="pending-price" placeholder="0.00" step="0.01">
    </div>
    <div class="form-group">
      <label class="form-label">Volume (Lots)</label>
      <div class="input-with-controls">
        <button class="qty-btn" onclick="adjustLot(-0.01)">−</button>
        <input type="number" class="form-input" id="lot-input" value="0.01" step="0.01" min="0.01" max="100">
        <button class="qty-btn" onclick="adjustLot(0.01)">+</button>
      </div>
      <div class="quick-lots">
        <button class="quick-lot-btn" onclick="setLot(0.01)">0.01</button>
        <button class="quick-lot-btn" onclick="setLot(0.10)">0.10</button>
        <button class="quick-lot-btn" onclick="setLot(0.50)">0.50</button>
        <button class="quick-lot-btn" onclick="setLot(1.00)">1.00</button>
      </div>
    </div>
    <div class="divider"></div>
    <div class="sltp-toggle">
      <span class="toggle-label">Stop Loss</span>
      <label class="toggle-switch"><input type="checkbox" id="sl-toggle" onchange="toggleSL()"><span class="toggle-track"></span></label>
    </div>
    <div id="sl-input-group" style="display:none;margin-bottom:16px;">
      <input type="number" class="form-input" id="sl-price" placeholder="Stop Loss Price" step="0.01">
    </div>
    <div class="sltp-toggle">
      <span class="toggle-label">Take Profit</span>
      <label class="toggle-switch"><input type="checkbox" id="tp-toggle" onchange="toggleTP()"><span class="toggle-track"></span></label>
    </div>
    <div id="tp-input-group" style="display:none;margin-bottom:16px;">
      <input type="number" class="form-input" id="tp-price" placeholder="Take Profit Price" step="0.01">
    </div>
    <div class="divider"></div>
    <button class="order-submit buy" id="submit-btn" onclick="placeOrder()">BUY XAUUSD</button>
    <div class="margin-info">
      <div class="margin-row"><span class="margin-label">Required Margin</span><span class="margin-value gold" id="req-margin">$238.45</span></div>
      <div class="margin-row"><span class="margin-label">Pip Value</span><span class="margin-value" id="pip-val">$1.00</span></div>
      <div class="margin-row"><span class="margin-label">Free Margin</span><span class="margin-value">$23,036</span></div>
      <div class="margin-row"><span class="margin-label">Margin Level</span><span class="margin-value gold">1,098%</span></div>
    </div>
  </div>
</div>

<div class="notification" id="notification">
  <div class="notification-title" id="notif-title">ORDER EXECUTED</div>
  <div id="notif-body">BUY 0.10 XAUUSD @ 2,384.70</div>
</div>

<script>
  // ═══════════════════════════════════════════════
  //  STATE
  // ═══════════════════════════════════════════════
  let direction   = 'buy';
  let basePrice   = 2384.45;
  let lastPrice   = basePrice;
  let chartType   = 'candle'; // 'candle' | 'line'
  let candles     = [];       // OHLC data
  let linePrices  = [];       // close prices for line chart
  const MAX_BARS  = 80;

  // ═══════════════════════════════════════════════
  //  CANVAS SETUP
  // ═══════════════════════════════════════════════
  const canvas  = document.getElementById('main-chart');
  const ctx     = canvas.getContext('2d');
  const wrap    = document.getElementById('chart-wrap');

  function resizeCanvas() {
    canvas.width  = wrap.clientWidth;
    canvas.height = wrap.clientHeight;
    drawChart();
  }

  window.addEventListener('resize', resizeCanvas);

  // ═══════════════════════════════════════════════
  //  GENERATE INITIAL CANDLE DATA
  // ═══════════════════════════════════════════════
  function generateCandles(count = MAX_BARS, startPrice = 2360) {
    let p = startPrice;
    const arr = [];
    for (let i = 0; i < count; i++) {
      const open  = p;
      const move  = (Math.random() - 0.47) * 4;
      const close = Math.round((open + move) * 100) / 100;
      const high  = Math.round((Math.max(open, close) + Math.random() * 2) * 100) / 100;
      const low   = Math.round((Math.min(open, close) - Math.random() * 2) * 100) / 100;
      arr.push({ open, high, low, close });
      p = close;
    }
    return arr;
  }

  candles    = generateCandles();
  linePrices = candles.map(c => c.close);

  // ═══════════════════════════════════════════════
  //  DRAW CHART
  // ═══════════════════════════════════════════════
  const PAD = { top: 20, right: 55, bottom: 28, left: 8 };

  function drawChart() {
    const W = canvas.width;
    const H = canvas.height;
    ctx.clearRect(0, 0, W, H);

    const chartW = W - PAD.left - PAD.right;
    const chartH = H - PAD.top  - PAD.bottom;

    // price range
    const prices = chartType === 'candle'
      ? candles.flatMap(c => [c.high, c.low])
      : linePrices;
    const minP = Math.min(...prices);
    const maxP = Math.max(...prices);
    const range = maxP - minP || 1;
    const pad   = range * 0.08;
    const lo    = minP - pad;
    const hi    = maxP + pad;

    const scaleY = v => PAD.top + chartH - ((v - lo) / (hi - lo)) * chartH;
    const barW   = chartW / MAX_BARS;

    // ── Grid lines ──
    ctx.strokeStyle = 'rgba(255,255,255,0.04)';
    ctx.lineWidth   = 1;
    const gridSteps = 5;
    for (let i = 0; i <= gridSteps; i++) {
      const y = PAD.top + (chartH / gridSteps) * i;
      ctx.beginPath(); ctx.moveTo(PAD.left, y); ctx.lineTo(W - PAD.right, y); ctx.stroke();

      // Price labels
      const labelPrice = hi - ((hi - lo) / gridSteps) * i;
      ctx.fillStyle    = 'rgba(136,136,136,0.55)';
      ctx.font         = '9px JetBrains Mono, monospace';
      ctx.textAlign    = 'left';
      ctx.fillText(labelPrice.toFixed(2), W - PAD.right + 4, y + 3);
    }

    // ── Vertical grid (time) ──
    ctx.strokeStyle = 'rgba(255,255,255,0.03)';
    for (let i = 0; i < MAX_BARS; i += 10) {
      const x = PAD.left + i * barW + barW / 2;
      ctx.beginPath(); ctx.moveTo(x, PAD.top); ctx.lineTo(x, H - PAD.bottom); ctx.stroke();
    }

    if (chartType === 'candle') {
      drawCandlesticks(barW, scaleY, chartH);
    } else {
      drawLineChart(barW, scaleY, chartH, lo, hi);
    }

    // ── Current price dashed line ──
    const curY = scaleY(basePrice);
    ctx.strokeStyle    = 'rgba(201,168,76,0.35)';
    ctx.lineWidth      = 1;
    ctx.setLineDash([4, 4]);
    ctx.beginPath();
    ctx.moveTo(PAD.left, curY);
    ctx.lineTo(W - PAD.right, curY);
    ctx.stroke();
    ctx.setLineDash([]);

    // Current price badge
    ctx.fillStyle    = '#C9A84C';
    ctx.beginPath();
    ctx.roundRect(W - PAD.right + 2, curY - 8, PAD.right - 4, 16, 2);
    ctx.fill();
    ctx.fillStyle = '#0A0A0A';
    ctx.font      = 'bold 9px JetBrains Mono, monospace';
    ctx.textAlign = 'center';
    ctx.fillText(basePrice.toFixed(2), W - PAD.right + (PAD.right / 2), curY + 3);
  }

  function drawCandlesticks(barW, scaleY, chartH) {
    const candleW = Math.max(barW * 0.6, 2);
    const offset  = barW * 0.2;

    candles.forEach((c, i) => {
      const x    = PAD.left + i * barW + offset;
      const isUp = c.close >= c.open;
      const col  = isUp ? '#4CAF7A' : '#E05050';

      const openY  = scaleY(c.open);
      const closeY = scaleY(c.close);
      const highY  = scaleY(c.high);
      const lowY   = scaleY(c.low);

      const bodyTop = Math.min(openY, closeY);
      const bodyH   = Math.max(Math.abs(closeY - openY), 1);
      const centerX = x + candleW / 2;

      // Wick
      ctx.strokeStyle = col;
      ctx.lineWidth   = 1;
      ctx.beginPath();
      ctx.moveTo(centerX, highY);
      ctx.lineTo(centerX, bodyTop);
      ctx.moveTo(centerX, bodyTop + bodyH);
      ctx.lineTo(centerX, lowY);
      ctx.stroke();

      // Body
      ctx.fillStyle = isUp ? col : col;
      if (isUp) {
        ctx.fillStyle = '#4CAF7A';
      } else {
        ctx.fillStyle = '#E05050';
      }
      ctx.fillRect(x, bodyTop, candleW, bodyH);

      // Hollow body for up candles (optional: filled green)
      if (isUp && bodyH > 2) {
        ctx.strokeStyle = '#4CAF7A';
        ctx.lineWidth   = 0.5;
        ctx.strokeRect(x, bodyTop, candleW, bodyH);
      }
    });
  }

  function drawLineChart(barW, scaleY, chartH, lo, hi) {
    const W = canvas.width;
    const H = canvas.height;

    // Gradient fill
    const grad = ctx.createLinearGradient(0, PAD.top, 0, H - PAD.bottom);
    grad.addColorStop(0,   'rgba(201,168,76,0.2)');
    grad.addColorStop(1,   'rgba(201,168,76,0)');

    ctx.beginPath();
    linePrices.forEach((p, i) => {
      const x = PAD.left + i * barW + barW / 2;
      const y = scaleY(p);
      i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    });

    // Close fill path
    const lastX = PAD.left + (linePrices.length - 1) * barW + barW / 2;
    ctx.lineTo(lastX, H - PAD.bottom);
    ctx.lineTo(PAD.left + barW / 2, H - PAD.bottom);
    ctx.closePath();
    ctx.fillStyle = grad;
    ctx.fill();

    // Line stroke with gradient
    const lineGrad = ctx.createLinearGradient(PAD.left, 0, W - PAD.right, 0);
    lineGrad.addColorStop(0,   '#8B6914');
    lineGrad.addColorStop(0.5, '#E8C96B');
    lineGrad.addColorStop(1,   '#C9A84C');

    ctx.beginPath();
    linePrices.forEach((p, i) => {
      const x = PAD.left + i * barW + barW / 2;
      const y = scaleY(p);
      i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    });
    ctx.strokeStyle = lineGrad;
    ctx.lineWidth   = 1.8;
    ctx.lineJoin    = 'round';
    ctx.stroke();
  }

  // ═══════════════════════════════════════════════
  //  CROSSHAIR + TOOLTIP
  // ═══════════════════════════════════════════════
  const chX      = document.getElementById('ch-x');
  const chY      = document.getElementById('ch-y');
  const tooltip  = document.getElementById('chart-tooltip');

  canvas.addEventListener('mousemove', e => {
    const rect  = canvas.getBoundingClientRect();
    const mx    = e.clientX - rect.left;
    const my    = e.clientY - rect.top;
    const W     = canvas.width;
    const H     = canvas.height;
    const chartW = W - PAD.left - PAD.right;
    const chartH = H - PAD.top  - PAD.bottom;

    chX.style.display = 'block';
    chY.style.display = 'block';
    chX.style.top  = my + 'px';
    chY.style.left = mx + 'px';

    // Price at cursor
    const prices = chartType === 'candle'
      ? candles.flatMap(c => [c.high, c.low])
      : linePrices;
    const minP  = Math.min(...prices);
    const maxP  = Math.max(...prices);
    const range = maxP - minP || 1;
    const pad   = range * 0.08;
    const lo    = minP - pad;
    const hi    = maxP + pad;

    const cursorPrice = hi - ((my - PAD.top) / chartH) * (hi - lo);

    // Bar index
    const barW  = chartW / MAX_BARS;
    const idx   = Math.floor((mx - PAD.left) / barW);

    if (chartType === 'candle' && idx >= 0 && idx < candles.length) {
      const c = candles[idx];
      tooltip.style.display = 'block';
      tooltip.innerHTML = `
        <span class="tt-o">O</span> ${c.open.toFixed(2)} &nbsp;
        <span class="tt-h">H</span> ${c.high.toFixed(2)}<br>
        <span class="tt-l">L</span> ${c.low.toFixed(2)} &nbsp;
        <span class="tt-c">C</span> ${c.close.toFixed(2)}
      `;
    } else if (chartType === 'line' && idx >= 0 && idx < linePrices.length) {
      tooltip.style.display = 'block';
      tooltip.innerHTML = `<span class="tt-c">Price</span> ${linePrices[idx].toFixed(2)}`;
    } else {
      tooltip.style.display = 'none';
    }
  });

  canvas.addEventListener('mouseleave', () => {
    chX.style.display = 'none';
    chY.style.display = 'none';
    tooltip.style.display = 'none';
  });

  // ═══════════════════════════════════════════════
  //  CHART TYPE SWITCH
  // ═══════════════════════════════════════════════
  function setChartType(type) {
    chartType = type;
    document.getElementById('btn-candle').className = 'ct-btn' + (type === 'candle' ? ' active' : '');
    document.getElementById('btn-line').className   = 'ct-btn' + (type === 'line'   ? ' active' : '');
    drawChart();
  }

  // ═══════════════════════════════════════════════
  //  LIVE PRICE UPDATE  → append new candle / point
  // ═══════════════════════════════════════════════
  let tickCount = 0;

  function updatePrices() {
    const change = (Math.random() - 0.5) * 0.8;
    basePrice = Math.round((basePrice + change) * 100) / 100;

    const bid = (basePrice - 0.25).toFixed(2);
    const ask = (basePrice + 0.25).toFixed(2);

    const priceEl = document.getElementById('xauusd-price');
    const wasUp   = basePrice > lastPrice;
    priceEl.textContent = basePrice.toLocaleString('en-US', { minimumFractionDigits: 2 });
    priceEl.classList.remove('flash-up', 'flash-down');
    void priceEl.offsetWidth;
    priceEl.classList.add(wasUp ? 'flash-up' : 'flash-down');

    document.getElementById('bid-price').textContent = bid;
    document.getElementById('ask-price').textContent = ask;

    // Update last candle's close / high / low
    if (candles.length > 0) {
      const last = candles[candles.length - 1];
      last.close = basePrice;
      last.high  = Math.max(last.high, basePrice);
      last.low   = Math.min(last.low, basePrice);
    }

    // Every 5 ticks → new candle
    tickCount++;
    if (tickCount % 5 === 0) {
      const prev = candles[candles.length - 1];
      candles.push({ open: prev.close, high: prev.close, low: prev.close, close: prev.close });
      if (candles.length > MAX_BARS) candles.shift();
      linePrices.push(basePrice);
      if (linePrices.length > MAX_BARS) linePrices.shift();
    }

    drawChart();

    // Positions
    const pos1Pnl = ((basePrice - 2368.20) * 50).toFixed(2);
    document.getElementById('pos1-cur').textContent = basePrice.toLocaleString('en-US', { minimumFractionDigits: 2 });
    document.getElementById('pos1-pnl').textContent = (pos1Pnl >= 0 ? '+' : '') + '$' + Math.abs(pos1Pnl).toFixed(2);
    document.getElementById('pos1-pnl').className   = 'td ' + (pos1Pnl >= 0 ? 'profit-pos' : 'profit-neg');

    const pos2Pnl = ((2392.10 - basePrice) * 25).toFixed(2);
    document.getElementById('pos2-cur').textContent = basePrice.toLocaleString('en-US', { minimumFractionDigits: 2 });
    document.getElementById('pos2-pnl').textContent = (pos2Pnl >= 0 ? '+' : '') + '$' + Math.abs(pos2Pnl).toFixed(2);
    document.getElementById('pos2-pnl').className   = 'td ' + (pos2Pnl >= 0 ? 'profit-pos' : 'profit-neg');

    const totalPnl = parseFloat(pos1Pnl) + parseFloat(pos2Pnl);
    const fpnlEl   = document.getElementById('floating-pnl');
    fpnlEl.textContent = (totalPnl >= 0 ? '+' : '') + '$' + Math.abs(totalPnl).toFixed(2);
    fpnlEl.className   = 'stat-value ' + (totalPnl >= 0 ? 'green' : 'red');

    document.getElementById('equity-val').textContent = '$' + (25420 + totalPnl).toLocaleString('en-US', { minimumFractionDigits: 2 });
    updateMargin();
    lastPrice = basePrice;
  }

  setInterval(updatePrices, 1500);

  // ═══════════════════════════════════════════════
  //  TIMEFRAME BUTTONS
  // ═══════════════════════════════════════════════
  document.querySelectorAll('.tf-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.tf-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      // Regenerate candles for new TF
      candles    = generateCandles(MAX_BARS, basePrice - 30 + Math.random() * 10);
      linePrices = candles.map(c => c.close);
      drawChart();
    });
  });

  // Symbol buttons
  document.querySelectorAll('.sym-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.sym-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // ═══════════════════════════════════════════════
  //  ORDER FUNCTIONS
  // ═══════════════════════════════════════════════
  function setDirection(dir) {
    direction = dir;
    document.getElementById('tab-buy').className  = 'order-tab buy'  + (dir === 'buy'  ? ' active' : '');
    document.getElementById('tab-sell').className = 'order-tab sell' + (dir === 'sell' ? ' active' : '');
    const btn = document.getElementById('submit-btn');
    const sym = document.getElementById('symbol-select').value.split(' ')[0];
    btn.className   = 'order-submit ' + dir;
    btn.textContent = dir.toUpperCase() + ' ' + sym;
  }

  function toggleSL() {
    const show = document.getElementById('sl-toggle').checked;
    document.getElementById('sl-input-group').style.display = show ? 'block' : 'none';
    if (show) document.getElementById('sl-price').value = (direction === 'buy' ? basePrice - 20 : basePrice + 20).toFixed(2);
  }

  function toggleTP() {
    const show = document.getElementById('tp-toggle').checked;
    document.getElementById('tp-input-group').style.display = show ? 'block' : 'none';
    if (show) document.getElementById('tp-price').value = (direction === 'buy' ? basePrice + 30 : basePrice - 30).toFixed(2);
  }

  function adjustLot(delta) {
    const input = document.getElementById('lot-input');
    let val = Math.round((parseFloat(input.value) + delta) * 100) / 100;
    if (val < 0.01) val = 0.01;
    if (val > 100)  val = 100;
    input.value = val.toFixed(2);
    updateMargin();
  }

  function setLot(val) {
    document.getElementById('lot-input').value = val.toFixed(2);
    updateMargin();
  }

  function updateMargin() {
    const lots   = parseFloat(document.getElementById('lot-input').value) || 0.01;
    const margin = (basePrice * lots * 100 / 500).toFixed(2);
    const pip    = (lots * 10).toFixed(2);
    document.getElementById('req-margin').textContent = '$' + parseFloat(margin).toLocaleString('en-US', { minimumFractionDigits: 2 });
    document.getElementById('pip-val').textContent    = '$' + pip;
  }

  function togglePendingPrice() {
    const type = document.getElementById('order-type').value;
    document.getElementById('pending-price-group').style.display = type === 'market' ? 'none' : 'block';
    if (type !== 'market') document.getElementById('pending-price').value = basePrice.toFixed(2);
  }

  function placeOrder() {
    const lots  = parseFloat(document.getElementById('lot-input').value);
    const price = direction === 'buy' ? (basePrice + 0.25).toFixed(2) : (basePrice - 0.25).toFixed(2);
    showNotif('ORDER EXECUTED', `${direction.toUpperCase()} ${lots.toFixed(2)} XAUUSD @ ${parseFloat(price).toLocaleString('en-US', { minimumFractionDigits: 2 })}`);
    const btn = document.getElementById('submit-btn');
    btn.style.filter = 'brightness(1.5)';
    setTimeout(() => { btn.style.filter = ''; }, 200);
  }

  function closePosition(posId, pnl) {
    const row = document.getElementById(posId);
    if (row) {
      row.style.opacity = '0';
      row.style.transition = 'opacity 0.3s';
      setTimeout(() => row.remove(), 300);
      showNotif('POSITION CLOSED', `Closed at ${basePrice.toFixed(2)} · P&L: ${pnl}`);
    }
  }

  function showNotif(title, body) {
    const n = document.getElementById('notification');
    document.getElementById('notif-title').textContent = title;
    document.getElementById('notif-body').textContent  = body;
    n.classList.add('show');
    setTimeout(() => n.classList.remove('show'), 3500);
  }

  // ═══════════════════════════════════════════════
  //  INIT
  // ═══════════════════════════════════════════════
  updateMargin();
  setTimeout(resizeCanvas, 50); // wait for layout
</script>