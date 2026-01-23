<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Auth</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../img-default/catlogo_ico.png">


    <link href="./../asset/bootstrap462.min.css" rel="stylesheet">
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

        background-image: url("../img-default/logincover2.jpg");
        background-repeat: no-repeat;
        background-color: #000; /* Used if the image is unavailable */
        height: 120vh; /* You must set a specified height */
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
        background-color: #555;
    }
</style>

<div class="container">
    <div class="row justify-content-end">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="d-login">
                <div class="my-3 text-center">
                    <h2>Login to Dashboard</h2>
                </div>

                <div class="row">
                    <div class="col-12 text-center my-3">
                    <!-- https://gratisography.com/wp-content/uploads/2024/01/gratisography-cyber-kitty-800x525.jpg -->
                    <img src="../img-default/loginlogo.jpg" 
                        class="rounded-circle" alt="image Profile" width="160" height="160">
                    </div>
                </div>
                <!-- <p>In this example, we use <code>.was-validated</code> to indicate what's missing before submitting the form:</p> -->
                <div class="my-3">
                    <form action="./checklogin" method="POST" class="was-validated">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                            <!-- <div class="valid-feedback">Valid.</div> -->
                            <div class="invalid-feedback">กรุณากรอก Username</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                            <!-- <div class="valid-feedback">Valid.</div> -->
                            <div class="invalid-feedback">กรุณากรอก Password</div>
                        </div>
                        <!-- <div class="form-group form-check">
                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember" required> I agree on blabla.
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Check this checkbox to continue.</div>
                            </label>
                        </div> -->
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <a href="register.php">
                            <button class="btn btn-outline-primary btn-block mt-2" type="button">Register</button>
                        </a>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div id="footer" class="footer bg-secondary">
    <?php include 'footer.php' ?>
</div>

<!-- <script type="module" src="cookieconsent-config.js"></script> -->
<script type="module" src="./../asset/iscookie/cookieconsent-config.js"></script>
<!-- <script type="module" src="/asset/"></script> -->

</body>
</html>
