<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
<link rel="stylesheet" href="<?=base_url();?>asset/font-awesome6/css/all.css">
  
<style>
    :root {
      --electric: #00f0ff;       /* สีหลักฟ้าไฟฟ้า */
      --electric-glow: #00ffff88; /* สีเรืองแสง */
      --electric-dark: #0a1f2f;   /* พื้นหลังเข้ม */
      --electric-accent: #ff00aa; /* สีชมพูเสริม */
    }

    body {
      background: linear-gradient(135deg, #0d001a, #000814);
      color: #e0f7ff;
      min-height: 100vh;
    }

    /* Sidebar Electric Theme */
    .sidebar {
      min-height: 100vh;
      background: var(--electric-dark);
      color: white;
      transition: width 0.4s ease;
      position: fixed;
      top: 0; left: 0; z-index: 1000;
      width: 260px;
      overflow: hidden;
      box-shadow: 0 0 30px rgba(0, 240, 255, 0.25);
    }

    .sidebar.collapsed {
      width: 80px;
    }

    /* Electric Border + Glow Animation */
    .sidebar::before {
      content: '';
      position: absolute;
      inset: 0;
      border: 2px solid var(--electric);
      border-radius: 0 18px 18px 0;
      pointer-events: none;
      animation: electricFlow 6s linear infinite;
      box-shadow: 
        0 0 15px var(--electric-glow),
        0 0 35px var(--electric-glow),
        inset 0 0 12px var(--electric-glow);
      background: linear-gradient(
        90deg,
        transparent 0%,
        var(--electric) 25%,
        var(--electric-accent) 50%,
        var(--electric) 75%,
        transparent 100%
      );
      background-size: 300% 300%;
      mask: linear-gradient(#fff 0 0) padding-box, 
            linear-gradient(#fff 0 0);
      mask-composite: exclude;
      -webkit-mask-composite: xor;
    }

    @keyframes electricFlow {
      0%   { background-position: 0% 50%; }
      100% { background-position: 300% 50%; }
    }

    .sidebar .nav-link {
      color: #c0f0ff;
      padding: 0.9rem 1.3rem;
      position: relative;
      transition: all 0.3s;
      overflow: hidden;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      color: white;
      text-shadow: 0 0 10px var(--electric);
      background: rgba(0, 240, 255, 0.12);
    }

    .sidebar .nav-link i {
      transition: transform 0.3s;
    }

    .sidebar .nav-link:hover i {
      transform: scale(1.2) rotate(10deg);
    }

    /* Dropdown */
    .sidebar .collapse {
      background: rgba(0, 15, 30, 0.6);
      border-left: 3px solid var(--electric);
    }

    .sidebar .nav.flex-column .nav-link {
      padding-left: 2.8rem;
    }

    /* Brand / Logo */
    .sidebar-brand {
      font-weight: bold;
      text-shadow: 0 0 12px var(--electric);
      letter-spacing: 1px;
    }

    /* Main content */
    .main-content {
      margin-left: 260px;
      transition: margin-left 0.4s ease;
      padding: 2rem;
    }

    .main-content.collapsed {
      margin-left: 80px;
    }

    /* Toggle Button */
    .toggle-btn {
      position: fixed;
      top: 1rem;
      left: 270px;
      z-index: 1100;
      transition: left 0.4s ease;
      background: var(--electric);
      border: none;
      box-shadow: 0 0 15px var(--electric-glow);
    }

    .collapsed .toggle-btn {
      left: 90px;
    }

    @media (max-width: 992px) {
      .sidebar { width: 0; }
      .main-content { margin-left: 0; }
      .toggle-btn { left: 1rem; }
    }
</style>

  <!-- Sidebar Electric -->
  <nav class="sidebar" id="sidebar">
    <div class="d-flex flex-column p-3">
      <!-- Brand -->
      <a href="#" class="d-flex align-items-center mb-4 text-decoration-none sidebar-brand fs-3">
        <i class="fas fa-bolt me-2"></i> ELECTRIC HUB
      </a>
      <hr class="border border-info border-2 opacity-75">

      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="fas fa-bolt me-2"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" 
             data-bs-toggle="collapse" data-bs-target="#menuSys">
            <i class="fas fa-microchip me-2"></i> System
          </a>
          <div class="collapse" id="menuSys">
            <ul class="nav flex-column ms-4">
              <li><a href="#" class="nav-link">CPU Monitor</a></li>
              <li><a href="#" class="nav-link">Network Pulse</a></li>
              <li><a href="#" class="nav-link">Power Grid</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" 
             data-bs-toggle="collapse" data-bs-target="#menuNeon">
            <i class="fas fa-plug me-2"></i> Neon Controls
          </a>
          <div class="collapse" id="menuNeon">
            <ul class="nav flex-column ms-4">
              <li><a href="#" class="nav-link">Glow Intensity</a></li>
              <li><a href="#" class="nav-link">Color Shift</a></li>
              <li><a href="#" class="nav-link">Pulse Mode</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-chart-line me-2"></i> Analytics
          </a>
        </li>
      </ul>

      <hr class="border border-info border-2 opacity-75">

      <a href="#" class="nav-link">
        <i class="fas fa-power-off me-2"></i> Shutdown
      </a>
    </div>
  </nav>

  <!-- Toggle Button -->
  <button class="btn btn-lg toggle-btn text-dark" id="toggleSidebar">
    <i class="fas fa-bolt"></i>
  </button>

  <!-- Main Content -->
  <main class="main-content" id="mainContent">
    <div class="container-fluid">
      <h1 class="mt-3 mb-4" style="text-shadow: 0 0 20px var(--electric);">
        <i class="fas fa-bolt me-2"></i> ELECTRIC DASHBOARD
      </h1>
      <p class="lead">Neon-powered admin interface with glowing electric borders ⚡</p>

      <div class="row mt-5">
        <div class="col-md-6">
          <div class="card bg-dark text-light border-0 shadow-lg" style="box-shadow: 0 0 40px var(--electric-glow);">
            <div class="card-body">
              <h5 class="card-title">Energy Status</h5>
              <p>Core systems online — glowing at maximum capacity.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
      $('#toggleSidebar').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('#mainContent').toggleClass('collapsed');
        $('.sidebar-brand, .nav-link span').toggleClass('d-none'); // ซ่อนข้อความเมื่อย่อ (ถ้าต้องการ)
      });

      // มือถือเริ่มต้นซ่อน
      if ($(window).width() < 992) {
        $('#sidebar').addClass('collapsed');
        $('#mainContent').addClass('collapsed');
      }
    });
</script>