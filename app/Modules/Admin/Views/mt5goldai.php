<!-- mt5goldai.php — Gold AI Trading Desk -->
<meta name="viewport"        content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
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
  --r:          3px;
  --mono:       'JetBrains Mono', monospace;
  --serif:      'Cormorant Garamond', serif;
  --sans:       'Sarabun', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
html  { font-size: 14px; }
button { touch-action: manipulation; }  /* ป้องกัน double-tap zoom บน mobile */
body  {
  background: var(--black);
  color: var(--white);
  font-family: var(--sans);
  min-height: 100vh;
  overflow-x: hidden;
}
body::after {
  content: '';
  position: fixed; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 9999;
}

/* ══ TOPBAR ══ */
.topbar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 24px; height: 52px;
  border-bottom: 1px solid rgba(201,168,76,0.2);
  background: rgba(9,9,9,0.97);
  backdrop-filter: blur(16px);
  position: sticky; top: 0; z-index: 1030;
}
.brand {
  font-family: var(--serif); font-size: 20px; font-weight: 700;
  letter-spacing: 5px; color: var(--gold); text-transform: uppercase;
  display: flex; align-items: baseline; gap: 12px;
}
.brand-sub { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); font-weight: 300; }
.brand-tag { font-family: var(--mono); font-size: 9px; letter-spacing: 3px; color: var(--gold-light); padding: 2px 8px; background: var(--gold-dim); border-radius: 2px; border: 1px solid rgba(201,168,76,0.3); }
.live-dot  { display: flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); }
.live-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--gold); box-shadow: 0 0 10px var(--gold); animation: blink 2s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* ══ PRICE STRIP ══ */
.price-strip {
  display: flex; align-items: stretch;
  background: var(--dark2);
  border-bottom: 1px solid rgba(201,168,76,0.1);
  overflow-x: auto; flex-shrink: 0;
}
.price-strip::-webkit-scrollbar { height: 0; }
.ps-tile {
  display: flex; flex-direction: column; justify-content: center;
  padding: 9px 22px; min-width: 140px; flex-shrink: 0;
  border-right: 1px solid rgba(255,255,255,0.04);
  border-bottom: 2px solid transparent;
  cursor: pointer; transition: all 0.2s; gap: 2px;
}
.ps-tile:hover  { background: rgba(201,168,76,0.04); }
.ps-tile.active { border-bottom-color: var(--gold); background: var(--gold-dim); }
.ps-tile.stat   { cursor: default; }
.ps-name  { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; }
.ps-price { font-family: var(--mono); font-size: 15px; font-weight: 500; color: var(--white); }
.ps-row   { display: flex; gap: 8px; align-items: center; }
.ps-chg   { font-family: var(--mono); font-size: 8px; padding: 1px 5px; border-radius: 2px; }
.ps-chg.up { background: var(--green-dim); color: var(--green); }
.ps-chg.dn { background: var(--red-dim);   color: var(--red); }
.ps-spd   { font-family: var(--mono); font-size: 7px; color: var(--gray); }
.ps-divider { width: 1px; background: rgba(201,168,76,0.15); margin: 6px 0; align-self: stretch; flex-shrink: 0; }

/* ══ LAYOUT — Bootstrap 5.3 ══ */
/* Order column sticky on desktop */
.order-sticky { position: sticky; top: 56px; }
@media (max-width: 991.98px) { .order-sticky { position: static; } }

/* Gap between rows */
.layout-gap { gap: 12px; }

/* Mobile: smaller topbar */
@media (max-width: 575.98px) {
  .topbar { padding: 0 12px; height: 48px; }
  .brand  { font-size: 15px; letter-spacing: 3px; }
  .brand-sub, .brand-tag { display: none; }
  #account-info { display: none; }
  .ps-tile   { padding: 7px 12px; min-width: 100px; }
  .ps-price  { font-size: 13px; }
  #main-chart { height: 220px !important; }
  .chart-toolbar { flex-wrap: wrap; gap: 6px; }
  .chart-ohlc { width: 100%; }
  .order-panel { padding: 12px; gap: 10px; }
  .dir-tab  { padding: 12px 6px; font-size: 13px; }
  .submit-btn { padding: 15px; font-size: 18px; }
  .lot-btn  { width: 40px; height: 40px; font-size: 20px; }
  #lot-input { font-size: 18px; text-align: center; }
  .ql-btn   { padding: 9px 4px; font-size: 10px; }
  .ai-panel-body { padding: 10px; gap: 10px; }
  .tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  .data-table { min-width: 480px; }
  .cc-btn { flex: 1; min-width: 80px; padding: 8px 6px; font-size: 9px; }
  .tab-item { font-size: 7px; padding: 10px 8px; letter-spacing: 1px; }
}

/* ══ PANEL CARD ══ */
.panel-card {
  border: 1px solid rgba(201,168,76,0.1);
  border-radius: 4px; overflow: hidden;
  background: var(--dark);
}

/* ══ SECTION LABEL ══ */
.sec-label {
  font-family: var(--serif); font-size: 11px; letter-spacing: 4px;
  text-transform: uppercase; color: var(--gold);
  display: flex; align-items: center; gap: 10px;
}
.sec-label::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, rgba(201,168,76,0.4), transparent); }

/* ══ CHART ══ */
.chart-toolbar {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 14px 7px; background: var(--dark);
  border-bottom: 1px solid rgba(255,255,255,0.04);
}
.chart-sym-badge { font-family: var(--mono); font-size: 10px; letter-spacing: 3px; color: var(--gold); background: var(--gold-dim); padding: 3px 10px; border-radius: 2px; border: 1px solid rgba(201,168,76,0.25); }
.chart-tf-btn { font-family: var(--mono); font-size: 8px; letter-spacing: 1px; background: transparent; border: 1px solid rgba(255,255,255,0.08); color: var(--gray); padding: 3px 8px; border-radius: 2px; cursor: pointer; transition: all 0.15s; }
.chart-tf-btn:hover, .chart-tf-btn.active { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
.chart-status { font-family: var(--mono); font-size: 9px; color: var(--gray); }
.chart-ohlc   { font-family: var(--mono); font-size: 9px; color: var(--light); margin-left: auto; letter-spacing: .5px; }
#main-chart   { width: 100%; height: 320px; }

/* ══ TAB BAR ══ */
.tab-bar   { display: flex; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding: 0 16px; background: var(--dark2); flex-shrink: 0; }
.tab-item  { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: var(--gray); padding: 12px 14px; cursor: pointer; border-bottom: 2px solid transparent; border-top: none; border-left: none; border-right: none; background: none; transition: all 0.2s; white-space: nowrap; }
.tab-item:hover  { color: var(--light); }
.tab-item.active { color: var(--gold); border-bottom-color: var(--gold); }
.tab-actions { margin-left: auto; display: flex; align-items: center; gap: 8px; }
.refresh-btn { font-family: var(--mono); font-size: 8px; letter-spacing: 1px; background: transparent; border: 1px solid rgba(255,255,255,0.1); color: var(--gray); padding: 4px 12px; border-radius: 2px; cursor: pointer; transition: all 0.15s; }
.refresh-btn:hover { border-color: var(--gold); color: var(--gold); }
.tab-content        { display: none; flex-direction: column; }
.tab-content.active { display: flex; }

/* ══ DATA TABLE ══ */
.tbl-wrap   { padding: 14px 16px; overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: var(--gray); padding: 7px 10px; text-align: left; border-bottom: 1px solid rgba(201,168,76,0.1); background: rgba(201,168,76,0.03); white-space: nowrap; }
.data-table td { font-family: var(--mono); font-size: 10px; color: var(--light); padding: 8px 10px; border-bottom: 1px solid rgba(255,255,255,0.03); white-space: nowrap; }
.data-table tr:hover td { background: rgba(201,168,76,0.025); }
.loading-row td { text-align: center !important; color: var(--gray) !important; padding: 28px !important; font-size: 9px !important; letter-spacing: 2px; }
.close-pos-btn { font-family: var(--mono); font-size: 8px; letter-spacing: 1px; padding: 3px 10px; background: var(--red-dim); border: 1px solid rgba(224,80,80,0.3); color: var(--red); border-radius: 2px; cursor: pointer; transition: all 0.15s; text-transform: uppercase; }
.close-pos-btn:hover { background: var(--red); color: #fff; }

/* ══ TAGS ══ */
.tag { display: inline-block; font-size: 7px; letter-spacing: 1px; padding: 2px 6px; border-radius: 2px; text-transform: uppercase; font-weight: 600; }
.tag.buy        { background: var(--green-dim); color: var(--green); }
.tag.sell       { background: var(--red-dim);   color: var(--red); }
.tag.pending    { background: var(--amber-dim); color: var(--amber); }
.tag.processing { background: var(--blue-dim);  color: var(--blue); }
.tag.executed   { background: var(--green-dim); color: var(--green); }
.tag.failed     { background: var(--red-dim);   color: var(--red); }

/* ══ AI PANEL ══ */
.ai-panel-body { padding: 16px; display: flex; flex-direction: column; gap: 14px; }

.ai-upload-zone {
  border: 2px dashed rgba(201,168,76,0.25);
  border-radius: 4px; padding: 22px 16px;
  text-align: center; cursor: pointer; transition: all 0.2s;
  background: rgba(201,168,76,0.02); position: relative;
}
.ai-upload-zone:hover, .ai-upload-zone.drag { border-color: var(--gold); background: var(--gold-dim); }
.ai-upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-icon { font-size: 24px; color: var(--gold); opacity: .6; margin-bottom: 8px; }
.upload-text { font-family: var(--mono); font-size: 10px; letter-spacing: 2px; color: var(--gray); }
.upload-hint { font-family: var(--mono); font-size: 8px; color: var(--gray2); margin-top: 4px; }

#ai-preview-wrap { display: none; position: relative; }
#ai-preview-img  { width: 100%; border-radius: 4px; border: 1px solid rgba(201,168,76,0.15); max-height: 200px; object-fit: cover; }
.preview-clear { position: absolute; top: 6px; right: 6px; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.2); color: var(--white); width: 24px; height: 24px; border-radius: 2px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center; }

.field-label { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: var(--gray); margin-bottom: 5px; display: block; }
.ai-prompt-input { width: 100%; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1); color: var(--white); font-family: var(--mono); font-size: 11px; padding: 8px 12px; border-radius: var(--r); outline: none; resize: none; transition: border-color 0.2s; line-height: 1.5; }
.ai-prompt-input:focus { border-color: var(--gold); }

.ai-analyse-btn {
  width: 100%; padding: 13px;
  background: linear-gradient(135deg, #3a2800, #C9A84C);
  border: none; border-radius: var(--r); cursor: pointer;
  font-family: var(--serif); font-size: 16px; font-weight: 700;
  letter-spacing: 5px; text-transform: uppercase; color: #000;
  box-shadow: 0 4px 24px rgba(201,168,76,0.25);
  transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px;
}
.ai-analyse-btn:hover    { transform: translateY(-1px); filter: brightness(1.1); box-shadow: 0 6px 30px rgba(201,168,76,0.4); }
.ai-analyse-btn:disabled { opacity: .45; cursor: not-allowed; transform: none; }

.ai-result { display: none; border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; overflow: hidden; }
.ai-result.show { display: block; animation: fadeIn 0.25s ease; }
.ai-result-header { padding: 12px 16px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(201,168,76,0.04); }
.ai-signal { font-family: var(--mono); font-size: 13px; font-weight: 600; letter-spacing: 3px; padding: 4px 14px; border-radius: 2px; text-transform: uppercase; }
.ai-signal.BUY  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.ai-signal.SELL { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.ai-signal.WAIT { background: var(--amber-dim); color: var(--amber); border: 1px solid rgba(240,160,80,0.4); }
.ai-confidence  { font-family: var(--mono); font-size: 9px; color: var(--gray); margin-left: auto; }
.ai-conf-bar    { height: 3px; border-radius: 2px; background: var(--dark4); margin-top: 4px; overflow: hidden; min-width: 80px; }
.ai-conf-fill   { height: 100%; border-radius: 2px; transition: width 0.6s ease; }
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
.ai-desc       { font-family: var(--sans); font-size: 12px; color: var(--light); line-height: 1.7; }
.ai-desc-label { font-family: var(--mono); font-size: 7px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; margin-bottom: 6px; }
.ai-apply-btn { width: 100%; padding: 10px; margin-top: 12px; border: none; border-radius: var(--r); cursor: pointer; font-family: var(--mono); font-size: 10px; letter-spacing: 3px; text-transform: uppercase; transition: all 0.2s; display: none; }
.ai-apply-btn.BUY  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.ai-apply-btn.SELL { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.ai-apply-btn.show { display: block; }
.ai-apply-btn:hover { filter: brightness(1.25); }

.ai-spinner { width: 18px; height: 18px; border: 2px solid rgba(0,0,0,0.3); border-top-color: #000; border-radius: 50%; animation: spin 0.7s linear infinite; display: none; }
.ai-spinner.show { display: inline-block; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ══ ORDER PANEL ══ */
.order-panel { padding: 16px; display: flex; flex-direction: column; gap: 14px; }
.sym-display { background: linear-gradient(135deg, rgba(201,168,76,0.08), rgba(201,168,76,0.03)); border: 1px solid rgba(201,168,76,0.25); border-radius: var(--r); padding: 12px 14px; display: flex; align-items: center; justify-content: space-between; }
.sd-left  { display: flex; flex-direction: column; gap: 2px; }
.sd-sym   { font-family: var(--mono); font-size: 14px; font-weight: 600; color: var(--gold-light); }
.sd-desc  { font-family: var(--mono); font-size: 8px; color: var(--gray); letter-spacing: 1px; }
.sd-right { font-family: var(--mono); font-size: 10px; color: var(--gray); text-align: right; }
.sd-price { font-family: var(--mono); font-size: 16px; color: var(--white); display: block; }

.dir-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; background: var(--dark3); padding: 3px; border-radius: var(--r); }
.dir-tab  { padding: 10px; text-align: center; cursor: pointer; font-family: var(--mono); font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--gray); border-radius: 2px; border: none; background: transparent; transition: all 0.2s; }
.dir-tab.buy.active  { background: var(--green-dim); color: var(--green); border: 1px solid rgba(76,175,122,0.4); }
.dir-tab.sell.active { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(224,80,80,0.4); }
.dir-tab:not(.active):hover { color: var(--light); }

.ba-row  { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.ba-card { background: var(--dark2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--r); padding: 10px 14px; text-align: center; }
.ba-lbl  { font-family: var(--mono); font-size: 8px; letter-spacing: 3px; color: var(--gray); margin-bottom: 4px; }
.ba-val  { font-family: var(--mono); font-size: 17px; font-weight: 500; }
.ba-val.bid { color: var(--red); }
.ba-val.ask { color: var(--green); }
.spread-line { text-align: center; font-family: var(--mono); font-size: 9px; color: var(--gray); letter-spacing: 2px; margin-top: -4px; }
.spread-line span { color: var(--gold); }

.field-input { width: 100%; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1); color: var(--white); font-family: var(--mono); font-size: 13px; padding: 9px 12px; border-radius: var(--r); outline: none; transition: border-color 0.2s; -webkit-appearance: none; }
.field-input:focus { border-color: var(--gold); }
.field-input::placeholder { color: var(--dark4); }
select.field-input { cursor: pointer; }

.lot-row { display: flex; align-items: center; gap: 4px; }
.lot-btn { width: 36px; height: 38px; background: var(--dark3); border: 1px solid rgba(255,255,255,0.1); color: var(--gold); cursor: pointer; font-size: 16px; border-radius: var(--r); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.15s; }
.lot-btn:hover { background: var(--gold-dim); border-color: var(--gold); }
.quick-lots { display: grid; grid-template-columns: repeat(4,1fr); gap: 4px; margin-top: 4px; }
.ql-btn { font-family: var(--mono); font-size: 9px; padding: 4px 0; background: var(--dark4); border: 1px solid rgba(255,255,255,0.07); color: var(--gray); cursor: pointer; border-radius: 2px; text-align: center; transition: all 0.15s; }
.ql-btn:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--gold); }

.sltp-row   { display: flex; align-items: center; justify-content: space-between; }
.sltp-label { font-family: var(--mono); font-size: 9px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.toggle { position: relative; width: 38px; height: 20px; cursor: pointer; }
.toggle input { display: none; }
.toggle-track { position: absolute; inset: 0; background: var(--dark4); border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s; }
.toggle-track::after { content: ''; position: absolute; width: 14px; height: 14px; background: var(--gray2); border-radius: 50%; top: 2px; left: 2px; transition: all 0.2s; }
.toggle input:checked + .toggle-track             { background: var(--gold-dim); border-color: var(--gold); }
.toggle input:checked + .toggle-track::after      { transform: translateX(18px); background: var(--gold); }

.divider { height: 1px; background: rgba(255,255,255,0.05); }

.submit-btn { width: 100%; padding: 13px; font-family: var(--serif); font-size: 16px; font-weight: 600; letter-spacing: 4px; text-transform: uppercase; cursor: pointer; border-radius: var(--r); border: none; transition: all 0.2s; }
.submit-btn.buy  { background: linear-gradient(135deg,#1e5c38,#4caf7a); color: #fff; box-shadow: 0 4px 20px rgba(76,175,122,0.25); }
.submit-btn.sell { background: linear-gradient(135deg,#6e1818,#e05050); color: #fff; box-shadow: 0 4px 20px rgba(224,80,80,0.25); }
.submit-btn:hover    { transform: translateY(-1px); filter: brightness(1.1); }
.submit-btn:active   { transform: none; }
.submit-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

.margin-box { background: var(--dark2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--r); padding: 11px 14px; display: flex; flex-direction: column; gap: 6px; }
.margin-row { display: flex; justify-content: space-between; align-items: center; }
.m-lbl { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; }
.m-val { font-family: var(--mono); font-size: 11px; color: var(--light); }
.m-val.gold { color: var(--gold-light); }

/* ══ TOAST ══ */
#toast {
  position: fixed; bottom: 20px; right: 20px;
  background: var(--dark2); border-radius: var(--r);
  padding: 12px 16px; font-family: var(--mono); font-size: 10px; color: var(--gold);
  z-index: 9000; transform: translateY(70px); opacity: 0;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 8px 28px rgba(0,0,0,0.6);
  max-width: 300px; border-left: 2px solid var(--gold);
}
#toast.show    { transform: translateY(0); opacity: 1; }
#toast.success { border-left-color: var(--green); color: var(--green); }
#toast.error   { border-left-color: var(--red);   color: var(--red); }
#toast-title   { font-size: 7px; letter-spacing: 2px; color: var(--gray); margin-bottom: 3px; text-transform: uppercase; }

/* ══ MISC ══ */
::-webkit-scrollbar       { width: 3px; height: 3px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--dark4); border-radius: 2px; }
.container-fluid, .container { background: transparent; }
@keyframes fadeIn { from{opacity:0;transform:translateY(5px)} to{opacity:1;transform:translateY(0)} }
.fade-in { animation: fadeIn 0.25s ease both; }

/* ══ BULK CLOSE BAR ══ */
.close-bar {
  display: flex; flex-wrap: wrap; align-items: center; gap: 8px;
  padding: 9px 14px;
  background: rgba(224,80,80,0.04);
  border-bottom: 1px solid rgba(224,80,80,0.1);
}
.close-bar-lbl { font-family: var(--mono); font-size: 8px; letter-spacing: 2px; color: var(--gray); text-transform: uppercase; flex-shrink:0; }
.cc-btn {
  font-family: var(--mono); font-size: 9px; letter-spacing: 1px; text-transform: uppercase;
  padding: 5px 12px; border-radius: 2px; cursor: pointer; transition: all 0.18s; white-space: nowrap;
  border: 1px solid transparent;
}
.cc-btn.all  { background: var(--red-dim);   border-color: rgba(224,80,80,0.35);  color: var(--red); }
.cc-btn.buy  { background: var(--green-dim); border-color: rgba(76,175,122,0.3);  color: var(--green); }
.cc-btn.sell { background: var(--red-dim);   border-color: rgba(224,80,80,0.25);  color: #e05888; }
.cc-btn:hover    { filter: brightness(1.3); box-shadow: 0 0 10px currentColor; }
.cc-btn:disabled { opacity: .3; cursor: not-allowed; filter: none; box-shadow: none; }

/* ══ CONFIRM MODAL ══ */
.cfm-backdrop {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.80); backdrop-filter: blur(4px);
  z-index: 9500; display: none; align-items: center; justify-content: center;
}
.cfm-backdrop.open { display: flex; }
.cfm-box {
  background: var(--dark); border: 1px solid rgba(224,80,80,0.3);
  border-radius: 4px; padding: 28px 26px 22px; width: 310px; text-align: center;
  box-shadow: 0 20px 60px rgba(0,0,0,0.9);
  animation: cfmIn .18s cubic-bezier(0.16,1,0.3,1);
}
@keyframes cfmIn { from{opacity:0;transform:scale(.94)} to{opacity:1;transform:none} }
.cfm-icon  { font-size: 28px; margin-bottom: 8px; }
.cfm-title { font-family: var(--serif); font-size: 17px; letter-spacing: 3px; color: var(--red); text-transform: uppercase; margin-bottom: 6px; }
.cfm-msg   { font-family: var(--mono); font-size: 10px; color: var(--gray); letter-spacing: 1px; margin-bottom: 22px; line-height: 1.7; white-space: pre-line; }
.cfm-btns  { display: flex; gap: 10px; }
.cfm-yes   { flex:1; padding: 10px; background: linear-gradient(135deg,#6e1818,#e05050); border: none; border-radius: var(--r); color: #fff; font-family: var(--serif); font-size: 15px; font-weight: 600; letter-spacing: 3px; cursor: pointer; }
.cfm-yes:hover { filter: brightness(1.1); }
.cfm-no    { flex:1; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.1); color: var(--gray); font-family: var(--mono); font-size: 10px; letter-spacing: 2px; border-radius: var(--r); cursor: pointer; }
.cfm-no:hover  { border-color: var(--gold); color: var(--gold); }
</style>


<!-- ══ TOPBAR ══ -->
<header class="topbar">
  <div class="brand">
    Gold AI
    <span class="brand-tag">XAU/USD</span>
    <span class="brand-sub">AI TRADING DESK</span>
  </div>
  <div class="d-flex align-items-center gap-3">
    <span style="font-family:var(--mono);font-size:9px;color:var(--gray)" id="account-info">—</span>
    <span class="live-dot">LIVE</span>
  </div>
</header>

<!-- ══ PRICE STRIP ══ -->
<div class="price-strip">
  <div class="ps-tile active" id="pst-GOLD">
    <span class="ps-name">GOLD</span>
    <span class="ps-price" id="pp-GOLD">—</span>
    <div class="ps-row">
      <span class="ps-chg" id="pc-GOLD">—</span>
      <span class="ps-spd" id="psp-GOLD">spd —</span>
    </div>
  </div>
  <div class="ps-tile" id="pst-XAUEUR">
    <!-- <span class="ps-name">XAU/EUR</span>
    <span class="ps-price" id="pp-XAUEUR">—</span>
    <div class="ps-row">
      <span class="ps-chg" id="pc-XAUEUR">—</span>
      <span class="ps-spd" id="psp-XAUEUR">spd —</span>
    </div> -->
  </div>
  <div class="ps-divider"></div>
  <div class="ps-tile stat">
    <span class="ps-name">BALANCE</span>
    <span class="ps-price" id="stat-balance" style="font-size:13px">—</span>
  </div>
  <div class="ps-tile stat">
    <span class="ps-name">EQUITY</span>
    <span class="ps-price" id="stat-equity" style="font-size:13px">—</span>
  </div>
  <div class="ps-tile stat" style="border-right:none">
    <span class="ps-name">FREE MARGIN</span>
    <span class="ps-price" id="stat-free-margin" style="font-size:13px">—</span>
  </div>
</div>


<!-- ══ MAIN LAYOUT — Bootstrap 5.3 container > row > col ══ -->
<div class="container-fluid px-2 px-md-3 py-3">
  <div class="row g-3 align-items-start">

  <!-- ╔══════════════════════════════╗
       ║  COL LEFT  —  Order Form    ║
       ╚══════════════════════════════╝ -->
    <!-- ╔═ COL LEFT — Order Form (sticky on desktop) ═╗ -->
    <div class="col-12 col-lg-4 col-xl-3">
      <div class="order-sticky">
    <div class="panel-card">
      <aside class="order-panel">

        <div class="sec-label">New Order</div>

        <input type="hidden" id="symbol-select" value="GOLD">
        <div class="sym-display">
          <div class="sd-left">
            <span class="sd-sym">GOLD</span>
            <span class="sd-desc">Gold (Broker Symbol)</span>
          </div>
          <div class="sd-right">
            <span style="font-size:8px;color:var(--gray)">MID</span>
            <span class="sd-price" id="sd-price">—</span>
          </div>
        </div>

        <div class="dir-tabs">
          <button class="dir-tab buy active" id="tab-buy"  onclick="setDir('buy')">BUY</button>
          <button class="dir-tab sell"       id="tab-sell" onclick="setDir('sell')">SELL</button>
        </div>

        <div class="ba-row">
          <div class="ba-card"><div class="ba-lbl">BID</div><div class="ba-val bid" id="bid-val">—</div></div>
          <div class="ba-card"><div class="ba-lbl">ASK</div><div class="ba-val ask" id="ask-val">—</div></div>
        </div>
        <div class="spread-line">SPREAD <span id="spread-val">—</span> pts</div>

        <div>
          <span class="field-label">Order Type</span>
          <select class="field-input" id="order-type" onchange="togglePrice()">
            <option value="market">Market Order</option>
            <option value="limit">Limit Order</option>
            <option value="stop">Stop Order</option>
          </select>
        </div>

        <div id="price-group" style="display:none">
          <span class="field-label">Price</span>
          <input type="number" class="field-input" id="pending-price" placeholder="0.00" step="0.01">
        </div>

        <div>
          <span class="field-label">Volume (Lots)</span>
          <div class="lot-row">
            <button class="lot-btn" onclick="adjLot(-0.01)">−</button>
            <input type="number" class="field-input" id="lot-input" value="0.01"
                   step="0.01" min="0.01" max="100" oninput="updateMargin()">
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

        <div class="sltp-row">
          <span class="sltp-label">Stop Loss</span>
          <label class="toggle"><input type="checkbox" id="sl-toggle" onchange="toggleSL()"><span class="toggle-track"></span></label>
        </div>
        <div id="sl-group" style="display:none">
          <input type="number" class="field-input" id="sl-price" placeholder="SL Price" step="0.01" style="margin-top:6px">
        </div>

        <div class="sltp-row">
          <span class="sltp-label">Take Profit</span>
          <label class="toggle"><input type="checkbox" id="tp-toggle" onchange="toggleTP()"><span class="toggle-track"></span></label>
        </div>
        <div id="tp-group" style="display:none">
          <input type="number" class="field-input" id="tp-price" placeholder="TP Price" step="0.01" style="margin-top:6px">
        </div>

        <div class="divider"></div>

        <button class="submit-btn buy" id="submit-btn" onclick="placeOrder()">BUY GOLD</button>

        <div class="margin-box">
          <div class="margin-row"><span class="m-lbl">Required Margin</span><span class="m-val gold" id="req-margin">—</span></div>
          <div class="margin-row"><span class="m-lbl">Pip Value</span>      <span class="m-val"      id="pip-val">—</span></div>
          <div class="margin-row"><span class="m-lbl">Free Margin</span>    <span class="m-val"      id="free-margin">—</span></div>
          <div class="margin-row"><span class="m-lbl">Margin Level</span>   <span class="m-val gold" id="margin-level">—</span></div>
        </div>

      </aside>
    </div>
      </div><!-- /order-sticky -->
    </div><!-- /col-left -->


    <!-- ╔═ COL RIGHT — AI + Chart + Queue/Pos ═╗ -->
    <div class="col-12 col-lg-8 col-xl-9">
      <div class="d-flex flex-column gap-3">
    <div class="panel-card">
      <div class="tab-bar">
        <button class="tab-item active" data-tab="ai">◈ AI Analysis</button>
        <div class="tab-actions">
          <span style="font-family:var(--mono);font-size:7px;letter-spacing:2px;color:var(--gray)">GOLD · CLAUDE VISION</span>
        </div>
      </div>
      <div class="tab-content active" id="tab-ai">
        <div class="ai-panel-body">

          <div id="ai-upload-zone" class="ai-upload-zone"
               ondragover="event.preventDefault();this.classList.add('drag')"
               ondragleave="this.classList.remove('drag')"
               ondrop="handleAiDrop(event)">
            <input type="file" id="ai-file-input" accept="image/*">
            <div class="upload-icon">📈</div>
            <div class="upload-text">DROP GOLD CHART IMAGE</div>
            <div class="upload-hint">Claude Vision · PNG, JPG, WEBP</div>
          </div>

          <div id="ai-preview-wrap">
            <img id="ai-preview-img" src="" alt="chart preview">
            <button class="preview-clear" onclick="clearAiImage()">✕</button>
          </div>

          <div>
            <span class="field-label">Context (Optional)</span>
            <textarea class="ai-prompt-input" id="ai-prompt" rows="2"
              placeholder="e.g. GOLD M15 — looking for breakout above resistance..."></textarea>
          </div>

          <button class="ai-analyse-btn" id="ai-analyse-btn" onclick="runAiAnalysis()" disabled>
            <div class="ai-spinner" id="ai-spinner"></div>
            <span id="ai-btn-label">◈ ANALYSE GOLD CHART</span>
          </button>

          <div class="ai-result" id="ai-result">
            <div class="ai-result-header">
              <span class="ai-signal" id="ai-signal-badge">—</span>
              <div class="ai-confidence">
                <div id="ai-conf-text">Confidence —</div>
                <div class="ai-conf-bar">
                  <div class="ai-conf-fill" id="ai-conf-fill" style="width:0%"></div>
                </div>
              </div>
            </div>
            <div class="ai-result-body">
              <div class="ai-zones">
                <div class="ai-zone-card">
                  <div class="ai-zone-lbl">⬆ Resistance</div>
                  <div class="ai-zone-val res" id="ai-resistance">—</div>
                </div>
                <div class="ai-zone-card">
                  <div class="ai-zone-lbl">⬇ Support</div>
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

        </div>
      </div>
    </div>

    <!-- ── Chart ── -->
    <div class="panel-card">
      <div class="chart-toolbar">
        <span class="chart-sym-badge">XAU/USD · GOLD</span>
        <button class="chart-tf-btn active" onclick="switchTF(this)">M15</button>
        <button class="chart-tf-btn"        onclick="switchTF(this)">M30</button>
        <button class="chart-tf-btn"        onclick="switchTF(this)">H1</button>
        <span class="chart-status" id="chart-status">Loading...</span>
        <span class="chart-ohlc"   id="chart-ohlc"></span>
      </div>
      <div id="main-chart"></div>
    </div>

    <!-- ── Queue / Positions ── -->
    <div class="panel-card" id="queue-pos-panel">
      <div class="tab-bar">
        <button class="tab-item active" data-tab="queue">Order Queue</button>
        <button class="tab-item"        data-tab="pos">Positions</button>
        <div class="tab-actions">
          <button class="refresh-btn" onclick="refreshAll()">↺ REFRESH</button>
        </div>
      </div>

      <div class="tab-content active" id="tab-queue" style="max-height:320px;overflow-y:auto">
        <div class="tbl-wrap">
          <table class="data-table">
            <thead>
              <tr><th>Time</th><th>Symbol</th><th>Dir</th><th>Vol</th><th>Price</th><th>Status</th><th>Ticket</th></tr>
            </thead>
            <tbody id="queue-tbody">
              <tr class="loading-row"><td colspan="7">LOADING...</td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="tab-content" id="tab-pos" style="max-height:320px;overflow-y:auto">
        <div class="close-bar">
          <span class="close-bar-lbl">⚡ Close :</span>
          <button class="cc-btn all"
            onclick="cfmShow('❌  Close ALL','ปิด positions ทั้งหมดทันที\nEA จะ execute ภายใน 2 วินาที', ()=>bulkClose('close_all'))">
            ✕ ALL
          </button>
          <button class="cc-btn buy"
            onclick="cfmShow('📈  Close All BUY','ปิด BUY positions ทั้งหมด', ()=>bulkClose('close_all_buy'))">
            ✕ ALL BUY
          </button>
          <button class="cc-btn sell"
            onclick="cfmShow('📉  Close All SELL','ปิด SELL positions ทั้งหมด', ()=>bulkClose('close_all_sell'))">
            ✕ ALL SELL
          </button>
        </div>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead>
              <tr><th>Ticket</th><th>Type</th><th>Volume</th><th>Open</th><th>Current</th><th>P&amp;L</th><th>Action</th></tr>
            </thead>
            <tbody id="pos-tbody">
              <tr class="loading-row"><td colspan="7">LOADING...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

      </div><!-- /d-flex col-right -->
    </div><!-- /col-right -->

  </div><!-- /row -->
</div><!-- /container-fluid -->

<!-- ══ TOAST ══ -->
<!-- ══ CONFIRM MODAL ══ -->
<div class="cfm-backdrop" id="cfm-backdrop">
  <div class="cfm-box">
    <div class="cfm-icon"  id="cfm-icon">⚠️</div>
    <div class="cfm-title" id="cfm-title">Confirm</div>
    <div class="cfm-msg"   id="cfm-msg">ยืนยันการดำเนินการ?</div>
    <div class="cfm-btns">
      <button class="cfm-no"  onclick="cfmCancel()">Cancel</button>
      <button class="cfm-yes" onclick="cfmProceed()">Confirm</button>
    </div>
  </div>
</div>

<div id="toast"><div id="toast-title">NOTICE</div><div id="toast-msg">—</div></div>


<!-- ══ SCRIPTS ══ -->
<!-- mt5_api.js handles: placeOrder, closePosition, fetchPositions, fetchAccount, pollOrderStatus -->
<script src="<?=base_url();?>asset/mt5_api.js"></script>

<script>
// ══════════════════════════════════════════════════
//  CONFIG
// ══════════════════════════════════════════════════
const API      = window.location.origin + '/api/mt5';
const GOLD_SYM = 'GOLD';
const GOLD_META = { contract:100, leverage:500, pip:0.01, decimals:2 };
const STRIP_SYMS = ['GOLD','XAUEUR','XAGUSD'];
const STRIP_META = {
  GOLD:   { pip:0.01,  decimals:2 },
  XAUEUR: { pip:0.01,  decimals:2 },
  XAGUSD: { pip:0.001, decimals:3 },
};

const prevPrices = {};
let curDir       = 'buy';
let curPrices    = {};
let aiLastSignal = null;


// ══════════════════════════════════════════════════
//  TOAST
// ══════════════════════════════════════════════════
function toast(title, msg, type = '') {
  $('#toast-title').text(title);
  $('#toast-msg').text(msg);
  $('#toast').attr('class', 'show ' + type);
  clearTimeout(window._tt);
  window._tt = setTimeout(() => $('#toast').attr('class', ''), 4500);
}

// Override MT5Api's showNotif to use our toast
// (MT5Api.showNotif targets #notification / #notif-title / #notif-body from old layout)
// We remap it after MT5Api is loaded:
function remapApiNotif() {
  if (typeof MT5Api !== 'undefined') {
    // Patch internal showNotif by overriding on the public object
    const _orig = MT5Api.showNotif;
    MT5Api.showNotif = function(title, body) {
      toast(title, body);
    };
  }
}


// ══════════════════════════════════════════════════
//  FETCH PRICES  (price strip + bid/ask + account)
// ══════════════════════════════════════════════════
function fetchPrices() {
  $.getJSON(API + '/prices_raw').done(res => {
    curPrices = res;

    STRIP_SYMS.forEach(sym => {
      const p = res[sym];
      if (!p) return;
      const meta = STRIP_META[sym];
      const bid  = parseFloat(p.bid);
      const ask  = parseFloat(p.ask);
      const mid  = ((bid + ask) / 2).toFixed(meta.decimals);
      const spd  = ((ask - bid) / meta.pip).toFixed(1);
      $(`#pp-${sym}`).text(mid);
      $(`#psp-${sym}`).text('spd ' + spd);
      if (prevPrices[sym] !== undefined) {
        const pct = ((bid - prevPrices[sym]) / prevPrices[sym] * 100).toFixed(2);
        $(`#pc-${sym}`)
          .text((pct >= 0 ? '+' : '') + pct + '%')
          .attr('class', 'ps-chg ' + (pct >= 0 ? 'up' : 'dn'));
      }
      prevPrices[sym] = bid;
    });

    // Live-tick chart: update current candle close with latest bid
    const goldP = res['GOLD'] || res['XAUUSD'];
    if (goldP && candleSeries && lwChart) {
      try {
        const bid = parseFloat(goldP.bid);
        const nowSec = Math.floor(Date.now() / 1000);
        candleSeries.update({ time: nowSec, open: bid, high: bid, low: bid, close: bid });
      } catch(e) { /* ignore if no base candle yet */ }
    }

    refreshBidAsk();
    updateMargin();
  });

  // Account — also feeds MT5Api's fetchAccount display IDs
  $.ajax({ url: API + '/account', method:'GET', dataType:'json',
           headers:{'X-Requested-With':'XMLHttpRequest'} })
  .done(res => {
    if (!res.success) return;
    const a   = res.account;
    const fmt = v => '$' + parseFloat(v || 0).toLocaleString('en-US', {minimumFractionDigits:2});
    if (a.balance)     { $('#stat-balance').text(fmt(a.balance)); }
    if (a.equity)      { $('#stat-equity').text(fmt(a.equity)); }
    if (a.free_margin) { $('#stat-free-margin').text(fmt(a.free_margin)); $('#free-margin').text(fmt(a.free_margin)); }
    if (a.margin_level){ $('#margin-level').text(parseFloat(a.margin_level).toFixed(1) + '%'); }
    if (a.balance)     {
      $('#account-info').text(
        'Balance: ' + fmt(a.balance) + '  Equity: ' + fmt(a.equity)
      );
    }
  });
}

function refreshBidAsk() {
  const p = curPrices[GOLD_SYM];
  if (!p) { $('#bid-val,#ask-val,#spread-val,#sd-price').text('—'); return; }
  const bid    = parseFloat(p.bid).toFixed(2);
  const ask    = parseFloat(p.ask).toFixed(2);
  const spread = ((p.ask - p.bid) / GOLD_META.pip).toFixed(1);
  const mid    = ((parseFloat(p.bid) + parseFloat(p.ask)) / 2).toFixed(2);
  $('#bid-val').text(bid);
  $('#ask-val').text(ask);
  $('#spread-val').text(spread);
  $('#sd-price').text(mid);
}


// ══════════════════════════════════════════════════
//  MARGIN CALC
// ══════════════════════════════════════════════════
function updateMargin() {
  const vol    = parseFloat($('#lot-input').val()) || 0.01;
  const p      = curPrices[GOLD_SYM];
  const price  = p ? parseFloat(p.ask) : 2384;
  const margin = (price * vol * GOLD_META.contract) / GOLD_META.leverage;
  const pipVal = vol * GOLD_META.contract * GOLD_META.pip;
  $('#req-margin').text('$' + margin.toLocaleString('en-US', {minimumFractionDigits:2}));
  $('#pip-val').text('$' + pipVal.toFixed(2));
}


// ══════════════════════════════════════════════════
//  LOAD QUEUE  (XAUUSD only)
// ══════════════════════════════════════════════════
function loadQueue() {
  $.getJSON(API + '/queue').done(res => {
    const $tb    = $('#queue-tbody').empty();
    const orders = (res.orders || [])
      .filter(o => o.symbol === GOLD_SYM)
      .slice().reverse();

    if (!orders.length) {
      $tb.html('<tr class="loading-row"><td colspan="7">NO GOLD ORDERS</td></tr>');
      return;
    }
    orders.forEach(o => {
      const time = (o.created_at || '').split(' ')[1] || '—';
      $tb.append(`
        <tr class="fade-in">
          <td style="color:var(--gray);font-size:9px">${time}</td>
          <td style="color:var(--gold)">${o.symbol}</td>
          <td><span class="tag ${o.direction}">${o.direction.toUpperCase()}</span></td>
          <td>${parseFloat(o.volume).toFixed(2)}</td>
          <td>${o.price > 0 ? parseFloat(o.price).toFixed(2) : '<span style="color:var(--gray)">MKT</span>'}</td>
          <td><span class="tag ${o.status}">${o.status}</span></td>
          <td>${o.ticket ? '#'+o.ticket : '<span style="color:var(--gray2)">—</span>'}</td>
        </tr>`);
    });
  }).fail(() => {
    $('#queue-tbody').html('<tr class="loading-row"><td colspan="7">FAILED TO LOAD</td></tr>');
  });
}


// ══════════════════════════════════════════════════
//  LOAD POSITIONS  (XAUUSD only)
// ══════════════════════════════════════════════════
function loadPositions() {
  $.ajax({ url: API + '/positions', method:'GET', dataType:'json',
           headers:{'X-Requested-With':'XMLHttpRequest'} })
  .done(res => {
    const $tb  = $('#pos-tbody').empty();
    const list = (res.positions || []).filter(p => p.symbol === GOLD_SYM || p.symbol === 'XAUUSD' || p.symbol.startsWith('XAUUSD'));
    if (!list.length) {
      $tb.html('<tr class="loading-row"><td colspan="7">NO OPEN POSITIONS</td></tr>');
      $('.cc-btn').prop('disabled', true);
      return;
    }
    $('.cc-btn').prop('disabled', false);
    list.forEach(p => {
      const pnl    = parseFloat(p.profit || 0);
      const pnlCol = pnl >= 0 ? 'var(--green)' : 'var(--red)';
      const pnlStr = (pnl >= 0 ? '+' : '') + '$' + Math.abs(pnl).toFixed(2);
      const typeLC = (p.type || '').toLowerCase();
      $tb.append(`
        <tr class="fade-in" id="posrow-${p.ticket}">
          <td style="color:var(--gold)">#${p.ticket}</td>
          <td><span class="tag ${typeLC}">${p.type}</span></td>
          <td>${parseFloat(p.volume).toFixed(2)}</td>
          <td>${parseFloat(p.open_price).toFixed(2)}</td>
          <td>${parseFloat(p.current).toFixed(2)}</td>
          <td style="color:${pnlCol};font-weight:500">${pnlStr}</td>
          <td>
            <button class="close-pos-btn"
              onclick="cfmShow('Close #${p.ticket}','${p.type}  ${parseFloat(p.volume).toFixed(2)} lots\\nยืนยันปิด position นี้?',()=>closeOne(${p.ticket}))">
              CLOSE
            </button>
          </td>
        </tr>`);
    });
  });
}


// ══════════════════════════════════════════════════
//  PLACE ORDER  —  delegates to mt5_api.js
//  mt5_api.js reads:
//    window.MT5_DIRECTION, #symbol-select, #order-type,
//    #lot-input, #pending-price, #sl-toggle, #sl-price,
//    #tp-toggle, #tp-price
// ══════════════════════════════════════════════════
function placeOrder() {
  const sym       = GOLD_SYM;
  const direction = String(curDir).toLowerCase().trim();  // force string, ป้องกัน undefined
  const orderType = $('#order-type').val();
  const volume    = parseFloat($('#lot-input').val()) || 0.01;
  const price     = orderType !== 'market' ? parseFloat($('#pending-price').val()) : 0;
  const sl        = $('#sl-toggle').is(':checked') ? parseFloat($('#sl-price').val()) : 0;
  const tp        = $('#tp-toggle').is(':checked') ? parseFloat($('#tp-price').val()) : 0;

  // Guard — ต้องเป็น buy หรือ sell เท่านั้น
  if (direction !== 'buy' && direction !== 'sell') {
    toast('ERROR', 'กรุณาเลือก BUY หรือ SELL ก่อน', 'error');
    return;
  }

  console.log('[placeOrder] direction=' + direction + ' curDir=' + curDir + ' sym=' + sym);

  const $btn = $('#submit-btn');
  $btn.prop('disabled', true).css('opacity', '0.6');

  // ส่งเป็น form-encoded (Cloudflare ไม่ block, CI4 อ่านได้ทั้ง getPost และ getJSON)
  const payload = {
    symbol: sym, direction: direction, volume: volume,
    order_type: orderType, price: price, sl: sl, tp: tp,
  };

  $.ajax({
    url:     '/api/mt5/order',
    method:  'POST',
    dataType:'json',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    data:    payload,
  })
  .done(res => {
    if (res.success) {
      toast('ORDER QUEUED',
        direction.toUpperCase() + ' ' + volume.toFixed(2) + ' ' + sym +
        ' · #' + res.order_id + ' · EA จะ execute ภายใน 2s', 'success');
      setTimeout(() => pollOrderStatus(res.order_id), 3000);
    } else {
      const msg = (res.messages && res.messages.error) || res.error || 'Validation failed';
      console.warn('[placeOrder] rejected:', res);
      toast('ORDER REJECTED', msg, 'error');
    }
  })
  .fail(err => {
    const msg = (err.responseJSON && err.responseJSON.messages && err.responseJSON.messages.error)
              || err.statusText || 'Request failed';
    console.error('[placeOrder] fail:', err.responseJSON || err);
    toast('ERROR', msg, 'error');
  })
  .always(() => $btn.prop('disabled', false).css('opacity', '1'));
}

function pollOrderStatus(orderId, attempts) {
  attempts = attempts || 0;
  if (attempts > 6) return;
  $.ajax({ url: '/api/mt5/order_status?id=' + orderId, method:'GET', dataType:'json',
           headers:{'X-Requested-With':'XMLHttpRequest'} })
  .done(res => {
    if (res.status === 'executed') {
      toast('ORDER EXECUTED', '#' + orderId + ' → MT5 Ticket #' + res.ticket + ' @ ' + (res.price || '—'), 'success');
      loadPositions();
    } else if (res.status === 'failed') {
      toast('EA REJECTED', res.error || 'MT5 rejected order', 'error');
    } else {
      setTimeout(() => pollOrderStatus(orderId, attempts + 1), 2500);
    }
  });
}


// ══════════════════════════════════════════════════
//  UI HELPERS
// ══════════════════════════════════════════════════
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
$(document).on('click', '#cfm-backdrop', e => {
  if (e.target.id === 'cfm-backdrop') cfmCancel();
});


// ══════════════════════════════════════════════════
//  CLOSE SINGLE POSITION
// ══════════════════════════════════════════════════
function closeOne(ticket) {
  $.ajax({
    url: API + '/close', method:'POST', dataType:'json',
    headers: {'X-Requested-With':'XMLHttpRequest'},
    data: { ticket: String(ticket) },
  })
  .done(res => {
    if (res.success) {
      toast('CLOSE QUEUED', '#' + ticket + ' — EA กำลัง close...', 'success');
      $(`#posrow-${ticket}`).fadeOut(300, () => loadPositions());
    } else {
      toast('CLOSE FAILED', res.error || res.message || 'Error', 'error');
    }
  })
  .fail(err => toast('ERROR', err.statusText || 'Request failed', 'error'));
}


// ══════════════════════════════════════════════════
//  BULK CLOSE
// ══════════════════════════════════════════════════
function bulkClose(endpoint) {
  const labels = { close_all:'CLOSE ALL', close_all_buy:'CLOSE ALL BUY', close_all_sell:'CLOSE ALL SELL' };
  $.ajax({
    url: API + '/' + endpoint, method:'POST', dataType:'json',
    headers: {'X-Requested-With':'XMLHttpRequest'},
    data: {},
  })
  .done(res => {
    if (res.success) {
      toast(labels[endpoint] || endpoint.toUpperCase(), 'Queued → EA จะ execute ภายใน 2s', 'success');
      setTimeout(loadPositions, 3500);
    } else {
      toast('FAILED', res.message || res.error || 'Error', 'error');
    }
  })
  .fail(err => toast('ERROR', err.statusText || 'Request failed', 'error'));
}


function setDir(dir) {
  curDir = dir;
  window.MT5_DIRECTION = dir;   // mt5_api.js อ่านจากตัวแปรนี้ — ต้อง sync ด้วย
  $('#tab-buy').toggleClass('active',  dir === 'buy');
  $('#tab-sell').toggleClass('active', dir === 'sell');
  $('#submit-btn').attr('class', `submit-btn ${dir}`).text(`${dir.toUpperCase()} GOLD`);
}

function togglePrice() {
  const show = $('#order-type').val() !== 'market';
  $('#price-group').toggle(show);
  if (show) {
    const p = curPrices[GOLD_SYM];
    $('#pending-price').val(p ? (curDir === 'buy' ? parseFloat(p.ask) : parseFloat(p.bid)).toFixed(2) : '');
  }
}

function toggleSL() {
  const show = $('#sl-toggle').is(':checked');
  $('#sl-group').toggle(show);
  if (show) {
    const p   = curPrices[GOLD_SYM];
    const ref = p ? (curDir === 'buy' ? parseFloat(p.bid) : parseFloat(p.ask)) : 2384;
    $('#sl-price').val((curDir === 'buy' ? ref - 20 : ref + 20).toFixed(2));
  }
}

function toggleTP() {
  const show = $('#tp-toggle').is(':checked');
  $('#tp-group').toggle(show);
  if (show) {
    const p   = curPrices[GOLD_SYM];
    const ref = p ? (curDir === 'buy' ? parseFloat(p.ask) : parseFloat(p.bid)) : 2384;
    $('#tp-price').val((curDir === 'buy' ? ref + 30 : ref - 30).toFixed(2));
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

function refreshAll() {
  fetchPrices();
  loadQueue();
  loadPositions();
  loadCandles();
  toast('REFRESHED', 'Data updated', 'success');
}

function switchTF(btn) {
  $('.chart-tf-btn').removeClass('active');
  $(btn).addClass('active');
  loadCandles();
}

// Tab switching — scoped to parent panel-card
$(document).on('click', '.tab-item[data-tab]', function() {
  const name    = $(this).data('tab');
  const $card   = $(this).closest('.panel-card');
  $card.find('.tab-item').removeClass('active');
  $(this).addClass('active');
  $card.find('.tab-content').removeClass('active');
  $card.find('#tab-' + name).addClass('active');
  if (name === 'pos')   loadPositions();
  if (name === 'queue') loadQueue();
});


// ══════════════════════════════════════════════════
//  CHART  —  Lightweight Charts
// ══════════════════════════════════════════════════
let lwChart      = null;
let candleSeries = null;
let chartInited  = false;

function initChart() {
  if (chartInited) return;
  const el = document.getElementById('main-chart');
  if (!el || typeof LightweightCharts === 'undefined') return;

  lwChart = LightweightCharts.createChart(el, {
    layout:    { background:{ color:'#101010' }, textColor:'#666' },
    grid:      { vertLines:{ color:'#1a1a1a' }, horzLines:{ color:'#1a1a1a' } },
    crosshair: { mode: LightweightCharts.CrosshairMode.Normal },
    rightPriceScale: { borderColor:'#222', textColor:'#666' },
    timeScale:       { borderColor:'#222', timeVisible:true, secondsVisible:false, rightOffset:5 },
    width:  el.clientWidth,
    height: el.clientHeight || 320,
  });

  candleSeries = lwChart.addCandlestickSeries({
    upColor:'#4caf7a', downColor:'#e05050',
    borderUpColor:'#4caf7a', borderDownColor:'#e05050',
    wickUpColor:'#4caf7a',   wickDownColor:'#e05050',
  });

  lwChart.subscribeCrosshairMove(p => {
    if (!p.time || !candleSeries) return;
    const d = p.seriesData.get(candleSeries);
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
    if (lwChart && el.clientWidth > 0) lwChart.resize(el.clientWidth, el.clientHeight || 320);
  }).observe(el);

  chartInited = true;
}

let lastCandleCount = 0;

function loadCandles() {
  $.ajax({
    url: API + '/candles?symbol=GOLD',
    method:'GET', dataType:'json',
    headers:{'X-Requested-With':'XMLHttpRequest'}
  }).done(res => {
    if (!res.success || !res.candles || !res.candles.length) {
      $('#chart-status').text('No candle data — EA not connected'); return;
    }
    initChart();
    const candles = res.candles.map(c => ({time:c.t, open:c.o, high:c.h, low:c.l, close:c.c}));

    if (!chartInited || candles.length !== lastCandleCount) {
      // Full reload (first load or new bar arrived)
      candleSeries.setData(candles);
      lwChart.timeScale().fitContent();
      lastCandleCount = candles.length;
    } else {
      // Lightweight update — just update last bar (price changed)
      candleSeries.update(candles[candles.length - 1]);
    }

    const last = candles[candles.length - 1];
    const clr  = last.close >= last.open ? '#4caf7a' : '#e05050';
    $('#chart-status').text('GOLD  ' + (res.timeframe || 'M15') + '  ' + candles.length + ' bars');
    $('#chart-ohlc').html('<span style="color:var(--gray)">C</span> <span style="color:' + clr + '">' + parseFloat(last.close).toFixed(2) + '</span>');
  }).fail(() => {
    $('#chart-status').text('candles API error — EA offline?');
  });
}


// ══════════════════════════════════════════════════
//  AI CHART ANALYSIS  —  Claude Vision
// ══════════════════════════════════════════════════
let aiImageBase64 = null;

// Drag & Drop
function handleAiDrop(e) {
  e.preventDefault();
  $('#ai-upload-zone').removeClass('drag');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) handleAiFile(file);
}

$(document).on('change', '#ai-file-input', function() {
  handleAiFile(this.files[0]);
});

function handleAiFile(file) {
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
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

  const userPrompt = $('#ai-prompt').val().trim() ||
    'Analyse this XAUUSD gold chart. Identify support and resistance zones. Give a trade signal: BUY, SELL, or WAIT.';

  const systemPrompt =
    `You are an expert gold (XAUUSD) technical analyst specialising in precious metals trading.\n` +
    `Analyse the provided chart image and respond ONLY with valid JSON in this exact format:\n` +
    `{\n` +
    `  "signal": "BUY" | "SELL" | "WAIT",\n` +
    `  "confidence": <number 0-100>,\n` +
    `  "resistance": "<price level or zone e.g. 2350.00 - 2355.00>",\n` +
    `  "support": "<price level or zone e.g. 2310.00 - 2315.00>",\n` +
    `  "description": "<Thai language analysis: อธิบายแนวรับแนวต้าน, รูปแบบราคาทองคำ, สัญญาณการเทรด และเหตุผล 3-5 ประโยค>"\n` +
    `}\n` +
    `Do not include any text outside the JSON object.`;

  try {

    const response = await fetch('/api/ai/claude', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify({
        model:      'claude-sonnet-4-6',
        max_tokens: 1000,
        system:     systemPrompt,
        messages: [{
          role: 'user',
          content: [
            { type: 'image', source: { type: 'base64', media_type: 'image/jpeg', data: aiImageBase64 } },
            { type: 'text',  text: userPrompt }
          ]
        }],
      })
    });

    const res = await response.json();
    if (!res.success) throw new Error(res.messages?.error || res.error || 'Proxy error');

    const data    = res.data;
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
    console.error('[GoldAI]', err);
  } finally {
    $('#ai-analyse-btn').prop('disabled', false);
    $('#ai-spinner').removeClass('show');
    $('#ai-btn-label').text('◈ ANALYSE GOLD CHART');
  }
}

function renderAiResult(r) {
  const signal = (r.signal || 'WAIT').toUpperCase();
  const conf   = Math.min(100, Math.max(0, parseInt(r.confidence) || 50));
  aiLastSignal = { signal, support: r.support, resistance: r.resistance };

  $('#ai-signal-badge').text(signal).attr('class', 'ai-signal ' + signal);
  $('#ai-conf-text').text('Confidence ' + conf + '%');
  $('#ai-conf-fill').css('width', conf + '%').attr('class', 'ai-conf-fill ' + signal);
  $('#ai-resistance').text(r.resistance || '—');
  $('#ai-support').text(r.support || '—');
  $('#ai-description').text(r.description || '—');

  if (signal === 'BUY' || signal === 'SELL') {
    $('#ai-apply-btn')
      .attr('class', 'ai-apply-btn ' + signal + ' show')
      .text('↗ APPLY ' + signal + ' SIGNAL TO ORDER FORM');
  } else {
    $('#ai-apply-btn').removeClass('show');
  }

  $('#ai-result').addClass('show');
  toast(
    'AI ANALYSIS COMPLETE',
    signal + '  Confidence ' + conf + '%',
    signal === 'BUY' ? 'success' : signal === 'SELL' ? 'error' : ''
  );
}

// Apply AI signal → pre-fills direction on order form
function applyAiSignal() {
  if (!aiLastSignal) return;
  const { signal } = aiLastSignal;
  if (signal !== 'BUY' && signal !== 'SELL') return;
  setDir(signal.toLowerCase());
  toast('AI SIGNAL APPLIED', signal + ' GOLD — ตรวจสอบ SL/TP ก่อน execute', 'success');
}


// ══════════════════════════════════════════════════
//  INIT
// ══════════════════════════════════════════════════
$(document).ready(function() {

  remapApiNotif();     // redirect MT5Api notifications to our toast

  setDir('buy');
  updateMargin();
  fetchPrices();
  loadQueue();
  loadPositions();
  initChart();
  loadCandles();

  // Polling intervals
  setInterval(fetchPrices,  3000);   // prices every 3s
  setInterval(loadCandles, 15000);   // candles every 15s
  setInterval(function() {           // active tab (queue/pos panel) every 5s
    const id = $('#queue-pos-panel .tab-content.active').attr('id');
    if (id === 'tab-queue') loadQueue();
    if (id === 'tab-pos')   loadPositions();
  }, 5000);

});
</script>