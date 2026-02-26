<!DOCTYPE html>
<html lang="en">
    <head>
        <title>mysite-aonitcmtc</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?=base_url();?>img-default/catlogo_ico.png">

        <link href="<?=base_url();?>asset/bootstrap.min.css" rel="stylesheet">
        <script src="<?=base_url();?>asset/bootstrap.bundle.min.js"></script>

        <script src="<?=base_url();?>asset/jquery.slim.min.js"></script>
        <script src="<?=base_url();?>asset/popper.min.js"></script>

        <!-- <link href="<?=base_url();?>asset/font-awesome.min.css" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="<?=base_url();?>asset/bootstrap-icons/bootstrap-icons.css">
    </head>
    <body>

    <style>
        body {
            margin: 0;
        }

        .landingpage { 
            padding: 0; 
            /* margin-top: 500px; */

            background-image: url("<?=base_url();?>img-default/landing-cover.png");
            background-repeat: no-repeat;
            background-color: #000; /* Used if the image is unavailable */
            height: 200vh; /* You must set a specified height */
            background-position: center; /* Center the image */
            background-size: cover; /* Resize the background image to cover the entire container */
        }

        .btn-navigation {
            margin-top: 145vh;
        }

        .btn-lg {
            --bs-btn-padding-y: 0.5rem;
            --bs-btn-padding-x: 0.5rem;
            --bs-btn-font-size: 1.2rem;
            --bs-btn-border-radius: 20px;
        }

        /* .h-shoping {
            height: 68vh !important;
        } */

        .h-nav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 100%;
            position: fixed;
            overflow: auto;
        }

        .v-ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 20%;
            background-color: #f1f1f1;
            position: fixed;
            top: 50px;
            height: 100%;
            overflow: auto;
        }

        .v-li a {
            display: block;
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
        }

        .v-li a.active {
            background-color:rgb(99, 160, 239);
            color: white;
        }

        .v-li a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        .screen {
            /* position: fixed; */
            /* top: 50px; */
            margin-left:20%;
            margin-top:90px;
            /* margin-bottom:90px; */
            /* padding:1px 16px; */
            width: 80%;
            height:756px;
            /* overflow: auto;    */
        }

        .pd-src {
            padding:8px 16px;
        }

        .d-navbar {
            position: fixed;
            top: 0;
            z-index: 999;
            width: 100%;
            /* height: 632px; */
            overflow: auto;
        }

        .dropdown-menu {
            /* position: absolute; */
            z-index: 999;
        }

        .footer {
            /* position: fixed;
            bottom: 0; */
            position: absolute;
            padding: 16px;
            width: 100%;
            min-height:48px;
            background-color: #555;
        }

        .li-dropdown:active { 
            background-color: red; 
        } 

        .crop-text-nav { 
            overflow:hidden; 
            white-space:nowrap; 
            text-overflow:ellipsis; 
            width:100px; 
        }

        .crop-text-nav-hor { 
            overflow:hidden; 
            white-space:nowrap; 
            text-overflow:ellipsis; 
            width:300px; 
        }

        @media screen and (max-width: 575px) {
            .d-flex {
                margin-bottom: 18px;
            }

            .crop-text-nav-hor { 
                overflow:hidden; 
                white-space:nowrap; 
                text-overflow:ellipsis; 
                width:80px; 
            }

            .landingpage { 
                height: 100vh; /* You must set a specified height */
            }

            .btn-navigation {
                margin-top: 0;
                position: absolute;
                bottom: 1rem;
            }

            .btn-lg {
                --bs-btn-padding-y: 0.3rem;
                --bs-btn-padding-x: 0.3rem;
                --bs-btn-font-size: 1rem;
                --bs-btn-border-radius: 20px;
            }
        }
    </style>
    

        <!-- <div class="d-navbar">
            <nav class="navbar navbar-expand-lg bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="<?=base_url();?>images/weblogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="<?=base_url();?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light active" aria-current="page" href="<?=base_url();?>landing.php">Landing Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://aonitcmtc.github.io/Portfolio/">Portfolio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Pricing</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    My Project
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" target="_blank" href="#">001</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="#">002</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="#">003</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/configure-tunnels/local-management/as-a-service/linux/
                    <form class="d-flex">
                        <input class="form-control me-2" type="text" placeholder="Search">
                        <button class="btn btn-primary" type="button">Search</button>
                        <hr>
                        <a href="<?=base_url();?>controller/logoutController.php">
                            <button class="btn btn-danger mx-2" type="button">Logout</button>
                        </a>
                    </form>

                    <p class="text-warning">count visit page</p> 
                    &ensp;
                    <p class="text-dark">theme mode</p> 
                </div>
            </nav>

        </div> -->

        <div class="container-fluid landingpage">
            <div class="row justify-content-center">
                <!-- <div class="col-12 mt-5">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="<?=base_url();?>public/img-default/newproducts.png" class="d-block h-shoping" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="<?=base_url();?>public/img-default/newproducts2.png" class="d-block h-shoping" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="<?=base_url();?>public/img-default/newproducts3.png" class="d-block h-shoping" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                </div> -->

                <div class="col-12 text-center text-light mt-5 p-2">
                    <h1>Guided by the Guardian</h1>
                    <h4>
                        Discover Patchara's world of code
                        and imagination.
                    </h4>
                    <h5>
                        <i class="bi bi-people"></i>
                        <span class="fs-6"><?= $count_view.'<br>'; ?></span>
                    </h5>

                    <!-- <p>
                        <?php   
                            $request = service('request'); // ดึง Request Service ของ CI4
                            $ip      = $request->getIPAddress();
                            $agent   = $request->getUserAgent();
                            $url     = current_url();
                            $visited_at = date('Y-m-d H:i:s');

                            echo $ip.'<br>';
                            echo $agent.'<br>';
                            echo $url.'<br>';
                            echo $visited_at;
                        ?>
                    </p> -->
                </div>
            </div>

            <div class="btn-navigation">
                <div class="row justify-content-center">
                    <div class="col-6 text-end mb-3">
                        <a href="<?=base_url();?>mysite">
                            <button class="btn btn-lg btn-outline-light mx-4" type="button">&emsp; My Site &emsp;</button>
                        </a>
                    </div>
                    <div class="col-6 text-start mb-3">
                        <a href="https://github.com/aonitcmtc" target="_blank">
                            <button class="btn btn-lg btn-outline-light mx-4" type="button">&emsp; Github &emsp;</button>
                        </a>
                    </div>
                    
                    <div class="col-6 text-center my-3">
                        <a href="<?=base_url();?>admin" target="_blank">
                            <button class="btn btn-lg btn-outline-light mx-4" type="button">&emsp; Admin site &emsp;</button>
                        </a>
                    </div>
                </div>
            </div>
            

        </div>

    <!-- <div id="footer" class="footer bg-dark">
        <div class="text-center text-light">
            copyright ©2025. create by 
            <a href="https://github.com/aonitcmtc" target="_blank" class="text-decoration-none text-light">@aonitcmtc</a>
            <br>
            power By 
            <a href="/powerby" target="_blank" class="text-decoration-none text-dark">CI4</a>
        </div>
    </div> -->
    <div id="footer" class="footer bg-secondary">
        <?php include 'footer.php' ?>
    </div>

    <script>
      $(document).ready(function(){
            $("#li_bootstrapExample").click(function(){
            var isExpanded = $('#li_bootstrapExample').hasClass('collapsed')
            // console.log(isExpanded);
            if (!isExpanded) {
                $("#icon_bootstrapExample").removeClass("fa-chevron-right");
                $("#icon_bootstrapExample").addClass("fa-chevron-down");
            } else {
                $("#icon_bootstrapExample").removeClass("fa-chevron-down");
                $("#icon_bootstrapExample").addClass("fa-chevron-right");
            }
            });

            $(".d-navbar").click(function(){
            var showdropdown = $('.dropdown-menu').hasClass('show')
            //   console.log(showdropdown);
            if(showdropdown){
                $(".d-navbar").css("height", "500px");
            } else {
                $(".d-navbar").css("height", "auto");
            }
            });

            

            // console.log($('#li_bootstrapExample').hasClass('active'))
            // $('li.menu').hasClass('active');

            // console.log('hello');
        });
    </script>

    </body>
</html>
