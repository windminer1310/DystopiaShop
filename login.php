<?php
	// load up global things
	include_once './autoloader.php';
    require_once('./display.php');
    // coming from facebook
	if ( isset( $_GET['state'] ) && FB_APP_STATE == $_GET['state'] ) { 
		// try and log the user in with $_GET vars from facebook 
		$fbLogin = tryAndLoginWithFacebook( $_GET );
	}  
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Dystopia Store</title>
    <link rel="icon" href="./img/favicons/favicon-32x32.png">     
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="./css/grid.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <div id="page-container">
        <header id="header">
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
        <div id="content-wrap">
            <div class="auth-form">
                <div class="form-log">
                    <div class="flex--between">
                        <span class="heading__text">Đăng nhập</span>
                        <a href="register.php" class="auth-form__switch-btn">Đăng ký</a>
                    </div>
                    <div id="auth-form__notify-text" class="auth__form--fail"></div>
                    <div id="login-form">  
                        <input id="phone" name="phone" type="text" class="form__input form_data" placeholder="Số điện thoại">
                        <div class="form__item">
                            <input id="password" name="password" type="password" class="form__input form_data" placeholder="Mật khẩu của bạn">
                        </div>
                        <div class="auth-form__aside">
                            <div class="auth-form__help">
                                <a href="" class="auth-form__help-link auth-form__help-foget">Quên mật khẩu</a>
                                <span class="auth-form__separate"></span>
                                <a href="" class="auth-form__help-link ">Cần trợ giúp?</a>
                            </div>
                        </div>

                        <div class="auth-form__controls">
                            <button class="btn btn--back" onclick="location.href='index.php'">TRỞ LẠI</button>
                            <button class="btn btn--log"  onclick="login()">ĐĂNG NHẬP</button>
                        </div>
                    </div>
                    <div class="auth-form__connect">
                        <a href="<?php echo getFacebookLoginUrl(); ?>" class="auth-form__socials auth-form__socials--facebook btn--size-s btn--with-icon">
                            <i class="auth-form__socials-icon fab fa-facebook-square"></i>
                            <span class="auth-form__socials-text">Tiếp tục với Facebook</span>
                        </a>
                        <a href="" class="auth-form__socials auth-form__socials--google btn--size-s btn--with-icon">
                            <i class="auth-form__socials-icon fab fa-google"></i>
                            <span class="auth-form__socials-text">Tiếp tục với Google</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Start -->
        <footer id="footer">
            <div class="grid wide">
                <div class="row">
                    <div class="col l-10-2">
                        <h3 class="footer__heading">Chăm sóc khách hàng</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Trung tâm trợ giúp</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Hướng dẫn mua hàng</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Chính sách thanh toán</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Chính sách giao hàng</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Chính sách hoàn trả</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Liên lạc</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="https://www.google.com/maps?ll=10.804914,106.717083&z=16&t=m&hl=vi&gl=US&mapclient=embed&q=2+V%C3%B5+Oanh+Ph%C6%B0%E1%BB%9Dng+25+B%C3%ACnh+Th%E1%BA%A1nh+Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh" class="footer-item__link">
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
                                <a href="#" class="footer-item__link">Giới thiệu</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Tuyển dụng</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Chính sách bảo mật</a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">Điều khoản</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col l-10-2">
                        <h3 class="footer__heading">Theo dõi</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-twitter-square"></i> Twitter
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-facebook-square"></i> Facebook
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-linkedin"></i> LinkedIn
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">
                                    <i class="footer-item__icon fab fa-instagram"></i> Instagram
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" class="footer-item__link">
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
                                <a href="#" class="footer__download-app-link">
                                    <img src="./img/download/google_play.png" alt="Google play" class="footer__download-app-img">
                                </a>
                                <a href="#" class="footer__download-app-link">
                                    <img src="./img/download/app_store.png" alt="App store" class="footer__download-app-img">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="grid wide">
                    <p class="footer__text">© 2021 Bản quyền thuộc về Team Error 404 </p>
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
    </div>
</body>
<!-- Template Javascript -->
    <script src="js/login.js"></script>
</html>