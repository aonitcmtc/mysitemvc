<!-- <title>สมุดบันทึกการซื้อสินค้า</title> -->
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Google Font: Sarabun -->
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
      background: #e8e8e8;
      font-family: 'Sarabun', system-ui, -apple-system, sans-serif;
      padding: 0;
      margin: 0;
    }

    .notebook {
      max-width: 960px;
      margin: 80px auto 40px;
      background: #fffef7;
      border: 1px solid #d0c9b8;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15), inset 0 0 80px rgba(0,0,0,0.03);
      position: relative;
      overflow: hidden;
    }

    .notebook::before {
      content: "";
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(to bottom, transparent 0, transparent 24px, #c2baa8 24px, #a8b0c2 25px);
      pointer-events: none;
      z-index: 1;
      margin-top: 110px;
      margin-bottom: 80px;
    }

    .notebook::after {
      content: "";
      position: absolute;
      left: 60px; top: 0; bottom: 0;
      width: 2px;
      background: #c94b4b;
      opacity: 0.4;
      z-index: 1;
    }

    .form-container {
      position: relative;
      z-index: 2;
      padding: 60px 40px 40px 70px;
    }

    .select2-container .select2-selection--single {
      background: transparent;
      border: none;
      border-bottom: 1.5px dashed #888;
      border-radius: 0;
      height: auto;
      padding: 0.35rem 0;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      color: #111;
      line-height: 1.6;
      padding: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 100%;
    }

    .form-control, .form-select {
      background: transparent;
      border: none;
      border-bottom: 1.5px dashed #888;
      border-radius: 0;
      padding: 0.4rem 0;
      font-size: 1.05rem;
      color: #111;
      transition: all 0.15s;
    }

    .form-control:focus, .form-select:focus {
      background: rgba(255,255,180,0.15);
      border-bottom-color: #555;
      box-shadow: none;
    }

    .table th {
      background: #f8f4e9;
      border-bottom: 2px solid #c9b38a;
      color: #444;
      font-weight: 600;
    }

    .table td {
      border-top: none;
      border-bottom: 1px dashed #aaa;
      vertical-align: middle;
    }

    .btn-remove {
      color: #dc3545;
      font-size: 1.5rem;
      line-height: 1;
      opacity: 0.7;
      background: none;
      border: none;
      cursor: pointer;
      transition: all 0.15s;
    }

    .btn-remove:hover {
      opacity: 1;
      transform: scale(1.25);
    }

    .total-amount {
      font-size: 1.9rem;
      font-weight: 700;
      color: #b02a37;
    }

    /* ===== ปุ่มส่งออกใบเสร็จ ===== */
    .btn-export-receipt {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #7b4f12 0%, #c4801a 100%);
      color: #fff;
      font-family: 'Sarabun', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 10px 28px;
      cursor: pointer;
      box-shadow: 0 3px 10px rgba(123,79,18,0.35);
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }
    .btn-export-receipt::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
      pointer-events: none;
    }
    .btn-export-receipt:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(123,79,18,0.45);
    }
    .btn-export-receipt:active {
      transform: translateY(0);
    }

    /* ===== Modal ใบเสร็จ ===== */
    #receiptModal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.55);
      z-index: 9998;
      overflow-y: auto;
      padding: 30px 15px;
    }
    #receiptModal.open { display: flex; align-items: flex-start; justify-content: center; }

    .receipt-wrapper {
      background: #fff;
      width: 100%;
      max-width: 680px;
      border-radius: 4px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.25);
      overflow: hidden;
      position: relative;
    }

    /* ปุ่มปิด modal */
    .receipt-close-btn {
      position: absolute;
      top: 14px; right: 16px;
      background: none;
      border: none;
      font-size: 1.6rem;
      color: #999;
      cursor: pointer;
      line-height: 1;
      z-index: 10;
      transition: color 0.15s;
    }
    .receipt-close-btn:hover { color: #333; }

    /* ===== ตัวใบเสร็จ ===== */
    #receiptDoc {
      padding: 40px 44px 32px;
      font-family: 'Sarabun', sans-serif;
      color: #1a1a1a;
      background: #fff;
    }

    .receipt-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 3px solid #1a1a1a;
      padding-bottom: 18px;
      margin-bottom: 22px;
    }

    .receipt-brand h1 {
      font-size: 1.55rem;
      font-weight: 700;
      margin: 0 0 2px;
      letter-spacing: 0.02em;
    }
    .receipt-brand p {
      font-size: 0.82rem;
      color: #666;
      margin: 0;
    }

    .receipt-meta {
      text-align: right;
      font-size: 0.88rem;
    }
    .receipt-meta .receipt-no {
      font-size: 1.15rem;
      font-weight: 700;
      color: #c4801a;
    }
    .receipt-meta p { margin: 2px 0; color: #555; }

    .receipt-parties {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 24px;
      background: #fafaf7;
      border: 1px solid #e8e2d4;
      border-radius: 4px;
      padding: 14px 18px;
      font-size: 0.9rem;
    }
    .receipt-parties .label {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #999;
      margin-bottom: 3px;
    }
    .receipt-parties .value {
      font-weight: 600;
      color: #1a1a1a;
    }

    /* ตารางสินค้า */
    .receipt-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
      margin-bottom: 0;
    }
    .receipt-table thead tr {
      background: #1a1a1a;
      color: #fff;
    }
    .receipt-table thead th {
      padding: 9px 12px;
      font-weight: 600;
      letter-spacing: 0.03em;
    }
    .receipt-table tbody tr:nth-child(even) { background: #fafaf8; }
    .receipt-table tbody td {
      padding: 9px 12px;
      border-bottom: 1px solid #ece8df;
    }
    .receipt-table tfoot td {
      padding: 10px 12px;
      font-weight: 700;
      border-top: 2px solid #1a1a1a;
    }
    .receipt-table .text-right { text-align: right; }
    .receipt-table .text-center { text-align: center; }

    .receipt-grand-total {
      font-size: 1.3rem;
      color: #c4801a;
    }

    .receipt-footer-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 28px;
      padding-top: 18px;
      border-top: 1px dashed #ccc;
      font-size: 0.85rem;
      color: #666;
      gap: 20px;
    }
    .receipt-note { max-width: 55%; }
    .receipt-note .label {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: #aaa;
      margin-bottom: 3px;
    }
    .receipt-sig {
      text-align: center;
      min-width: 140px;
    }
    .receipt-sig .sig-line {
      border-top: 1px solid #333;
      margin-bottom: 5px;
      margin-top: 32px;
    }

    .receipt-stamp {
      text-align: center;
      margin-top: 20px;
    }
    .receipt-stamp span {
      display: inline-block;
      border: 2.5px solid #2c7a4b;
      color: #2c7a4b;
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 0.15em;
      padding: 4px 16px;
      border-radius: 3px;
      transform: rotate(-3deg);
      opacity: 0.75;
    }

    /* ปุ่มในบาร์ด้านล่าง modal */
    .receipt-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding: 16px 24px;
      background: #f4f1eb;
      border-top: 1px solid #e0d9cc;
    }
    .receipt-actions button {
      font-family: 'Sarabun', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      border-radius: 6px;
      padding: 8px 22px;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      transition: all 0.15s;
    }
    .btn-receipt-print {
      background: #1a1a1a;
      color: #fff;
    }
    .btn-receipt-print:hover { background: #333; }
    .btn-receipt-cancel {
      background: #e0d9cc;
      color: #555;
    }
    .btn-receipt-cancel:hover { background: #ccc4b4; }
    .btn-receipt-save-img {
      background: linear-gradient(135deg, #2c7a4b 0%, #3aa36a 100%);
      color: #fff;
    }
    .btn-receipt-save-img:hover { filter: brightness(1.1); }

    /* Print styles */
    @media print {
      body > *:not(#receiptModal) { display: none !important; }
      #receiptModal {
        display: block !important;
        position: static !important;
        background: none !important;
        padding: 0 !important;
        overflow: visible !important;
      }
      .receipt-wrapper {
        box-shadow: none !important;
        max-width: 100% !important;
      }
      .receipt-close-btn,
      .receipt-actions { display: none !important; }
      #receiptDoc { padding: 10mm 14mm !important; }
    }
    .btn-save-image {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #2c7a4b 0%, #3aa36a 100%);
      color: #fff;
      font-family: 'Sarabun', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 10px 28px;
      cursor: pointer;
      box-shadow: 0 3px 10px rgba(44,122,75,0.35);
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }

    .btn-save-image::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
      pointer-events: none;
    }

    .btn-save-image:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(44,122,75,0.45);
    }

    .btn-save-image:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(44,122,75,0.3);
    }

    .btn-save-image svg {
      flex-shrink: 0;
    }

    /* สถานะขณะบันทึก */
    .btn-save-image.loading {
      pointer-events: none;
      opacity: 0.8;
    }

    .btn-save-image.loading .btn-label { display: none; }
    .btn-save-image .btn-loading { display: none; }
    .btn-save-image.loading .btn-loading { display: inline-flex; align-items: center; gap: 6px; }

    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner-icon { animation: spin 0.8s linear infinite; }

    /* Toast notification */
    #toast-notify {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #2c7a4b;
      color: #fff;
      padding: 12px 22px;
      border-radius: 8px;
      font-family: 'Sarabun', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      box-shadow: 0 4px 14px rgba(0,0,0,0.2);
      opacity: 0;
      transform: translateY(12px);
      transition: opacity 0.3s, transform 0.3s;
      z-index: 9999;
      pointer-events: none;
    }

    #toast-notify.show {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 576px) {
      .form-container { padding: 40px 20px 30px; }
      .notebook::after { display: none; }


      /* ซ่อน thead บน mobile */
      #itemsTable thead { display: none; }

      /* แต่ละ tr เป็น card */
      #itemsTable tbody tr {
        display: flex;
        flex-direction: column;
        border: 1px dashed #c9b38a;
        border-radius: 6px;
        padding: 12px 14px;
        margin-bottom: 12px;
        background: rgba(255,254,247,0.85);
      }

      #itemsTable tbody td {
        border: none !important;
        padding: 4px 0;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      #itemsTable tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #888;
        font-size: 0.82rem;
        min-width: 84px;
        flex-shrink: 0;
      }

      #itemsTable tbody td.td-no {
        font-weight: 700;
        color: #c94b4b;
        font-size: 0.85rem;
        border-bottom: 1px dashed #ddd !important;
        padding-bottom: 8px;
        margin-bottom: 4px;
      }

      #itemsTable tbody td.td-no::before { content: "รายการที่ "; min-width: unset; }

      #itemsTable tbody td.item-total {
        font-size: 1.05rem;
        color: #b02a37;
        border-top: 1px dashed #ddd !important;
        margin-top: 4px;
        padding-top: 8px;
      }

      #itemsTable tbody td.item-total::before { color: #b02a37; }

      #itemsTable tbody td.td-action { justify-content: flex-end; }
      #itemsTable tbody td.td-action::before { content: ""; min-width: 0; }

      /* tfoot */
      #itemsTable tfoot tr {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding: 6px 0 0;
      }
      #itemsTable tfoot td { border: none !important; padding: 0; }
      #itemsTable tfoot td:nth-child(1),
      #itemsTable tfoot td:nth-child(2),
      #itemsTable tfoot td:nth-child(3),
      #itemsTable tfoot td:nth-child(6) { display: none; }
    }
</style>
<div class="container-fluid landingpage">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <div class="notebook" id="notebookCapture">
                <div class="form-container">

                    <div class="text-center mb-5">
                    <h2 class="fw-bold">สมุดบันทึกการซื้อสินค้า</h2>
                    <small id="note_date" class="text-muted">วันที่ ............................................</small>
                    </div>

                    <form id="purchaseForm">
                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                        <label class="form-label">เลขที่ใบเสร็จ/รายการ</label>
                        <input type="text" class="form-control" placeholder="เช่น 001/2568">
                        </div>
                        <div class="col-md-4">
                        <label class="form-label">ผู้ขาย / ร้านค้า</label>
                        <select class="form-select select2-seller" id="sellerInput">
                            <option></option>
                            <option value="ตลาดสด">ตลาดสด</option>
                            <option value="7-11">7-11</option>
                            <option value="goldbal">goldbal</option>
                        </select>
                        </div>
                        <div class="col-md-4">
                        <label class="form-label">ประเภทการจ่ายเงิน</label>
                        <select class="form-select">
                            <option>เงินสด</option>
                            <option>โอนเงิน</option>
                            <option>บัตรเครดิต</option>
                            <option>อื่นๆ</option>
                        </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">รายการสินค้า</h5>
                        <button type="button" class="btn btn-sm btn-success" id="addRowBtn">+ เพิ่มรายการสินค้า</button>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table" id="itemsTable">
                        <thead>
                            <tr>
                            <th width="50">ที่</th>
                            <th>รายการสินค้า / รายละเอียด</th>
                            <th width="120" class="text-center">จำนวน</th>
                            <th width="150" class="text-end">ราคาต่อหน่วย</th>
                            <th width="150" class="text-end">ราคารวม</th>
                            <th width="60"></th>
                            </tr>
                        </thead>
                        <tbody id="itemRows">
                            <tr>
                            <td class="td-no">1</td>
                            <td data-label="สินค้า">
                                <select class="form-select item-name select2">
                                <option></option>
                                <option value="ข้าวหอมมะลิ 5 กก.">ข้าวหอมมะลิ 5 กก.</option>
                                <option value="น้ำตาลทราย 1 กก.">น้ำตาลทราย 1 กก.</option>
                                <option value="น้ำมันพืช 1 ลิตร">น้ำมันพืช 1 ลิตร</option>
                                <option value="ปลากระป๋อง">ปลากระป๋อง</option>
                                <option value="ผงซักฟอก">ผงซักฟอก</option>
                                </select>
                            </td>
                            <td data-label="จำนวน"><input type="number" class="form-control text-center item-qty" value="1" min="1" step="1"></td>
                            <td data-label="ราคา/หน่วย"><input type="number" class="form-control text-end item-price" value="0.00" min="0" step="0.01"></td>
                            <td data-label="รวม" class="fw-bold item-total">0.00 บาท</td>
                            <td class="td-action"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                            <td colspan="3"></td>
                            <td class="text-end fw-bold">รวมทั้งสิ้น</td>
                            <td class="text-end total-amount" id="grandTotal">0.00 บาท</td>
                            <td></td>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                        <label class="form-label">หมายเหตุ</label>
                        <textarea class="form-control" rows="3" placeholder="เช่น ซื้อเพื่อใช้ในงาน..."></textarea>
                        </div>
                        <div class="col-md-6">
                        <label class="form-label">ผู้บันทึก</label>
                        <input type="text" class="form-control" placeholder="ชื่อ-นามสกุล" value="<?=$userName?>">
                        </div>
                    </div>

                    <!-- ===== ปุ่มทั้งหมด ===== -->
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary btn-lg px-5">บันทึกข้อมูล</button>

                        <!-- ปุ่มบันทึกเป็นรูป -->
                        <button type="button" class="btn-save-image" id="saveImageBtn">
                        <svg class="btn-label" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        <span class="btn-label">บันทึกเป็นรูปภาพ</span>
                        <span class="btn-loading">
                            <svg class="spinner-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                            </svg>
                            กำลังบันทึก...
                        </span>
                        </button>

                        <!-- ปุ่มส่งออกใบเสร็จ -->
                        <button type="button" class="btn-export-receipt" id="exportReceiptBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                        ส่งออกใบเสร็จ
                        </button>
                    </div>

                    </form>
                </div>
                </div>

        </div>
    </div>
</div>



<!-- ===== Modal ใบเสร็จ ===== -->
<div id="receiptModal">
  <div class="receipt-wrapper">
    <button class="receipt-close-btn" id="receiptCloseBtn" title="ปิด">×</button>

    <!-- ตัวใบเสร็จ -->
    <div id="receiptDoc">
      <!-- Header -->
      <div class="receipt-header">
        <div class="receipt-brand">
          <h1>ใบเสร็จรับเงิน</h1>
          <p>RECEIPT / TAX INVOICE</p>
        </div>
        <div class="receipt-meta">
          <div class="receipt-no" id="r-receipt-no">เลขที่ —</div>
          <p id="r-date">วันที่ —</p>
          <p id="r-payment">ชำระโดย —</p>
        </div>
      </div>

      <!-- ผู้ขาย / ผู้ซื้อ -->
      <div class="receipt-parties">
        <div>
          <div class="label">ผู้ขาย / ร้านค้า</div>
          <div class="value" id="r-seller">—</div>
        </div>
        <div>
          <div class="label">ผู้บันทึก</div>
          <div class="value" id="r-recorder">—</div>
        </div>
      </div>

      <!-- ตารางสินค้า -->
      <table class="receipt-table">
        <thead>
          <tr>
            <th style="width:40px">ที่</th>
            <th>รายการสินค้า</th>
            <th class="text-center" style="width:80px">จำนวน</th>
            <th class="text-right" style="width:110px">ราคา/หน่วย</th>
            <th class="text-right" style="width:110px">รวม (บาท)</th>
          </tr>
        </thead>
        <tbody id="r-items"></tbody>
        <tfoot>
          <tr>
            <td colspan="4" class="text-right">รวมทั้งสิ้น</td>
            <td class="text-right receipt-grand-total" id="r-grand-total">0.00</td>
          </tr>
        </tfoot>
      </table>

      <!-- Footer -->
      <div class="receipt-footer-row">
        <div class="receipt-note">
          <div class="label">หมายเหตุ</div>
          <div id="r-note">—</div>
        </div>
        <div class="receipt-sig">
          <div class="sig-line"></div>
          <div id="r-sig-name">ผู้รับเงิน</div>
        </div>
      </div>

      <div class="receipt-stamp">
        <span>ชำระเงินแล้ว</span>
      </div>
    </div>

    <!-- Action bar -->
    <div class="receipt-actions">
      <button class="btn-receipt-cancel" id="receiptCloseBtn2">ปิด</button>
      <button class="btn-receipt-save-img" id="receiptSaveImgBtn">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
          <circle cx="12" cy="13" r="4"/>
        </svg>
        <span class="r-btn-label">บันทึกเป็นรูป</span>
        <span class="r-btn-loading" style="display:none">
          <svg class="spinner-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
          กำลังบันทึก...
        </span>
      </button>
      <button class="btn-receipt-print" id="receiptPrintBtn">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        พิมพ์ / บันทึก PDF
      </button>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast-notify">📸 บันทึกรูปภาพเรียบร้อยแล้ว!</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
  $(function () {

    const $tbody = $('#itemRows');
    const $grandTotal = $('#grandTotal');

    function initSelect2($element) {
      $element.select2({
        tags: true,
        placeholder: "พิมพ์หรือเลือกสินค้า...",
        allowClear: true,
        width: '100%',
        createTag: function (params) {
          var term = $.trim(params.term);
          if (term === '') return null;
          return { id: term, text: term };
        }
      });
    }

    $('.select2').each(function () { initSelect2($(this)); });

    // ✅ Init select2 สำหรับ ผู้ขาย / ร้านค้า
    $('#sellerInput').select2({
      tags: true,
      placeholder: "พิมพ์หรือเลือกร้านค้า...",
      allowClear: true,
      width: '100%',
      createTag: function (params) {
        var term = $.trim(params.term);
        if (term === '') return null;
        return { id: term, text: term };
      }
    });

    function updateRowNumbers() {
      $tbody.find('tr').each(function (i) { $(this).find('td.td-no').text(i + 1); });
    }

    function calculateRowTotal($row) {
      let qty   = parseFloat($row.find('.item-qty').val())   || 0;
      let price = parseFloat($row.find('.item-price').val()) || 0;
      if (qty < 1)   { $row.find('.item-qty').val(1);   qty = 1; }
      if (price < 0) { $row.find('.item-price').val(0); price = 0; }
      $row.find('.item-total').text((qty * price).toFixed(2) + ' บาท');
      calculateGrandTotal();
    }

    function calculateGrandTotal() {
      let sum = 0;
      $tbody.find('.item-total').each(function () {
        sum += parseFloat($(this).text().replace(' บาท', '')) || 0;
      });
      $grandTotal.text(sum.toFixed(2) + ' บาท');
    }

    function refreshRemoveButtons() {
      const rowCount = $tbody.find('tr').length;
      $tbody.find('tr').each(function () {
        const $lastTd = $(this).find('td:last');
        if (rowCount > 1) {
          if (!$lastTd.find('.btn-remove').length) {
            $lastTd.html('<button type="button" class="btn-remove">×</button>');
          }
        } else {
          $lastTd.empty();
        }
      });
    }

    $('#addRowBtn').on('click', function () {
      const rowIndex = $tbody.find('tr').length + 1;
      const $newRow = $(`
        <tr>
          <td class="td-no">${rowIndex}</td>
          <td data-label="สินค้า">
            <select class="form-select item-name select2">
              <option></option>
              <option value="ข้าวหอมมะลิ 5 กก.">ข้าวหอมมะลิ 5 กก.</option>
              <option value="น้ำตาลทราย 1 กก.">น้ำตาลทราย 1 กก.</option>
              <option value="น้ำมันพืช 1 ลิตร">น้ำมันพืช 1 ลิตร</option>
              <option value="ปลากระป๋อง">ปลากระป๋อง</option>
              <option value="ผงซักฟอก">ผงซักฟอก</option>
            </select>
          </td>
          <td data-label="จำนวน"><input type="number" class="form-control text-center item-qty" value="1" min="1" step="1"></td>
          <td data-label="ราคา/หน่วย"><input type="number" class="form-control text-end item-price" value="0.00" min="0" step="0.01"></td>
          <td data-label="รวม" class="fw-bold item-total">0.00 บาท</td>
          <td class="td-action"></td>
        </tr>
      `);
      $tbody.append($newRow);
      initSelect2($newRow.find('.select2'));
      $newRow.find('.item-qty, .item-price').on('input', function () { calculateRowTotal($newRow); });
      refreshRemoveButtons();
      calculateGrandTotal();
      $newRow.find('.select2').select2('open');
    });

    $tbody.on('click', '.btn-remove', function () {
      if ($tbody.find('tr').length <= 1) return;
      $(this).closest('tr').remove();
      updateRowNumbers();
      refreshRemoveButtons();
      calculateGrandTotal();
    });

    $tbody.on('input', '.item-qty, .item-price', function () {
      calculateRowTotal($(this).closest('tr'));
    });

    $('#purchaseForm').on('submit', function (e) {
      e.preventDefault();
      const data = {
        receiptNo : $('input[placeholder="เช่น 001/2568"]').val().trim(),
        seller    : $('#sellerInput').val()?.trim() || '',
        payment   : $('.form-select:not(.item-name)').val(),
        items     : [],
        note      : $('textarea').val().trim(),
        recorder  : $('input[placeholder="ชื่อ-นามสกุล"]').val().trim()
      };
      $tbody.find('tr').each(function () {
        const $row = $(this);
        const name = $row.find('.item-name').val()?.trim();
        if (name) {
          data.items.push({
            name:  name,
            qty:   $row.find('.item-qty').val(),
            price: $row.find('.item-price').val(),
            total: $row.find('.item-total').text()
          });
        }
      });
      console.log('ข้อมูลที่บันทึก:', data);
      alert('บันทึกเรียบร้อยแล้ว!\nดู Console เพื่อดูข้อมูล JSON');
    });

    // ===== ส่งออกใบเสร็จ =====
    function collectFormData() {
      const items = [];
      $tbody.find('tr').each(function () {
        const $row = $(this);
        const name = $row.find('.item-name').val()?.trim();
        if (name) {
          items.push({
            no    : $row.find('.td-no').text(),
            name  : name,
            qty   : $row.find('.item-qty').val(),
            price : parseFloat($row.find('.item-price').val() || 0).toLocaleString('th-TH', {minimumFractionDigits:2}),
            total : $row.find('.item-total').text().replace(' บาท','').trim()
          });
        }
      });
      return {
        receiptNo : $('input[placeholder="เช่น 001/2568"]').val().trim() || '—',
        seller    : $('#sellerInput').val()?.trim() || '—',
        payment   : $('.form-select:not(.item-name)').first().val() || '—',
        note      : $('textarea').val().trim() || '—',
        recorder  : $('input[placeholder="ชื่อ-นามสกุล"]').val().trim() || '—',
        grandTotal: $('#grandTotal').text().replace(' บาท','').trim(),
        items
      };
    }

    function buildReceiptModal(data) {
      const now = new Date();
      const dateStr = now.toLocaleDateString('th-TH', { year:'numeric', month:'long', day:'numeric' });

      $('#r-receipt-no').text('เลขที่ ' + data.receiptNo);
      $('#r-date').text('วันที่ ' + dateStr);
      $('#r-payment').text('ชำระโดย ' + data.payment);
      $('#r-seller').text(data.seller);
      $('#r-recorder').text(data.recorder);
      $('#r-note').text(data.note);
      $('#r-sig-name').text(data.recorder !== '—' ? data.recorder : 'ผู้รับเงิน');
      $('#r-grand-total').text(data.grandTotal + ' บาท');

      const $tbody_r = $('#r-items').empty();
      if (data.items.length === 0) {
        $tbody_r.append('<tr><td colspan="5" style="text-align:center;color:#aaa;padding:18px 0">ไม่มีรายการสินค้า</td></tr>');
      } else {
        data.items.forEach(item => {
          $tbody_r.append(`
            <tr>
              <td class="text-center">${item.no}</td>
              <td>${item.name}</td>
              <td class="text-center">${item.qty}</td>
              <td class="text-right">${item.price}</td>
              <td class="text-right">${item.total}</td>
            </tr>
          `);
        });
      }
    }

    $('#exportReceiptBtn').on('click', function () {
      const data = collectFormData();
      buildReceiptModal(data);
      $('#receiptModal').addClass('open');
      document.body.style.overflow = 'hidden';
    });

    function closeReceiptModal() {
      $('#receiptModal').removeClass('open');
      document.body.style.overflow = '';
    }

    $('#receiptCloseBtn, #receiptCloseBtn2').on('click', closeReceiptModal);
    $('#receiptModal').on('click', function (e) {
      if ($(e.target).is('#receiptModal')) closeReceiptModal();
    });

    $('#receiptPrintBtn').on('click', function () {
      window.print();
    });

    // ===== บันทึกใบเสร็จเป็นรูปภาพ =====
    $('#receiptSaveImgBtn').on('click', async function () {
      const $btn = $(this);
      $btn.prop('disabled', true);
      $btn.find('.r-btn-label').hide();
      $btn.find('.r-btn-loading').show();

      // ซ่อน action bar ก่อนจับภาพ
      const $actions = $('.receipt-actions');
      const $closeBtn = $('.receipt-close-btn');
      $actions.css('visibility', 'hidden');
      $closeBtn.css('visibility', 'hidden');

      try {
        await document.fonts.ready;

        const target = document.getElementById('receiptDoc');
        const canvas = await html2canvas(target, {
          scale          : 2,
          useCORS        : true,
          backgroundColor: '#ffffff',
          logging        : false
        });

        const now      = new Date();
        const date     = `${now.getFullYear()}${String(now.getMonth()+1).padStart(2,'0')}${String(now.getDate()).padStart(2,'0')}`;
        const time     = `${String(now.getHours()).padStart(2,'0')}${String(now.getMinutes()).padStart(2,'0')}`;
        const filename = `receipt_${date}_${time}.png`;

        const link = document.createElement('a');
        link.download = filename;
        link.href = canvas.toDataURL('image/png');
        link.click();

        // toast
        const $toast = $('#toast-notify');
        $toast.text('🖼️ บันทึกใบเสร็จเป็นรูปภาพแล้ว!').addClass('show');
        setTimeout(() => { $toast.removeClass('show'); $toast.text('📸 บันทึกรูปภาพเรียบร้อยแล้ว!'); }, 2800);

      } catch (err) {
        console.error('บันทึกใบเสร็จล้มเหลว:', err);
        alert('เกิดข้อผิดพลาด กรุณาลองใหม่');
      } finally {
        $actions.css('visibility', '');
        $closeBtn.css('visibility', '');
        $btn.prop('disabled', false);
        $btn.find('.r-btn-label').show();
        $btn.find('.r-btn-loading').hide();
      }
    });

    // ===== ปุ่มบันทึกเป็นรูปภาพ =====
    $('#saveImageBtn').on('click', async function () {
      const $btn = $(this);
      $btn.addClass('loading');

      // ซ่อน elements ที่ไม่ต้องการในรูป
      const $hideOnCapture = $('.btn-save-image, #addRowBtn, .btn-remove, [type="submit"], .btn-export-receipt');
      $hideOnCapture.css('visibility', 'hidden');
      $('.select2-dropdown').hide();

      try {
        const target = document.getElementById('notebookCapture');
        await document.fonts.ready;

        const canvas = await html2canvas(target, {
          scale          : 2,
          useCORS        : true,
          backgroundColor: '#fffef7',
          logging        : false,
          scrollY        : -window.scrollY,
          windowWidth    : document.documentElement.scrollWidth
        });

        const now  = new Date();
        const date = `${now.getFullYear()}${String(now.getMonth()+1).padStart(2,'0')}${String(now.getDate()).padStart(2,'0')}`;
        const time = `${String(now.getHours()).padStart(2,'0')}${String(now.getMinutes()).padStart(2,'0')}`;
        const filename = `purchase_record_${date}_${time}.png`;

        const link = document.createElement('a');
        link.download = filename;
        link.href = canvas.toDataURL('image/png');
        link.click();

        const $toast = $('#toast-notify');
        $toast.addClass('show');
        setTimeout(() => $toast.removeClass('show'), 2800);

      } catch (err) {
        console.error('บันทึกรูปล้มเหลว:', err);
        alert('เกิดข้อผิดพลาดในการบันทึกรูป กรุณาลองใหม่');
      } finally {
        // คืนค่า visibility ทุก element
        $hideOnCapture.css('visibility', '');
        $('.select2-dropdown').show();
        $btn.removeClass('loading');
      }
    });

    function init(data) {
        

        setTimeout(function() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dathTH = now.toLocaleDateString('th-TH', dateOptions); 
            // console.log("dathTH : ",dathTH);

            $('#note_date').text(dathTH);
        }, 1000);

    }

    // ตั้งค่าเริ่มต้น
    refreshRemoveButtons();
    calculateGrandTotal();
    init();
  });
</script>