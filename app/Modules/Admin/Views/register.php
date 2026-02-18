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

    <!-- CSS ICONS -->
    <link href="./../asset/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
    <!-- <link href="./../asset/fontawesome4/css/font-awesome.min.css" rel="stylesheet"> -->



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

    .d-register {
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
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="d-register">

                <a href="/admin/login" id="Login" class="text-decoration-none text-secondary">
                    <!-- <i class="fa fa-sign-in" aria-hidden="true"></i> -->
                    <i class="bi bi-box-arrow-left"></i>
                    Login
                </a>

                <div class="my-3 text-center">
                    <h2>notofication</h2>
                </div>

                <div class="row">
                    <div class="col-12 text-center my-2">
                    <!-- https://gratisography.com/wp-content/uploads/2024/01/gratisography-cyber-kitty-800x525.jpg -->
                    <img src="../img-default/loginlogo.jpg" 
                        class="rounded-circle" alt="image Profile" width="140" height="140">
                    </div>
                </div>
                <!-- <p>In this example, we use <code>.was-validated</code> to indicate what's missing before submitting the form:</p> -->
                <div class="text-center my-3">
                    <h5>Notification</h5>
                </div>
            </div>
            
        </div>

        <div class="col-12 col-md-6 col-lg-8">
            <div class="d-register">
                <div class="my-3 text-center">
                    <h2>Register</h2>
                </div>

                <form action="./checklogin" method="POST" id="form_register" class="was-validated-unactive">
                <div class="row">
                    <div class="col-6 p-3">
                        <div class="my-3">
                            <div class="form-group">
                                <label for="firstname">Firstname:</label>
                                <input type="text" class="form-control form-control-sm" id="firstname" placeholder="Enter firstname" name="firstname" required>
                                <!-- <div class="valid-feedback">กรุณากรอก firstname</div> -->
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control form-control-sm" id="email" placeholder="Enter email" name="email" required>
                                <!-- <div class="valid-feedback">กรุณากรอก email</div> -->
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate:</label>
                                <input type="text" class="form-control form-control-sm" id="birthdate" placeholder="Enter birthdate" name="birthdate" required>
                                <!-- <div class="valid-feedback">กรุณากรอก birthdate</div> -->
                            </div>
                            <div class="form-group">
                                <label for="nationality">nationality:</label>
                                <input type="text" class="form-control form-control-sm" id="nationality" placeholder="Enter nationality" name="nationality" required>
                                <!-- <div class="valid-feedback">กรุณากรอก nationality</div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="my-3">
                            <div class="form-group">
                                <label for="lasname">Lasname:</label>
                                <input type="text" class="form-control form-control-sm" id="lasname" placeholder="Enter lasname" name="lasname" required>
                                <!-- <div class="valid-feedback">กรุณากรอก lasname</div> -->
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="phone" class="form-control form-control-sm" id="phone" placeholder="Enter phone" name="phone" required>
                                <!-- <div class="valid-feedback">กรุณากรอก phone</div> -->
                            </div>
                            <div class="form-group">
                                <label for="sex">Sex:</label>
                                <select class="form-control form-control-sm form-select" required aria-label="sex">
                                    <option value="">select sex</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                                <!-- <div class="valid-feedback">Example invalid select feedback</div> -->
                            </div>
                        
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control form-control-sm" id="password" placeholder="Enter password" name="password" required>
                                <!-- <div class="valid-feedback">กรุณากรอก Password</div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-check px-3 mx-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" require>
                            <!-- <label class="form-check-label text-dark" for="flexCheckDefault">
                                ข้าพเจ้ายินยอมให้ เว็บไซต์เก็บรวบรวม ใช้ และเปิดเผยข้อมูลส่วนบุคคลของข้าพเจ้า เช่น ชื่อ เบอร์โทรศัพท์ อีเมล และข้อมูลการใช้งาน เพื่อวัตถุประสงค์ในการให้บริการ ปรับปรุงคุณภาพ ทำการตลาด และปฏิบัติตามกฎหมาย โดยข้าพเจ้าทราบสิทธิในการเข้าถึง แก้ไข ลบ หรือเพิกถอนความยินยอมได้ทุกเมื่อ
                            </label> -->
                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                I consent to website collecting, using, and disclosing my personal data-such as name, phone number, email, and usage information-for the purposes of providing services, improving quality, marketing, and legal compliance, with the understanding that I have the right to access, correct, delete, or withdraw my consent at any time.
                            </label>
                            <div class="valid-feedback text-danger">checkbox require</div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" id="recording" class="btn btn-outline-light">Recording</button>
                        </div>
                    </div>
                </div>
                </form>
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
            $("#recording").click(function(){
                $("#form_register").removeClass("was-validated-unactive").addClass("was-validated");
            });
        });
    </script>

</body>
</html>
