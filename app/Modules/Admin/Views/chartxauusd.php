<!-- <title>Live Gold Price - Gold Theme | Bangkok 2026</title> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="<?=base_url();?>asset/chartjs451.js"></script>

<style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #0a0015, #120026, #1a0f3a);
      color: #f5e8c7;
    }

    h1 {
      text-align: center;
      color: #FFD700;
      text-shadow: 0 0 35px #ffd700d9, 0 0 60px #d4af3780;
      margin-bottom: 15px;
      letter-spacing: 2px;
    }

    .d-trade {
        margin-top: 5rem;
        padding: 2rem;
    }

    .subtitle {
      text-align: center;
      color: #d4af37;
      margin-bottom: 40px;
      font-size: 1.25rem;
      font-weight: 500;
    }

    .card {
      background: linear-gradient(to bottom, #140f32f2, #0a0523fa);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 15px 50px #000000cc,
                  inset 0 0 40px #d4af371f;
      border: 1px solid #d4af374d;
      backdrop-filter: blur(10px);
    }

    .price-box {
      display: flex;
      justify-content: space-around;
      margin-bottom: 35px;
      flex-wrap: wrap;
      gap: 25px;
    }

    .price-item {
      background: #1e1946bf;
      padding: 25px 35px;
      border-radius: 16px;
      text-align: center;
      min-width: 240px;
      border: 2px solid #D4AF37;
      transition: all 0.45s ease;
      box-shadow: 0 5px 20px #00000080;
    }

    .price-item:hover {
      transform: translateY(-8px) scale(1.03);
      border-color: #FFD700;
      box-shadow: 0 15px 40px #ffd70066;
    }

    .label {
      font-size: 1.15rem;
      color: #e0c070;
      margin-bottom: 10px;
      font-weight: 500;
    }

    .value {
      font-size: 2.6rem;
      font-weight: bold;
      color: #FFD700;
      text-shadow: 0 0 25px #ffd700bf;
    }

    .change {
      font-size: 1.4rem;
      margin-top: 10px;
      font-weight: 600;
    }

    .up { color: #90EE90; text-shadow: 0 0 15px #90EE90; }
    .down { color: #FF6347; text-shadow: 0 0 15px #FF6347; }

    canvas {
      max-height: 320px;
      background: #080519b3;
      border-radius: 16px;
      padding: 20px;
      border: 1px solid #d4af3733;
    }

    @media (max-width: 768px) {
      h1 { font-size: 2.4rem; }
      .value { font-size: 2.1rem; }
      .price-item { min-width: 48%; padding: 20px; }
    }
</style>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="d-trade">
                <h1>🟡 Live Gold Price Trading (Gold Theme)</h1>
                <div class="subtitle">Spot XAU • Bangkok Time • February 18, 2026</div>

                <div class="card">
                    <div class="price-box">
                    <div class="price-item">
                        <div class="label">Gold Spot (USD / oz)</div>
                        <div class="value" id="usdPrice">4,905</div>
                        <div class="change up" id="usdChange">+38 (+0.78%)</div>
                    </div>
                    <div class="price-item">
                        <div class="label">Gold Spot (THB / oz)</div>
                        <div class="value" id="thbPrice">≈ 153,800</div>
                        <div class="change up" id="thbChange">+1,200 (+0.78%)</div>
                    </div>
                    <div class="price-item">
                        <div class="label">Thai Gold (96.5%) per Baht</div>
                        <div class="value" id="bahtPrice">≈ 74,200</div>
                    </div>
                    </div>

                    <canvas id="goldChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sample recent price history (based on today's real range ~4,870-4,935 USD)
let goldData = {
    labels: ["09:00", "10:00", "10:41", "11:00", "12:00", "13:00", "Now"],
    pricesUSD: [4905, 4890, 4915, 4928, 4900, 4885, 4905],
};

const ctx = document.getElementById('goldChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: goldData.labels,
        datasets: [{
        label: 'Gold Spot Price (USD/oz)',
        data: goldData.pricesUSD,
        borderColor: '#FFD700',            // Bright gold line
        backgroundColor: 'rgba(212,175,55,0.22)', // Metallic gold fill
        borderWidth: 5,
        tension: 0.38,
        pointBackgroundColor: '#FFDC73',   // Shine highlight
        pointBorderColor: '#8B6914',
        pointBorderWidth: 2,
        pointRadius: 7,
        pointHoverRadius: 11,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false,
                title: { display: true, text: 'Price (USD)', color: '#FFD700', font: {size:16} },
                ticks: { color: '#e0c070' },
                grid: { color: 'rgba(255,215,0,0.08)' }
            },
            x: {
                title: { display: true, text: 'Time (Feb 18, 2026 Bangkok)', color: '#FFD700', font: {size:16} },
                ticks: { color: '#e0c070' },
                grid: { color: 'rgba(255,215,0,0.05)' }
            }
            },
            plugins: {
            legend: { labels: { color: '#FFD700', font: { size: 15 } } },
            tooltip: {
                backgroundColor: 'rgba(20,15,50,0.92)',
                titleColor: '#FFD700',
                bodyColor: '#f5e8c7',
                borderColor: '#D4AF37',
                borderWidth: 2
            }
        }
    }
});

// Fake live update simulation (every 10s) – replace with real API fetch for production
setInterval(() => {
    let last = goldData.pricesUSD[goldData.pricesUSD.length - 1];
    let change = (Math.random() - 0.5) * 30; // ±15 USD random volatility
    let newPrice = Math.round(last + change);

    goldData.labels.push(new Date().toLocaleTimeString('th-TH', {hour:'2-digit', minute:'2-digit'}));
    goldData.pricesUSD.push(newPrice);

    if (goldData.labels.length > 12) {
        goldData.labels.shift();
        goldData.pricesUSD.shift();
    }

    chart.update();

    // Update displayed prices (approx THB: USD × 31.3, Baht weight ≈ oz / 0.49)
    let usd = newPrice;
    let thbOz = Math.round(usd * 31.3);
    let bahtWeight = Math.round(thbOz * 0.49); // rough Thai baht equiv

    $("#usdPrice").text(usd.toLocaleString());
    $("#thbPrice").text("≈ " + thbOz.toLocaleString());
    $("#bahtPrice").text("≈ " + bahtWeight.toLocaleString());

    let chText = change > 0 ? "+" : "";
    let chClass = change > 0 ? "up" : "down";
    let pct = (change / last * 100).toFixed(2);
    $("#usdChange").text(chText + change.toFixed(0) + " (" + pct + "%)").removeClass("up down").addClass(chClass);
    $("#thbChange").text(chText + Math.round(change*31.3) + " (" + pct + "%)").removeClass("up down").addClass(chClass);

}, 10000);

</script>

</body>
</html>