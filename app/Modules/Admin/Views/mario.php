<style>
    body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(to bottom, #87CEEB 0%, #98D8E8 70%, #E0F6FF 100%);
      font-family: 'Courier New', monospace;
      color: #000;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }
    #game-wrapper { position: relative; }
    canvas {
      border: 4px solid #8B4513;
      background: #87CEEB;
      box-shadow: 0 0 40px rgba(139, 69, 19, 0.5);
      image-rendering: pixelated;
    }
    #hud {
      position: absolute;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(255,255,255,0.9);
      padding: 10px 24px;
      border-radius: 8px;
      border: 3px solid #FF0000;
      font-size: 1.4rem;
      font-weight: bold;
      pointer-events: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    #world { margin-top: 8px; color: #FF6B35; }
    #game-over, #win {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.85);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 4rem;
      color: #FFD700;
      text-shadow: 0 0 20px #FF6B35;
      z-index: 10;
      text-align: center;
    }
    #win { color: #00FF00; text-shadow: 0 0 20px #00FF00; }
    button {
      margin-top: 30px;
      padding: 16px 44px;
      font-size: 1.6rem;
      background: #FF0000;
      color: white;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      font-weight: bold;
      font-family: inherit;
    }
    button:hover { background: #FF4444; }
    #instructions {
        margin-top: 20px;
        font-size: 1.2rem;
        color: #333;
        text-align: center;
        max-width: 800px;
    }
    .d-navbar, .footer{ visibility: hidden;}
</style>
<body>

<div id="game-wrapper">
  <canvas id="gameCanvas" width="800" height="400"></canvas>

  <div id="hud">
    <div>🌟 Coins: <span id="coins">0</span>  •  World: <span id="world">1-1</span></div>
    <div>Score: <span id="score">0</span></div>
  </div>

  <div id="game-over">
    <div>GAME OVER</div>
    <div style="font-size:1.5rem; margin:20px 0;">Final Score: <span id="finalScore">0</span></div>
    <button id="restart">Play Again</button>
  </div>

  <div id="win">
    <div>LEVEL COMPLETE!</div>
    <div style="font-size:1.8rem; margin:20px 0;">🏆 You reached the flag!</div>
    <button id="restart">Play 1-1 Again</button>
  </div>
</div>

<div id="instructions">
  ← → or A D = Move • W or SPACE = Jump • Reach the flag! Stomp Goombas 👣 • Collect coins 🟡
</div>

<script>
$(function() {

  const canvas = $('#gameCanvas')[0];
  const ctx = canvas.getContext('2d');
  const TILE = 32;
  const VIEW_WIDTH = canvas.width / TILE;  // 25 tiles visible
  const WORLD_WIDTH = 200;                 // Long level

  // Simple level data (1-1 layout: ground, pipes, platforms, bricks, coins, goombas, flag)
  const level = [
    // Ground (bottom row)
    ...Array(200).fill(1).map((v,i) => ({x:i, y:11, type:1})), // solid ground
    // Pipe 1
    {x:12, y:9, type:3}, {x:13, y:9, type:3},
    {x:12, y:10, type:3}, {x:13, y:10, type:3},
    // Pipe 2
    {x:18, y:8, type:3}, {x:19, y:8, type:3},
    {x:18, y:9, type:3}, {x:19, y:9, type:3},
    {x:18, y:10, type:3}, {x:19, y:10, type:3},
    // Brick platforms
    {x:25, y:9, type:4}, {x:26, y:9, type:4}, {x:27, y:9, type:4},
    {x:42, y:8, type:4}, {x:43, y:8, type:4}, {x:44, y:8, type:4}, {x:45, y:8, type:4},
    // ? Block (coin)
    {x:16, y:6, type:5},
    {x:38, y:6, type:5},
    {x:52, y:6, type:5},
    // Flag pole
    {x:195, y:5, type:6}, {x:195, y:6, type:6}, {x:195, y:7, type:6}, {x:195, y:8, type:6}, {x:195, y:9, type:6}
  ];

  let mario = {
    x: 1 * TILE,
    y: 9 * TILE - 16,
    vx: 0,
    vy: 0,
    width: 16,
    height: 16,
    onGround: false,
    facing: 1  // 1 right, -1 left
  };

  let camera = { x: 0 };
  let coins = 0;
  let score = 0;
  let gameRunning = true;
  let goombas = [
    {x: 20*TILE, y: 9*TILE-12, vx: -0.5, dead: false},
    {x: 30*TILE, y: 9*TILE-12, vx: 0.6, dead: false},
    {x: 50*TILE, y: 9*TILE-12, vx: -0.4, dead: false},
    {x: 80*TILE, y: 9*TILE-12, vx: 0.5, dead: false},
    {x: 120*TILE, y: 9*TILE-12, vx: -0.6, dead: false}
  ];

  let keys = {};

  // Controls
  $(window).on('keydown', e => {
    if (!gameRunning) return;
    let k = e.key.toLowerCase();
    keys[k] = true;
    e.preventDefault();
  });
  $(window).on('keyup', e => { keys[e.key.toLowerCase()] = false; });

  function getTile(x, y) {
    let tx = Math.floor(x / TILE);
    let ty = Math.floor(y / TILE);
    return level.find(t => t.x === tx && t.y === ty) || {type: 0};
  }

  function collide(rect, dx=0, dy=0) {
    let left = Math.floor((rect.x + dx) / TILE);
    let right = Math.floor((rect.x + rect.width + dx) / TILE);
    let top = Math.floor((rect.y + dy) / TILE);
    let bottom = Math.floor((rect.y + rect.height + dy) / TILE);

    for (let ty = top; ty <= bottom; ty++) {
      for (let tx = left; tx <= right; tx++) {
        let tile = level.find(t => t.x === tx && t.y === ty);
        if (tile && tile.type >= 1 && tile.type <= 4) {
          // Solid collision
          if (dx > 0 && rect.x + rect.width + dx > tx * TILE) return 'right';
          if (dx < 0 && rect.x + dx < (tx+1) * TILE) return 'left';
          if (dy > 0 && rect.y + rect.height + dy > ty * TILE) return 'bottom';
          if (dy < 0 && rect.y + dy < (ty+1) * TILE) return 'top';
        }
      }
    }
    return false;
  }

  function update() {
    if (!gameRunning) return;

    // Input
    let accel = 0.4;
    let friction = 0.85;
    let jump = -12;
    let gravity = 0.4;

    if (keys['a'] || keys['arrowleft'])  mario.vx = Math.max(mario.vx - accel, -2.5);
    if (keys['d'] || keys['arrowright']) mario.vx = Math.min(mario.vx + accel, 2.5);
    if ((keys['w'] || keys[' '] || keys['arrowup']) && mario.onGround) {
      mario.vy = jump;
      mario.onGround = false;
    }

    mario.vx *= friction;
    mario.vy += gravity;

    // Horizontal move + collide
    let hCollide = collide(mario, mario.vx, 0);
    if (!hCollide) mario.x += mario.vx;
    else {
      if (hCollide === 'left' || hCollide === 'right') mario.vx = 0;
    }
    mario.facing = mario.vx > 0 ? 1 : -1;

    // Vertical move + collide
    let vCollide = collide(mario, 0, mario.vy);
    if (!vCollide) {
      mario.y += mario.vy;
      mario.onGround = false;
    } else {
      if (vCollide === 'bottom') {
        mario.onGround = true;
        mario.y = Math.floor(mario.y / TILE) * TILE;
        mario.vy = 0;
      }
      if (vCollide === 'top') {
        mario.vy = 0;
        // Check for coin block
        let tile = getTile(mario.x + 8, mario.y);
        if (tile.type === 5) {
          coins++;
          score += 100;
          // "Break" block visually (remove for simplicity)
          level.splice(level.indexOf(tile), 1);
          updateHUD();
        }
      }
    }

    // Fall death
    if (mario.y > canvas.height + 100) gameOver();

    // Camera follow
    camera.x = Math.max(0, Math.min(mario.x - canvas.width / 2, WORLD_WIDTH * TILE - canvas.width));

    // Win: touch flag
    if (getTile(mario.x / TILE, (mario.y + 16)/ TILE)?.type === 6) {
      $('#win').fadeIn(800);
      gameRunning = false;
    }

    // Goombas
    goombas.forEach(g => {
      if (g.dead) return;
      g.x += g.vx;
      if (collide({x:g.x, y:g.y, width:16, height:12}, g.vx, 0)) g.vx *= -1;

      // Mario stomp
      let dx = mario.x - g.x;
      let dy = mario.y - g.y;
      if (Math.abs(dx) < 16 && dy > 0 && mario.vy > 0 && mario.y < g.y + 12) {
        g.dead = true;
        mario.vy = -6;  // Bounce
        score += 200;
        updateHUD();
      } else if (Math.abs(dx) < 16 && Math.abs(dy) < 16) {
        gameOver();
      }
    });
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    let camX = camera.x / TILE;

    // Sky gradient (already in CSS bg, but reinforce)
    let grad = ctx.createLinearGradient(0,0,0,canvas.height);
    grad.addColorStop(0, '#87CEEB');
    grad.addColorStop(1, '#E0F6FF');
    ctx.fillStyle = grad;
    ctx.fillRect(0,0,canvas.width,canvas.height);

    // Clouds (procedural)
    for (let i = 0; i < 10; i++) {
      let cx = (i * 25 * TILE - camera.x * 0.3) % (WORLD_WIDTH * TILE);
      ctx.fillStyle = 'rgba(255,255,255,0.8)';
      ctx.beginPath();
      ctx.arc(cx, 60 + i*20, 40, 0, Math.PI*2);
      ctx.arc(cx+30, 60 + i*20, 50, 0, Math.PI*2);
      ctx.arc(cx+60, 60 + i*20, 40, 0, Math.PI*2);
      ctx.fill();
    }

    // Tiles
    level.forEach(t => {
      let screenX = t.x * TILE - camera.x;
      if (screenX > -TILE && screenX < canvas.width + TILE) {
        ctx.fillStyle = t.type === 1 ? '#8B4513' :  // ground
                        t.type === 3 ? '#0F5'    :  // pipe
                        t.type === 4 ? '#D2B48C' :  // brick
                        t.type === 5 ? '#FFD700' :  // coin block
                        '#00F';                      // flag
        ctx.fillRect(screenX, t.y * TILE, TILE, TILE);

        // Details
        if (t.type === 1) {
          ctx.fillStyle = '#654321';
          ctx.fillRect(screenX + 4, t.y * TILE + 20, TILE-8, 12);
        }
        if (t.type === 3) {
          ctx.fillStyle = '#228B22';
          ctx.fillRect(screenX, t.y * TILE, TILE, TILE);
        }
        if (t.type === 6) {
          ctx.fillStyle = '#FFD700';
          ctx.fillRect(screenX + 24, t.y * TILE - 32, 8, 40);
        }
      }
    });

    // Mario (simple pixel art style)
    let mx = mario.x - camera.x;
    ctx.save();
    if (mario.facing < 0) {
      ctx.scale(-1, 1);
      mx = -mx - 16;
    }
    ctx.fillStyle = '#FF0000';  // overalls
    ctx.fillRect(mx + 4, mario.y + 8, 8, 8);
    ctx.fillStyle = '#FDBCB4';  // skin
    ctx.fillRect(mx + 8, mario.y, 8, 8);
    ctx.fillStyle = '#0000FF';  // shirt
    ctx.fillRect(mx, mario.y + 8, 12, 8);
    ctx.fillStyle = '#FF0000';  // hat
    ctx.fillRect(mx + 2, mario.y - 4, 12, 8);
    ctx.fillStyle = '#000';
    ctx.fillRect(mx + 10, mario.y - 2, 4, 4);  // eyes
    ctx.restore();

    // Mario shadow
    ctx.fillStyle = 'rgba(0,0,0,0.2)';
    ctx.fillRect(mx + 4, mario.y + 16, 8, 4);

    // Goombas
    goombas.forEach(g => {
      if (g.dead) return;
      let gx = g.x - camera.x;
      ctx.fillStyle = '#8B4513';
      ctx.fillRect(gx, g.y, 16, 12);
      ctx.fillStyle = '#654321';
      ctx.fillRect(gx + 2, g.y + 2, 12, 8);
      ctx.fillStyle = '#000';
      ctx.fillRect(gx + 4, g.y + 4, 2, 2);
      ctx.fillRect(gx + 10, g.y + 4, 2, 2);
    });

    // Coin particles (simple animation)
    // Omitted for brevity, can add later
  }

  function updateHUD() {
    $('#coins').text(coins);
    $('#score').text(score);
  }

  function gameOver() {
    gameRunning = false;
    $('#finalScore').text(score);
    $('#game-over').fadeIn(600);
  }

  function loop() {
    update();
    draw();
    requestAnimationFrame(loop);
  }

  // Start
  updateHUD();
  loop();

  $('#restart').on('click', () => {
    location.reload();
  });
});
</script>