<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Auth</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="https://app.myexpress-api.click/img-default/weblogo.png">

    <link href="./../asset/bootstrap.min.css" rel="stylesheet">
    <script src="./../asset/jquery.slim.min.js"></script>
    <script src="./../asset/popper.min.js"></script>
    <script src="./../asset/bootstrap.bundle.min.js"></script>

    <!-- cookieconsent -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css">
</head>
<body>

<style>
    body {
        margin: 0;
        padding: 0; 
        /* margin-top: 500px; */

        /* background-image: url("../img-default/logincover2.jpg"); */
        background-repeat: no-repeat;
        background-color: #C4D7FF; /* Used if the image is unavailable */
        height: 100vh; /* You must set a specified height */
        background-position: center; /* Center the image */
        background-size: cover; /* Resize the background image to cover the entire container */
    }

    .bg-87A2FF {background-color: #87A2FF;}
    .bg-C4D7FF {background-color: #C4D7FF;}
    .bg-FFD7C4 {background-color: #FFD7C4;}
    .bg-FFF4B5 {background-color: #FFF4B5;}
    .bg-B3BFFF {background-color: #B3BFFF;}
    .bg-96A7E8 {background-color: #96A7E8;}
    .bd-87A {border: 2px solid #87A;}

    .d-dashboard {
        padding: 2rem; 
        /* backdrop-filter: blur(10px) brightness(110%); */
        margin-top: 3rem;
        margin-bottom: 3rem;
        min-height: 90vh;
        border: 2px solid #B3BFFF;
        border-radius: 30px;
    }

    .d-workspace {
        margin: 2rem 0.5rem;
        padding: 2rem; 
        min-height: 50vh;
        border: 2px solid #B3BFFF;
        border-radius: 20px;
    }

    .d-navbar {
        position: absolute;
        padding: 0 100px;
        width: 100%;
        color: #fff;
        background-color: #87A2FF;
    }

    .footer {
        /* position: fixed;
        bottom: 0; */
        position: absolute;
        padding: 16px;
        width: 100%;
        min-height:48px;
        /* backdrop-filter: blur(25px) brightness(120%); */
        color: #fff;
        background-color: #87A2FF;
    }
</style>

<div class="d-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-87A2FF">
        <div class="container-fluid">
            <a class="" href="/admin/">
                <img src="../img-default/weblogo.png" alt="Avatar Logo" style="width:30px;" class="rounded-pill"> 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li> -->
                </ul>
                <div class="d-flex">
                    <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    &ensp; -->
                    <a class="btn btn-sm btn-outline-danger" href="/admin/logout">logout</a>
                </div>
            </div>
        </div>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5 pt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb rounded-pill bg-96A7E8 px-3">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>

                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="admin/">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="#">statistic</a></li>
                    <li class="breadcrumb-item active" aria-current="page">user</li>
                </ol> -->
            </nav>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12">
            <div class="d-dashboard text-center">
                <h4>Admin Dashboard</h4>
                <h5>color tone</h5>
                    <!-- 
                    #87A2FF
                    #C4D7FF
                    #FFD7C4
                    #FFF4B5 
                    border-line
                    #B3BFFF
                    -->
                <botton class="btn btn-sm btn-disable bd-87A bg-87A2FF">#87A2FF</botton>
                <botton class="btn btn-sm btn-disable bd-87A bg-C4D7FF">#C4D7FF</botton>
                <botton class="btn btn-sm btn-disable bd-87A bg-FFD7C4">#FFD7C4</botton>
                <botton class="btn btn-sm btn-disable bd-87A bg-FFF4B5">#FFF4B5</botton>

                <div class="col-12 text-center m-3">
                    <label for="selectColor" class="form-label">Select Color</label>
                    <input type="color" class="form-control-color" id="selectColor" value="#87A2FF" title="Choose your color">
                </div>

                <div class="d-workspace">
                    workspace
                </div>
            </div>
            
        </div>
    </div>
</div>

<div id="footer" class="footer">
    <?php include 'footer.php' ?>
</div>

<!-- <script type="module" src="cookieconsent-config.js"></script> -->
<script type="module" src="./../asset/iscookie/cookieconsent-config.js"></script>
<!-- <script type="module" src="/asset/"></script> -->

</body>
</html>
