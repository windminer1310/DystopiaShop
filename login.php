<?php
	// load up global things
	include_once 'autoloader.php';

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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/base.css" rel="stylesheet">
</head>

<body>

    <div class="header-auth-form">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="logo">
                        <a href="index.php">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-auth-form">
        <div class="auth-form">
            <div class="auth-form__container">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng nhập</h3>
                    <a href="register.html" class="auth-form__switch-btn">Đăng ký</a>
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



    <!-- Feature Start-->
    <div class="feature">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fab fa-cc-mastercard"></i>
                        <h2>Thanh toán an toàn</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-truck"></i>
                        <h2>Vận chuyển toàn cầu</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-sync-alt"></i>
                        <h2>Trả hàng trong vòng 30 ngày</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-comments"></i>
                        <h2>Hổ trợ 24/7</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End-->

    <!-- Call to Action Start -->
    <div class="call-to-action">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Liên hệ với BStore</h1>
                </div>
                <div class="col-md-6">
                    <a href="tel:0123456789">012-345-6789</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->


    <!-- Footer Start -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Liên lạc</h2>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i>Số 2 đường Võ Oanh phường 25 quận Bình Thạnh</p>
                            <p><i class="fa fa-envelope"></i>email@example.com</p>
                            <p><i class="fa fa-phone"></i>+123-456-7890</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Theo dõi chúng tôi</h2>
                        <div class="contact-info">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Thông tin về công ty</h2>
                        <ul>
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Điều khoản và điều kiện</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Thông tin mua hàng</h2>
                        <ul>
                            <li><a href="#">Chính sách thanh toán</a></li>
                            <li><a href="#">Chính sách giao hàng</a></li>
                            <li><a href="#">Chính sách hoàn trả</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row payment align-items-center">
                <div class="col-md-6">
                    <div class="payment-method">
                        <h2>Chấp nhận thanh toán</h2>
                        <img src="img/payment-method.png" alt="Payment Method" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="payment-security">
                        <h2>Được đảm bảo bởi</h2>
                        <img src="img/godaddy.svg" alt="Payment Security" />
                        <img src="img/norton.svg" alt="Payment Security" />
                        <img src="img/ssl.svg" alt="Payment Security" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Template Javascript -->
    <script src="js/loginForm.js"></script>

</body>

</html>