<!-- <title>Bootstrap 5.3 Navbar with Profile Dropdown</title> -->

<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm">
  <div class="container-fluid">
    
    <!-- Brand / Logo -->
    <a class="navbar-brand fw-bold" href="#">MySite</a>
    
    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarContent" aria-controls="navbarContent" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarContent">
      
      <!-- Left side menu items -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        
        <!-- Example Dropdown (kept from before) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Web Development</a></li>
            <li><a class="dropdown-item" href="#">Mobile Apps</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Consulting</a></li>
            <li><a class="dropdown-item" href="#">SEO & Marketing</a></li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>

      <!-- Right side: User Profile Dropdown (replaces search) -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">  <!-- ms-auto pushes to right -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Optional: User avatar/icon -->
            <i class="bi bi-person-circle fs-4 me-2"></i>
            Patchara
          </a>
          <ul class="dropdown-menu dropdown-menu-end">  <!-- dropdown-menu-end aligns menu to the right edge -->
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>