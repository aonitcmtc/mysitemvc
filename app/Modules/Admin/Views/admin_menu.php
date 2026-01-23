<!-- tab menu -->
<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'mysite';
    $menu = isset($_GET['menu']) ? $_GET['menu'] : '';
?>



<ul class="v-ul">
    <li class="v-li"><a class="crop-text-nav-hor text-center text-danger" href="#">Admin menu</a></li>
    <li class="v-li"><a class="crop-text-nav-hor" href="#">Page :: <?= $page; ?></a></li>


    <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'mysite' ? 'active':''; ?>" href="/mysite">Mysite</a></li>
    <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'admin' ? 'active':''; ?>" href="/admin">Admin</a></li>

    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'home.php' ? 'active':''; ?>" href="?page=home.php">Home</a></li> -->
    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'uploadFiles.php' ? 'active':''; ?>" href="?page=uploadFiles.php">uploadFiles</a></li> -->
    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'uploadBigFiles.php' ? 'active':''; ?>" href="?page=uploadBigFiles.php">upload BigFiles</a></li> -->
    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'add_md5.php' ? 'active':''; ?>" href="?page=add_md5.php">md5</a></li> -->
    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'calcpi.php' ? 'active':''; ?>" href="?page=calcpi.php">Calcpi</a></li> -->

    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'texteditor.php' ? 'active':''; ?>" href="?page=texteditor.php">TextBox Editor</a></li> -->
    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'address.php' ? 'active':''; ?>" href="?page=address.php">Address</a></li> -->

    <!-- <li class="v-li">
        <a id="li_bootstrapExample" class="crop-text-nav-hor <?= $menu == 'bootstrapExample' ? 'active bg-secondary':''?>" data-bs-toggle="collapse" data-bs-target="#bootstrapExample" aria-expanded="false" aria-controls="bootstrapExample">
        <i id="icon_bootstrapExample" 
            class="fa <?= $menu == 'bootstrapExample' ? 'fa-chevron-down':'fa-chevron-right'?>" aria-hidden="true">
        </i>
        bootstrapExample 5.3.3
        </a>
    </li> -->
    <!-- <div class="<?= $menu == 'bootstrapExample' ? '' : 'collapse'?>" id="bootstrapExample">
        <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'table.php' ? 'active':''; ?>" href="?menu=bootstrapExample&page=table.php">table</a></li>
        <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'carousel.php' ? 'active':''; ?>" href="?menu=bootstrapExample&page=carousel.php">carousel</a></li>
        <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'calendar.php' ? 'active':''; ?>" href="?page=calendar.php">calendar</a></li>
        <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'video.php' ? 'active':''; ?>" href="?page=video.php">video</a></li>
    </div> -->

    <!-- <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'plan.php' ? 'active':''; ?>" href="?page=plan.php">Plan</a></li>
    <li class="v-li"><a class="crop-text-nav-hor <?= $page == 'abount.php' ? 'active':''; ?>" href="?page=abount.php">About</a></li> -->
</ul>  