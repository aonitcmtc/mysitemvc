<style>
    body {
      margin: 0;
      height: 100vh;
      background: #0a0a1f;
      font-family: Arial, Helvetica, sans-serif;
      color: #eee;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }
    #game-wrapper {
      position: relative;
    }
    canvas {
      border: 4px solid #444;
      background: #000814;
      box-shadow: 0 0 40px rgba(0, 255, 180, 0.25);
      image-rendering: pixelated;
    }
    #hud {
      position: absolute;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0,0,0,0.7);
      padding: 10px 24px;
      border-radius: 12px;
      border: 2px solid #0f0;
      font-size: 1.4rem;
      font-weight: bold;
      pointer-events: none;
    }
    #game-over {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.92);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 3.5rem;
      color: #ff3366;
      text-shadow: 0 0 15px #f00;
      z-index: 10;
    }
    #game-over small {
      font-size: 1.4rem;
      color: #ccc;
      margin: 20px 0;
    }
    button {
      margin-top: 30px;
      padding: 14px 40px;
      font-size: 1.5rem;
      background: #0f0;
      color: black;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background: #0f8;
    }
    #instructions {
      margin-top: 20px;
      font-size: 1.1rem;
      color: #88ffaa;
      text-align: center;
    }
    .d-navbar, .footer{ visibility: hidden;}
</style>
<body>

<div id="game-wrapper">
  <canvas id="gameCanvas" width="600" height="600"></canvas>

  <div id="hud">
    Score: <span id="score">0</span>
  </div>

  <div id="game-over">
    <div>GAME OVER</div>
    <small>Your score: <span id="finalScore">0</span></small>
    <button id="restart">Play Again</button>
  </div>
</div>

<div id="instructions">
  Use ← ↑ → ↓ or WASD keys to move<br>
  Eat the red food • Don't hit walls or yourself
</div>

<script>
$(function() {

  const canvas = $('#gameCanvas')[0];
  const ctx = canvas.getContext('2d');
  const GRID = 20;
  const COLS = canvas.width / GRID;
  const ROWS = canvas.height / GRID;

  let snake = [{x: 10, y: 10}];
  let dx = 1;
  let dy = 0;
  let food = {x: 15, y: 8};
  let score = 0;
  let gameRunning = true;
  let speed = 120; // ms per frame (lower = faster)

  let keys = {};

  // Controls
  $(window).on('keydown', e => {
    if (!gameRunning) return;

    let k = e.key.toLowerCase();

    if ((k === 'arrowleft'  || k === 'a') && dx !== 1)  { dx = -1; dy = 0; }
    if ((k === 'arrowright' || k === 'd') && dx !== -1) { dx =  1; dy = 0; }
    if ((k === 'arrowup'    || k === 'w') && dy !== 1)  { dx =  0; dy = -1; }
    if ((k === 'arrowdown'  || k === 's') && dy !== -1) { dx =  0; dy =  1; }

    // Prevent instant reverse on single press
    e.preventDefault();
  });

  function placeFood() {
    food.x = Math.floor(Math.random() * COLS);
    food.y = Math.floor(Math.random() * ROWS);

    // Make sure food doesn't spawn on snake
    if (snake.some(s => s.x === food.x && s.y === food.y)) {
      placeFood();
    }
  }

  function update() {
    if (!gameRunning) return;

    // Create new head
    let head = { x: snake[0].x + dx, y: snake[0].y + dy };

    // Wall collision
    if (head.x < 0 || head.x >= COLS || head.y < 0 || head.y >= ROWS) {
      gameOver();
      return;
    }

    // Self collision
    if (snake.some(s => s.x === head.x && s.y === head.y)) {
      gameOver();
      return;
    }

    // Add new head
    snake.unshift(head);

    // Eat food?
    if (head.x === food.x && head.y === food.y) {
      score += 10;
      $('#score').text(score);
      placeFood();

      // Speed up slightly every 50 points
      if (score % 50 === 0 && speed > 60) {
        speed -= 8;
      }
    } else {
      // Remove tail
      snake.pop();
    }
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Grid background (optional subtle pattern)
    ctx.fillStyle = '#001122';
    for (let y = 0; y < ROWS; y++) {
      for (let x = 0; x < COLS; x++) {
        if ((x + y) % 2 === 0) {
          ctx.fillRect(x*GRID, y*GRID, GRID, GRID);
        }
      }
    }

    // Snake
    ctx.fillStyle = '#00ff88';
    snake.forEach((seg, i) => {
      let brightness = 220 - i * 8;
      ctx.fillStyle = `rgb(0, ${brightness}, 120)`;
      ctx.fillRect(seg.x * GRID + 1, seg.y * GRID + 1, GRID - 2, GRID - 2);
    });

    // Head glow
    ctx.fillStyle = '#88ffdd';
    ctx.fillRect(snake[0].x * GRID + 3, snake[0].y * GRID + 3, GRID - 6, GRID - 6);

    // Food
    ctx.fillStyle = '#ff3366';
    ctx.beginPath();
    ctx.arc(
      food.x * GRID + GRID/2,
      food.y * GRID + GRID/2,
      GRID/2 - 2,
      0, Math.PI * 2
    );
    ctx.fill();

    // Food glow
    ctx.shadowBlur = 15;
    ctx.shadowColor = '#ff3366';
    ctx.fill();
    ctx.shadowBlur = 0;
  }

  function gameOver() {
    gameRunning = false;
    $('#finalScore').text(score);
    $('#game-over').fadeIn(600);
  }

  function gameLoop() {
    update();
    draw();
    setTimeout(() => {
      requestAnimationFrame(gameLoop);
    }, speed);
  }

  // Restart
  $('#restart').on('click', () => {
    snake = [{x: 10, y: 10}];
    dx = 1; dy = 0;
    score = 0;
    speed = 120;
    $('#score').text(0);
    placeFood();
    gameRunning = true;
    $('#game-over').hide();
    gameLoop();
  });

  // Start
  placeFood();
  gameLoop();
});
</script>