<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Dystopia Store</title>
    <link rel="icon" href="./img/favicons/favicon-32x32.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="../css/grid.css" rel="stylesheet">
    <link href="../css/base.css" rel="stylesheet">
    <link href="../css/home.css" rel="stylesheet">
</head>
<body>
    <div id="page-container">
        <header id="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="index.php" class="header__logo-link">
                            <img src="../img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div id="content-wrap">
            <div class="auth-form">
                <div class="form-log">
                    <span class="heading__text">Đăng nhập</span>
                    <div id="auth-form__notify-text" class="auth__form--fail"></div>
                    <div id="login-form">
                        <input id="phone" name="phone" type="text" class="form__input form_data" placeholder="Số điện thoại">
                        <div class="form__item">
                            <input id="password" name="password" type="password" class="form__input form_data" placeholder="Mật khẩu của bạn">
                        </div>

                        <div class="auth-form__controls">
                            <button class="btn btn--log" onclick="login('admin')">ĐĂNG NHẬP</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Template Javascript -->
    <script src="../js/login.js"></script>

</body>

</html>