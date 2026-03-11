<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= esc($title ?? 'mySite') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?=base_url();?><?= esc($favicon ?? 'homemysite.ico') ?>">

        <!-- Bootstrap 5 -->
        <link href="<?=base_url();?>asset/bootstrap.min.css" rel="stylesheet">
        <script src="<?=base_url();?>asset/jquery.slim.min.js"></script>
        <script src="<?=base_url();?>asset/popper.min.js"></script>
        <script src="<?=base_url();?>asset/bootstrap.bundle.min.js"></script>

        <!-- CSS ICONS -->
        <link href="<?=base_url();?>asset/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
        <link href="<?=base_url();?>asset/fontawesome4/css/font-awesome.min.css" rel="stylesheet">

        <!-- JQuery -->
        <script src="<?=base_url();?>asset/jquery-3.7.1.min.js"></script>
        
        <!-- Sweetalert2 -->
        <script src="<?=base_url();?>asset/sweetalert2/sweetalert2.all.min.js"></script>
        <link href="<?=base_url();?>asset/sweetalert2/sweetalert2.min.css" rel="stylesheet">

        <!-- my custom css -->
        <link rel="stylesheet" href="<?=base_url();?>css/mysite.css">

        <!-- cookieconsent -->
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css"> -->
    </head>
    <body>
        <style>
            .navbar-nav {
                --bs-nav-link-padding-y: 0; /* remove padding y */
            }

            @media (max-width: 900px) {
                .d-navbar {
                    min-height: 50px;
                    line-height: 2;
                }

                #d_user {visibility: hidden;}
            }

            /* ✅ Fix: navbar sticky + dropdown อยู่เหนือทุก content */
            .d-navbar {
                overflow: visible !important;
            }
            .d-navbar nav.navbar {
                position: sticky;
                top: 0;
                z-index: 10000;
            }
            .d-navbar .dropdown-menu {
                z-index: 10001;
            }
        </style>

        <?php $session = session(); ?>
        <?php $statusMsg = $session->getFlashdata('status'); ?>
        <input type="hidden" name="statusMsg" id="statusMsg" value="<?= esc($statusMsg) ?>">

        <!-- Top navbar -->
        <div class="d-navbar">
            <nav class="navbar navbar-expand-lg bg-primary-subtle">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="<?=base_url();?>img-default/weblogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
            </a>
            <!-- Mobile: user icon + hamburger ชิดขวา -->
            <div class="d-flex align-items-center gap-2 ms-auto d-lg-none">
                <?php if (session()->get('user')) : ?>
                    <?php $user_mobile = session()->get('user'); ?>
                    <div id="d_user" class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle d-flex align-items-center gap-1"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (!empty($user_mobile['avatar'])) : ?>
                                <img src="<?= $user_mobile['avatar'] ?>" alt="avatar" class="rounded-circle" width="22" height="22" style="object-fit:cover;">
                            <?php else : ?>
                                <i class="bi bi-person-circle"></i>
                            <?php endif; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item small" href="<?= base_url('profile') ?>"><i class="bi bi-person me-2"></i>โปรไฟล์</a></li>
                            <li><a class="dropdown-item small" href="<?= base_url('userdata') ?>"><i class="bi bi-database me-2"></i>ข้อมูลของฉัน</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li><a class="dropdown-item small text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>ออกจากระบบ</a></li>
                        </ul>
                    </div>
                <?php else : ?>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <i class="bi bi-ui-radios-grid"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url();?>mysite">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link disabled" aria-current="page" href="<?=base_url();?>page/noodle">Noodle Shop</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?=base_url();?>note">Note</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url();?>landing.php">landing</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="https://aonitcmtc.github.io/Portfolio/">Portfolio</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle disabled" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My Project
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" target="_blank" href="<?=base_url();?>drive">myDrive</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">002</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">003</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Chart stock
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" target="_blank" href="/chart/xauusd">XAUUSD</a></li>
                            <!-- <li><a class="dropdown-item" target="_blank" href="#">002</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">003</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle disabled" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            More
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" target="_blank" href="#">chart</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">statistic</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">news</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Social
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" target="_blank" href="https://www.facebook.com/">
                                facebook
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" target="_blank" href="https://www.instagram.com/">
                                instargram
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" target="_blank" href="https://www.blockdit.com/followdmoney">
                                blockdit
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/configure-tunnels/local-management/as-a-service/linux/ -->
            <!-- <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
                <hr>
                <a href="<?=base_url();?>controller/logoutController.php">
                    <button class="btn btn-danger mx-2" type="button">Logout</button>
                </a>
            </form> -->

            <!-- Desktop: visitor count + user section (ซ่อนบน mobile) -->
            <p class="text-secondary pt-3 d-none d-lg-block mb-0 ms-2">
                <i class="bi bi-people"></i>
                <small><?= $count_view ?></small>
            </p> 
            <div class="d-none d-lg-flex align-items-center gap-2 ms-2">
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Dark Mode">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>

                <?php if (session()->get('user')) : ?>
                    <?php $user = session()->get('user'); ?>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" 
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (!empty($user['avatar'])) : ?>
                                <!-- <img src="<?= $user['avatar'] ?>" 
                                    alt="avatar" 
                                    class="rounded-circle" 
                                    width="24" height="24"
                                    style="object-fit:cover;"> -->
                            <?php else : ?>
                                <i class="bi bi-person-circle"></i>
                            <?php endif; ?>
                            <small><?= esc($user['name']) ?></small>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <!-- Profile Header -->
                            <li>
                                <div class="dropdown-item-text d-flex align-items-center gap-2 py-2">
                                    <?php if (!empty($user['avatar'])) : ?>
                                        <img src="<?= $user['avatar'] ?>" 
                                            alt="avatar" 
                                            class="rounded-circle" 
                                            width="40" height="40"
                                            style="object-fit:cover;">
                                    <?php else : ?>
                                        <i class="bi bi-person-circle fs-4"></i>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold small"><?= esc($user['name']) ?></div>
                                        <div class="text-muted" style="font-size:0.75rem;"><?= esc($user['email']) ?></div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- User Profile -->
                            <li>
                                <a class="dropdown-item small" href="<?= base_url('profile') ?>">
                                    <i class="bi bi-person me-2"></i> โปรไฟล์
                                </a>
                            </li>

                            <!-- User Data -->
                            <li>
                                <a class="dropdown-item small" href="<?= base_url('userdata') ?>">
                                    <i class="bi bi-database me-2"></i> ข้อมูลของฉัน
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Logout -->
                            <li>
                                <a class="dropdown-item small text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </div>

                <?php else : ?>
                    <!-- ✅ เปิด Login Modal โดยตรง ไม่ต้อง navigate -->
                    <button type="button"
                        id="loginNavBtn"
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                <?php endif; ?>
            </div> 
        </div>
    </nav>

            <!-- <nav class="navbar navbar-expand-lg bg-primary navbar-light bg-87A2FF">
                <div class="container-fluid">
                    <a class="" href="/admin/">
                        <img src="<?=base_url();?>/img-default/weblogo.png" alt="Avatar Logo" style="width:30px;" class="rounded-pill"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-outline-secondary" href="/admin/logout">logout</a>
                        </div>
                    </div>
                </div>
            </nav> -->
        </div>

        <!-- Sidebar here (same as above) -->
        <div class="main-content">
            <main>
                <?= $content ?? '' ?>
            </main>
        </div>

        <div id="footer" class="footer">
            <?php include 'footer.php' ?>
        </div>

        <!-- ✅ LOGIN MODAL -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px; border: 2px solid #ffe6e6;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-secondary" id="loginModalLabel">Login to Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-2">

                        <div class="text-center mb-3">
                            <img src="<?=base_url();?>img-default/loginlogo.jpg"
                                class="rounded-circle" alt="Profile" width="90" height="90"
                                style="border: 3px solid #dee2e6;">
                        </div>

                        <form id="loginForm" class="was-validated-inactive">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>

                            <input type="hidden" name="ip" id="ip">
                            <input type="hidden" name="detail" id="detail">

                            <button type="button" id="loginBtn" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>

                            <div class="my-3">
                                <div class="d-flex align-items-center">
                                    <hr class="flex-grow-1">
                                    <span class="px-2 text-muted small">OR</span>
                                    <hr class="flex-grow-1">
                                </div>
                            </div>

                            <button type="button" id="googleLoginBtn" class="btn w-100 py-2"
                                style="background-color:#fff; border:1px solid #dee2e6; color:#333;">
                                <i class="bi bi-google"></i> Login with Google
                            </button>

                            <a href="<?= base_url('register') ?>" class="btn btn-outline-secondary w-100 py-2 mt-2 text-decoration-none">
                                <i class="bi bi-person-plus"></i> Create Account
                            </a>
                        </form>

                        <hr class="my-3">
                        <small class="text-muted d-block text-center">
                            <i class="bi bi-geo-alt"></i> <span id="showdetail">Loading location...</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LOGIN MODAL -->

        <script>
            $(document).ready(function(){
                // Enable tooltips (ยกเว้นปุ่ม loginNavBtn ที่ใช้ modal แทน)
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                if ($('#statusMsg').val() === 'login') {
                    console.log( $('#statusMsg').val());
                     $('#loginModal').modal('show');
                }

                // ✅ Google Login
                $('#googleLoginBtn').on('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'info',
                        title: 'Google Login',
                        text: 'Redirecting to Google...',
                        allowOutsideClick: false,
                        didOpen: function() { Swal.showLoading(); }
                    });
                    setTimeout(function() {
                        window.location.href = '<?= base_url('auth/google') ?>';
                    }, 1000);
                });

                // ✅ Regular Login
                $('#loginBtn').on('click', function() {
                    var email    = $('#email').val().trim();
                    var password = $('#password').val().trim();

                    if (!email || !password) {
                        Swal.fire({ icon: 'warning', title: 'Required Fields', text: 'Please enter email and password', timer: 2500 });
                        return;
                    }

                    Swal.fire({
                        icon: 'info', title: 'Logging in...', text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: function() { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: '<?= base_url('auth/login') ?>',
                        method: 'POST',
                        data: { email: email, password: password, ip: $('#ip').val(), detail: $('#detail').val() },
                        success: function(res) {
                            Swal.fire({ icon: 'success', title: 'Welcome!', text: 'Login successful', timer: 1500 })
                                .then(function() { location.reload(); });
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', title: 'Login Failed', text: 'Invalid email or password' });
                        }
                    });
                });

                // ✅ ดึง IP / Location
                $.ajax({
                    url: 'https://ipinfo.io/json?token=507072ba246a48',
                    method: 'GET',
                    success: function(res) {
                        var show_detail = res.city + ', ' + res.region + ', ' + res.country;
                        var detail      = res.ip + ' >>> ' + res.city + ' ' + res.region + ' ' + res.country + ' ' + res.org;
                        $('#ip').val(res.ip);
                        $('#detail').val(detail);
                        $('#showdetail').text(show_detail);
                    },
                    error: function() {
                        $('#showdetail').text('Location unavailable');
                    }
                });
            });
        </script>
    </body>
</html>