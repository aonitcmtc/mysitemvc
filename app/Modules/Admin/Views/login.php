<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Auth</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../img-default/catlogo_ico.png">


    <link href="<?=base_url();?>asset/bootstrap462.min.css" rel="stylesheet">
    <script src="<?=base_url();?>asset/jquery.slim.min.js"></script>
    <script src="<?=base_url();?>asset/popper.min.js"></script>
    <script src="<?=base_url();?>asset/bootstrap.bundle.min.js"></script>

    <!-- CSS ICONS -->
    <link href="<?=base_url();?>asset/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?=base_url();?>asset/fontawesome4/css/font-awesome.min.css" rel="stylesheet">

    <!-- cookieconsent -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css"> -->
</head>
<body>

<style>
    body {
        margin: 0;

        padding: 0; 
        /* margin-top: 500px; */

        background-image: url("../img-default/logincover2.jpg");
        background-repeat: no-repeat;
        background-color: #000; /* Used if the image is unavailable */
        height: 100vh; /* You must set a specified height */
        background-position: center; /* Center the image */
        background-size: cover; /* Resize the background image to cover the entire container */
    }

    .d-login {
        padding: 2rem; 
        backdrop-filter: blur(10px) brightness(110%);
        margin-top: 3rem;
        margin-bottom: 3rem;

        border: 2px solid #ffe6e6;
        border-radius: 30px;
    }

    .footer {
        /* position: fixed;
        bottom: 0; */
        position: absolute;
        padding: 16px;
        width: 100%;
        min-height:48px;
        backdrop-filter: blur(25px) brightness(120%);
        color: #fff;
        /* background-color: #555; */
    }
</style>

<div class="container">
    <div class="row justify-content-end">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="d-login">
                <div class="my-3 text-center">
                    <h4 class="text-secondary">Login to Workspace</h4>

                    <i class="bi bi-person-fill-check text-light"></i>
                    <span class="text-light"><?= $user_active ?></span>&emsp;

                    <!-- <i class="bi bi-sunglasses text-light"></i> -->
                    <i class="bi bi-person-walking text-light"></i>
                    <span class="text-light"><?= $user_login ?></span>


                </div>

                <div class="row">
                    <div class="col-12 text-center my-2">
                    <!-- https://gratisography.com/wp-content/uploads/2024/01/gratisography-cyber-kitty-800x525.jpg -->
                    <img src="../img-default/loginlogo.jpg" 
                        class="rounded-circle" alt="image Profile" width="140" height="140">
                    </div>
                </div>
                <!-- <p>In this example, we use <code>.was-validated</code> to indicate what's missing before submitting the form:</p> -->
                <div class="my-3">
                    <form action="./checklogin" method="POST" id="form_login" class="was-validated-unactive">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
                            <!-- <div class="valid-feedback">กรุณากรอก Email</div> -->
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                            <!-- <div class="valid-feedback">กรุณากรอก Password</div> -->
                        </div>

                        <button type="botton" id="login" class="btn btn-outline-light btn-block">Login</button>
                        <a href="/admin/register" class="btn btn-outline-warning btn-block mt-2 text-decoration-none">
                            Register
                        </a>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div id="footer" class="footer">
    <?php include 'footer.php' ?>
</div>

<!-- <script type="module" src="cookieconsent-config.js"></script> -->
<!-- <script type="module" src="./../asset/iscookie/cookieconsent-config.js"></script> -->
<!-- <script type="module" src="/asset/"></script> -->
<script>
    $(document).ready(function(){
        $("#login").click(function(){
            $("#form_login").removeClass("was-validated-unactive").addClass("was-validated");

            var email = $('#email').val();
            var password = $('#password').val();
            if(email != "" && password != ""){
                $('#form_login').submit();
            }

        });
    });
</script>
</body>
</html>
