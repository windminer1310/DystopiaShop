<?php 
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('shop_info/shop-info.php');
    require_once('database/connectDB.php');

    if(hasUserInfoSession($_SESSION['name'], $_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
    }
    else{
        headToIndexPage();
    }



    $tableCart = 'cart';
    $column = 'user_id';
    $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

    $productInCart = $getCartRow->rowCount();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link rel="stylesheet" href="./css/grid.css">

        <!-- <link href="css/style.css" rel="stylesheet"> -->
        <link href="css/home.css" rel="stylesheet">
        <link href="css/base.css" rel="stylesheet">
    </head>

    <body>
        <!-- Header Start -->
        <header class="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./user-login.php" class="header__logo-link">
                            <img src="img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <form class="header__search" method="get" action="product-list.php?">
                        <input type="text" class="header__search-input" placeholder="Tìm kiếm sản phẩm" name="search">
                        <button class="header__search-btn">
                            <i class="header__search-btn-icon bi bi-search" type="submit"></i>
                        </button>
                    </form>
                    <div class="header__item">
                        <a href="#sale" class="header__icon-link">
                            <i class="header__icon bi bi-tags"></i>
                        </a>
                        <a href="#sale" class="header__link">
                            Khuyến mãi
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="" class="header__icon-link">
                            <i class="header__icon bi bi-pc-display"></i>
                        </a>
                        <a href="" class="header__link">
                            Cấu hình PC
                        </a>
                    </div>

                    <!-- Đã đăng nhập -->
                    <div class="header__item">
                        <a class="header__icon-link" href="">
                            <i class="header__icon bi bi-clipboard-check"></i>
                        </a>
                        <a href="" class="header__link header__user-orders">Đơn hàng</a>
                    </div>
                    
                    <div class="header__item header__user">
                    <?php 
                        if(!isset($_SESSION['img_url'])){
                            echo "<a class='header__icon-link' href=''>
                                <i class='header__icon bi bi-person'></i>
                            </a>
                            <a href='' class='header__link header__user-login'>". $name ."</a>";
                        }
                        else {
                            echo "<a class='header__icon-link' href=''>
                                <img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">
                            </a>
                            <a href='' class='header__link header__user-login'>". $name ."</a>";
                        }
                    ?>

                        <ul class="header__user-menu">
                            <li class="header__user-item">
                                <a href="./my-account.php">Tài khoản của tôi</a>
                            </li>
                            <li class="header__user-item">
                                <a href="./logout.php" >Đăng xuất</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </header>
        <!-- Header End -->
        
        <!-- Breadcrumb Start -->
        <div class="homepage">
            <div class="grid wide">
                <ul class="path-homepage">
                    <li class="path-link "><a href="user-login.php">Trang chủ</a></li>
                    <li class="path-link ">></li>
                    <li class="path-link ">Tài khoản cá nhân</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <div class='product featured-product padding__map'>
            <div class='grid wide'>
                <div class=' row'>
                    <div class='col l-3'>
                        <div class='feild-user__nav'>
                            <div class='header-user-nav__item'>
                                <?php 
                                    if(!isset($_SESSION['img_url'])){
                                        echo "<i class='header__icon far fa-user-circle'></i>
                                        <span class='text-user__account'>".$name."</a></span>";
                                    }
                                    else {
                                        echo "<img class = 'header__avatar-img' src=".$_SESSION['img_url'].">
                                        <span class='text-user__account'>".$name."</a></span>";
                                    }
                                ?>
                            </div>
                            <div class='user-nav__item user-nav__item-active'>
                                <i class="header__icon bi bi-clipboard-check"></i>
                                <span class='text-user__account'>Lịch sử đơn hàng</span>
                            </div>
                            <div class='user-nav__item'>
                                <i class="header__icon bi bi-person"></i>
                                <span class='text-user__account'>Thông tin tài khoản</span>
                            </div>
                        </div>
                    </div>
                    <div class='col l-9 field-user__account field-user__account--active'>
                        <div class='header-user__account'>
                            <div class = 'header__text-field' >Lịch sử mua hàng</div>
                        </div>
                        <div class='list-info-order'>
                            <div class='header-info-order'>
                                <div class='header-text-order__item id-order__item'  >Mã đơn hàng</div>
                                <div class='header-text-order__item product-order__item'  >Sản phẩm</div>
                                <div class='header-text-order__item date-order__item'  >Ngày đặt</div>
                                <div class='header-text-order__item address-order__item'  >Địa chỉ</div>
                                <div class='header-text-order__item price-order__item'  >Tổng tiền</div>
                                <div class='header-text-order__item status-order__item'  >Trạng thái</div>
                            </div>
                            <?php   
                                $tableTransaction = 'transaction';
                                $column = 'user_id';
                                $getTransactiontRow = getAllRowWithValue($tableTransaction, $column, $user_id);
                            
                                foreach ($row = $getTransactiontRow->fetchAll() as $value => $row){
                                    echo "<div class='info-order__item'>
                                        <a class='text-order__item id-order__item' href='submit-checkout.php?id_transaction=" . $row['transaction_id'] . "'>
                                        ". $row["transaction_id"] ."
                                        </a>
                                        <span class='text-order__item product-order__item' >May tinh Asusdsadasd sadasdas asdasd</span>";
                                        $dateTime = explode( ' ', $row["date"]);
                                        echo "<span class='text-order__item date-order__item' >". dayOfDate($dateTime[0]).", ".$dateTime[1]."  ". dateFormat($dateTime[0])."</span>
                                        <span class='text-order__item address-order__item' >". displayAddress($row['address'])."</span>
                                        <span class='text-order__item price-order__item' >". number_format($row["payment"], 0, ',', '.') ." đ</span>
                                        <a class='text-order__item status-order__item' >Xem</a>
                                    </div>";
                                }
                            ?>
                            

                        </div> 
                    </div>
                    <div class='col l-9 field-user__account'>
                        <div class='field-user__account--info'>
                            <div class='l-7 '>
                                <div class='header-user__account'>
                                    <div class = 'header__text-field' >Thông tin tài khoản</div>
                                </div>
                                <div class='info-account'>
                                    <?php
                                        $tableUser = 'user';
                                        $column = 'user_id';
                                        $userRow = getRowWithValue( $tableUser, $column, $user_id);
                                    echo "<div class = 'one-field-checkout'>
                                        <p class = 'title-checkout-text'>Họ và tên</p>
                                        <input id = 'user-name' name = 'user-name' class = 'auth-form__input' type='text' disabled placeholder='".$userRow['user_name']."'>
                                    </div>
                                    <div class = 'one-field-checkout'>
                                        <p class = 'title-checkout-text'>Email</p>
                                        <input id = 'user-email' name = 'user-email' class = 'auth-form__input' type='text' disabled placeholder='".$userRow['user_email']."'>
                                    </div>
                                    <div class = 'one-field-checkout'>
                                        <p class = 'title-checkout-text'>Số điện thoại</p>
                                        <input id = 'user-phone' name = 'user-phone' class = 'auth-form__input' type='text' disabled placeholder='".$userRow['user_phone']."'>
                                    </div>";
                                    ?>
                                </div>
                            </div>
                            <?php 
                                if(!isset($_SESSION['img_url'])){
                                    echo "
                                    <div class='l-5' style='margin-left: 12px;'>
                                        <div class='header-user__account' style='justify-content: space-between;'>
                                            <div class = 'header__text-field' >Đổi mật khẩu</div>
                                            <div id='password-change__notify-text'></div>
                                        </div>
                                        <div class='info-account'>
                                            <form id='change-password-form'>
                                                <div class = 'one-field-checkout'>
                                                    <p class = 'title-checkout-text'>Mật khẩu cũ <span class = 'must-input-icon'>(*)</span></p>
                                                    <input id = 'current-password' name = 'current-password' class = 'auth-form__input' type='password' required onkeyup='checkedPassword();'>
                                                </div>
                                                <div class = 'one-field-checkout'>
                                                    <p class = 'title-checkout-text'>Mật khẩu mới <span class = 'must-input-icon'>(*)</span></p>
                                                    <input id = 'new-password' name = 'new-password' class = 'auth-form__input' type='password' required minlength='8' placeholder='Phải có độ dài lớn hơn 7 kí tự' onkeyup='checkedPassword();'>
                                                </div>
                                                <div class = 'one-field-checkout '>
                                                    <div class='with-spacebetween-icon'>
                                                        <p class = 'title-checkout-text'>Nhập lại mật khẩu mới <span class = 'must-input-icon'>(*)</span></p>
                                                        <div class='status-icon'>
                                                            
                                                        </div>
                                                    </div>
                                                    <input id = 'new-password-checked' name = 'new-password-checked' class = 'auth-form__input' type='password' required autocomplete='on' placeholder='Phải có độ dài lớn hơn 7 kí tự' onkeyup='checkedPassword();' minlength='8'>
                                                </div>
                                                <div class='update-input__field'>
                                                    <div id='change-password' class='btn btn--disabled' disabled type='submit' onclick='changePasswordStatus();'>Đổi mật khẩu</div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>";
                                }
                            ?>
                            
                        </div>
                    </div>
                   
                    
                    
                </div>
            </div>
        </div>
        
        <!-- Footer Start -->
        <footer class="footer">
            <div class="grid wide">
                <div class="row">
                    <div class="col l-10-2">
                        <h3 class="footer__heading">Chăm sóc khách hàng</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Trung tâm trợ giúp</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Hướng dẫn mua hàng</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Chính sách thanh toán</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Chính sách giao hàng</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Chính sách hoàn trả</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Liên lạc</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fas fa-map-marked-alt"></i><?php echo SHOP_ADDRESS ?>
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="mailto:<?php echo SHOP_EMAIL ?>" class="footer-item__link">
                                    <i class="footer-item__icon fas fa-envelope"></i><?php echo SHOP_EMAIL ?>
                            </a>
                            </li>
                            <li class="footer-item">
                                <a href="tel:<?php echo SHOP_PHONE ?>" class="footer-item__link">
                                    <i class="footer-item__icon fa fa-phone"></i><?php echo SHOP_PHONE ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Về Dystopia</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Giới thiệu</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Tuyển dụng</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Chính sách bảo mật</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">Điều khoản</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Theo dõi</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-twitter-square"></i> Twitter
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-facebook-square"></i> Facebook
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-linkedin"></i> LinkedIn
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-instagram"></i> Instagram
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-youtube-square"></i> Youtube
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Vào cửa hàng trên ứng dụng</h3>
                        <div class="footer__download">
                            <img src="./img/download/qr_code.png" alt="QR Code" class="footer__download-qr">
                            <div class="footer__download-apps">
                                <a href="" class="footer__download-app-link">
                                    <img src="./img/download/google_play.png" alt="Google play" class="footer__download-app-img">
                                </a>
                                <a href="" class="footer__download-app-link">
                                    <img src="./img/download/app_store.png" alt="App store" class="footer__download-app-img">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="grid wide">
                    <p class="footer__text">© 2021 Bản quyền thuộc về Team ... </p>
                </div>
            </div>
            <!-- Footer End -->
    
        
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        <script src="js/changePassword.js"></script>
        <script>

            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            const fields = $$('.field-user__account');
            const items = $$('.user-nav__item');

            items.forEach((item, index) => {
                const field = fields[index];

                item.onclick = function () {

                    $('.user-nav__item.user-nav__item-active').classList.remove('user-nav__item-active');
                    $('.field-user__account.field-user__account--active').classList.remove('field-user__account--active');

                    field.classList.add('field-user__account--active');
                    this.classList.add('user-nav__item-active');
                }
            });

            function checkedPassword(){
                var currentPassword = document.getElementById('current-password');
                var newPassword = document.getElementById('new-password');
                var newCheckedPassword = document.getElementById('new-password-checked');
                var minLengthPw = 8;


                if(passwordForm(currentPassword, minLengthPw) && 
                    passwordForm(newPassword, minLengthPw) && 
                    passwordForm(newCheckedPassword, minLengthPw)) {

                    if(newPassword.value === newCheckedPassword.value) {
                        document.getElementsByClassName('status-icon')[0].innerHTML = '<i class="fas fa-check-circle succes-auth__form"></i>';

                        document.getElementById("change-password").removeAttribute("disabled");
                        document.getElementById("change-password").classList.remove('btn--disabled');
                    }
                    else{
                        document.getElementsByClassName('status-icon')[0].innerHTML = '';
                        document.getElementById("change-password").classList.add('btn--disabled');
                    }
                }
                else {

                    document.getElementById("change-password").classList.add('btn--disabled');
                }
            }

            function passwordForm(password, minLength){
                if (password.value.length >= minLength) return true;
                return false;
            }
                
        </script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
</html>