<style>
    .img-cover {
        width: 100%;
        overflow: hidden; /* ซ่อนส่วนเกิน */
    }

    .img-cover img {
        width: 100%;
        height: auto;
        display: block;
    }


    @media screen and (max-width: 900px) {
        .img-cover {
            width: 100%;   /* responsive scaling */
            height: 80vh;      /* keep aspect ratio */
            display: inline-block;
        }
        
    }
</style>

<div class="container-fluid landingpage">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <div id="carouselmySite" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselmySite" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselmySite" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselmySite" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselmySite" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselmySite" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item text-center active">
                        <img src="<?=base_url();?>img-default/newproducts.JPG" class="img-cover" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?=base_url();?>img-default/newproducts2.JPG" class="img-cover" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Second slide label</h5>
                            <p>Some representative placeholder content for the second slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?=base_url();?>img-default/newproducts3.JPG" class="img-cover" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?=base_url();?>img-default/newproducts4.JPG" class="img-cover" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?=base_url();?>img-default/newproducts5.JPG" class="img-cover" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselmySite" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselmySite" data-bs-slide="next">
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