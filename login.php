<?php
	// load up global things
	include_once 'autoloader.php';
    require_once('shop_info/shop-info.php');

	if ( isset( $_GET['state'] ) && FB_APP_STATE == $_GET['state'] ) { // coming from facebook
		// try and log the user in with $_GET vars from facebook 
		$fbLogin = tryAndLoginWithFacebook( $_GET );
	}
    
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
                    <h3 class="auth-form__heading">Đăng nhập</h3>
                    <a href="register.php" class="auth-form__switch-btn">Đăng ký</a>
                </div>
                <div id="auth-form__notify-text"></div>
				
                <form id="login-form">
                    <div class="auth-form__form">
                        <div class="auth-form__group">
                            <input id="phone" name="phone" type="text" class="auth-form__input form_data" placeholder="Số điện thoại">
                        </div>
                        <div class="auth-form__group">
                            <input id="password" name="password" type="password" onkeyup="success()" class="auth-form__input form_data" placeholder="Mật khẩu của bạn">
                        </div>
                    </div>
                    <div class="auth-form__aside">
                        <div class="auth-form__help">
                            <a href="" class="auth-form__help-link auth-form__help-foget">Quên mật khẩu</a>
                            <span class="auth-form__separate"></span>
                            <a href="" class="auth-form__help-link ">Cần trợ giúp?</a>
                        </div>
                    </div>

                    <div class="auth-form__controls">
                        <input type="button" class="btns auth-form__controls-back btns--normal" onclick="location.href='index.php'" value="TRỞ LẠI">
                        <input class="btns btns--disabled btns--primary " type="submit" name="submit" id="submit" onclick="login(); return false" value="ĐĂNG NHẬP" disabled>
                    </div>
                </form>
            </div>

            <div class="auth-form__socials">
                <a href="<?php echo getFacebookLoginUrl(); ?>" class="auth-form__socials--facebook btns--size-s btn--with-icon">
                    <i class="auth-form__socials-icon fab fa-facebook-square"></i>
                    <span class="auth-form__socials-text">Kết nối với Facebook</span>

                </a>
                <a href="" class="auth-form__socials--google btns--size-s btn--with-icon">
                    <i class="auth-form__socials-icon fab fa-google"></i>
                    <span class="auth-form__socials-text">Kết nối với Google</span>
                </a>

            </div>

        </div>
    </div>



     <!-- MAP & FEATURE -->
    <!-- Cần fix giao diện :( -->
    <div class="map-and-feature">
        <div class="grid wide">
            <div class="row">
                <div class="col l-9">
                    <!-- Google Map Start -->
                    <div class="contact-map-wrap">
                        <iframe title="google-map" class="contact-map" src="<?php echo ADDRESS_GOOGLE_URL ?>"></iframe>
                    </div>
                    <!-- Google Map End -->
                </div>
                <div class="col l-3">
                    <div class="features">
                        <div class="feature-content">
                            <i class="fab fa-cc-mastercard"></i>
                            Thanh toán an toàn
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-truck"></i>
                            Giao hàng toàn quốc
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-sync-alt"></i>
                            Đổi trả trong vòng 7 ngày
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-comments"></i>
                            Hổ trợ 24/7
                        </div>
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
    <script src="js/loginForm.js"></script>

</body>

</html>