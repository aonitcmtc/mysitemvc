<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Digital Clock</title>
  
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #fff;
    }
    
    .clock-container {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
      padding: 40px 60px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.5);
      border: 1px solid rgba(255,255,255,0.1);
      text-align: center;
    }
    
    .clock {
      font-size: 5.5rem;
      font-weight: bold;
      letter-spacing: 8px;
      text-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
      color: #00ffff;
    }
    
    .date {
      font-size: 1.4rem;
      margin-top: 15px;
      opacity: 0.9;
      color: #e0e0e0;
    }
    
    h1 {
      margin: 0 0 20px 0;
      font-size: 2.2rem;
      color: #ffffff;
      text-shadow: 0 2px 10px rgba(0,0,0,0.6);
    }
  </style>
</head>
<body>

  <div class="clock-container">
    <h1>Digital Clock</h1>
    <div class="clock" id="clock">00:00:00</div>
    <div class="date" id="date"></div>
  </div>

  <script>
    function updateClock() {
      const now = new Date();
      
      // Time with leading zeros
      let h = String(now.getHours()).padStart(2, '0');
      let m = String(now.getMinutes()).padStart(2, '0');
      let s = String(now.getSeconds()).padStart(2, '0');
      
      document.getElementById('clock').textContent = `${h}:${m}:${s}`;
      
      // Optional: Show current date below
      const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('date').textContent = now.toLocaleDateString('en-US', dateOptions);
    }

    // Update immediately + every second
    updateClock();
    setInterval(updateClock, 1000);
  </script>

</body>
</html>