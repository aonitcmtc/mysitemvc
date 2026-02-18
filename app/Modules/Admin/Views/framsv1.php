<!-- <title>Farm Survivor</title> -->
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<style>
    body {
      margin: 0;
      height: 100vh;
      background: #111;
      font-family: Arial, Helvetica, sans-serif;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    #game-wrapper { position: relative; }
    canvas {
      border: 3px solid #444;
      background: #000;
      image-rendering: pixelated;
      box-shadow: 0 0 30px rgba(0,0,0,0.8);
    }
    #hud {
      position: absolute;
      top: 12px; left: 12px;
      background: rgba(0,0,0,0.75);
      color: #eee;
      padding: 12px 16px;
      border-radius: 8px;
      border: 1px solid #555;
      font-size: 1.05rem;
      line-height: 1.5;
      pointer-events: none;
      user-select: none;
    }
    #hud strong { color: #4fc; }
    #mode { margin-top: 8px; font-weight: bold; color: #ffeb3b; }
    #instructions {
      position: absolute;
      bottom: 20px; left: 50%;
      transform: translateX(-50%);
      background: rgba(0,0,0,0.6);
      color: #ccc;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 1rem;
      pointer-events: none;
    }
    #game-over {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.9);
      color: #ff4444;
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 3rem;
      font-weight: bold;
      text-shadow: 0 0 10px black;
      z-index: 10;
    }
    #game-over button {
      margin-top: 30px;
      padding: 14px 32px;
      font-size: 1.4rem;
      background: #c44;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    #game-over button:hover { background: #e55; }
    .d-navbar, .footer{ visibility: hidden;}
</style>
<body>

<div id="game-wrapper">
  <canvas id="gameCanvas" width="800" height="600"></canvas>

  <div id="hud">
    <div>Health: <strong id="health">100</strong></div>
    <div>Hunger: <strong id="hunger">0</strong>%</div>
    <div id="inv">Wood: <strong id="wood">0</strong> • Seeds: <strong id="seeds">5</strong> • Food: <strong id="food">2</strong></div>
    <div id="mode">Mode: Seeds 🌱</div>
  </div>

  <div id="instructions">
    WASD = move • 1=Hoe ✂️ • 2=Seeds 🌱 • 3=Harvest 🌾 • E = use • Watch out for raiders!
  </div>

  <div id="game-over">
    <div>GAME OVER<br><small>You starved or got raided</small></div>
    <button id="restart">Play Again</button>
  </div>
</div>

<audio id="chopSound" preload="auto"><source src="https://assets.codepen.io/243235/axe-hit.mp3"></audio>
<audio id="plantSound" preload="auto"><source src="https://assets.codepen.io/243235/plant.mp3"></audio>
<audio id="harvestSound" preload="auto"><source src="https://assets.codepen.io/243235/harvest.mp3"></audio>
<audio id="eatSound" preload="auto"><source src="https://assets.codepen.io/243235/eat-crunch.mp3"></audio>
<audio id="hurtSound" preload="auto"><source src="https://assets.codepen.io/243235/hurt.mp3"></audio>

<script>
$(function() {
  const canvas = $('#gameCanvas')[0];
  const ctx = canvas.getContext('2d');
  const TILE = 40;
  const COLS = canvas.width / TILE;
  const ROWS = canvas.height / TILE;

  let player = {
    x: canvas.width / 2 - TILE/2,
    y: canvas.height / 2 - TILE/2,
    speed: 4.2,
    health: 100,
    hunger: 0,
    inventory: { wood: 0, seeds: 5, food: 2 }
  };

  let mode = "seeds"; // "hoe", "seeds", "harvest"
  let world = Array.from({length: ROWS}, () => Array(COLS).fill(0));
  let crops = [];
  let enemies = [
    {x: 200, y: 150, vx: 0.8, vy: 0.6},
    {x: 600, y: 400, vx: -0.7, vy: 0.9}
  ];
  let gameTime = 360; // start at 6:00 (morning)
  const DAY_LENGTH = 8 * 60;
  let keys = {};

  const sounds = {
    chop: $('#chopSound')[0],
    plant: $('#plantSound')[0],
    harvest: $('#harvestSound')[0],
    eat: $('#eatSound')[0],
    hurt: $('#hurtSound')[0]
  };

  function play(sound) {
    sound.currentTime = 0;
    sound.volume = 0.5;
    sound.play().catch(() => {});
  }

  function generateWorld() {
    for (let i = 0; i < 18; i++) {
      let x = Math.floor(Math.random() * COLS);
      let y = Math.floor(Math.random() * ROWS);
      if (world[y][x] === 0) world[y][x] = 1;
    }
    for (let i = 0; i < 12; i++) {
      let x = Math.floor(Math.random() * COLS);
      let y = Math.floor(Math.random() * ROWS);
      if (world[y][x] === 0) world[y][x] = 2;
    }
  }
  generateWorld();

  $(window).on('keydown', e => {
    let k = e.key.toLowerCase();
    keys[k] = true;

    if (k === '1') { mode = "hoe"; showMode("Hoe ✂️"); }
    if (k === '2') { mode = "seeds"; showMode("Seeds 🌱"); }
    if (k === '3') { mode = "harvest"; showMode("Harvest 🌾"); }
    if (k === 'e') interact();
  });

  $(window).on('keyup', e => { keys[e.key.toLowerCase()] = false; });

  function showMode(text) {
    $('#mode').text("Mode: " + text);
    let $msg = $(`<div style="position:absolute;top:80px;left:50%;transform:translateX(-50%);
      color:#ffeb3b;font-size:1.8rem;font-weight:bold;pointer-events:none;text-shadow:0 0 10px black;">${text}</div>`);
    $('body').append($msg);
    $msg.fadeOut(1200, () => $msg.remove());
  }

  function interact() {
    let tx = Math.floor((player.x + TILE/2) / TILE);
    let ty = Math.floor((player.y + TILE/2) / TILE);
    if (tx < 0 || tx >= COLS || ty < 0 || ty >= ROWS) return;

    let tile = world[ty][tx];

    if (mode === "hoe" && tile === 1) {
      player.inventory.wood += Math.floor(Math.random()*4)+3;
      if (Math.random()<0.4) player.inventory.seeds++;
      world[ty][tx] = 0;
      play(sounds.chop);
    }
    else if (mode === "seeds" && tile === 2 && player.inventory.seeds > 0) {
      player.inventory.seeds--;
      world[ty][tx] = 3;
      crops.push({x:tx, y:ty, stage:0});
      play(sounds.plant);
    }
    else if ((mode === "harvest" || mode === "seeds") && tile === 3) {
      let crop = crops.find(c => c.x === tx && c.y === ty);
      if (crop && crop.stage >= 4) {
        player.inventory.food += 2 + Math.floor(Math.random()*3);
        world[ty][tx] = 2;
        crops = crops.filter(c => c !== crop);
        play(sounds.harvest);
      }
    }
    updateHUD();
  }

  function updateHUD() {
    $('#health').text(Math.floor(player.health));
    $('#hunger').text(Math.floor(player.hunger));
    $('#wood').text(player.inventory.wood);
    $('#seeds').text(player.inventory.seeds);
    $('#food').text(player.inventory.food);

    if (player.health <= 0) {
      $('#game-over').fadeIn();
    }
  }

  function update() {
    if ($('#game-over').is(':visible')) return;

    // Movement
    if (keys['w']) player.y -= player.speed;
    if (keys['s']) player.y += player.speed;
    if (keys['a']) player.x -= player.speed;
    if (keys['d']) player.x += player.speed;

    player.x = Math.max(0, Math.min(player.x, canvas.width - TILE));
    player.y = Math.max(0, Math.min(player.y, canvas.height - TILE));

    // Day/Night
    gameTime = (gameTime + 1/60) % 1440;
    let isNight = gameTime >= 1200 || gameTime < 360;
    player.hunger += isNight ? 0.055 : 0.028;

    if (player.hunger > 100) {
      player.hunger = 100;
      player.health -= 0.18;
    }

    // Auto-eat
    if (player.hunger > 65 && player.inventory.food > 0) {
      player.inventory.food--;
      player.hunger = Math.max(0, player.hunger - 32);
      play(sounds.eat);
      updateHUD();
    }

    // Crop growth
    crops.forEach(c => {
      if (Math.random() < 0.008) c.stage = Math.min(c.stage + 1, 4);
    });

    // Enemies (simple chase)
    enemies.forEach(e => {
      let dx = player.x - e.x;
      let dy = player.y - e.y;
      let dist = Math.sqrt(dx*dx + dy*dy);
      if (dist > 0) {
        e.x += (dx / dist) * 0.9;
        e.y += (dy / dist) * 0.9;
      }
      if (dist < TILE) {
        player.health -= 0.5;
        player.hunger += 3;
        play(sounds.hurt);
        updateHUD();
      }
    });

    if (player.hunger < 30 && player.health < 100) player.health += 0.06;
  }

  function draw() {
    ctx.clearRect(0,0,canvas.width,canvas.height);

    // Tiles
    for (let y = 0; y < ROWS; y++) {
      for (let x = 0; x < COLS; x++) {
        let tile = world[y][x];
        ctx.fillStyle = '#228B22';
        if (tile === 1) ctx.fillStyle = '#5a3e1b';
        if (tile === 2) ctx.fillStyle = '#8B4513';
        if (tile === 3) {
          let crop = crops.find(c => c.x === x && c.y === y);
          let green = 60 + (crop?.stage || 0) * 50;
          ctx.fillStyle = `rgb(0, ${green}, 0)`;
        }
        ctx.fillRect(x * TILE, y * TILE, TILE, TILE);
      }
    }

    // Enemies
    enemies.forEach(e => {
      ctx.fillStyle = '#c00';
      ctx.fillRect(e.x + 6, e.y + 6, TILE*0.7, TILE*0.7);
      ctx.fillStyle = '#ff0';
      ctx.fillRect(e.x + 12, e.y + 12, 10, 10);
    });

    // Day/Night tint
    let isNight = gameTime >= 1200 || gameTime < 360;
    let darkness = isNight ? 0.7 : 0.05;
    ctx.fillStyle = `rgba(10, 20, 80, ${darkness})`;
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Sun/Moon
    let angle = (gameTime / 1440) * Math.PI * 2;
    let sunX = 100 + 600 * (Math.sin(angle) + 1) / 2;
    let sunY = 80 + 300 * (1 - Math.cos(angle));
    ctx.fillStyle = isNight ? "#ddd" : "#ffeb3b";
    ctx.beginPath();
    ctx.arc(sunX, sunY, 30, 0, Math.PI*2);
    ctx.fill();

    // Player (emoji)
    ctx.font = `${TILE}px Arial`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    let emoji = player.hunger > 80 ? "🥵" : "🧑‍🌾";
    ctx.fillText(emoji, player.x + TILE/2, player.y + TILE/2);
  }

  function loop() {
    update();
    draw();
    updateHUD();
    requestAnimationFrame(loop);
  }

  updateHUD();
  showMode("Seeds 🌱");
  loop();

  $('#restart').on('click', () => location.reload());
});
</script>