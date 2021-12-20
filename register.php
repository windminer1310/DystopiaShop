<?php
    require_once('shop_info/shop-info.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BShop</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="./css/grid.css">
    
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="./css/home.css">
</head>

<body>
    <header class="header">
        <div class="grid wide">
            <div class="header-with-search">
                <div class="header__logo">
                    <a href="index.php" class="header__logo-link">
                        <img src="img/logo.png" alt="Logo" class="header__logo-img">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="body-auth-form auth">
        <div class="auth-form">
            <div class="auth-form__container">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng ký</h3>
                    <a href="login.php" class="auth-form__switch-btn">Đăng nhập</a>
                </div>
                <div id="auth-form__notify-text"></div>
                <form id="register-form">
                    <div class="auth-form__form">
                        <div class="auth-form__group" style="display: flex;">
                            <div class = "instruction-box" id = "instruction-box__name">
                                <p>Nhập đầy đủ họ tên của bạn, không được chứa kí tự đặc biệt</p>
                            </div>
                            <input id="name" name="name" type="text" onfocus="clearWarningInput('name')" onfocusout="checkUserName()" class="auth-form__input form_data" placeholder="Họ và tên" required>
                        </div>
                        <div class="auth-form__group" style="display: flex;">
                            <div class = "instruction-box" id = "instruction-box__email">
                                <p>VD: viethoang@gmail.com</p>
                            </div>
                            <input id="email" name="email" type="text" onfocus="clearWarningInput('email')" onfocusout="checkUserEmail()" class="auth-form__input form_data" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,4}$" placeholder="Email của bạn" required>
                        </div>
                        <div class="auth-form__group" style="display: flex;">
                            <div class = "instruction-box" id = "instruction-box__phone">
                                <p>SĐT có độ dài từ 10 đến 12 kí tự</p>
                            </div>
                            <input id="phone" name="phone" type="text" onfocus="clearWarningInput('phone')" onfocusout="checkUserPhone()" class="auth-form__input form_data" placeholder="Số điện thoại" required>
                        </div>
                        <div class="auth-form__group">
                            <div class = "instruction-box" id = "instruction-box__password">
                                <p>Mật khẩu phải có độ dài hơn 7 kí tự</p>
                            </div>
                            <input id="password" name="password" type="password" onfocus="clearWarningInput('password')" onfocusout="checkUserPassword()" class="auth-form__input form_data" placeholder="Mật khẩu của bạn" required>
                        </div>
                    </div>
                    <div class="auth-form__aside">
                        <p class="auth-form__policy-text">
                            Bằng việc đăng kí, bạn đã đồng ý về
                            <a href="" class="auth-form__text-link">Điều khoản dịch vụ</a> &
                            <a href="" class="auth-form__text-link">Chính sách bảo mật</a>
                        </p>
                    </div>

                    <div class="auth-form__controls">
                        <input type="button" class="btns auth-form__controls-back btns--normal" onclick="location.href='index.php'" value="TRỞ LẠI">
                        <!-- <button class="btns btns--primary">ĐĂNG KÝ</button> -->
                        <input class="btns btns--primary" type="submit" name="submit" id="submit" onclick="success(); return false" value="ĐĂNG KÝ ">
                    </div>
                </form>
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
        <!-- <div class="row payment align-items-center">
            <div class="col-md-6">
                <div class="payment-method">
                    <h2>Chấp nhận thanh toán</h2>
                    <img src="img/payment-method.png" alt="Payment Method" />
                </div>
            </div>
        </div> -->
    </footer>
    <!-- Footer End -->

    <!-- Template Javascript -->
    <script src="js/registerForm.js "></script>

</body>

</html>