<!-- <title>กราฟราคาทองคำไทย - อัพเดทเรียลไทม์</title> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="<?=base_url();?>asset/chartjs451.js"></script>

  
<style>
    body { background: linear-gradient(to bottom, #f8f9fa, #e9ecef); font-family: 'Segoe UI', sans-serif; }
    .card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .card-header { background: linear-gradient(90deg, #d4af37, #b8972e); color: white; font-weight: bold; text-align: center; padding: 1.2rem; }
    #goldChart { max-height: 320px; background: white; border-radius: 0 0 16px 16px; }
    .price-box { font-size: 1.8rem; font-weight: bold; color: #d4af37; }
    .update-time { font-size: 0.9rem; color: #666; }
    .mini-screen {
        margin: 10px auto;
        padding-top: 2rem;
        width: 800px;
    }
</style>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mini-screen my-5">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>กราฟราคาทองคำแท่ง 96.5% (ไทย)</h3>
                        <p>ข้อมูลจากสมาคมค้าทองคำ (อัพเดทอัตโนมัติ)</p>

                        <br>
                        <small class="date" id="date"></small>
                        <small class="clock" id="clock">00:00:00</small>
                    </div>
                    
                    <div class="card-body text-center">
                    <div class="mb-4">
                        <span>ราคาขายออกล่าสุด: </span>
                        <span class="price-box" id="sellPrice">—</span> บาท
                        <br>
                        <!-- <span class="text-danger fs-6" id="lastSell"></span> -->
                        <span class="text-success fs-6" id="lastBuy"></span>
                        <br>
                        <br>
                        <span class="update-time" id="updateTime">กำลังโหลดข้อมูล...</span>
                    </div>
                    
                    <canvas id="goldChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let chart;
let labels = [];
let sellPrices = [];
let buyPrices = [];

function createChart() {
  const ctx = document.getElementById('goldChart').getContext('2d');
  chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'ราคาขายออก (บาท)',
                data: sellPrices,
                borderColor: '#48bb58',
                backgroundColor: '#b3b3174b',
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#48bb58',
                pointBorderColor: '#88a58c',
                pointRadius: 5
            },
            {
                label: 'ราคารับซื้อ (บาท)',
                data: buyPrices,
                borderColor: '#ba291c',
                backgroundColor: '#4f0505a6',
                fill: true,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } },
        scales: {
            y: { beginAtZero: false, title: { display: true, text: 'ราคา (บาท/บาททอง)' } },
            x: { title: { display: true, text: 'วันที่ / เวลา' } }
        }
    }
  });
}

// function loadDatasheet() {

//     $.ajax({
//         url: 'https://script.google.com/macros/s/AKfycbwq5hO0q2RZB94fAt9n5VXM5hze3fT5UJiI6rQaVvKk5veDriBouQe28acbxLn_FZERXg/exec?year=2026&type=all&limit=20',
//         method: 'GET',
//         timeout: 8000,
//         success: function(data) {
//             // var json = JSON.stringify(data, null, 2);
//             // const jsObject = JSON.parse(data);
//             // console.log(data.message);
//             const resp = data.message;
//             console.log(resp[19]);

//             const lastBar = resp[19];  // ใช้ราคาทองแท่ง
//             const goldBar = lastBar['ask'];  // ใช้ราคาทองแท่ง

//             const sell = lastBar['askbar'];
//             const buy  = lastBar['bidbar'];
//             // console.log(sell);
//             // console.log(buy);

//             // แปลงเวลาให้สวยงาม
//             // const updateStr = `${resp.update_date} ${resp.update_time}`;
//             // const time = new Date().toLocaleString('th-TH', { timeZone: 'Asia/Bangkok' });

//             // $('#sellPrice').text(sell.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
//             // $('#updateTime').text(`อัพเดทล่าสุด: ${updateStr} (${time})`);

//             const sellbath = sell.toLocaleString('en-US');          // [th-TH, en-US] "73,000" (or sometimes ๗๓,๐๐๐ if numeral system changes)
//             $('#sellPrice').text(sellbath);

//             const [datePart] = lastBar['datetime'].split(' ');           // take only "17/02/2026"
//             const [d, m, y] = datePart.split('/');
//             const dateObj = new Date(Number(y), Number(m) - 1, Number(d));
//             const dateStr = dateObj.toLocaleDateString('th-TH', {
//                 day: '2-digit',
//                 month: '2-digit',
//                 year: 'numeric'
//             });

//             const timeStr = lastBar['datetime'].split(' ')[1] || '';

//             // Ex อัพเดท: 17/02/2569 เวลา 10:20 น. (ครั้งที่ 3) (17/2/2569 10:45:35)
//             $('#updateTime').text(`อัพเดทล่าสุด: ${dateStr} ${lastBar['des']}`);

//             // เพิ่มข้อมูลกราฟ
//             // const label = timeStr.split(',')[1]?.trim() || timeStr; // เอาเฉพาะเวลา
//             labels.push(`${dateStr} (${timeStr})`);
//             sellPrices.push(parseFloat(sell));
//             buyPrices.push(parseFloat(buy));

//             // จำกัด 50 จุดข้อมูล
//             if (labels.length > 50) {
//             labels.shift();
//             sellPrices.shift();
//             buyPrices.shift();
//             }

//             if (chart) chart.update();
//         },
//         error: function(xhr, status, error) {
//         let msg = error;
//         if (xhr.responseJSON && xhr.responseJSON.message) {
//             msg = xhr.responseJSON.message;
//         } else if (status === 'timeout') {
//             msg = 'Request timed out (8s)';
//         }
//         console.log({message: msg});

//         }
//     });
// }

function fetchGoldPrice() {
  $.ajax({
    url: 'https://api.chnwt.dev/thai-gold-api/latest',  //master api
    method: 'GET',
    success: function(data) {
        if (data.status === 'success') {
            const resp = data.response;
            console.log(resp);
            console.log(resp);

            const goldBar = resp.price.gold_bar;  // ใช้ราคาทองแท่ง

            const sell = goldBar.sell;
            const buy  = goldBar.buy;

            // แปลงเวลาให้สวยงาม
            const updateStr = `${resp.update_date} ${resp.update_time}`;
            const time = new Date().toLocaleString('th-TH', { timeZone: 'Asia/Bangkok' });

            $('#sellPrice').text(sell.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            // $('#lastSell').text(`ขายออก: ${sell} บาท`);
            $('#lastBuy').text(`รับซื้อ: ${buy} บาท`);
            
            // $('#updateTime').text(`อัพเดทล่าสุด: ${updateStr} (${time})`);
            $('#updateTime').text(`อัพเดทล่าสุด: ${updateStr}`);

            // เพิ่มข้อมูลกราฟ
            const label = time.split(',')[1]?.trim() || time; // เอาเฉพาะเวลา
            labels.push(label);
            sellPrices.push(parseFloat(sell.replace(/,/g, '')));
            buyPrices.push(parseFloat(buy.replace(/,/g, '')));

            // จำกัด 50 จุดข้อมูล
            if (labels.length > 50) {
            labels.shift();
            sellPrices.shift();
            buyPrices.shift();
            }

            if (chart) chart.update();
        } else {
            $('#updateTime').text('API ส่งสถานะไม่สำเร็จ');
        }
    },
    error: function(xhr, status, error) {
      $('#updateTime').text(`ไม่สามารถดึงข้อมูลได้ (${status}) — ลองใหม่ใน 30 วินาที`);
      console.error('API Error:', error);
    }
  });
}

function updateClock() {
    const now = new Date();
    
    // Time with leading zeros
    let h = String(now.getHours()).padStart(2, '0');
    let m = String(now.getMinutes()).padStart(2, '0');
    let s = String(now.getSeconds()).padStart(2, '0');
    
    document.getElementById('clock').textContent = `${h}:${m}:${s}`;
    
    // Optional: Show current date below
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('date').textContent = now.toLocaleDateString('th-TH', dateOptions); // toLocaleDateString [th-TH, en-US]
}

$(document).ready(function() {
    createChart();
    // loadDatasheet();              // โหลดครั้งแรก
    // setInterval(loadDatasheet, 30000);  // อัพเดททุก 30 วินาที
    
    // Update immediately + every second
    updateClock();
    setInterval(updateClock, 1000);

    fetchGoldPrice();           // โหลดครั้งแรก
    setInterval(fetchGoldPrice, 30000);  // อัพเดททุก 30 วินาที
});
</script>