
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>phpMonitor</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="./../asset/bootstrap.min.css" rel="stylesheet">
        <script src="./../asset/bootstrap.bundle.min.js"></script>

        <script src="./../asset/jquery.slim.min.js"></script>
        <script src="./../asset/popper.min.js"></script>

        <link href="./../asset/font-awesome.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    </head>
    <body>

        <style>
        body {
            margin: 0;
        }

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
            height:632px;
            overflow: auto;
        }

        .dropdown-layout {
            /* position: absolute; */
            z-index: 999;
        }

        .footer {
            /* position: fixed;
            bottom: 0; */
            position: absolute;
            padding: 16px;
            width: 100%;
            height:48px;
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
            <nav class="navbar navbar-expand-sm navbar-primary bg-primary h-nav">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="../../images/cat.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                        <!-- <span class="navbar-toggler-icon"></span> -->
                        <span class="">
                        <!-- <i class="fa fa-user-o" aria-hidden="true"></i> -->
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
                            <a class="nav-link crop-text-nav" href="../../public/" target="blank">PublicPage</a>
                        </li>
                        </ul>
                        <!-- https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/configure-tunnels/local-management/as-a-service/linux/ -->
                        <form class="d-flex">
                        <!-- <input class="form-control me-2" type="text" placeholder="Search">
                        <button class="btn btn-primary" type="button">Search</button> -->
                        <hr>
                        <a href="../../controller/logoutController.php">
                            <button class="btn btn-danger mx-2" type="button">Logout</button>
                        </a>
                        </form>
                    </div>
                </div>
            </nav>

        </div>

        <!-- tab menu -->
        <?php
            // include '../controller/checkcookie.php';
            // include '../controller/checksession.php';

            $page = $controller;;
            $manu = $method;
        ?>

       
        
        <?php include 'admin_menu.php' ?>

        <div id="render_screen" class="screen">
            <?php if ($manu == 'admin') :?>
                <!-- render mysite -->
                 123456789
            <?php else :?>
                <?php include $page.'.php' ?>
            <?php endif;?>
        </div>

        <!-- <div id="footer" class="footer bg-secondary">
        </div> -->

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

            // console.log($('#li_bootstrapExample').hasClass('active'))
            // $('li.menu').hasClass('active');

            // console.log('hello');
        });
        </script>

    </body>
</html>