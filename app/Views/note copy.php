<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Google Font: Sarabun -->
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
      background: #e8e8e8;
      font-family: 'Sarabun', system-ui, -apple-system, sans-serif;
      padding: 30px 15px;
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

    /* ปรับ Select2 ให้เข้ากับสไตล์สมุด (dashed bottom) */
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

    @media (max-width: 900px) {
      
    }

    @media (max-width: 576px) {
      .form-container { padding: 40px 20px 30px; }
      .notebook::after { left: 40px; }
      .table-responsive { font-size: 0.95rem; }
    }
    
</style>

<div class="notebook">
  <div class="form-container">

    <div class="text-center mb-5">
      <h2 class="fw-bold">สมุดบันทึกการซื้อสินค้า</h2>
      <small class="text-muted">วันที่ ............................................</small>
    </div>

    <form id="purchaseForm">
      <div class="row g-3 mb-5">
        <div class="col-md-4">
          <label class="form-label">เลขที่ใบเสร็จ/รายการ</label>
          <input type="text" class="form-control" placeholder="เช่น 001/2568">
        </div>
        <div class="col-md-4">
          <label class="form-label">ผู้ขาย / ร้านค้า</label>
          <input type="text" class="form-control" placeholder="ชื่อร้านหรือบุคคล">
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
        <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
          + เพิ่มรายการสินค้า
        </button>
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
              <td>1</td>
              <td>
                <select class="form-select item-name select2">
                  <option></option>
                  <option value="ข้าวหอมมะลิ 5 กก.">ข้าวหอมมะลิ 5 กก.</option>
                  <option value="น้ำตาลทราย 1 กก.">น้ำตาลทราย 1 กก.</option>
                  <option value="น้ำมันพืช 1 ลิตร">น้ำมันพืช 1 ลิตร</option>
                  <option value="ปลากระป๋อง">ปลากระป๋อง</option>
                  <option value="ผงซักฟอก">ผงซักฟอก</option>
                </select>
              </td>
              <td><input type="number" class="form-control text-center item-qty" value="1" min="1" step="1"></td>
              <td><input type="number" class="form-control text-end item-price" value="0.00" min="0" step="0.01"></td>
              <td class="text-end fw-bold item-total">0.00 บาท</td>
              <td></td>
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
          <input type="text" class="form-control" placeholder="ชื่อ-นามสกุล">
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg px-5">บันทึกข้อมูล</button>
      </div>
    </form>

  </div>
</div>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function() {

      const $tbody = $('#itemRows');
      const $grandTotal = $('#grandTotal');

      // ฟังก์ชัน init Select2 ที่รองรับการพิมพ์เพิ่มรายการใหม่ (tags)
      function initSelect2($element) {
        $element.select2({
          tags: true,
          placeholder: "พิมพ์หรือเลือกสินค้า... (พิมพ์ใหม่ได้เลย)",
          allowClear: true,
          width: '100%',
          createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') {
              return null;
            }
            return {
              id: term,
              text: term
            };
          }
        });
      }

      // Init Select2 สำหรับแถวที่มีอยู่แล้ว
      $('.select2').each(function() {
        initSelect2($(this));
      });

      function updateRowNumbers() {
        $tbody.find('tr').each(function(i) {
          $(this).find('td:first').text(i + 1);
        });
      }

      function calculateRowTotal($row) {
        let qty   = parseFloat($row.find('.item-qty').val())   || 0;
        let price = parseFloat($row.find('.item-price').val()) || 0;

        if (qty < 1) { $row.find('.item-qty').val(1); qty = 1; }
        if (price < 0) { $row.find('.item-price').val(0); price = 0; }

        const total = qty * price;
        $row.find('.item-total').text(total.toFixed(2) + ' บาท');
        calculateGrandTotal();
      }

      function calculateGrandTotal() {
        let sum = 0;
        $tbody.find('.item-total').each(function() {
          sum += parseFloat($(this).text().replace(' บาท','')) || 0;
        });
        $grandTotal.text(sum.toFixed(2) + ' บาท');
      }

      function refreshRemoveButtons() {
        const rowCount = $tbody.find('tr').length;
        $tbody.find('tr').each(function() {
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

      // เพิ่มแถวใหม่
      $('#addRowBtn').on('click', function() {
        const rowIndex = $tbody.find('tr').length + 1;

        const $newRow = $(`
          <tr>
            <td>${rowIndex}</td>
            <td>
              <select class="form-select item-name select2">
                <option></option>
                <option value="ข้าวหอมมะลิ 5 กก.">ข้าวหอมมะลิ 5 กก.</option>
                <option value="น้ำตาลทราย 1 กก.">น้ำตาลทราย 1 กก.</option>
                <option value="น้ำมันพืช 1 ลิตร">น้ำมันพืช 1 ลิตร</option>
                <option value="ปลากระป๋อง">ปลากระป๋อง</option>
                <option value="ผงซักฟอก">ผงซักฟอก</option>
              </select>
            </td>
            <td><input type="number" class="form-control text-center item-qty" value="1" min="1" step="1"></td>
            <td><input type="number" class="form-control text-end item-price" value="0.00" min="0" step="0.01"></td>
            <td class="text-end fw-bold item-total">0.00 บาท</td>
            <td></td>
          </tr>
        `);

        $tbody.append($newRow);

        // Init Select2 สำหรับแถวใหม่ (รองรับ tags)
        initSelect2($newRow.find('.select2'));

        $newRow.find('.item-qty, .item-price').on('input', function() {
          calculateRowTotal($newRow);
        });

        refreshRemoveButtons();
        calculateGrandTotal();

        // เปิดช่องค้นหา/พิมพ์ทันที
        $newRow.find('.select2').select2('open');
      });

      // ลบแถว + คำนวณใหม่
      $tbody.on('click', '.btn-remove', function() {
        if ($tbody.find('tr').length <= 1) return;
        $(this).closest('tr').remove();
        updateRowNumbers();
        refreshRemoveButtons();
        calculateGrandTotal();
      });

      $tbody.on('input', '.item-qty, .item-price', function() {
        calculateRowTotal($(this).closest('tr'));
      });

      // ส่งฟอร์ม (ตัวอย่างเก็บข้อมูลลง console)
      $('#purchaseForm').on('submit', function(e) {
        e.preventDefault();

        const data = {
          receiptNo : $('input[placeholder="เช่น 001/2568"]').val().trim(),
          seller    : $('input[placeholder="ชื่อร้านหรือบุคคล"]').val().trim(),
          payment   : $('.form-select:not(.item-name)').val(),
          items     : [],
          note      : $('textarea').val().trim(),
          recorder  : $('input[placeholder="ชื่อ-นามสกุล"]').val().trim()
        };

        $tbody.find('tr').each(function() {
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

      // ตั้งค่าตอนเริ่มต้น
      refreshRemoveButtons();
      calculateGrandTotal();
    });
</script>