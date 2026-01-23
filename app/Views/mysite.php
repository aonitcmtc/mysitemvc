<!DOCTYPE html>
<html lang="en">
    <head>
        <title>mysite-aonitcmtc</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="./img-default/catlogo_ico.png">

        <link href="./asset/bootstrap.min.css" rel="stylesheet">
        <script src="./asset/bootstrap.bundle.min.js"></script>

        <script src="./asset/jquery.slim.min.js"></script>
        <script src="./asset/popper.min.js"></script>

        <link href="./asset/font-awesome.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="./asset/bootstrap-icons/bootstrap-icons.css">
    </head>
    <body>

    <style>
        body {
            margin: 0;
        }

        .landingpage { padding: 0; }

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
            
        }
    </style>
    

        <div class="d-navbar">
            <nav class="navbar navbar-expand-lg bg-primary-subtle">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="./img-default/weblogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="./page/noodle.php">Noodle Shop</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./landing.php">landing</a>
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
                                    <li><a class="dropdown-item" target="_blank" href="./drive">myDrive</a></li>
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
                        <a href="./controller/logoutController.php">
                            <button class="btn btn-danger mx-2" type="button">Logout</button>
                        </a>
                    </form> -->

                    <p class="text-warning">count visit page</p> 
                    &ensp;
                    <p class="text-dark">theme mode</p> 
                </div>
            </nav>

            <!-- <nav class="navbar navbar-expand-sm navbar-primary bg-secondary h-nav">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="./public/profiles/aonitcmtc1.jpg" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                        <span class="navbar-toggler-icon"></span>
                        <span class="">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="mynavbar">
                        <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                            <a class="nav-link crop-text-nav" href="https://myinvest-app.online/" target="blank">My Invest</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link crop-text-nav" href="http://myexpress-api.click/" target="blank">Express api</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link crop-text-nav" href="https://dash.cloudflare.com/" target="blank">Cloudflare</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link crop-text-nav" href="https://hpanel.hostinger.com/" target="blank">Hostinger</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link crop-text-nav" href="./public/" target="blank">PublicPage</a>
                        </li>
                        
                        </ul>
                        https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/configure-tunnels/local-management/as-a-service/linux/
                        <form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Search">
                            <button class="btn btn-primary" type="button">Search</button>
                            <hr>
                            <a href="./controller/logoutController.php">
                                <button class="btn btn-danger mx-2" type="button">Logout</button>
                            </a>
                        </form>

                        <p class="text-warning">count visit page</p> 
                        &ensp;
                        <p class="text-dark">theme mode</p> 

                        theme mode
                    </div>
                </div>
            </nav> -->

        </div>

        <div class="container-fluid landingpage">
            <div class="row justify-content-center">
                <div class="col-12 mt-5">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="./img-default/newproducts.png" class="d-block h-shoping" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="./img-default/newproducts2.png" class="d-block h-shoping" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="./img-default/newproducts3.png" class="d-block h-shoping" alt="...">
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
                </div>
            </div>

            <!-- <div class="row justify-content-center">
                <div class="col-12">
                    <div class="bg-success">
                        collection web project
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="bg-warning">
                        statistic
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="bg-danger">
                        news
                    </div>
                </div>
            </div> -->

            <!-- <div class="row">
                <div class="col-12 mt-2">
                    <div class="bg-dark"> -->
                        <!-- <a href="#" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="https://www.tiktok.com/@likefloorstampconcrete"><i class="fab fa-ะราะนา fa-lg"></i></a>
                        <a href="#"><i class="fab fa-line fa-lg"></i></a> -->

                        <!-- <a href="https://www.tiktok.com/@likefloorstampconcrete" target="_blank" class="mx-2"><i class="bi bi-tiktok fa-2x"></i></a>
                        <a href="https://www.facebook.com/likefloorstampconcrete" target="_blank" class="mx-2"><i class="bi bi-facebook fa-2x"></i></a>
                        <a href="https://www.instagram.com/likefloorstampconcrete" target="_blank" class="mx-2"><i class="bi bi-instagram fa-2x"></i></a>
                        <a href="https://lin.ee/nknUyhZ" target="_blank" class="mx-2"><i class="bi bi-line fa-2x"></i></a>
                    </div>
                </div>
            </div> -->
        </div>

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
