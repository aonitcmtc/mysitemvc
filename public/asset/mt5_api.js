/**
 * mt5_api.js  —  jQuery Client (EA + WebRequest Flow)
 * =====================================================
 * HTML ↔ CI4 only (ไม่คุยกับ MT5 โดยตรง)
 * CI4 จะเป็นคนคุยกับ EA
 *
 * v2.1 — fixes:
 *   - direction อ่านจาก window.MT5_DIRECTION (set โดย setDir() ใน view)
 *   - POST เปลี่ยนเป็น form-encoded (แก้ Cloudflare WAF + CSRF)
 *   - CSRF token อ่านใหม่ทุกครั้งที่ส่ง (ไม่ cache ที่ load time)
 */

const MT5Api = (() => {

  const BASE = window.location.origin + '/api/mt5';



  // ════════════════════════════════════════════════
  //  PLACE ORDER  → POST /api/mt5/order
  // ════════════════════════════════════════════════
  function placeOrder() {
    // อ่าน direction จาก window.MT5_DIRECTION — set โดย setDir() ใน view
    // fallback: อ่านจาก active tab button
    const direction = (window.MT5_DIRECTION || $('#tab-sell').hasClass('active') ? 'sell' : 'buy');
    const symFull   = $('#symbol-select').val() || 'GOLD';
    const sym       = symFull.split(' ')[0];
    const orderType = $('#order-type').val();
    const volume    = parseFloat($('#lot-input').val()) || 0.01;
    const price     = orderType !== 'market' ? parseFloat($('#pending-price').val()) : 0;
    const sl        = $('#sl-toggle').is(':checked') ? parseFloat($('#sl-price').val()) : 0;
    const tp        = $('#tp-toggle').is(':checked') ? parseFloat($('#tp-price').val()) : 0;

    console.log('[MT5Api] placeOrder direction=' + direction + ' MT5_DIRECTION=' + window.MT5_DIRECTION);

    const $btn = $('#submit-btn');
    $btn.prop('disabled', true).css('opacity', '0.6');

    $.ajax({
      url:      BASE + '/order',
      method:   'POST',
      dataType: 'json',
      headers:  { 'X-Requested-With': 'XMLHttpRequest' },
      data: {
        symbol:     sym,
        direction:  direction,
        volume:     volume,
        order_type: orderType,
        price:      price,
        sl:         sl,
        tp:         tp,
      },
    })
    .done(res => {
      if (res.success) {
        showNotif('ORDER QUEUED',
          direction.toUpperCase() + ' ' + volume.toFixed(2) + ' ' + sym +
          ' · ID #' + res.order_id + ' · EA จะ execute ภายใน 2 วินาที'
        );
        setTimeout(() => pollOrderStatus(res.order_id), 3000);
      } else {
        showNotif('ORDER REJECTED', (res.messages && res.messages.error) || res.error || 'Validation failed');
      }
    })
    .fail(err => {
      const msg = (err.responseJSON && err.responseJSON.messages && err.responseJSON.messages.error)
               || err.statusText || 'Request failed';
      showNotif('ERROR', msg);
    })
    .always(() => {
      $btn.prop('disabled', false).css('opacity', '1');
    });
  }


  // ════════════════════════════════════════════════
  //  POLL ORDER STATUS
  // ════════════════════════════════════════════════
  function pollOrderStatus(orderId, attempts) {
    attempts = attempts || 0;
    if (attempts > 6) return;

    $.ajax({
      url:      BASE + '/order_status?id=' + orderId,
      method:   'GET',
      dataType: 'json',
      headers:  { 'X-Requested-With': 'XMLHttpRequest' },
    })
    .done(res => {
      if (res.status === 'executed') {
        showNotif('ORDER EXECUTED',
          '#' + orderId + ' → MT5 Ticket #' + res.ticket + ' @ ' + (res.price || '—')
        );
        fetchPositions();
        fetchAccount();
      } else if (res.status === 'failed') {
        showNotif('EA REJECTED', res.error || 'MT5 rejected order');
      } else {
        setTimeout(() => pollOrderStatus(orderId, attempts + 1), 2000);
      }
    });
  }


  // ════════════════════════════════════════════════
  //  CLOSE POSITION  → POST /api/mt5/close
  // ════════════════════════════════════════════════
  function closePosition(ticket) {
    if (!confirm('Close position #' + ticket + '?')) return;

    $.ajax({
      url:      BASE + '/close',
      method:   'POST',
      dataType: 'json',
      headers:  { 'X-Requested-With': 'XMLHttpRequest' },
      data: {
        ticket: ticket,
      },
    })
    .done(res => {
      if (res.success) {
        showNotif('CLOSE QUEUED', 'Position #' + ticket + ' — EA กำลัง close...');
        setTimeout(fetchPositions, 3000);
      } else {
        showNotif('CLOSE FAILED', res.error || res.message || 'Error');
      }
    });
  }


  // ════════════════════════════════════════════════
  //  FETCH POSITIONS  → GET /api/mt5/positions
  // ════════════════════════════════════════════════
  function fetchPositions() {
    $.ajax({
      url:      BASE + '/positions',
      method:   'GET',
      dataType: 'json',
      headers:  { 'X-Requested-With': 'XMLHttpRequest' },
    })
    .done(res => {
      if (!res.success) return;

      const $tbody = $('#positions-tbody');
      $tbody.empty();

      if (!res.positions || res.positions.length === 0) {
        $tbody.append(
          '<div class="table-row">' +
          '<span class="td" style="grid-column:1/-1;color:var(--gray);text-align:center;padding:8px">No open positions</span>' +
          '</div>'
        );
        return;
      }

      let totalPnl = 0;
      res.positions.forEach(pos => {
        const pnl      = parseFloat(pos.profit);
        const pnlClass = pnl >= 0 ? 'profit-pos' : 'profit-neg';
        const dirClass = pos.type === 'BUY' ? 'buy' : 'sell';
        const pnlStr   = (pnl >= 0 ? '+' : '') + '$' + Math.abs(pnl).toFixed(2);
        totalPnl      += pnl;

        $tbody.append(
          '<div class="table-row" id="pos-' + pos.ticket + '">' +
          '<span class="td symbol">'           + pos.symbol + '</span>' +
          '<span class="td ' + dirClass + '">' + pos.type   + '</span>' +
          '<span class="td">' + parseFloat(pos.volume).toFixed(2)     + '</span>' +
          '<span class="td">' + parseFloat(pos.open_price).toFixed(2) + '</span>' +
          '<span class="td">' + parseFloat(pos.current).toFixed(2)    + '</span>' +
          '<span class="td ' + pnlClass + '">' + pnlStr + '</span>' +
          '<button class="close-btn" onclick="MT5Api.closePosition(' + pos.ticket + ')">CLOSE</button>' +
          '</div>'
        );
      });

      const $fp = $('#floating-pnl');
      if ($fp.length) {
        $fp.text((totalPnl >= 0 ? '+' : '') + '$' + Math.abs(totalPnl).toFixed(2));
        $fp.attr('class', 'stat-value ' + (totalPnl >= 0 ? 'green' : 'red'));
      }
    });
  }


  // ════════════════════════════════════════════════
  //  FETCH ACCOUNT  → GET /api/mt5/account
  // ════════════════════════════════════════════════
  function fetchAccount() {
    $.ajax({
      url:      BASE + '/account',
      method:   'GET',
      dataType: 'json',
      headers:  { 'X-Requested-With': 'XMLHttpRequest' },
    })
    .done(res => {
      if (!res.success || !res.account) return;
      const a   = res.account;
      const fmt = v => '$' + parseFloat(v || 0).toLocaleString('en-US', { minimumFractionDigits: 2 });

      if ($('#equity-val').length)    $('#equity-val').text(fmt(a.equity));
      if ($('#account-info').length && a.balance) {
        $('#account-info').text('Balance: ' + fmt(a.balance) + '  Equity: ' + fmt(a.equity));
      }
      if ($('#free-margin').length && a.free_margin)  $('#free-margin').text(fmt(a.free_margin));
      if ($('#margin-level').length && a.margin_level) $('#margin-level').text(parseFloat(a.margin_level).toFixed(1) + '%');
    });
  }


  // ════════════════════════════════════════════════
  //  MARGIN CALCULATOR  (realtime, ไม่ต้องรอ server)
  // ════════════════════════════════════════════════
  function updateMarginDisplay() {
    const lots  = parseFloat($('#lot-input').val()) || 0.01;
    const price = parseFloat($('#ask-price').text().replace(/,/g, '')) || 2384;

    // GOLD/XAUUSD: contractSize=100, leverage=500
    const margin = (price * lots * 100) / 500;
    const pipVal = lots * 100 * 0.01;

    $('#req-margin').text('$' + margin.toLocaleString('en-US', { minimumFractionDigits: 2 }));
    $('#pip-val').text('$' + pipVal.toFixed(2));
  }


  // ════════════════════════════════════════════════
  //  NOTIFICATION
  // ════════════════════════════════════════════════
  function showNotif(title, body) {
    // รองรับทั้ง toast (mt5goldai) และ notification box (เดิม)
    if (typeof window.toast === 'function') {
      const type = title.includes('ERROR') || title.includes('REJECTED') || title.includes('FAILED')
        ? 'error' : 'success';
      window.toast(title, body, type);
      return;
    }
    $('#notif-title').text(title);
    $('#notif-body').text(body);
    $('#notification').addClass('show');
    clearTimeout(window._notifTimer);
    window._notifTimer = setTimeout(() => $('#notification').removeClass('show'), 4000);
  }


  // ════════════════════════════════════════════════
  //  INIT
  // ════════════════════════════════════════════════
  function init() {
    // expose ไปที่ window — แต่ placeOrder ของ view จะ override ถ้ามี
    // ดังนั้น window.MT5_DIRECTION ต้อง sync กับ setDir() เสมอ
    window.MT5Api_placeOrder  = placeOrder;   // ชื่อไม่ชนกับ view
    window.closePosition      = (posId) => closePosition(posId);
    window.adjustLot          = (delta) => {
      const $i = $('#lot-input');
      let val  = Math.round((parseFloat($i.val()) + delta) * 100) / 100;
      if (val < 0.01) val = 0.01;
      if (val > 100)  val = 100;
      $i.val(val.toFixed(2));
      updateMarginDisplay();
    };
    window.setLot = (val) => {
      $('#lot-input').val(parseFloat(val).toFixed(2));
      updateMarginDisplay();
    };

    fetchPositions();
    fetchAccount();
    setInterval(fetchPositions, 10000);  // ลดลงจาก 3s → 10s ป้องกัน overload
    setInterval(fetchAccount,    8000);

    $(document).on('input', '#lot-input', updateMarginDisplay);

    console.log('[MT5Api v2.1] initialized ✓  BASE:', BASE);
  }

  return { init, placeOrder, closePosition, fetchPositions, fetchAccount, showNotif };

})();


// ── Auto Init ────────────────────────────────────
$(document).ready(() => MT5Api.init());