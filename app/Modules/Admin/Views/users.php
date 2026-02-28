<style>
    /* style costom only page */
    /* .table-outer-rounded {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 20px #00000014;
    } */

    /* .table-outer-rounded .table > :not(caption) > * > * {
        background-clip: padding-box;
    }

    .table-outer-rounded.table-bordered > :not(caption) > * > * {
        border-color: #0000001f;
    } */
</style>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5 pt-3">
            <nav aria-label="breadcrumb">
                <!-- <ol class="breadcrumb rounded-pill bg-96A7E8 px-3">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol> -->

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="#Management">management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">user</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12 text-center p-2">
            <h2>Admin :: Users</h2>
        </div>

        <div class="col-12 vh-100">
            <div class="table-responsive table-outer-rounded my-5">
                <!-- <table class="table table-success table-striped"> -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <!-- <th scope="col">member_id</th> -->
                            <th scope="col">id</th>
                            <th scope="col">fullname</th>
                            <th scope="col">email</th>
                            <th scope="col">profile</th>
                            <th scope="col">phone</th>
                            <th scope="col">sex</th>
                            <th scope="col">status</th>
                            <th scope="col">birthdate</th>
                            <th scope="col">createdAt</th>
                            <th scope="col">updatedAt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $formatter = new IntlDateFormatter(
                                'th_TH@calendar=buddhist', // Thai locale with Buddhist calendar
                                IntlDateFormatter::FULL,   // Full date style
                                IntlDateFormatter::SHORT,  // Short time style
                                'Asia/Bangkok',
                                IntlDateFormatter::GREGORIAN
                            );
                        ?>
                        <?php foreach($users as $key => $val) : ?>
                            <tr>
                                <?php $mael = '<i class="bi bi-person-standing fs-5 text-primary"></i>'?>
                                <?php $femael = '<i class="bi bi-person-standing-dress fs-5 text-primary"></i>'?>

                                <th scope="row"><?= $key+1 ?></th>
                                <td><?= $val['member_id'] ?></td>
                                <td><?= $val['first_name'].' '.$val['last_name'] ?></td>
                                <td><?= $val['email'] ?></td>
                                <td class="img_profile"><?= $val['img_profile'] ?></td>
                                <td><?= $val['phone']??'<i class="bi bi-telephone-x-fill text-danger"></i>' ?></td>
                                <td><?= $val['sex'] == 1 ? $mael:$femael; ?></td>
                                <td><?= $val['status'] ?></td>
                                <td><?= date("d/m/Y H:i",strtotime($val['birthdate'])) ?></td>
                                <td><?= date("d/m/Y H:i",strtotime($val['createdat'])) ?></td>
                                <td><?= date("d/m/Y H:i",strtotime($val['updatedat'])) ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                        <!-- more rows... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- <script type="module" src="./../asset/iscookie/cookieconsent-config.js"></script> -->

<script>
    $(document).ready(function() {
        // setInterval(fetchGoldPrice, 30000);  // อัพเดททุก 30 วินาที

        function getImage(tdImg, user_profile) {
            const ACCESS_TOKEN = "<?= session()->get('access_token') ?>";
            // console.log(ACCESS_TOKEN);

            if(!user_profile || user_profile == '') user_profile = 'user_not_image.png';
            // console.log(`user_profile : ${user_profile}`);

            $.ajax({
                url: `./userimg?img=${user_profile}`,
                type: "GET",
                contentType: "application/json",
                success: function(res) {
                    // console.log(`res: ${res}`);
                    let urlImg = JSON.parse(res);
                    // console.log(`urlImg: ${urlImg}`);
                    // console.log(`user_profile : ${user_profile}`);

                    $(tdImg).html(`<img src="${urlImg}" alt="Avatar Logo" style="width:25px;" class="rounded-pill">`);
                    // console.log(`user_profile : ${user_profile}`);
                },
                error: function(xhr) {
                    // console.log(xhr.responseText);
                }
            });
        }
        
        function init() {
            let imgArr = [];
            $('table').find("tbody > tr").each(function(rowIndex, row) {
                const td_img_profile = $(row).find("td.img_profile");
                let loading = `<div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                               </div>`;
                imgArr[rowIndex] = td_img_profile.text();
                td_img_profile.html(loading);
                getImage(td_img_profile, imgArr[rowIndex]);
                // console.log(`img [${rowIndex}]: ${imgArr[rowIndex]}`);
            });
        }

        init();
    });
</script>