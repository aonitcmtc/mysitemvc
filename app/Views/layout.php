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
            }
        </style>

        <?php $session = session(); ?>

        <!-- Top navbar -->
        <div class="d-navbar">
            <nav class="navbar navbar-expand-lg bg-primary-subtle">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="<?=base_url();?>img-default/weblogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url();?>mysite">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-current="page" href="<?=base_url();?>page/noodle.php">Noodle Shop</a>
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
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <li><a class="dropdown-item" target="_blank" href="#">002</a></li>
                            <li><a class="dropdown-item" target="_blank" href="#">003</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

            <p class="text-secondary">
                <i class="bi bi-people"></i>
                <small><?= $count_view ?></small>
            </p> 
            &ensp;&ensp;&ensp;
            <p class="text-dark">
                <i class="bi bi-moon-stars-fill"></i>
            </p> 
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

        <!-- scripts -->

        <!-- <script type="module" src="cookieconsent-config.js"></script> --> <!-- is Admin page not Active -->
        <!-- <script type="module" src="/asset/iscookie/cookieconsent-config.js"></script> -->
        <!-- <script type="module" src="/asset/"></script> -->
    </body>
</html>