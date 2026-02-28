<!-- Font Awesome สำหรับไอคอน (ถ้าต้องการ) -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
<link rel="stylesheet" href="<?=base_url();?>asset/font-awesome6/css/all.css">

<style>
    /* ปรับแต่ง sidebar */
    .sidebar {
      min-height: 100vh;
      background-color: #212529; /* สีพื้นหลังเข้ม */
      color: white;
      transition: width 0.3s ease;
      position: fixed;
      top: 66px;
      left: 0;
      z-index: 1000;
      width: 250px;
    }
    
    .sidebar.collapsed {
      width: 70px;
    }
    
    .sidebar .nav-link {
      color: rgba(255,255,255,0.85);
      padding: 0.75rem 1.25rem;
      font-size: 1.05rem;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      color: white;
      background-color: rgba(255,255,255,0.1);
    }
    
    .sidebar .dropdown-menu {
      background-color: #343a40;
      border: none;
    }
    
    .sidebar .dropdown-item {
      color: rgba(255,255,255,0.85);
    }
    
    .sidebar .dropdown-item:hover {
      background-color: #495057;
      color: white;
    }
    
    /* เนื้อหาหลักเลื่อนตาม sidebar */
    .main-content {
      margin-left: 250px;
      transition: margin-left 0.3s ease;
      min-height: 100vh;
      padding: 20px;
    }
    
    .main-content.collapsed {
      margin-left: 70px;
    }
    
    /* ปุ่ม toggle */
    .toggle-btn {
        position: fixed;
        top: 78px;
        left: 200px;
        z-index: 1100;
        transition: left 0.3s ease;
        background-color: #2a272f;
        opacity: 0.2;
    }
    
    .collapsed .toggle-btn {
      left: 80px;
    }
    
    @media (max-width: 992px) {
      .sidebar {
        width: 0;
        overflow: hidden;
      }
      .main-content {
        margin-left: 0;
      }
      .toggle-btn {
        left: 15px;
      }
    }
</style>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="d-flex flex-column p-3">
      <!-- Logo / Brand -->
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
        <i class="fas fa-rocket fs-3 me-2"></i>
        <span class="fs-4 sidebar-brand">My App</span>
      </a>
      <button class="btn btn-secondary toggle-btn" id="toggleSidebar">
    <i class="fas fa-bars"></i>
</button>

      <hr class="text-white">

      <!-- เมนูหลัก -->
      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="fas fa-home me-2"></i>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>

        <!-- Dropdown ตัวอย่าง 1 -->
        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" 
             data-bs-toggle="collapse" 
             data-bs-target="#menu1" 
             aria-expanded="false">
            <i class="fas fa-cog me-2"></i>
            <span class="sidebar-text">ตั้งค่า</span>
          </a>
          <div class="collapse" id="menu1">
            <ul class="nav flex-column ms-4">
              <li><a href="#" class="nav-link">โปรไฟล์</a></li>
              <li><a href="#" class="nav-link">บัญชี</a></li>
              <li><a href="#" class="nav-link">ความปลอดภัย</a></li>
            </ul>
          </div>
        </li>

        <!-- Dropdown ตัวอย่าง 2 -->
        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" 
             data-bs-toggle="collapse" 
             data-bs-target="#menu2" 
             aria-expanded="false">
            <i class="fas fa-box me-2"></i>
            <span class="sidebar-text">สินค้า</span>
          </a>
          <div class="collapse" id="menu2">
            <ul class="nav flex-column ms-4">
              <li><a href="#" class="nav-link">รายการสินค้า</a></li>
              <li><a href="#" class="nav-link">เพิ่มสินค้า</a></li>
              <li><a href="#" class="nav-link">หมวดหมู่</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-chart-bar me-2"></i>
            <span class="sidebar-text">รายงาน</span>
          </a>
        </li>
      </ul>

      <hr class="text-white">
      
      <!-- เมนูล่าง -->
      <div>
        <a href="#" class="nav-link">
          <i class="fas fa-sign-out-alt me-2"></i>
          <span class="sidebar-text">ออกจากระบบ</span>
        </a>
      </div>
    </div>
</nav>

<!-- ปุ่มเปิด-ปิด sidebar -->
<!-- <button class="btn btn-dark toggle-btn" id="toggleSidebar">
    <i class="fas fa-bars"></i>
</button> -->

<!-- เนื้อหาหลัก -->
<main class="main-content" id="mainContent">
    <div class="container-fluid">
      <h1 class="mt-4">ยินดีต้อนรับเข้าสู่ระบบ</h1>
      <p>นี่คือตัวอย่างเมนูด้านข้าง Bootstrap 5.3 พร้อม dropdown และการควบคุมด้วย jQuery</p>
      
      <div class="row mt-5">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card example</h5>
              <p class="card-text">เนื้อหาจะเลื่อนตาม sidebar เมื่อย่อ-ขยาย</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>

<script>
    $(document).ready(function() {
      // Toggle sidebar เมื่อกดปุ่ม
      $('#toggleSidebar').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('#mainContent').toggleClass('collapsed');
        
        // ซ่อนข้อความเมื่อย่อ sidebar (optional)
        $('.sidebar-text, .sidebar-brand').toggleClass('d-none');
      });

      // สำหรับมือถือ ให้ sidebar ซ่อนตอนแรก
      if ($(window).width() < 992) {
        $('#sidebar').addClass('collapsed');
        $('#mainContent').addClass('collapsed');
        $('.sidebar-text, .sidebar-brand').addClass('d-none');
      }
    });
</script>