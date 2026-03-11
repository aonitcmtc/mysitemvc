<!-- <title>MT5 — Orders & History</title> -->
<meta name="base-url"        content="<?= base_url() ?>">
<meta name="csrf-token-name" content="csrf_token">
<meta name="csrf-token"      content="<?= csrf_hash() ?>">
<script src="<?=base_url();?>asset/lightweight-charts.standalone.dev.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600&family=Cormorant+Garamond:wght@400;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">

<style>
/* ══ DESIGN TOKENS ══ */
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

/* ══ RESETS ══ */
*, *::before, *::after { box-sizing: border-box; }
html  { font-size: 14px; }
body  {
  background: var(--black);
  color: var(--white);
  font-family: var(--sans);
  min-height: 100vh;
  overflow-x: hidden;
}
body::after {
  content: '';
  position: fixed;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 9999;
}

/* ══ TOPBAR ══ */
.topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 24px;
  height: 52px;
  border-bottom: 1px solid rgba(201,168,76,0.15);
  background: rgba(9,9,9,0.96);
  backdrop-filter: blur(16px);
  position: sticky;
  top: 0;
  z-index: 1030;
}
.brand {
  font-family: var(--serif);
  font-size: 19px;
  font-weight: 700;
  letter-spacing: 4px;
  color: var(--gold);
  text-transform: uppercase;
  display: flex;
  align-items: baseline;
  gap: 10px;
}
.brand-sub { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); font-weight: 300; }
.live-dot  { display: flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); }
.live-dot::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--green);
  box-shadow: 0 0 8px var(--green);
  animation: blink 2s infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* ══ TICKER BAR ══ */
.ticker-bar {
  display: flex;
  align-items: stretch;
  background: var(--dark2);
  border-bottom: 1px solid rgba(255,255,255,0.05);
  overflow-x: auto;
}
.ticker-bar::-webkit-scrollbar { height: 0; }

.sym-tile {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 10px 20px;
  cursor: pointer;
  border-right: 1px solid rgba(255,255,255,0.04);
  border-bottom: 2px solid transparent;
  transition: all 0.2s;
  min-width: 140px;
  gap: 3px;
  flex-shrink: 0;
}
.sym-tile:hover            { background: rgba(255,255,255,0.03); }
.sym-tile.active           { border-bottom-color: var(--gold); background: var(--gold-dim); }
.sym-tile.active-btc       { border-bottom-color: var(--btc);  background: var(--btc-dim); }
.sym-tile.active-eth       { border-bottom-color: var(--eth);  background: var(--eth-dim); }

.st-row1   { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.st-name   { font-family: var(--mono); font-size: 9px; letter-spacing: 2px; color: var(--light); text-transform: uppercase; }
.st-badge  { font-family: var(--mono); font-size: 7px; letter-spacing: 1px; padding: 1px 5px; border-radius: 2px; text-transform: uppercase; }
.st-badge.gold   { background: var(--gold-dim); color: var(--gold); }
.st-badge.btc    { background: var(--btc-dim);  color: var(--btc); }
.st-badge.eth    { background: var(--eth-dim);  color: var(--eth); }
.st-badge.silver { background: rgba(180,180,180,0.1); color: #aaa; }
.st-price  { font-family: var(--mono); font-size: 14px; font-weight: 500; color: var(--white); letter-spacing: -.3px; }
.st-sub    { display: flex; align-items: center; justify-content: space-between; }
.st-chg    { font-family: var(--mono); font-size: 9px; padding: 1px 5px; border-radius: 2px; }
.st-chg.up { background: var(--green-dim); color: var(--green); }
.st-chg.dn { background: var(--red-dim);   color: var(--red); }
.st-spread { font-family: var(--mono); font-size: 8px; color: var(--gray); }

/* ══ SECTION LABEL ══ */
.sec-label {
  font-family: var(--serif);
  font-size: 11px;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: var(--gold);
  display: flex;
  align-items: center;
  gap: 10px;
}
.sec-label::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, rgba(201,168,76,0.4), transparent);
}

/* ══ CARD WRAPPER ══ */
.panel-card {
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 4px;
  overflow: hidden;
  background: var(--dark);
}

/* ══ CHART ══ */
.chart-toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 8px 12px 6px;
  background: var(--dark);
}
.chart-sym-select {
  font-family: var(--mono);
  font-size: 9px;
  background: var(--dark3);
  border: 1px solid rgba(255,255,255,0.1);
  color: var(--gold);
  padding: 3px 8px;
  border-radius: 2px;
  outline: none;
  cursor: pointer;
}
.chart-tf-badge {
  font-family: var(--mono);
  font-size: 8px;
  letter-spacing: 2px;
  color: var(--gold);
  background: var(--gold-dim);
  padding: 3px 8px;
  border-radius: 2px;
}
.chart-status { font-family: var(--mono); font-size: 9px; color: var(--gray); }
.chart-ohlc   { font-family: var(--mono); font-size: 9px; color: var(--light); margin-left: auto; letter-spacing: 1px; }
#main-chart   { width: 100%; height: 300px; }

/* ══ TAB BAR ══ */
.tab-bar {
  display: flex;
  align-items: center;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  padding: 0 20px;
  background: var(--dark2);
  flex-shrink: 0;
}
.tab-item {
  font-family: var(--mono);
  font-size: 8px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--gray);
  padding: 14px 16px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  border-top: none; border-left: none; border-right: none;
  background: none;
  transition: all 0.2s;
  white-space: nowrap;
}
.tab-item:hover        { color: var(--light); }
.tab-item.active       { color: var(--gold); border-bottom-color: var(--gold); }
.tab-actions           { margin-left: auto; display: flex; align-items: center; gap: 8px; }
.refresh-btn {
  font-family: var(--mono);
  font-size: 8px;
  letter-spacing: 1px;
  background: transparent;
  border: 1px solid rgba(255,255,255,0.1);
  color: var(--gray);
  padding: 4px 12px;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.15s;
}
.refresh-btn:hover { border-color: var(--gold); color: var(--gold); }

.tab-content           { display: none; flex-direction: column; }
.tab-content.active    { display: flex; }

/* ══ DATA TABLE ══ */
.tbl-wrap   { padding: 16px 20px; overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
  font-family: var(--mono);
  font-size: 8px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--gray);
  padding: 7px 10px;
  text-align: left;
  border-bottom: 1px solid rgba(201,168,76,0.12);
  background: rgba(201,168,76,0.03);
  white-space: nowrap;
  position: sticky;
  top: 0;
}
.data-table td {
  font-family: var(--mono);
  font-size: 10px;
  color: var(--light);
  padding: 8px 10px;
  border-bottom: 1px solid rgba(255,255,255,0.03);
  white-space: nowrap;
}
.data-table tr:hover td { background: rgba(201,168,76,0.025); }

/* ══ TAGS ══ */
.tag { display: inline-block; font-size: 7px; letter-spacing: 1px; padding: 2px 6px; border-radius: 2px; text-transform: uppercase; font-weight: 600; }
.tag.buy        { background: var(--green-dim); color: var(--green); }
.tag.sell       { background: var(--red-dim);   color: var(--red); }
.tag.pending    { background: var(--amber-dim); color: var(--amber); }
.tag.processing { background: var(--blue-dim);  color: var(--blue); }
.tag.executed   { background: var(--green-dim); color: var(--green); }
.tag.failed     { background: var(--red-dim);   color: var(--red); }
.tag.close      { background: rgba(255,255,255,0.07); color: var(--light); }
.tag.market     { background: rgba(255,255,255,0.05); color: var(--gray); }
.tag.limit      { background: var(--blue-dim);  color: var(--blue); }
.tag.stop       { background: var(--amber-dim); color: var(--amber); }

/* ══ SYMBOL COLORS ══ */
.sym-xau { color: var(--gold) !important; }
.sym-btc { color: var(--btc)  !important; }
.sym-eth { color: var(--eth)  !important; }
.sym-xag { color: #aaa        !important; }

/* ══ ORDER PANEL ══ */
.order-panel { padding: 16px; display: flex; flex-direction: column; gap: 14px; }

.sym-display {
  background: var(--dark3);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--r);
  padding: 10px 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.sd-left   { display: flex; flex-direction: column; gap: 2px; }
.sd-sym    { font-family: var(--mono); font-size: 13px; font-weight: 600; color: var(--gold-light); }
.sd-desc   { font-family: var(--mono); font-size: 8px; color: var(--gray); letter-spacing: 1px; }
.sd-right  { font-family: var(--mono); font-size: 10px; color: var(--gray); text-align: right; }
.sd-price  { font-family: var(--mono); font-size: 15px; color: var(--white); display: block; }

/* dir tabs */
.dir-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; background: var(--dark3); padding: 3px; border-radius: var(--r); }
.dir-tab  { padding: 10px; text-align: center; cursor: pointer; font-family: var(--mono); font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--gray); border-radius: 2px; border: none; background: transparent; transition: all 0.2s; }
.dir-tab.buy.active  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.dir-tab.sell.active { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.dir-tab:not(.active):hover { color: var(--light); }

/* bid/ask */
.ba-row    { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.ba-card   { background: var(--dark2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--r); padding: 10px 14px; text-align: center; }
.ba-lbl    { font-family: var(--mono); font-size: 8px; letter-spacing: 3px; color: var(--gray); margin-bottom: 4px; }
.ba-val    { font-family: var(--mono); font-size: 17px; font-weight: 500; }
.ba-val.bid { color: var(--red); }
.ba-val.ask { color: var(--green); }
.spread-line { text-align: center; font-family: var(--mono); font-size: 9px; color: var(--gray); letter-spacing: 2px; margin-top: -6px; }
.spread-line span { color: var(--gold); }

/* fields */
.field       { display: flex; flex-direction: column; gap: 5px; }
.field-label { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: var(--gray); }
.field-input {
  width: 100%;
  background: var(--dark3);
  border: 1px solid rgba(255,255,255,0.1);
  color: var(--white);
  font-family: var(--mono);
  font-size: 13px;
  padding: 9px 12px;
  border-radius: var(--r);
  outline: none;
  transition: border-color 0.2s;
  -webkit-appearance: none;
}
.field-input:focus       { border-color: var(--gold); }
.field-input::placeholder { color: var(--dark4); }
select.field-input       { cursor: pointer; }

/* lot row */
.lot-row  { display: flex; align-items: center; gap: 4px; }
.lot-btn  { width: 36px; height: 38px; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1); color: var(--gold); cursor: pointer; font-size: 16px; border-radius: var(--r); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.15s; }
.lot-btn:hover { background: var(--gold-dim); border-color: var(--gold); }
.quick-lots { display: grid; grid-template-columns: repeat(4,1fr); gap: 4px; margin-top: 4px; }
.ql-btn { font-family: var(--mono); font-size: 9px; padding: 4px 0; background: var(--dark4); border: 1px solid rgba(255,255,255,0.07); color: var(--gray); cursor: pointer; border-radius: 2px; text-align: center; transition: all 0.15s; }
.ql-btn:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--gold); }

/* sl/tp toggle */
.sltp-row   { display: flex; align-items: center; justify-content: space-between; }
.sltp-label { font-family: var(--mono); font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.toggle     { position: relative; width: 38px; height: 20px; cursor: pointer; }
.toggle input { display: none; }
.toggle-track { position: absolute; inset: 0; background: var(--dark4); border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s; }
.toggle-track::after { content: ''; position: absolute; width: 14px; height: 14px; background: var(--gray2); border-radius: 50%; top: 2px; left: 2px; transition: all 0.2s; }
.toggle input:checked + .toggle-track             { background: rgba(201,168,76,0.2); border-color: var(--gold); }
.toggle input:checked + .toggle-track::after      { transform: translateX(18px); background: var(--gold); }

.divider { height: 1px; background: rgba(255,255,255,0.05); }

/* submit */
.submit-btn { width: 100%; padding: 13px; font-family: var(--serif); font-size: 16px; font-weight: 600; letter-spacing: 4px; text-transform: uppercase; cursor: pointer; border-radius: var(--r); border: none; transition: all 0.2s; }
.submit-btn.buy  { background: linear-gradient(135deg,#1e5c38,#4caf7a); color: #fff; box-shadow: 0 4px 20px rgba(76,175,122,0.25); }
.submit-btn.sell { background: linear-gradient(135deg,#6e1818,#e05050); color: #fff; box-shadow: 0 4px 20px rgba(224,80,80,0.25); }
.submit-btn:hover    { transform: translateY(-1px); filter: brightness(1.1); }
.submit-btn:active   { transform: none; }
.submit-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* margin box */
.margin-box   { background: var(--dark2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--r); padding: 11px 14px; display: flex; flex-direction: column; gap: 6px; }
.margin-row   { display: flex; justify-content: space-between; align-items: center; }
.m-lbl        { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.m-val        { font-family: var(--mono); font-size: 11px; color: var(--light); }
.m-val.gold   { color: var(--gold-light); }

/* ══ MISC ══ */
.loading-row td { text-align: center !important; color: var(--gray) !important; padding: 28px !important; font-size: 9px !important; letter-spacing: 2px; }
.empty-state    { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; gap: 8px; color: var(--gray2); font-family: var(--mono); font-size: 9px; letter-spacing: 2px; }

/* ══ TOAST ══ */
#toast {
  position: fixed; bottom: 20px; right: 20px;
  background: var(--dark2); border-radius: var(--r);
  padding: 12px 16px;
  font-family: var(--mono); font-size: 10px; color: var(--gold);
  z-index: 9000;
  transform: translateY(70px); opacity: 0;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 8px 28px rgba(0,0,0,0.6);
  max-width: 300px;
  border-left: 2px solid var(--gold);
}
#toast.show    { transform: translateY(0); opacity: 1; }
#toast.success { border-left-color: var(--green); color: var(--green); }
#toast.error   { border-left-color: var(--red);   color: var(--red); }
#toast-title   { font-size: 7px; letter-spacing: 2px; color: var(--gray); margin-bottom: 3px; text-transform: uppercase; }

/* ══ SCROLLBAR ══ */
::-webkit-scrollbar       { width: 3px; height: 3px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--dark4); border-radius: 2px; }

/* Bootstrap overrides — keep dark theme */
.container-fluid, .container { background: transparent; }

@keyframes fadeIn { from{opacity:0;transform:translateY(5px)} to{opacity:1;transform:translateY(0)} }
.fade-in { animation: fadeIn 0.25s ease both; }

/* ══ BULK CLOSE CONTROLS ══ */
.close-bar {
  display: flex; flex-wrap: wrap; align-items: center; gap: 8px;
  padding: 10px 14px;
  background: rgba(224,80,80,0.04);
  border-bottom: 1px solid rgba(224,80,80,0.1);
}
.close-bar-lbl {
  font-family: var(--mono); font-size: 8px; letter-spacing: 2px;
  color: var(--gray); text-transform: uppercase; flex-shrink: 0;
}
.cc-btn {
  font-family: var(--mono); font-size: 9px; letter-spacing: 1px;
  text-transform: uppercase; padding: 5px 13px; border-radius: 2px;
  cursor: pointer; transition: all 0.18s; white-space: nowrap;
  border: 1px solid transparent;
}
.cc-btn.all  { background: var(--red-dim);   border-color: rgba(224,80,80,0.35);  color: var(--red); }
.cc-btn.buy  { background: var(--green-dim); border-color: rgba(76,175,122,0.3);  color: var(--green); }
.cc-btn.sell { background: var(--red-dim);   border-color: rgba(224,80,80,0.25);  color: var(--red); }
.cc-btn:hover { filter: brightness(1.3); box-shadow: 0 0 10px currentColor; opacity:.9; }
.cc-btn:disabled { opacity: .35; cursor: not-allowed; filter: none; box-shadow: none; }
.close-row-btn {
  font-family: var(--mono); font-size: 8px; letter-spacing: 1px;
  padding: 3px 9px; background: var(--red-dim);
  border: 1px solid rgba(224,80,80,0.3); color: var(--red);
  border-radius: 2px; cursor: pointer; transition: all 0.15s; text-transform: uppercase;
}
.close-row-btn:hover { background: var(--red); color: #fff; }

/* ══ CONFIRM MODAL ══ */
.cfm-backdrop {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.78); backdrop-filter: blur(4px);
  z-index: 9500; display: none; align-items: center; justify-content: center;
}
.cfm-backdrop.open { display: flex; }
.cfm-box {
  background: var(--dark); border: 1px solid rgba(224,80,80,0.3);
  border-radius: 4px; padding: 28px 26px 22px; width: 310px; text-align: center;
  box-shadow: 0 20px 60px rgba(0,0,0,0.85);
  animation: cfmIn .18s cubic-bezier(0.16,1,0.3,1);
}
@keyframes cfmIn { from{opacity:0;transform:scale(.94)} to{opacity:1;transform:none} }
.cfm-title { font-family: var(--serif); font-size: 17px; letter-spacing: 3px; color: var(--red); text-transform: uppercase; margin-bottom: 8px; }
.cfm-msg   { font-family: var(--mono); font-size: 10px; color: var(--gray); letter-spacing: 1px; margin-bottom: 22px; line-height: 1.65; white-space: pre-line; }
.cfm-btns  { display: flex; gap: 10px; }
.cfm-yes   { flex:1; padding: 10px; background: linear-gradient(135deg,#6e1818,#e05050); border: none; border-radius: var(--r); color: #fff; font-family: var(--serif); font-size: 15px; font-weight: 600; letter-spacing: 3px; cursor: pointer; }
.cfm-yes:hover { filter: brightness(1.1); }
.cfm-no    { flex:1; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.1); color: var(--gray); font-family: var(--mono); font-size: 10px; letter-spacing: 2px; border-radius: var(--r); cursor: pointer; }
.cfm-no:hover  { border-color: var(--gold); color: var(--gold); }

/* ══ AI TRADE BUTTON ══ */
.ai-trade-btn {
  width: 100%;
  padding: 11px 14px;
  background: linear-gradient(135deg, rgba(91,141,238,0.12), rgba(201,168,76,0.08));
  border: 1px solid rgba(91,141,238,0.35);
  border-radius: var(--r);
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  transition: all 0.2s;
  position: relative;
  overflow: hidden;
}
.ai-trade-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(91,141,238,0.08), transparent);
  opacity: 0;
  transition: opacity 0.2s;
}
.ai-trade-btn:hover { border-color: rgba(91,141,238,0.7); transform: translateY(-1px); }
.ai-trade-btn:hover::before { opacity: 1; }
.ai-btn-icon { font-size: 18px; color: var(--blue); flex-shrink: 0; animation: aiPulse 2.5s infinite; }
@keyframes aiPulse { 0%,100%{opacity:1;text-shadow:0 0 8px var(--blue)} 50%{opacity:.5;text-shadow:none} }
.ai-btn-text { font-family: var(--mono); font-size: 11px; letter-spacing: 3px; color: var(--blue); text-transform: uppercase; font-weight: 600; }
.ai-btn-sub  { font-family: var(--mono); font-size: 7px; color: var(--gray); letter-spacing: 1px; margin-left: auto; }

/* ══ AI MODAL ══ */
.ai-modal-backdrop {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.85);
  backdrop-filter: blur(6px);
  z-index: 9100;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.ai-modal-backdrop.open { display: flex; }

.ai-modal {
  background: var(--dark);
  border: 1px solid rgba(91,141,238,0.25);
  border-radius: 6px;
  width: 100%;
  max-width: 560px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 24px 80px rgba(0,0,0,0.8), 0 0 0 1px rgba(91,141,238,0.1);
  animation: modalIn 0.25s cubic-bezier(0.16,1,0.3,1);
}
@keyframes modalIn { from{opacity:0;transform:translateY(16px) scale(0.97)} to{opacity:1;transform:none} }

.ai-modal-header {
  display: flex; align-items: center; gap: 12px;
  padding: 16px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  background: rgba(91,141,238,0.05);
}
.ai-modal-title { font-family: var(--serif); font-size: 16px; letter-spacing: 3px; color: var(--blue); text-transform: uppercase; }
.ai-modal-sub   { font-family: var(--mono); font-size: 8px; color: var(--gray); letter-spacing: 2px; margin-top: 2px; }
.ai-modal-close {
  margin-left: auto;
  background: transparent; border: 1px solid rgba(255,255,255,0.1);
  color: var(--gray); width: 28px; height: 28px;
  border-radius: 2px; cursor: pointer; font-size: 14px;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.15s;
}
.ai-modal-close:hover { border-color: var(--red); color: var(--red); }

.ai-modal-body { padding: 20px; display: flex; flex-direction: column; gap: 16px; }

/* Upload zone */
.upload-zone {
  border: 2px dashed rgba(91,141,238,0.3);
  border-radius: 4px;
  padding: 28px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s;
  background: rgba(91,141,238,0.03);
  position: relative;
}
.upload-zone:hover, .upload-zone.drag { border-color: var(--blue); background: rgba(91,141,238,0.08); }
.upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-icon { font-size: 28px; color: var(--blue); opacity: .5; margin-bottom: 8px; }
.upload-text { font-family: var(--mono); font-size: 10px; letter-spacing: 2px; color: var(--gray); }
.upload-hint { font-family: var(--mono); font-size: 8px; color: var(--gray2); margin-top: 4px; letter-spacing: 1px; }

/* Preview */
#ai-preview-wrap { display: none; position: relative; }
#ai-preview-img  { width: 100%; border-radius: 4px; border: 1px solid rgba(255,255,255,0.08); max-height: 220px; object-fit: cover; }
.preview-clear {
  position: absolute; top: 6px; right: 6px;
  background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.2);
  color: var(--white); width: 24px; height: 24px; border-radius: 2px;
  cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center;
}

/* Prompt input */
.ai-prompt-row { display: flex; flex-direction: column; gap: 5px; }
.ai-prompt-label { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.ai-prompt-input {
  width: 100%; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1);
  color: var(--white); font-family: var(--mono); font-size: 11px;
  padding: 8px 12px; border-radius: var(--r); outline: none; resize: none;
  transition: border-color 0.2s; line-height: 1.5;
}
.ai-prompt-input:focus { border-color: var(--blue); }

/* Analyse button */
.ai-analyse-btn {
  width: 100%; padding: 13px;
  background: linear-gradient(135deg, #1a2a5e, #5b8dee);
  border: none; border-radius: var(--r); cursor: pointer;
  font-family: var(--serif); font-size: 15px; font-weight: 600;
  letter-spacing: 4px; text-transform: uppercase; color: #fff;
  box-shadow: 0 4px 20px rgba(91,141,238,0.3);
  transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px;
}
.ai-analyse-btn:hover { transform: translateY(-1px); filter: brightness(1.15); }
.ai-analyse-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* Result panel */
.ai-result {
  display: none;
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 4px;
  overflow: hidden;
}
.ai-result.show { display: block; }
.ai-result-header {
  padding: 12px 16px;
  display: flex; align-items: center; gap: 12px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.ai-signal {
  font-family: var(--mono); font-size: 13px; font-weight: 600;
  letter-spacing: 3px; padding: 4px 14px; border-radius: 2px; text-transform: uppercase;
}
.ai-signal.BUY  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.ai-signal.SELL { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.ai-signal.WAIT { background: var(--amber-dim); color: var(--amber); border: 1px solid rgba(240,160,80,0.4); }

.ai-confidence { font-family: var(--mono); font-size: 9px; color: var(--gray); margin-left: auto; }
.ai-conf-bar   { height: 3px; border-radius: 2px; background: var(--dark4); margin-top: 4px; overflow: hidden; }
.ai-conf-fill  { height: 100%; border-radius: 2px; transition: width 0.6s ease; }
.ai-conf-fill.BUY  { background: var(--green); }
.ai-conf-fill.SELL { background: var(--red); }
.ai-conf-fill.WAIT { background: var(--amber); }

.ai-result-body { padding: 14px 16px; background: var(--dark2); }
.ai-zones { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px; }
.ai-zone-card { background: var(--dark3); border-radius: var(--r); padding: 9px 12px; border: 1px solid rgba(255,255,255,0.05); }
.ai-zone-lbl  { font-family: var(--mono); font-size: 7px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 4px; }
.ai-zone-val  { font-family: var(--mono); font-size: 11px; }
.ai-zone-val.sup { color: var(--green); }
.ai-zone-val.res { color: var(--red); }

.ai-desc { font-family: var(--sans); font-size: 12px; color: var(--light); line-height: 1.7; }
.ai-desc-label { font-family: var(--mono); font-size: 7px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 6px; }

/* Apply signal button */
.ai-apply-btn {
  width: 100%; padding: 10px; margin-top: 12px;
  border: none; border-radius: var(--r); cursor: pointer;
  font-family: var(--mono); font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
  transition: all 0.2s; display: none;
}
.ai-apply-btn.BUY  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.ai-apply-btn.SELL { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.ai-apply-btn.show { display: block; }
.ai-apply-btn:hover { filter: brightness(1.2); }

/* Spinner */
.ai-spinner {
  width: 18px; height: 18px;
  border: 2px solid rgba(255,255,255,0.2);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
  display: none;
}
.ai-spinner.show { display: inline-block; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ══ AI MODE TOGGLE ══ */
.ai-mode-tabs {
  display: grid; grid-template-columns: 1fr 1fr; gap: 4px;
  background: var(--dark3); padding: 3px; border-radius: var(--r);
}
.ai-mode-tab {
  padding: 9px; text-align: center; cursor: pointer;
  font-family: var(--mono); font-size: 9px; letter-spacing: 2px; text-transform: uppercase;
  border-radius: 2px; border: 1px solid transparent; background: transparent;
  color: var(--gray); transition: all 0.2s;
}
.ai-mode-tab.active-tm   { background: var(--blue-dim); color: var(--blue); border-color: rgba(91,141,238,0.4); }
.ai-mode-tab.active-claude { background: var(--gold-dim); color: var(--gold); border-color: rgba(201,168,76,0.4); }
.ai-mode-tab:not(.active-tm):not(.active-claude):hover { color: var(--light); }

/* ══ TM SCOREBOARD ══ */
.tm-scoreboard {
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--r); overflow: hidden;
}
.tm-scoreboard-header {
  background: var(--dark3); padding: 8px 14px;
  font-family: var(--mono); font-size: 8px; letter-spacing: 3px;
  color: var(--gold); text-transform: uppercase; text-align: center;
}
.tm-score-row {
  padding: 9px 14px;
  border-bottom: 1px solid rgba(255,255,255,0.04);
  background: var(--dark2);
}
.tm-score-row:last-child { border-bottom: none; }
.tm-score-row.top-row    { background: rgba(255,255,255,0.02); }
.tm-score-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
.tm-score-name { font-family: var(--mono); font-size: 10px; color: var(--light); font-weight: 600; }
.tm-score-pct  { font-family: var(--mono); font-size: 11px; font-weight: 600; }
.tm-progress   { height: 6px; background: var(--dark4); border-radius: 3px; overflow: hidden; }
.tm-progress-fill { height: 100%; border-radius: 3px; transition: width 0.4s ease; }
.tm-empty {
  padding: 24px 14px; text-align: center;
  font-family: var(--mono); font-size: 9px; color: var(--gray); letter-spacing: 1px;
  background: var(--dark2);
}

/* ══ TM WEBCAM BTN ══ */
.tm-cam-btn {
  width: 100%; padding: 9px 14px;
  font-family: var(--mono); font-size: 9px; letter-spacing: 2px; text-transform: uppercase;
  background: var(--dark3); border: 1px solid rgba(255,255,255,0.1);
  color: var(--gray); border-radius: var(--r); cursor: pointer; transition: all 0.2s;
}
.tm-cam-btn:hover         { border-color: rgba(91,141,238,0.5); color: var(--blue); }
.tm-cam-btn.cam-running   { background: var(--red-dim); color: var(--red); border-color: rgba(224,80,80,0.4); }

/* ══ TM ACTION PANEL ══ */
.tm-action-panel {
  display: none;
  border-radius: var(--r); overflow: hidden;
  border: 1px solid rgba(255,255,255,0.07);
}
.tm-action-panel.show { display: block; }
.tm-action-header {
  padding: 10px 14px;
  font-family: var(--mono); font-size: 9px; letter-spacing: 3px; text-transform: uppercase;
  font-weight: 600; text-align: center;
}
.tm-action-panel.BUY  .tm-action-header { background: var(--green-dim); color: var(--green); border-bottom: 1px solid rgba(76,175,122,0.3); }
.tm-action-panel.SELL .tm-action-header { background: var(--red-dim);   color: var(--red);   border-bottom: 1px solid rgba(224,80,80,0.3); }

.tm-action-body {
  background: var(--dark2); padding: 14px;
  display: flex; flex-direction: column; gap: 10px;
}

/* Confidence bar inside action panel */
.tm-conf-row   { display: flex; justify-content: space-between; align-items: center; }
.tm-conf-label { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.tm-conf-val   { font-family: var(--mono); font-size: 10px; font-weight: 600; }
.tm-conf-bar   { height: 4px; background: var(--dark4); border-radius: 2px; overflow: hidden; margin-top: 3px; }
.tm-conf-fill  { height: 100%; border-radius: 2px; transition: width 0.5s ease; }
.tm-action-panel.BUY  .tm-conf-fill { background: var(--green); }
.tm-action-panel.SELL .tm-conf-fill { background: var(--red); }

/* Lot size row */
.tm-lot-row  { display: flex; align-items: center; gap: 6px; }
.tm-lot-label { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 4px; }
.tm-lot-btn  {
  width: 34px; height: 34px; flex-shrink: 0;
  background: var(--dark3); border: 1px solid rgba(255,255,255,0.1);
  color: var(--gold); font-size: 16px; border-radius: var(--r);
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: all 0.15s;
}
.tm-lot-btn:hover { background: var(--gold-dim); border-color: var(--gold); }
.tm-lot-input {
  flex: 1; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1);
  color: var(--white); font-family: var(--mono); font-size: 14px;
  padding: 7px 10px; border-radius: var(--r); outline: none; text-align: center;
  transition: border-color 0.2s;
}
.tm-lot-input:focus { border-color: var(--gold); }
.tm-quick-lots {
  display: grid; grid-template-columns: repeat(4,1fr); gap: 4px;
}
.tm-ql-btn {
  font-family: var(--mono); font-size: 8px; padding: 4px 0;
  background: var(--dark4); border: 1px solid rgba(255,255,255,0.07);
  color: var(--gray); cursor: pointer; border-radius: 2px; text-align: center;
  transition: all 0.15s;
}
.tm-ql-btn:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--gold); }

/* Order button */
.tm-order-btn {
  width: 100%; padding: 13px; border: none; border-radius: var(--r);
  font-family: var(--serif); font-size: 16px; font-weight: 600;
  letter-spacing: 4px; text-transform: uppercase; cursor: pointer;
  transition: all 0.2s; color: #fff;
}
.tm-order-btn.BUY  { background: linear-gradient(135deg,#1e5c38,#4caf7a); box-shadow: 0 4px 20px rgba(76,175,122,0.3); }
.tm-order-btn.SELL { background: linear-gradient(135deg,#6e1818,#e05050); box-shadow: 0 4px 20px rgba(224,80,80,0.3); }
.tm-order-btn:hover   { transform: translateY(-1px); filter: brightness(1.1); }
.tm-order-btn:active  { transform: none; }
.tm-order-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* threshold badge */
.tm-threshold-note {
  font-family: var(--mono); font-size: 8px; color: var(--gray);
  text-align: center; letter-spacing: 1px;
}

/* ══ AUTO SL/TP DISPLAY ══ */
.tm-sltp-box {
  background: var(--dark3);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--r);
  padding: 10px 12px;
  display: flex; flex-direction: column; gap: 5px;
}
.tm-sltp-title {
  font-family: var(--mono); font-size: 7px; letter-spacing: 3px;
  color: var(--gold); text-transform: uppercase; margin-bottom: 4px;
}
.tm-sltp-row {
  display: flex; justify-content: space-between; align-items: center;
}
.tm-sltp-lbl { font-family: var(--mono); font-size: 8px; color: var(--gray); letter-spacing: 1px; }
.tm-sltp-val { font-family: var(--mono); font-size: 10px; font-weight: 600; }
.tm-sltp-val.sl { color: var(--red); }
.tm-sltp-val.tp { color: var(--green); }
.tm-sltp-val.pip { color: var(--light); font-size: 9px; }
.tm-sltp-divider { height: 1px; background: rgba(255,255,255,0.05); margin: 2px 0; }
.tm-sltp-note {
  font-family: var(--mono); font-size: 7px; color: var(--gray2);
  letter-spacing: 1px; text-align: center; margin-top: 2px;
}

/* editable SL/TP $ inputs */
.tm-sltp-edit-row {
  display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-top: 4px;
}
.tm-sltp-edit-group { display: flex; flex-direction: column; gap: 3px; }
.tm-sltp-edit-lbl { font-family: var(--mono); font-size: 7px; letter-spacing: 2px; text-transform: uppercase; }
.tm-sltp-edit-lbl.sl { color: var(--red); }
.tm-sltp-edit-lbl.tp { color: var(--green); }
.tm-sltp-input {
  width: 100%; background: var(--dark4); border: 1px solid rgba(255,255,255,0.1);
  color: var(--white); font-family: var(--mono); font-size: 12px;
  padding: 5px 8px; border-radius: 2px; outline: none; text-align: center;
  transition: border-color 0.2s;
}
.tm-sltp-input.sl:focus { border-color: var(--red); }
.tm-sltp-input.tp:focus { border-color: var(--green); }

</style>

<!-- ══ TOPBAR ══ -->
<header class="topbar">
  <div class="brand">
    BIBarahctap
    <span class="brand-sub">MT5 TRADING DESK</span>
  </div>
  <div class="d-flex align-items-center gap-3">
    <span style="font-family:var(--mono);font-size:9px;color:var(--gray)" id="account-info">—</span>
    <span class="live-dot">LIVE</span>
  </div>
</header>

<!-- ══ TICKER BAR ══ -->
<div class="ticker-bar" id="ticker-bar">

  <div class="sym-tile active" data-sym="XAUUSD" data-active-class="active">
    <div class="st-row1"><span class="st-name">XAU/USD</span><span class="st-badge gold">GOLD</span></div>
    <span class="st-price" id="tp-XAUUSD">—</span>
    <div class="st-sub"><span class="st-chg" id="tc-XAUUSD">—</span><span class="st-spread" id="ts-XAUUSD">spd —</span></div>
  </div>

  <div class="sym-tile" data-sym="XAGUSD" data-active-class="active">
    <div class="st-row1"><span class="st-name">XAG/USD</span><span class="st-badge silver">SILVER</span></div>
    <span class="st-price" id="tp-XAGUSD">—</span>
    <div class="st-sub"><span class="st-chg" id="tc-XAGUSD">—</span><span class="st-spread" id="ts-XAGUSD">spd —</span></div>
  </div>

  <div class="sym-tile" data-sym="BTCUSD" data-active-class="active-btc">
    <div class="st-row1"><span class="st-name">BTC/USD</span><span class="st-badge btc">CRYPTO</span></div>
    <span class="st-price" id="tp-BTCUSD">—</span>
    <div class="st-sub"><span class="st-chg" id="tc-BTCUSD">—</span><span class="st-spread" id="ts-BTCUSD">spd —</span></div>
  </div>

  <div class="sym-tile" data-sym="ETHUSD" data-active-class="active-eth">
    <div class="st-row1"><span class="st-name">ETH/USD</span><span class="st-badge eth">CRYPTO</span></div>
    <span class="st-price" id="tp-ETHUSD">—</span>
    <div class="st-sub"><span class="st-chg" id="tc-ETHUSD">—</span><span class="st-spread" id="ts-ETHUSD">spd —</span></div>
  </div>

  <div class="sym-tile" data-sym="XAUEUR" data-active-class="active">
    <div class="st-row1"><span class="st-name">XAU/EUR</span><span class="st-badge gold">GOLD</span></div>
    <span class="st-price" id="tp-XAUEUR">—</span>
    <div class="st-sub"><span class="st-chg" id="tc-XAUEUR">—</span><span class="st-spread" id="ts-XAUEUR">spd —</span></div>
  </div>

</div>

<!-- ══════════════════════════════════════════════
     MAIN — Bootstrap container › row › col
══════════════════════════════════════════════ -->
<div class="container-fluid py-3" style="background:var(--black)">
  <div class="row justify-content-center gx-3">

    <!-- ╔══════════════════════════════════════╗
         ║  CENTER-LEFT  (chart + queue/pos)   ║
         ╚══════════════════════════════════════╝ -->
    <div class="col-12 col-xl-8 d-flex flex-column gap-3">

      <!-- Chart Panel -->
      <div class="panel-card">
        <div class="chart-toolbar">
          <span style="font-family:var(--mono);font-size:8px;letter-spacing:2px;color:var(--gray)">CHART</span>
          <select id="chart-sym" class="chart-sym-select" >
            <option value="XAUUSD">XAU/USD</option>
            <option value="BTCUSD" selected>BTC/USD</option>
            <option value="ETHUSD">ETH/USD</option>
            <option value="XAGUSD">XAG/USD</option>
          </select>
          <span class="chart-tf-badge">M15</span>
          <span class="chart-status" id="chart-status">Loading...</span>
          <span class="chart-ohlc"   id="chart-ohlc"></span>
        </div>
        <div id="main-chart"></div>
      </div>

      <!-- Queue / Positions Panel -->
      <div class="panel-card">
        <div class="tab-bar">
          <button class="tab-item active" data-tab="queue">Order Queue</button>
          <button class="tab-item"        data-tab="pos">Positions</button>
          <div class="tab-actions">
            <button class="refresh-btn" onclick="refreshAll()">↺ REFRESH</button>
          </div>
        </div>

        <!-- Queue -->
        <div class="tab-content active" id="tab-queue" style="max-height:280px;overflow-y:auto">
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

        <!-- Positions -->
        <div class="tab-content" id="tab-pos" style="max-height:340px;overflow-y:auto">
          <!-- Bulk Close Controls -->
          <div class="close-bar">
            <span class="close-bar-lbl">⚡ Close :</span>
            <button class="cc-btn all"
              onclick="cfmShow('❌ Close ALL Positions','ปิด positions ทั้งหมดทันที\nEA จะ execute ภายใน 2 วินาที',()=>bulkClose('close_all'))">
              ✕ ALL
            </button>
            <button class="cc-btn buy"
              onclick="cfmShow('📈 Close All BUY','ปิด BUY positions ทั้งหมด',()=>bulkClose('close_all_buy'))">
              ✕ ALL BUY
            </button>
            <button class="cc-btn sell"
              onclick="cfmShow('📉 Close All SELL','ปิด SELL positions ทั้งหมด',()=>bulkClose('close_all_sell'))">
              ✕ ALL SELL
            </button>
          </div>
          <div class="tbl-wrap">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Ticket</th><th>Symbol</th><th>Type</th><th>Volume</th>
                  <th>Open</th><th>Current</th><th>P&amp;L</th>
                  <th>SL</th><th>TP</th><th>Close</th>
                </tr>
              </thead>
              <tbody id="pos-tbody"><tr class="loading-row"><td colspan="10">LOADING...</td></tr></tbody>
            </table>
          </div>
        </div>
      </div>

    </div><!-- /col left -->

    <!-- ╔══════════════════════════════════════╗
         ║  RIGHT  (New Order form)             ║
         ╚══════════════════════════════════════╝ -->
    <div class="col-12 col-xl-4" style="max-width:360px">
      <div class="panel-card h-100">
        <aside class="order-panel">

          <div class="sec-label">New Order</div>

          <!-- Symbol Display -->
          <input type="hidden" id="symbol-select" value="XAUUSD">
          <div class="sym-display" id="sym-display">
            <div class="sd-left">
              <span class="sd-sym"  id="sd-sym">XAUUSD</span>
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
            <div class="ba-card"><div class="ba-lbl">BID</div><div class="ba-val bid" id="bid-val">—</div></div>
            <div class="ba-card"><div class="ba-lbl">ASK</div><div class="ba-val ask" id="ask-val">—</div></div>
          </div>
          <div class="spread-line">SPREAD <span id="spread-val">—</span> pts</div>

          <!-- Order Type -->
          <div class="field">
            <span class="field-label">Order Type</span>
            <select class="field-input" id="order-type" onchange="togglePrice()">
              <option value="market">Market Order</option>
              <option value="limit">Limit Order</option>
              <option value="stop">Stop Order</option>
            </select>
          </div>

          <!-- Pending Price -->
          <div class="field" id="price-group" style="display:none">
            <span class="field-label">Price</span>
            <input type="number" class="field-input" id="pending-price" placeholder="0.00" step="0.01">
          </div>

          <!-- Volume -->
          <div class="field">
            <span class="field-label">Volume (Lots)</span>
            <div class="lot-row">
              <button class="lot-btn" onclick="adjLot(-0.01)">−</button>
              <input type="number" class="field-input" id="lot-input" value="0.01" step="0.01" min="0.01" max="100" oninput="updateMargin()">
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

          <!-- Stop Loss -->
          <div class="sltp-row">
            <span class="sltp-label">Stop Loss</span>
            <label class="toggle"><input type="checkbox" id="sl-toggle" onchange="toggleSL()"><span class="toggle-track"></span></label>
          </div>
          <div id="sl-group" style="display:none">
            <input type="number" class="field-input" id="sl-price" placeholder="SL Price" step="0.01" style="margin-top:6px">
          </div>

          <!-- Take Profit -->
          <div class="sltp-row">
            <span class="sltp-label">Take Profit</span>
            <label class="toggle"><input type="checkbox" id="tp-toggle" onchange="toggleTP()"><span class="toggle-track"></span></label>
          </div>
          <div id="tp-group" style="display:none">
            <input type="number" class="field-input" id="tp-price" placeholder="TP Price" step="0.01" style="margin-top:6px">
          </div>

          <div class="divider"></div>

          <!-- Submit -->
          <button class="submit-btn buy" id="submit-btn" onclick="placeOrder()">BUY XAUUSD</button>

          <!-- AI Analysis Button -->
          <button class="ai-trade-btn" id="ai-trade-btn" onclick="openAiModal()">
            <span class="ai-btn-icon">◈</span>
            <span class="ai-btn-text">TRADE BY AI</span>
            <span class="ai-btn-sub">Upload chart → AI Analysis</span>
          </button>

          <!-- Margin Info -->
          <div class="margin-box">
            <div class="margin-row"><span class="m-lbl">Required Margin</span><span class="m-val gold" id="req-margin">—</span></div>
            <div class="margin-row"><span class="m-lbl">Pip Value</span>      <span class="m-val"      id="pip-val">—</span></div>
            <div class="margin-row"><span class="m-lbl">Free Margin</span>    <span class="m-val"      id="free-margin">—</span></div>
            <div class="margin-row"><span class="m-lbl">Margin Level</span>   <span class="m-val gold" id="margin-level">—</span></div>
          </div>

        </aside>
      </div>
    </div><!-- /col right -->

  </div><!-- /row -->
</div><!-- /container-fluid -->


<!-- ══ AI TRADE MODAL ══ -->
<div class="ai-modal-backdrop" id="ai-modal-backdrop" onclick="closeAiModalOutside(event)">
  <div class="ai-modal" id="ai-modal" style="max-width:580px;max-height:90vh;overflow-y:auto">

    <div class="ai-modal-header">
      <div>
        <div class="ai-modal-title">◈ AI Chart Analysis</div>
        <div class="ai-modal-sub" id="ai-modal-sub">SELECT MODE → UPLOAD CHART → GET TRADE SIGNAL</div>
      </div>
      <button class="ai-modal-close" onclick="closeAiModal()">✕</button>
    </div>

    <div class="ai-modal-body">

      <!-- ══ MODE TOGGLE ══ -->
      <div class="ai-mode-tabs">
        <button id="mode-tab-tm"     class="ai-mode-tab active-tm"  onclick="switchAiMode('tm')">🤖 TM Model</button>
        <button id="mode-tab-claude" class="ai-mode-tab"            onclick="switchAiMode('claude')">◈ Claude AI</button>
      </div>

      <!-- ══════════════════════════════
           TM MODE
      ══════════════════════════════ -->
      <div id="ai-mode-tm">

        <!-- TM Scoreboard -->
        <div id="tm-scoreboard-wrap" class="tm-scoreboard">
          <div class="tm-scoreboard-header">🏆 TM SCOREBOARD</div>
          <div class="tm-empty">📊 Upload Image / Start Camera</div>
        </div>

        <!-- TM Action Panel (shown when UP>80% or DOWN>80%) -->
        <div class="tm-action-panel" id="tm-action-panel">

          <div class="tm-action-header" id="tm-action-header">— SIGNAL —</div>

          <div class="tm-action-body">

            <!-- Confidence -->
            <div>
              <div class="tm-conf-row">
                <span class="tm-conf-label">Confidence</span>
                <span class="tm-conf-val" id="tm-conf-val">—</span>
              </div>
              <div class="tm-conf-bar">
                <div class="tm-conf-fill" id="tm-conf-fill" style="width:0%"></div>
              </div>
            </div>

            <!-- Lot Size -->
            <div>
              <div class="tm-lot-label">Volume (Lots)</div>
              <div class="tm-lot-row">
                <button class="tm-lot-btn" onclick="adjTmLot(-0.01)">−</button>
                <input type="number" class="tm-lot-input" id="tm-lot-input" value="0.01" step="0.01" min="0.01" max="100" oninput="recalcTmSlTp()">
                <button class="tm-lot-btn" onclick="adjTmLot(+0.01)">+</button>
              </div>
              <div class="tm-quick-lots" style="margin-top:6px">
                <button class="tm-ql-btn" onclick="setTmLot(0.01)">0.01</button>
                <button class="tm-ql-btn" onclick="setTmLot(0.10)">0.10</button>
                <button class="tm-ql-btn" onclick="setTmLot(0.50)">0.50</button>
                <button class="tm-ql-btn" onclick="setTmLot(1.00)">1.00</button>
              </div>
            </div>

            <!-- Order Button -->
            <button class="tm-order-btn" id="tm-order-btn" onclick="executeTmOrder()">— ORDER —</button>

            <!-- Auto SL / TP -->
            <div class="tm-sltp-box">
              <div class="tm-sltp-title">⚙ Auto SL / TP</div>

              <!-- Editable $ targets -->
              <div class="tm-sltp-edit-row">
                <div class="tm-sltp-edit-group">
                  <span class="tm-sltp-edit-lbl sl">Stop Loss ($)</span>
                  <input type="number" class="tm-sltp-input sl" id="tm-sl-usd" value="5" min="0.1" step="0.5" oninput="recalcTmSlTp()">
                </div>
                <div class="tm-sltp-edit-group">
                  <span class="tm-sltp-edit-lbl tp">Take Profit ($)</span>
                  <input type="number" class="tm-sltp-input tp" id="tm-tp-usd" value="12" min="0.1" step="0.5" oninput="recalcTmSlTp()">
                </div>
              </div>

              <div class="tm-sltp-divider"></div>

              <!-- Calculated pip distances -->
              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">SL distance</span>
                <span class="tm-sltp-val sl" id="tm-sl-pips">— pips</span>
              </div>
              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">SL price</span>
                <span class="tm-sltp-val sl" id="tm-sl-price">—</span>
              </div>

              <div class="tm-sltp-divider"></div>

              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">TP distance</span>
                <span class="tm-sltp-val tp" id="tm-tp-pips">— pips</span>
              </div>
              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">TP price</span>
                <span class="tm-sltp-val tp" id="tm-tp-price">—</span>
              </div>

              <div class="tm-sltp-divider"></div>

              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">$ per pip</span>
                <span class="tm-sltp-val pip" id="tm-pip-val">—</span>
              </div>
              <div class="tm-sltp-row">
                <span class="tm-sltp-lbl">R:R ratio</span>
                <span class="tm-sltp-val pip" id="tm-rr-ratio">—</span>
              </div>

              <div class="tm-sltp-note" id="tm-sltp-note">ปรับ lot → คำนวณใหม่อัตโนมัติ</div>
            </div>

            <div class="tm-threshold-note">⚡ Auto-shown when signal ≥ 80% confidence</div>

          </div>
        </div>

        <!-- TM Upload Zone -->
        <div id="tm-upload-zone" class="upload-zone"
             ondragover="event.preventDefault();this.classList.add('drag')"
             ondragleave="this.classList.remove('drag')"
             ondrop="handleTmDrop(event)">
          <input type="file" id="tm-file-input" accept="image/*">
          <div class="upload-icon">📊</div>
          <div class="upload-text">DROP CHART IMAGE HERE</div>
          <div class="upload-hint">TM Model · PNG, JPG, WEBP</div>
        </div>

        <!-- TM Preview -->
        <div id="tm-preview-wrap" style="display:none;position:relative">
          <img id="tm-preview-img" style="width:100%;border-radius:4px;border:1px solid rgba(255,255,255,0.08);max-height:200px;object-fit:cover">
          <button class="preview-clear" onclick="clearTmImage()">✕</button>
        </div>

        <!-- TM Webcam -->
        <div style="display:flex;gap:8px;align-items:center">
          <button id="tm-cam-btn" class="tm-cam-btn" onclick="toggleTmWebcam()">📷 Start Camera</button>
        </div>
        <div id="tm-webcam-container" style="display:flex;justify-content:center"></div>

      </div><!-- /tm mode -->

      <!-- ══════════════════════════════
           CLAUDE MODE
      ══════════════════════════════ -->
      <div id="ai-mode-claude" style="display:none;flex-direction:column;gap:16px">

        <!-- Upload Zone (Claude) -->
        <div id="ai-upload-zone" class="upload-zone"
             ondragover="event.preventDefault();this.classList.add('drag')"
             ondragleave="this.classList.remove('drag')"
             ondrop="handleAiDrop(event)">
          <input type="file" id="ai-file-input" accept="image/*">
          <div class="upload-icon">📈</div>
          <div class="upload-text">DROP CHART IMAGE HERE</div>
          <div class="upload-hint">Claude Vision · PNG, JPG, WEBP</div>
        </div>

        <!-- Claude Preview -->
        <div id="ai-preview-wrap" style="display:none;position:relative">
          <img id="ai-preview-img" src="" alt="chart preview" style="width:100%;border-radius:4px;border:1px solid rgba(255,255,255,0.08);max-height:220px;object-fit:cover">
          <button class="preview-clear" onclick="clearAiImage()">✕</button>
        </div>

        <!-- Optional prompt -->
        <div class="ai-prompt-row">
          <span class="ai-prompt-label">Additional Context (Optional)</span>
          <textarea class="ai-prompt-input" id="ai-prompt" rows="2"
            placeholder="e.g. This is XAUUSD M15, looking for breakout opportunity..."></textarea>
        </div>

        <!-- Analyse button -->
        <button class="ai-analyse-btn" id="ai-analyse-btn" onclick="runAiAnalysis()" disabled>
          <div class="ai-spinner" id="ai-spinner"></div>
          <span id="ai-btn-label">◈ ANALYSE CHART</span>
        </button>

        <!-- Claude Result -->
        <div class="ai-result" id="ai-result">
          <div class="ai-result-header">
            <span class="ai-signal" id="ai-signal-badge">—</span>
            <div class="ai-confidence">
              <div id="ai-conf-text">Confidence —</div>
              <div class="ai-conf-bar"><div class="ai-conf-fill" id="ai-conf-fill" style="width:0%"></div></div>
            </div>
          </div>
          <div class="ai-result-body">
            <div class="ai-zones">
              <div class="ai-zone-card">
                <div class="ai-zone-lbl">⬆ แนวต้าน (Resistance)</div>
                <div class="ai-zone-val res" id="ai-resistance">—</div>
              </div>
              <div class="ai-zone-card">
                <div class="ai-zone-lbl">⬇ แนวรับ (Support)</div>
                <div class="ai-zone-val sup" id="ai-support">—</div>
              </div>
            </div>
            <div class="ai-desc-label">การวิเคราะห์</div>
            <div class="ai-desc" id="ai-description">—</div>
            <button class="ai-apply-btn" id="ai-apply-btn" onclick="applyAiSignal()">
              ↗ APPLY SIGNAL TO ORDER FORM
            </button>
          </div>
        </div>

      </div><!-- /claude mode -->

    </div><!-- /body -->
  </div><!-- /modal -->
</div>

<!-- ══ DEBUG PANEL ══ -->
<div id="debug-panel" style="
  position:fixed;bottom:0;left:0;right:0;
  height:220px;
  background:#0a0a0a;
  border-top:1px solid rgba(201,168,76,0.3);
  z-index:8000;
  display:none;
  flex-direction:column;
  font-family:'JetBrains Mono',monospace;
">
  <div style="display:flex;align-items:center;gap:12px;padding:6px 16px;background:#111;border-bottom:1px solid #222;flex-shrink:0">
    <span style="font-size:9px;letter-spacing:3px;color:#C9A84C;text-transform:uppercase">Debug Console</span>
    <button onclick="$('#dbg-body').empty();dbgCount=0;$('#dbg-count').text('0')"
      style="font-family:inherit;font-size:8px;background:transparent;border:1px solid #333;color:#555;padding:2px 10px;border-radius:2px;cursor:pointer;margin-left:auto">CLEAR</button>
    <span id="dbg-count" style="font-size:8px;color:#555">0</span>
    <span style="font-size:8px;color:#555">entries</span>
    <button onclick="toggleDebug()"
      style="font-family:inherit;font-size:8px;background:transparent;border:1px solid #333;color:#555;padding:2px 10px;border-radius:2px;cursor:pointer">CLOSE ✕</button>
  </div>
  <div id="dbg-body" style="flex:1;overflow-y:auto;padding:8px 0"></div>
</div>

<!-- Debug toggle button (fixed bottom-right) -->
<!-- <button id="debug-btn" onclick="toggleDebug()" style="
  position:fixed;bottom:20px;left:20px;
  font-family:'JetBrains Mono',monospace;
  font-size:8px;letter-spacing:2px;
  background:#111;border:1px solid rgba(201,168,76,0.3);
  color:#C9A84C;padding:6px 14px;border-radius:2px;
  cursor:pointer;z-index:8001;
  transition:all .2s;
">⬡ DEBUG</button> -->

<!-- ══ CONFIRM MODAL ══ -->
<div class="cfm-backdrop" id="cfm-backdrop">
  <div class="cfm-box">
    <div class="cfm-title" id="cfm-title">Confirm</div>
    <div class="cfm-msg"   id="cfm-msg">ยืนยันการดำเนินการ?</div>
    <div class="cfm-btns">
      <button class="cfm-no"  onclick="cfmCancel()">Cancel</button>
      <button class="cfm-yes" onclick="cfmProceed()">Confirm</button>
    </div>
  </div>
</div>

<div id="toast"><div id="toast-title">NOTICE</div><div id="toast-msg">—</div></div>

<script src="<?=base_url();?>asset/mt5_api.js"></script>
<script>
// ══════════════════════════════════════════════════
//  CONFIG
// ══════════════════════════════════════════════════
const BASE_URL   = window.location.origin;
const API        = BASE_URL + '/api/mt5';
const CSRF_NAME  = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_token';
// Always read the LIVE hash from meta — CI4 rotates it after every POST
function getCsrfHash() {
  return $('meta[name="csrf-token"]').attr('content') || '';
}

const SYMBOLS = {
  XAUUSD: { desc:'Gold vs US Dollar',     contract:100,  leverage:500, pip:0.01,  decimals:2 },
  XAGUSD: { desc:'Silver vs US Dollar',   contract:5000, leverage:500, pip:0.001, decimals:3 },
  XAUEUR: { desc:'Gold vs Euro',          contract:100,  leverage:500, pip:0.01,  decimals:2 },
  BTCUSD: { desc:'Bitcoin vs US Dollar',  contract:1,    leverage:100, pip:1,     decimals:2 },
  ETHUSD: { desc:'Ethereum vs US Dollar', contract:1,    leverage:100, pip:0.1,   decimals:2 },
};

const prevPrices = {};
let curSym       = 'XAUUSD';
let curDir       = 'buy';
let curPrices    = {};
let activeFilter = 'all';
let allLogLines  = [];

// ══════════════════════════════════════════════════
//  TOAST
// ══════════════════════════════════════════════════
function toast(title, msg, type='') {
  $('#toast-title').text(title);
  $('#toast-msg').text(msg);
  $('#toast').attr('class', 'show ' + type);
  clearTimeout(window._tt);
  window._tt = setTimeout(() => $('#toast').attr('class',''), 4000);
}

// ══════════════════════════════════════════════════
//  SYMBOL PICKER  — single source of truth
// ══════════════════════════════════════════════════
function syncSymbol(sym, reloadChart) {
  if (!sym) return;
  console.log('[syncSymbol] sym=', sym, 'reloadChart=', reloadChart);
  curSym = sym;                          // ← THE only place curSym is written
  $('#symbol-select').val(sym);          // keep mt5_api.js in sync

  // 1. highlight correct ticker tile
  $('.sym-tile').removeClass('active active-btc active-eth');
  const $tile = $('.sym-tile[data-sym="' + sym + '"]');
  if ($tile.length) $tile.addClass($tile.attr('data-active-class') || 'active');

  // 2. sync chart dropdown (without re-triggering change event)
  const $cs = $('#chart-sym');
  if ($cs.find('option[value="' + sym + '"]').length) $cs.val(sym);

  // 3. order panel labels
  const meta = SYMBOLS[sym] || {};
  $('#sd-sym').text(sym);
  $('#sd-desc').text(meta.desc || sym);
  $('#submit-btn').text(curDir.toUpperCase() + ' ' + sym);

  refreshBidAsk();
  updateMargin();

  if (reloadChart) loadCandles();
}

function refreshBidAsk() {
  const p = curPrices[curSym];
  if (!p) { $('#bid-val,#ask-val,#spread-val,#sd-price').text('—'); return; }
  const meta   = SYMBOLS[curSym] || { pip:0.01, decimals:2 };
  const dec    = meta.decimals;
  const bid    = parseFloat(p.bid).toFixed(dec);
  const ask    = parseFloat(p.ask).toFixed(dec);
  const spread = ((p.ask - p.bid) / meta.pip).toFixed(1);
  const mid    = ((parseFloat(p.bid) + parseFloat(p.ask)) / 2).toFixed(dec);
  $('#bid-val').text(bid);
  $('#ask-val').text(ask);
  $('#spread-val').text(spread);
  $('#sd-price').text(mid);
}

// ══════════════════════════════════════════════════
//  FETCH PRICES
// ══════════════════════════════════════════════════
function fetchPrices() {
  $.getJSON(API + '/prices_raw').done(res => {
    curPrices = res;
    Object.keys(SYMBOLS).forEach(sym => {
      const p = res[sym];
      if (!p) return;
      const meta = SYMBOLS[sym];
      const dec  = meta.decimals;
      const bid  = parseFloat(p.bid);
      const ask  = parseFloat(p.ask);
      const mid  = ((bid + ask) / 2).toFixed(dec);
      const spd  = ((ask - bid) / meta.pip).toFixed(1);
      $(`#tp-${sym}`).text(mid);
      $(`#ts-${sym}`).text('spd ' + spd);
      if (prevPrices[sym] !== undefined) {
        const pct  = ((bid - prevPrices[sym]) / prevPrices[sym] * 100).toFixed(2);
        $(`#tc-${sym}`).text((pct >= 0 ? '+' : '') + pct + '%')
                       .attr('class', 'st-chg ' + (pct >= 0 ? 'up' : 'dn'));
      }
      prevPrices[sym] = bid;
    });
    refreshBidAsk();
    updateMargin();
  });

  $.ajax({
    url: API + '/account', method: 'GET', dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => {
    if (!res.success) return;
    const a = res.account;
    $('#free-margin').text(a.free_margin
      ? '$' + parseFloat(a.free_margin).toLocaleString('en-US',{minimumFractionDigits:2}) : '—');
    $('#margin-level').text(a.margin_level ? a.margin_level + '%' : '—');
    if (a.balance) {
      $('#account-info').text(
        'Balance: $' + parseFloat(a.balance).toLocaleString('en-US',{minimumFractionDigits:2}) +
        '  Equity: $' + parseFloat(a.equity||0).toLocaleString('en-US',{minimumFractionDigits:2})
      );
    }
  });
}

// ══════════════════════════════════════════════════
//  MARGIN CALC
// ══════════════════════════════════════════════════
function updateMargin() {
  const meta   = SYMBOLS[curSym] || { contract:100, leverage:500, pip:0.01 };
  const vol    = parseFloat($('#lot-input').val()) || 0.01;
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
    const $tb   = $('#queue-tbody').empty();
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
//  LOAD POSITIONS
// ══════════════════════════════════════════════════
function loadPositions() {
  $.ajax({
    url: API + '/positions', method: 'GET', dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => {
    const $tb  = $('#pos-tbody').empty();
    const list = res.positions || [];
    if (!list.length) {
      $tb.html('<tr class="loading-row"><td colspan="10">NO OPEN POSITIONS</td></tr>');
      $('.cc-btn').prop('disabled', true);
      return;
    }
    $('.cc-btn').prop('disabled', false);
    list.forEach(p => {
      const pnl    = parseFloat(p.profit || 0);
      const pnlCol = pnl >= 0 ? 'var(--green)' : 'var(--red)';
      const pnlStr = (pnl >= 0 ? '+' : '') + '$' + Math.abs(pnl).toFixed(2);
      const sym    = p.symbol || '';
      const dec    = (SYMBOLS[sym] || {decimals:2}).decimals;
      $tb.append(`
        <tr class="fade-in" id="posrow-${p.ticket}">
          <td style="color:var(--gold)">#${p.ticket}</td>
          <td class="${symColorClass(sym)}">${sym}</td>
          <td><span class="tag ${p.type.toLowerCase()}">${p.type}</span></td>
          <td>${parseFloat(p.volume).toFixed(2)}</td>
          <td>${parseFloat(p.open_price).toFixed(dec)}</td>
          <td>${parseFloat(p.current).toFixed(dec)}</td>
          <td style="color:${pnlCol};font-weight:500">${pnlStr}</td>
          <td style="color:var(--red);font-size:9px">${p.sl > 0 ? parseFloat(p.sl).toFixed(dec) : '—'}</td>
          <td style="color:var(--green);font-size:9px">${p.tp > 0 ? parseFloat(p.tp).toFixed(dec) : '—'}</td>
          <td>
            <button class="close-row-btn"
              onclick="cfmShow('Close #${p.ticket}','${p.type}  ${parseFloat(p.volume).toFixed(2)} lots  ${sym}\\nยืนยันปิด position นี้?',()=>closeOne(${p.ticket}))">
              CLOSE
            </button>
          </td>
        </tr>`);
    });
  });
}

// ══════════════════════════════════════════════════
//  PLACE ORDER — delegated to mt5_api.js
//  mt5_api.js reads: #symbol-select, #order-type,
//  #lot-input, #pending-price, #sl-toggle, #sl-price,
//  #tp-toggle, #tp-price
// ══════════════════════════════════════════════════
function placeOrder() {
  // Sync curSym → #symbol-select before mt5_api.js reads it
  $('#symbol-select').val(curSym);
  console.log('[placeOrder] delegating to MT5Api, curSym=', curSym,
    'order-type=', $('#order-type').val(),
    'lot=', $('#lot-input').val());
  MT5Api.placeOrder();
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
  const show = $('#order-type').val() !== 'market';
  $('#price-group').toggle(show);
  if (show) {
    const p   = curPrices[curSym];
    const dec = (SYMBOLS[curSym]||{decimals:2}).decimals;
    $('#pending-price').val(p ? (curDir==='buy' ? p.ask : p.bid).toFixed(dec) : '');
  }
}

function toggleSL() {
  const show = $('#sl-toggle').is(':checked');
  $('#sl-group').toggle(show);
  if (show) {
    const p      = curPrices[curSym];
    const dec    = (SYMBOLS[curSym]||{decimals:2}).decimals;
    const ref    = p ? (curDir==='buy' ? parseFloat(p.bid) : parseFloat(p.ask)) : 2384;
    const offset = curSym.includes('BTC') ? 500 : curSym.includes('ETH') ? 50 : 20;
    $('#sl-price').val((curDir==='buy' ? ref - offset : ref + offset).toFixed(dec));
  }
}

function toggleTP() {
  const show = $('#tp-toggle').is(':checked');
  $('#tp-group').toggle(show);
  if (show) {
    const p      = curPrices[curSym];
    const dec    = (SYMBOLS[curSym]||{decimals:2}).decimals;
    const ref    = p ? (curDir==='buy' ? parseFloat(p.ask) : parseFloat(p.bid)) : 2384;
    const offset = curSym.includes('BTC') ? 1000 : curSym.includes('ETH') ? 100 : 30;
    $('#tp-price').val((curDir==='buy' ? ref + offset : ref - offset).toFixed(dec));
  }
}

function adjLot(d) {
  let v = Math.round((parseFloat($('#lot-input').val()) + d) * 100) / 100;
  if (v < 0.01) v = 0.01;
  if (v > 100)  v = 100;
  $('#lot-input').val(v.toFixed(2));
  updateMargin();
}

function setLot(v) { $('#lot-input').val(v.toFixed(2)); updateMargin(); }

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
  if (name === 'pos')   loadPositions();
  if (name === 'queue') loadQueue();
});

// ══════════════════════════════════════════════════
//  CONFIRM MODAL
// ══════════════════════════════════════════════════
let _cfmAction = null;

function cfmShow(title, msg, action) {
  _cfmAction = action;
  $('#cfm-title').text(title);
  $('#cfm-msg').text(msg);
  $('#cfm-backdrop').addClass('open');
}
function cfmCancel() {
  _cfmAction = null;
  $('#cfm-backdrop').removeClass('open');
}
function cfmProceed() {
  $('#cfm-backdrop').removeClass('open');
  if (typeof _cfmAction === 'function') _cfmAction();
  _cfmAction = null;
}
$(document).on('click', '#cfm-backdrop', e => { if (e.target.id === 'cfm-backdrop') cfmCancel(); });


// ══════════════════════════════════════════════════
//  CLOSE SINGLE POSITION
// ══════════════════════════════════════════════════
function closeOne(ticket) {
  const csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_token';
  const csrfHash = $('meta[name="csrf-token"]').attr('content') || '';
  $.ajax({
    url: API + '/close', method: 'POST', dataType: 'json', contentType: 'application/json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    data: JSON.stringify({ ticket: String(ticket), [csrfName]: csrfHash })
  }).done(res => {
    if (res.success) {
      toast('CLOSE QUEUED', `#${ticket} — EA กำลัง close...`, 'success');
      $(`#posrow-${ticket}`).fadeOut(300, () => loadPositions());
    } else {
      toast('CLOSE FAILED', res.error || res.message || 'Error', 'error');
    }
  }).fail(err => toast('ERROR', err.statusText || 'Request failed', 'error'));
}


// ══════════════════════════════════════════════════
//  BULK CLOSE  (close_all / close_all_buy / close_all_sell)
// ══════════════════════════════════════════════════
function bulkClose(endpoint) {
  const csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_token';
  const csrfHash = $('meta[name="csrf-token"]').attr('content') || '';
  const labels   = { close_all:'CLOSE ALL', close_all_buy:'CLOSE ALL BUY', close_all_sell:'CLOSE ALL SELL' };
  $.ajax({
    url: API + '/' + endpoint, method: 'POST', dataType: 'json', contentType: 'application/json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    data: JSON.stringify({ [csrfName]: csrfHash })
  }).done(res => {
    if (res.success) {
      toast(labels[endpoint] || endpoint.toUpperCase(), 'Queued → EA จะ execute ภายใน 2s', 'success');
      setTimeout(loadPositions, 3000);
    } else {
      toast('FAILED', res.message || res.error || 'Error', 'error');
    }
  }).fail(err => toast('ERROR', err.statusText || 'Request failed', 'error'));
}


function refreshAll() {
  fetchPrices();
  loadQueue();
  initChart();
  loadCandles();
  loadPositions();
  toast('REFRESHED', 'Data updated', 'success');
}

// ══════════════════════════════════════════════════
//  CHART — Lightweight Charts
// ══════════════════════════════════════════════════
let lwChart      = null;
let candleSeries = null;
let chartInited  = false;

function initChart() {
  if (chartInited) return;
  const container = document.getElementById('main-chart');
  if (!container || typeof LightweightCharts === 'undefined') return;

  lwChart = LightweightCharts.createChart(container, {
    layout:  { background: { color: '#101010' }, textColor: '#666' },
    grid:    { vertLines: { color: '#1a1a1a' }, horzLines: { color: '#1a1a1a' } },
    crosshair: { mode: LightweightCharts.CrosshairMode.Normal },
    rightPriceScale: { borderColor: '#222', textColor: '#666' },
    timeScale: { borderColor: '#222', timeVisible: true, secondsVisible: false, rightOffset: 5 },
    width:  container.clientWidth,
    height: container.clientHeight || 300,
  });

  candleSeries = lwChart.addCandlestickSeries({
    upColor: '#4caf7a', downColor: '#e05050',
    borderUpColor: '#4caf7a', borderDownColor: '#e05050',
    wickUpColor:   '#4caf7a', wickDownColor:   '#e05050',
  });

  lwChart.subscribeCrosshairMove(param => {
    if (!param.time || !candleSeries) return;
    const d = param.seriesData.get(candleSeries);
    if (!d) return;
    const clr = d.close >= d.open ? 'var(--green)' : 'var(--red)';
    $('#chart-ohlc').html(
      '<span style="color:var(--gray)">O</span> ' + d.open.toFixed(2) + '  ' +
      '<span style="color:#4caf7a">H</span> '     + d.high.toFixed(2) + '  ' +
      '<span style="color:#e05050">L</span> '     + d.low.toFixed(2)  + '  ' +
      '<span style="color:var(--gray)">C</span> <span style="color:' + clr + '">' + d.close.toFixed(2) + '</span>'
    );
  });

  new ResizeObserver(() => {
    if (lwChart && container.clientWidth > 0)
      lwChart.resize(container.clientWidth, container.clientHeight || 300);
  }).observe(container);

  chartInited = true;
}

function loadCandles() {
  const sym = $('#chart-sym').val() || 'BTCUSD';
  $.ajax({
    url: window.location.origin + '/api/mt5/candles?symbol=' + sym,
    method: 'GET', dataType: 'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).done(res => {
    if (!res.success || !res.candles || !res.candles.length) {
      $('#chart-status').text('No data — EA not connected'); return;
    }
    initChart();
    candleSeries.setData(res.candles.map(c => ({ time:c.t, open:c.o, high:c.h, low:c.l, close:c.c })));
    lwChart.timeScale().fitContent();
    const last = res.candles[res.candles.length - 1];
    const clr  = last.c >= last.o ? '#4caf7a' : '#e05050';
    $('#chart-status').text(res.symbol + '  ' + res.timeframe + '  ' + res.candles.length + ' bars');
    $('#chart-ohlc').html('<span style="color:var(--gray)">C</span> <span style="color:' + clr + '">' + parseFloat(last.c).toFixed(2) + '</span>');
  }).fail(() => { $('#chart-status').text('candles API error'); });
}

// ══════════════════════════════════════════════════
//  INIT
// ══════════════════════════════════════════════════
// ══════════════════════════════════════════════════
//  DEBUG CONSOLE
// ══════════════════════════════════════════════════
let dbgCount = 0;
let debugOpen = false;

function toggleDebug() {
  debugOpen = !debugOpen;
  $('#debug-panel').css('display', debugOpen ? 'flex' : 'none');
  $('#debug-btn').text(debugOpen ? '✕ CLOSE' : '⬡ DEBUG');
  // shift toast up when panel open
  $('#toast').css('bottom', debugOpen ? '240px' : '20px');
}

function dbgLog(label, sub, data) {
  dbgCount++;
  $('#dbg-count').text(dbgCount);

  const now = new Date().toTimeString().slice(0,8);
  const isErr = label.includes('4') || label.includes('5') || label.includes('ERR');
  const labelColor = isErr ? '#e05050' : label.includes('REQUEST') ? '#f0a050' : '#4caf7a';

  let dataStr = '';
  try {
    dataStr = typeof data === 'string' ? data : JSON.stringify(data, null, 2);
  } catch(e) { dataStr = String(data); }

  // Highlight important fields
  dataStr = dataStr
    .replace(/"(error|message|messages)":/g, '<span style="color:#e05050">"$1":</span>')
    .replace(/"(success|order_id|ticket)":/g, '<span style="color:#4caf7a">"$1":</span>')
    .replace(/"(symbol|direction|volume|order_type)":/g, '<span style="color:#C9A84C">"$1":</span>');

  const $entry = $(`
    <div style="padding:5px 16px;border-bottom:1px solid #1a1a1a;display:grid;grid-template-columns:70px 160px 1fr;gap:8px;align-items:start">
      <span style="color:#555;font-size:8px;padding-top:2px">${now}</span>
      <span style="font-size:9px;color:${labelColor};letter-spacing:1px">${label}<br>
        <span style="color:#555;font-size:8px;font-weight:300">${sub}</span></span>
      <pre style="margin:0;font-size:9px;color:#bbb;white-space:pre-wrap;word-break:break-all;line-height:1.5">${dataStr}</pre>
    </div>`);

  $('#dbg-body').prepend($entry);   // newest on top

  // Auto-open panel on error
  if (isErr && !debugOpen) toggleDebug();
}


// ══════════════════════════════════════════════════
//  AI CHART ANALYSIS — DUAL MODE (TM + Claude)
// ══════════════════════════════════════════════════

// ── Shared state ──────────────────────────────────
let curAiMode     = 'tm';   // 'tm' | 'claude'
let aiImageBase64 = null;
let aiLastSignal  = null;

// ── Modal open / close ────────────────────────────
function openAiModal() {
  $('#ai-modal-backdrop').addClass('open');
  switchAiMode('tm');   // always open on TM tab
}

function closeAiModal() {
  stopTmWebcam();
  $('#ai-modal-backdrop').removeClass('open');
}

function closeAiModalOutside(e) {
  if (e.target === document.getElementById('ai-modal-backdrop')) closeAiModal();
}

// ── Mode switcher ─────────────────────────────────
function switchAiMode(mode) {
  curAiMode = mode;

  if (mode === 'tm') {
    $('#ai-mode-tm').show();
    $('#ai-mode-claude').css('display','none');
    $('#mode-tab-tm').addClass('active-tm').removeClass('active-claude');
    $('#mode-tab-claude').removeClass('active-tm active-claude');
    $('#ai-modal-sub').text('TENSORFLOW MODEL → UPLOAD / CAMERA → INSTANT SIGNAL');
  } else {
    $('#ai-mode-tm').hide();
    $('#ai-mode-claude').css('display','flex');
    $('#mode-tab-claude').addClass('active-claude').removeClass('active-tm');
    $('#mode-tab-tm').removeClass('active-tm active-claude');
    $('#ai-modal-sub').text('CLAUDE VISION → UPLOAD CHART → AI ANALYSIS');
    stopTmWebcam();
    // pre-fill Claude prompt
    const sym = curSym || 'XAUUSD';
    if (!$('#ai-prompt').val()) {
      $('#ai-prompt').val('This is ' + sym + ' chart. Please analyse support/resistance zones and give a trade signal.');
    }
  }
}

// ══════════════════════════════════════════════════
//  TM MODEL (TensorFlow · Teachable Machine)
// ══════════════════════════════════════════════════
const TM_MODEL_URL = '/ai/chartD/';
let   tmModel      = null;
let   tmWebcam     = null;
let   tmIsRunning  = false;
let   tmAnimFrame  = null;
let   tmLastSignal = null;

async function loadTmModel() {
  if (!tmModel) {
    const modelURL = TM_MODEL_URL + 'model.json';
    const metaURL  = TM_MODEL_URL + 'metadata.json';
    tmModel = await tmImage.load(modelURL, metaURL);
    dbgLog('TM MODEL', 'Loaded', { classes: tmModel.getTotalClasses(), url: TM_MODEL_URL });
  }
}

// ── TM Scoreboard ─────────────────────────────────
const TM_THRESHOLD = 0.75;  // ← ปรับ threshold ได้ที่นี่

function renderTmScoreboard(predictions) {
  if (!predictions || !predictions.length) {
    $('#tm-scoreboard-wrap').html(`
      <div class="tm-scoreboard-header">🏆 TM SCOREBOARD</div>
      <div class="tm-empty">📊 Upload Image / Start Camera</div>`);
    hideTmActionPanel();
    return;
  }

  const sorted = [...predictions].sort((a, b) => b.probability - a.probability);
  const colorMap     = { UP:'var(--green)', DOWN:'var(--red)', BUY:'var(--green)', SELL:'var(--red)', WAIT:'var(--amber)' };
  const defaultColors = ['#5b8dee','#C9A84C','#aaa','#f0a050'];
  const medals        = ['🥇','🥈','🥉'];

  const rows = sorted.map((p, i) => {
    const pct   = (p.probability * 100).toFixed(1);
    const name  = p.className.toUpperCase();
    const clr   = colorMap[name] || defaultColors[i % defaultColors.length];
    const isTop = i === 0;
    const medal = medals[i] || '';
    const stripe = isTop
      ? 'background-image:repeating-linear-gradient(45deg,rgba(255,255,255,0.04) 0,rgba(255,255,255,0.04) 5px,transparent 5px,transparent 50%);background-size:20px 20px'
      : '';
    return `
      <div class="tm-score-row ${isTop ? 'top-row' : ''}">
        <div class="tm-score-meta">
          <span class="tm-score-name">${medal} ${p.className}</span>
          <span class="tm-score-pct" style="color:${clr}">${pct}%</span>
        </div>
        <div class="tm-progress">
          <div class="tm-progress-fill" style="width:${pct}%;background:${clr};${stripe}"></div>
        </div>
      </div>`;
  }).join('');

  $('#tm-scoreboard-wrap').html(`
    <div class="tm-scoreboard-header">🏆 TM SCOREBOARD</div>${rows}`);

  // ── Check threshold → show action panel ──────────
  const top    = sorted[0];
  const topName = top.className.toUpperCase();
  const topPct  = top.probability;

  // Map class name → BUY / SELL direction
  const dirMap = { UP:'BUY', BUY:'BUY', DOWN:'SELL', SELL:'SELL' };
  const dir    = dirMap[topName];   // undefined if neither UP/DOWN/BUY/SELL

  if (dir && topPct >= TM_THRESHOLD) {
    showTmActionPanel(dir, topPct);
  } else {
    hideTmActionPanel();
  }

  dbgLog('TM PREDICT', topName + ' ' + (topPct*100).toFixed(1)+'%',
    sorted.map(p => ({ class: p.className, pct: (p.probability*100).toFixed(1)+'%' })));
}

// ── Action Panel show / hide ──────────────────────
function showTmActionPanel(dir, probability) {
  tmLastSignal = { signal: dir, probability };
  const pct = (probability * 100).toFixed(1);

  const label = dir === 'BUY'
    ? `📈 UP TREND DETECTED — ${pct}%  →  BUY SIGNAL`
    : `📉 DOWN TREND DETECTED — ${pct}%  →  SELL SIGNAL`;

  $('#tm-action-header').text(label);
  $('#tm-conf-val').text(pct + '%');
  $('#tm-conf-fill').css('width', pct + '%');
  $('#tm-order-btn')
    .text((dir === 'BUY' ? '🟢 ' : '🔴 ') + dir + ' ' + curSym)
    .removeClass('BUY SELL').addClass(dir);

  $('#tm-action-panel')
    .removeClass('BUY SELL show')
    .addClass('show ' + dir);

  recalcTmSlTp();
}

function hideTmActionPanel() {
  tmLastSignal = null;
  $('#tm-action-panel').removeClass('show BUY SELL');
}

// ── Pip value calculator ──────────────────────────
// $ per pip = contract × pipSize × lots
function getTmPipValuePerLot() {
  const meta = SYMBOLS[curSym] || { contract: 100, pip: 0.01 };
  return meta.contract * meta.pip;
}

// pips needed = targetUsd / (pipValuePerLot × lots)
function usdToPips(usd, lots) {
  const ppL = getTmPipValuePerLot();
  if (!ppL || !lots) return 0;
  return usd / (ppL * lots);
}

// ── Recalculate SL/TP display ─────────────────────
function recalcTmSlTp() {
  const lots   = parseFloat($('#tm-lot-input').val()) || 0.01;
  const slUsd  = parseFloat($('#tm-sl-usd').val())   || 5;
  const tpUsd  = parseFloat($('#tm-tp-usd').val())   || 12;
  const meta   = SYMBOLS[curSym] || { pip: 0.01, decimals: 2 };
  const dir    = tmLastSignal ? tmLastSignal.signal : 'BUY';

  // $ per pip at current lots
  const pipValPerLot = getTmPipValuePerLot();
  const pipValTotal  = pipValPerLot * lots;

  // pip distances
  const slPips = usdToPips(slUsd, lots);
  const tpPips = usdToPips(tpUsd, lots);

  // price distances
  const slDist = slPips * meta.pip;
  const tpDist = tpPips * meta.pip;

  // current price
  const p      = curPrices[curSym];
  const dec    = meta.decimals;
  const refBuy  = p ? parseFloat(p.ask) : null;
  const refSell = p ? parseFloat(p.bid) : null;

  let slPrice = '—', tpPrice = '—';
  if (dir === 'BUY' && refBuy) {
    slPrice = (refBuy - slDist).toFixed(dec);
    tpPrice = (refBuy + tpDist).toFixed(dec);
  } else if (dir === 'SELL' && refSell) {
    slPrice = (refSell + slDist).toFixed(dec);
    tpPrice = (refSell - tpDist).toFixed(dec);
  }

  // R:R
  const rr = slUsd > 0 ? (tpUsd / slUsd).toFixed(2) : '—';

  // Update DOM
  $('#tm-sl-pips').text(slPips.toFixed(1) + ' pips  (' + slDist.toFixed(dec) + ' pts)');
  $('#tm-tp-pips').text(tpPips.toFixed(1) + ' pips  (' + tpDist.toFixed(dec) + ' pts)');
  $('#tm-sl-price').text(slPrice);
  $('#tm-tp-price').text(tpPrice);
  $('#tm-pip-val').text('$' + pipValTotal.toFixed(3) + ' / pip');
  $('#tm-rr-ratio').text('1 : ' + rr);
  $('#tm-sltp-note').text(
    '1 pip = $' + pipValPerLot.toFixed(3) + ' / lot  ·  ' + lots.toFixed(2) + ' lots = $' + pipValTotal.toFixed(3) + ' / pip'
  );

  // store calculated prices for order execution
  if (tmLastSignal) {
    tmLastSignal.slPrice = parseFloat(slPrice) || null;
    tmLastSignal.tpPrice = parseFloat(tpPrice) || null;
  }
}

// ── Lot size helpers ──────────────────────────────
function adjTmLot(delta) {
  let v = Math.round((parseFloat($('#tm-lot-input').val() || 0.01) + delta) * 100) / 100;
  if (v < 0.01) v = 0.01;
  if (v > 100)  v = 100;
  $('#tm-lot-input').val(v.toFixed(2));
  recalcTmSlTp();
}
function setTmLot(v) {
  $('#tm-lot-input').val(v.toFixed(2));
  recalcTmSlTp();
}

// ── Execute TM Order ──────────────────────────────
function executeTmOrder() {
  if (!tmLastSignal) return;
  const { signal, slPrice, tpPrice } = tmLastSignal;
  if (signal !== 'BUY' && signal !== 'SELL') return;

  const lot   = parseFloat($('#tm-lot-input').val()) || 0.01;
  const slUsd = parseFloat($('#tm-sl-usd').val()) || 5;
  const tpUsd = parseFloat($('#tm-tp-usd').val()) || 12;

  // Sync to main order form
  setDir(signal.toLowerCase());
  $('#lot-input').val(lot.toFixed(2));

  // Enable SL
  if (slPrice) {
    $('#sl-toggle').prop('checked', true);
    $('#sl-group').show();
    $('#sl-price').val(slPrice);
  }

  // Enable TP
  if (tpPrice) {
    $('#tp-toggle').prop('checked', true);
    $('#tp-group').show();
    $('#tp-price').val(tpPrice);
  }

  updateMargin();
  closeAiModal();

  setTimeout(() => {
    placeOrder();
    toast(
      'TM ORDER SENT',
      signal + ' ' + lot.toFixed(2) + ' lots  SL:$' + slUsd + '  TP:$' + tpUsd,
      signal === 'BUY' ? 'success' : 'error'
    );
  }, 250);

  dbgLog('TM ORDER', signal + ' ' + lot + ' lots', {
    symbol: curSym, direction: signal, volume: lot,
    sl_price: slPrice, tp_price: tpPrice,
    sl_usd: slUsd, tp_usd: tpUsd
  });
}

// ── TM File Upload ────────────────────────────────
function handleTmDrop(e) {
  e.preventDefault();
  $('#tm-upload-zone').removeClass('drag');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) processTmFile(file);
}

async function processTmFile(file) {
  if (!file) return;
  await loadTmModel();
  stopTmWebcam();

  const reader = new FileReader();
  reader.onload = function(ev) {
    $('#tm-preview-img').attr('src', ev.target.result);
    $('#tm-preview-wrap').show();
    $('#tm-upload-zone').hide();

    $('#tm-preview-img').off('load.tm').on('load.tm', async function() {
      renderTmScoreboard([]);
      const prediction = await tmModel.predict(this);
      renderTmScoreboard(prediction);
    });
  };
  reader.readAsDataURL(file);
}

function clearTmImage() {
  $('#tm-preview-wrap').hide();
  $('#tm-upload-zone').show();
  $('#tm-file-input').val('');
  renderTmScoreboard([]);
}

// ── TM Webcam ─────────────────────────────────────
async function toggleTmWebcam() {
  if (tmIsRunning) { stopTmWebcam(); return; }
  await loadTmModel();
  clearTmImage();

  tmWebcam = new tmImage.Webcam(200, 150, true);
  await tmWebcam.setup();
  await tmWebcam.play();

  $('#tm-webcam-container').empty().append(tmWebcam.canvas);
  tmIsRunning = true;

  $('#tm-cam-btn').text('⏹ Stop Camera').addClass('cam-running');
  tmLoop();
}

function stopTmWebcam() {
  if (tmWebcam)     { tmWebcam.stop(); tmWebcam = null; }
  if (tmAnimFrame)  { cancelAnimationFrame(tmAnimFrame); tmAnimFrame = null; }
  $('#tm-webcam-container').empty();
  tmIsRunning = false;
  $('#tm-cam-btn').text('📷 Start Camera').removeClass('cam-running');
  renderTmScoreboard([]);
}

async function tmLoop() {
  if (!tmIsRunning) return;
  tmWebcam.update();
  const prediction = await tmModel.predict(tmWebcam.canvas);
  renderTmScoreboard(prediction);
  tmAnimFrame = requestAnimationFrame(tmLoop);
}

// ── Wire TM file input ────────────────────────────
$(document).on('change', '#tm-file-input', function() {
  processTmFile(this.files[0]);
});

// ══════════════════════════════════════════════════
//  CLAUDE MODE
// ══════════════════════════════════════════════════
function handleAiDrop(e) {
  e.preventDefault();
  $('#ai-upload-zone').removeClass('drag');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) handleAiFile(file);
}

// Wire Claude file input
$(document).on('change', '#ai-file-input', function() {
  handleAiFile(this.files[0]);
});

function handleAiFile(file) {
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(ev) {
    const dataUrl = ev.target.result;
    aiImageBase64 = dataUrl.split(',')[1];
    $('#ai-preview-img').attr('src', dataUrl);
    $('#ai-preview-wrap').show();
    $('#ai-upload-zone').hide();
    $('#ai-analyse-btn').prop('disabled', false);
    $('#ai-result').removeClass('show');
    aiLastSignal = null;
    $('#ai-apply-btn').removeClass('show');
  };
  reader.readAsDataURL(file);
}

function clearAiImage() {
  aiImageBase64 = null;
  $('#ai-preview-wrap').hide();
  $('#ai-upload-zone').show();
  $('#ai-file-input').val('');
  $('#ai-analyse-btn').prop('disabled', true);
  $('#ai-result').removeClass('show');
  aiLastSignal = null;
  $('#ai-apply-btn').removeClass('show');
}

async function runAiAnalysis() {
  if (!aiImageBase64) { toast('AI', 'Please upload a chart image first', 'error'); return; }

  $('#ai-analyse-btn').prop('disabled', true);
  $('#ai-spinner').addClass('show');
  $('#ai-btn-label').text('ANALYSING...');
  $('#ai-result').removeClass('show');

  const prompt = $('#ai-prompt').val().trim() ||
    'Analyse this trading chart. Identify support and resistance zones. Give a trade signal: BUY, SELL, or WAIT.';

  const systemPrompt = `You are an expert forex and commodities technical analyst.
Analyse the provided chart image and respond ONLY with valid JSON in this exact format:
{
  "signal": "BUY" | "SELL" | "WAIT",
  "confidence": <number 0-100>,
  "resistance": "<price level or zone e.g. 2350.00 - 2355.00>",
  "support": "<price level or zone e.g. 2310.00 - 2315.00>",
  "description": "<Thai language analysis: อธิบายแนวรับแนวต้าน, รูปแบบราคา, สัญญาณการเทรด และเหตุผล 3-5 ประโยค>"
}
Do not include any text outside the JSON object.`;

  try {
    const response = await fetch('https://api.anthropic.com/v1/messages', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        model: 'claude-sonnet-4-20250514',
        max_tokens: 1000,
        system: systemPrompt,
        messages: [{
          role: 'user',
          content: [
            { type: 'image', source: { type: 'base64', media_type: 'image/jpeg', data: aiImageBase64 } },
            { type: 'text', text: prompt }
          ]
        }]
      })
    });

    const data = await response.json();
    if (!response.ok) throw new Error(data.error?.message || 'API error ' + response.status);

    const rawText = data.content?.[0]?.text || '';
    let result;
    try {
      result = JSON.parse(rawText.replace(/```json|```/g, '').trim());
    } catch(e) {
      throw new Error('Could not parse AI response: ' + rawText.slice(0, 120));
    }

    renderAiResult(result);

  } catch(err) {
    toast('AI ERROR', String(err), 'error');
    console.error('[AI]', err);
  } finally {
    $('#ai-analyse-btn').prop('disabled', false);
    $('#ai-spinner').removeClass('show');
    $('#ai-btn-label').text('◈ ANALYSE CHART');
  }
}

function renderAiResult(r) {
  const signal = (r.signal || 'WAIT').toUpperCase();
  const conf   = Math.min(100, Math.max(0, parseInt(r.confidence) || 50));
  aiLastSignal = { signal, sl: r.support, tp: r.resistance };

  $('#ai-signal-badge').text(signal).attr('class', 'ai-signal ' + signal);
  $('#ai-conf-text').text('Confidence ' + conf + '%');
  $('#ai-conf-fill').css('width', conf + '%').attr('class', 'ai-conf-fill ' + signal);
  $('#ai-resistance').text(r.resistance || '—');
  $('#ai-support').text(r.support || '—');
  $('#ai-description').text(r.description || '—');

  if (signal === 'BUY' || signal === 'SELL') {
    $('#ai-apply-btn').attr('class', 'ai-apply-btn ' + signal + ' show')
      .text('↗ APPLY ' + signal + ' SIGNAL TO ORDER FORM');
  } else {
    $('#ai-apply-btn').removeClass('show');
  }

  $('#ai-result').addClass('show');
  dbgLog('CLAUDE RESULT', signal + ' ' + conf + '%', r);
}

function applyAiSignal() {
  if (!aiLastSignal) return;
  const { signal } = aiLastSignal;
  if (signal !== 'BUY' && signal !== 'SELL') return;
  setDir(signal.toLowerCase());
  closeAiModal();
  toast('AI SIGNAL APPLIED', signal + ' ' + curSym + ' — ตรวจสอบ SL/TP ก่อน execute', 'success');
}

$(document).ready(function () {

  // ── Ticker tile click — use closest() to handle child element clicks ──
  $(document).on('click', '.sym-tile, .sym-tile *', function () {
    const sym = $(this).closest('.sym-tile').attr('data-sym');
    console.log('[CLICK] sym-tile clicked, sym=', sym, 'curSym before=', curSym);
    if (sym) syncSymbol(sym, true);
  });

  // ── Chart dropdown change ──────────────────────────────────
  $(document).on('change', '#chart-sym', function () {
    const sym = $(this).val();
    if (sym) syncSymbol(sym, true);
  });

  setDir('buy');
  updateMargin();
  fetchPrices();
  loadQueue();
  initChart();
  loadCandles();

  setInterval(fetchPrices, 3000);
  setInterval(() => {
    const a = $('.tab-content.active').attr('id');
    if (a === 'tab-queue') loadQueue();
    if (a === 'tab-pos')   loadPositions();
  }, 5000);
  setInterval(loadCandles, 15000);
});
</script>