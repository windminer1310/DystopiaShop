<<<<<<< Updated upstream
<?php 
    session_start();

    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('shop_info/shop-info.php');

    if(hasUserInfoSession($_SESSION['name'], $_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
    }
    else{
        headToIndexPage();
    }

    $totalProductPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>BShop</title>
        <meta charset="UTF-8">

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
        
       <!-- Nav Bar Start -->
    <div class="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="user-login.php" class="nav-item nav-link active">Trang chủ</a>
                        <a href="product-list.php" class="nav-item nav-link">Sản phẩm</a>
                        <a href="cart.php" class="nav-item nav-link">Giỏ hàng</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <div class="header__navbar-item header__navbar-user">
                            <img class = "avatar-img" src=<?php echo $_SESSION['img_url']; ?> alt="">
                            <span class="header__navbar-user-name"><?php echo $name; ?></span>
                    
                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-item">
                                    <a href="my-account.php">Tài khoản của tôi</a>
                                </li>
                                <li class="header__navbar-user-item header__navbar-user-item--separate">
                                    <a href="logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->     
        
        <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="logo">
                            <a href="user-login.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <form method="get" action="product-list.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search">
                            <button><i class="fa fa-search" type="submit"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="user-login.php">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="product-list.php">Sản phẩm</a></li>
                    <li class="breadcrumb-item"><a href="cart.php">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active">Xác nhận thanh toán</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <div class="container-fluid">
                <form method = "POST" action="database/checkoutDB.php">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart-page-inner">
                                <div class="table-responsive">
                                    <h5 class = "header-checkout_text">Thông tin người nhận hàng</h5>
                                    <div class = "one-field-checkout">
                                        <p class = "title-checkout-text">Họ tên <span class = "must-input-icon">(*)</span></p>
                                        <input id = "name" name = "name" class = "auth-form__input" type="text" placeholder="Nhập tên của bạn" required>
                                    </div>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Số điện thoại <span class = "must-input-icon">(*)</span></p>
                                            <input id = "phone" name = "phone" class = "auth-form__input" type="text" pattern="[0-9]+" placeholder="Nhập số điện thoại" required>
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Email <span class = "must-input-icon">(*)</span></p>
                                            <input id = "email" name = "email" class = "auth-form__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,4}$" placeholder="Nhập Email của bạn" required>
                                        </div>
                                    </div>
                                    <h5 style="margin-top: 30px;" class = "header-checkout_text">Địa chỉ nhận hàng</h5>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Tỉnh/Thành phố <span class = "must-input-icon">(*)</p>
                                            <select id = "city" name = "city" class="auth-form__input" required 
                                                onclick="startDistrict(); startWard();">
                                            </select>
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Quận/Huyện <span class = "must-input-icon">(*)</p>
                                            <select id = "district" name = "district" class="auth-form__input" onclick="startWard();">
                                            </select>
                                        </div>
                                    </div>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Phường/xã</p>
                                            <select id = "ward" name = "ward" class="auth-form__input" required></select>
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Địa chỉ cụ thể <span class = "must-input-icon">(*)</span></p>
                                            <input id = "address" name = "address" class = "auth-form__input" type="text" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-page-inner">
                                <div class="row">
                                    <div class="col-md-11 header-checkout">
                                        <div>
                                            <h5 class = "header-checkout_text">Thông tin đơn hàng</h5>
                                        </div>
                                        <div>
                                            <a href="cart.php">Chỉnh sửa</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="cart-summary view-info_checkout">
                                            <?php 
                                                $tableCart = 'cart';
                                                $column = 'user_id';
                                                $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

                                                foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                                    $id_product = $row['product_id'];
                                                    $tableName = 'product';
                                                    $column = 'product_id';

                                                    $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                                    echo "<div class='cart-content-info'>";
                                                        echo "<div><a href='product-detail.php?id=". $productInfo['product_id'] ."' ><img class = 'img-checkout' src='". $productInfo['image_link'] ."' alt='Image'></a></div>";
                                                        echo "<div class = 'right-checkout_info'>";
                                                            echo "<p class = 'title-checkout-text_info'>".$productInfo['product_name']."</p>";
                                                            echo "<p class = 'title-checkout-text_info-num'>Số lượng: ".$row['qty']."</p>";
                                                            $price = 0;
                                                            if ($productInfo['discount'] == 0){
                                                                $price = $productInfo['price']; 
                                                            }else{
                                                                $price = ($productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01));
                                                            }
                                                            $sumPrice = $price * $row['qty'];
                                                            $totalProductPrice += $sumPrice;
                                                            echo "<p class = 'header-checkout_text'>".number_format($sumPrice, 0, ',', '.')." đ</p>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="cart-page-inner">
                                <div class="table-responsive">
                                    <h5 class = "header-checkout_text">Ghi chú cho đơn hàng</h5>
                                    <div class = "one-field-checkout">
                                        <input id = "note" name = "note" class = "auth-form__input" type="text" placeholder="Nhập thông tin ghi chú cho nhà bán hàng">
                                    </div>
                                    <h5 style = "margin-top: 30px;" class = "header-checkout_text">PHƯƠNG THỨC THANH TOÁN <span class = "must-input-icon">(*)</span></h5>
                                    <div class = "payment-method">
                                        <label for="banking" class = "payment-method__box checked-hover" id="banking-method" onclick="activePaymentMethod('banking-method')">
                                            <input hidden type="radio" name = "payment_type" value="banking" id="banking">
                                            <div>
                                                <p style = "margin-top: 0px" class = "title-checkout-text">Thanh toán qua Internet Banking</p>
                                                <p class = "checkout-text payment-method__text">MoMo, Paypal</p>
                                            </div>  
                                            <div class = "checked-payment-method">
                                                <i class="fas fa-money-check-alt payment-icon"></i>
                                            </div>      
                                        </label>
                                        <label for="cash" class = "payment-method__box active-method" id="cash-method" onclick="activePaymentMethod('cash-method')">
                                            <input hidden type="radio" name = "payment_type" value="cash" id="cash" checked required>
                                            <div >
                                                <p style = "margin-top: 0px" class = "title-checkout-text">Thanh toán khi nhận hàng</p>
                                                <p class = "checkout-text payment-method__text">Thanh toán bằng tiền mặt khi nhận hàng tại nhà hoặc showroom</p>
                                            </div>     
                                            <div class = "checked-payment-method">
                                                <i class="fas fa-money-bill payment-icon"></i>
                                            </div>     
                                        </label>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-page-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cart-summary">
                                            <div class="cart-content">
                                                <p class = "checkout-text">Tổng giá<span class = "checkout-price"><?php echo number_format($totalProductPrice, 0, ',', '.')?> đ</span></p>

                                                <p class = "checkout-text">Phí vận chuyển<span class = "checkout-price">
                                                    <?php 
                                                        $shippingPrice = 35000;
                                                        echo number_format($shippingPrice, 0, ',', '.'); 
                                                    ?> đ</span>
                                                </p>

                                                <h2>Thành tiền<span class = "total-checkout-price" >
                                                    <?php 
                                                        $totalPrice = $totalProductPrice + $shippingPrice;
                                                        $_SESSION['totalPrice'] = $totalPrice;
                                                        echo number_format($totalPrice, 0, ',', '.'); 
                                                    ?> đ</span>
                                                </h2>
                                            </div>
                                            <div class="cart-btn">
                                                <button type="submit">XÁC NHẬN THANH TOÁN</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cart End -->
        
        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Liên lạc</h2>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i><?php echo SHOP_ADDRESS ?></p>
                                <p><i class="fa fa-envelope"></i><?php echo SHOP_EMAIL ?></p>
                                <p><i class="fa fa-phone"></i><?php echo SHOP_PHONE ?></p>
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
        
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script src="js/paymentMethod.js"></script>
        <script src="js/getProvinceInVietNamInfo.js"></script>
        
    </body>
</html>
=======
<?php 
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('shop_info/shop-info.php');
    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
        $bankingMethod = 'banking-method';
        $cashMethod = 'cash-method';
        $tableCart = 'cart';
        $column = 'user_id';
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
    }else{
        header('Location: index.php');
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <!-- Template Stylesheet -->
        <link rel="stylesheet" href="./css/grid.css">
        <link rel="stylesheet" href="./css/base.css">
        <link rel="stylesheet" href="./css/home.css">    
    </head>
    <body>
        <div id="page-container">
            <!-- Header Start -->
            <header id="header">
                <div class="grid wide">
                    <div class="header-with-search">
                        <div class="header__logo">
                            <a href="./index.php" class="header__logo-link">
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
                            <a href="./index.php#sale" class="header__icon-link">
                                <i class="header__icon bi bi-tags"></i>
                            </a>
                            <a href="./index.php#sale" class="header__link">
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
                        <div class="header__item header__cart-wrap">
                            <a href="./cart.php" class="header__icon-link">
                                <i class="header__icon bi bi-cart3"></i>
                                <?php 
                                if($productInCart > 0){
                                    echo "<span class='header__cart-notice'>".$productInCart." </span>";
                                }
                                ?>
                            </a>
                            <a href="./cart.php" class="header__link">
                                Giỏ hàng
                            </a>
                            <?php
                                $tableCart = 'cart';
                                $column = 'user_id';
                                $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
                            
                                $count = $getCartRow->rowCount();
                                if(cartIsEmpty($count)){
                                    //No cart: header__cart--no-item
                                    echo '<div class="header__cart-list header__cart--no-item">
                                        <img src="./img/emptycart.svg" alt="" class="header__cart-no-cart-img">
                                        <span class="header__cart-list-no-cart-msg">
                                                    Chưa có sản phẩm
                                        </span>
                                    <?div>';
                                }
                                else{
                                    echo '<div class="header__cart-list">
                                        <h4 class="header__cart-heading">Sản phẩm đã thêm</h4>
                                        <ul class="header__cart-list-item" id="scrollbar">';
                                        $totalPrice = 0;
                                            foreach ($row = $getCartRow->fetchAll() as $value => $row) {
                                                $id_product = $row['product_id'];
                                                $tableName = 'product';
                                                $column = 'product_id';
                                                $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                                $productLink = 'product-detail.php?id='.$productInfo['product_id'];
                                                $img = $productInfo['image_link'];
                                                $productName = $productInfo['product_name'];
                                                $quantity = $row['qty'];
                                                $price = $productInfo['price'] * (100 - $productInfo['discount']) / 100;
                                                $totalPrice += $price*$quantity;

                                                echo '<li class="header__cart-item">
                                                    <a href="'.$productLink.'" class="header__cart-img-link"><img src="'.$img.'" alt="Ảnh sản phẩm" class="header__cart-img"></a>
                                                        <div class="header__cart-item-info">
                                                        <a href="'.$productLink.'" class="header__cart-item-name">'.$productName.'</a>
                                                            <span class="header__cart-item-qnt">Số lượng: '.$quantity.'</span>
                                                            <span class="header__cart-item-price">Đơn giá: '.number_format($price, 0, ',', '.').'đ</span>                  
                                                        </div>
                                                    </li>
                                                ';
                                            }
                                        echo '</ul>';
                                        echo '<div class="header__cart-footer">
                                                <h4 class="cart-footer__title">Tổng tiền sản phẩm</h4>
                                                <div class="cart-footer__total-price">'.number_format($totalPrice, 0, ',', '.').'đ</div>
                                            </div>
                                            <a href="./cart.php" class="header__cart-view-cart">Xem giỏ hàng</a>
                                            ';
                                    echo '</div>';
                                }  
                            ?>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Header End -->
            <div id="content-wrap">
                <!-- Breadcrumb Start -->
                <div class="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link "><a href="index.php">Trang chủ</a></li>
                            <li class="path-link ">></li>
                            <li class="path-link "><a href="cart.php">Giỏ hàng</a></li>
                            <li class="path-link ">></li>
                            <li class="path-link active">Thanh toán</li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                <!-- Product Detail Start -->
                <?php 
                    $tableCart = 'cart';
                    $column = 'user_id';
                    $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
                    $count = $getCartRow->rowCount();
                    if(!cartIsEmpty($count)){
                        echo "<div class='last-section'>
                            <div class='grid wide'>
                                <form method = 'POST' action='database/checkoutDB.php'>
                                    <div class='product-cart-top row'>
                                        <div class='col l-7'>
                                            <div class='checkout-form'>
                                                <div class='form__section'>
                                                    <span  class = 'form__title'>Thông tin người nhận</span>
                                                    <div class = 'row'>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Họ tên <span class = 'must-input-icon'>(*)</span></p>
                                                            <input id = 'name' name = 'name' class = 'form__input' type='text' placeholder='Nhập tên của bạn' required>
                                                        </div>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Số điện thoại <span class = 'must-input-icon'>(*)</span></p>
                                                            <input id = 'phone' name = 'phone' class = 'form__input' type='text' pattern='[0-9]+' placeholder='Nhập số điện thoại' required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form__section'>
                                                    <span  class = 'form__title'>Địa chỉ nhận hàng</span>
                                                    <div class = 'row'>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Tỉnh/Thành phố <span class = 'must-input-icon'>(*)</span></p>
                                                            <select id = 'city' name = 'city' class='form__input' required onchange='startDistrict()'>
                                                            </select>
                                                        </div>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Quận/Huyện <span class = 'must-input-icon'>(*)</span></p>
                                                            <select id = 'district' name = 'district' class='form__input' disabled onchange='startWard()'>
                                                                <option value='' disabled selected hidden>Chọn quận/huyện</option>
                                                            </select>
                                                        </div>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Phường/xã</p>
                                                            <select id = 'ward' name = 'ward' class='form__input' disabled>
                                                                <option value='' disabled selected hidden>Chọn phường/xã</option>
                                                            </select>
                                                        </div>
                                                        <div class = 'form__item col l-6'>
                                                            <p class = 'form__label'>Địa chỉ cụ thể</p>
                                                            <input id = 'address' name = 'address' class = 'form__input' type='text' required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form__section form__section--last'>
                                                    <span class = 'form__title'>Ghi chú cho đơn hàng</span>
                                                    <div class = 'form__item'>
                                                        <textarea rows=2 id = 'note' name = 'note' class = 'textarea__field' type='text' placeholder='Nhập thông tin ghi chú cho nhà bán hàng'></textarea>
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class='checkout-form checkout-form--last'>
                                                <span class = 'form__title'>Phương thức thanh toán <span class = 'must-input-icon'>(*)</span></span>
                                                <div class = 'payment-methods-wrap'>
                                                    <label for='banking' class = 'payment-method' id='banking-method' >
                                                        <input hidden class='payment-method__radio' type='radio' name = 'payment_type' value='banking' id='banking'>
                                                        <div>
                                                            <p style = 'margin-top: 0px' class = 'form__label'>Thanh toán trực tuyến</p>
                                                            <p class = 'checkout-text payment-method__text'>Ví MoMo, Internet Banking, Paypal</p>
                                                        </div>  
                                                        <div class = 'payment-method__tag'>
                                                            <i class='fas fa-money-check-alt payment-icon'></i>
                                                        </div>      
                                                    </label>
                                                    <label for='cash' class = 'payment-method payment-method--active' id='cash-method' >
                                                        <input hidden class='payment-method__radio' type='radio' name = 'payment_type' value='cash' id='cash' checked required>
                                                        <div >
                                                            <p style = 'margin-top: 0px' class = 'form__label'>Thanh toán khi nhận hàng</p>
                                                            <p class = 'checkout-text payment-method__text'>Thanh toán bằng tiền mặt khi nhận hàng tại nhà hoặc showroom</p>
                                                        </div>     
                                                        <div class = 'payment-method__tag'>
                                                            <i class='fas fa-money-bill payment-icon'></i>
                                                        </div>     
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class='col l-5'>
                                        <div class='checkout-form'>
                                            <div class='heading'>
                                                <span class = 'form__title'>Thông tin đơn hàng</span>
                                                <a href='./cart.php' class='form__title form__title--primary'>Chỉnh sửa</a>
                                            </div>
                                            <div class='checkout-form__list-product' id='scrollbar'>";
                                                $tableCart = 'cart';
                                                $column = 'user_id';
                                                $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

                                                foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                                    $id_product = $row['product_id'];
                                                    $tableName = 'product';
                                                    $column = 'product_id';

                                                    $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                                echo "<div class='checkout-form__product-item'>
                                                        <img class='cart-item__img' src='". $productInfo['image_link'] ."'>
                                                        <div class='cart-item__info'>
                                                            <a href='product-detail.php?id=". $productInfo['product_id'] ."'  class='cart-item__name'>
                                                                ".$productInfo['product_name']."
                                                            </a>
                                                            <div class='cart-item__brand'>Số lượng: ".$row['qty']."</div>
                                                        </div>
                                                        <div class='cart-item__price'>";
                                                            if($productInfo['discount'] == 0){
                                                                $totalPrice += $productInfo['price']*$row['qty'];
                                                                echo "<span class = 'cart-item__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                            }
                                                            else{
                                                                $discountPrice = $productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01);
                                                                $totalPrice += $discountPrice*$row['qty'];
                
                                                                echo "<span class = 'cart-item__current-price'>" . number_format($discountPrice, 0, ',', '.') . " ₫</span>
                                                                <span class = 'cart-item__original-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                            }
                                                        echo "</div>
                                                    </div>";
                                                }
                                            echo "</div>
                                        </div>
                                        <div class='checkout-form checkout-form--last'>
                                            <div class='body-product-cart'>
                                                <div class='heading__text-sub'>Tạm tính</div>
                                                <span class = 'totalPrice product-item__sub-price'></span>
                                            </div>
                                            <div class='body-product-cart'>
                                                <div class='heading__text-sub'>Phí vận chuyển</div>
                                                <span class = 'product-item__sub-price'>0 ₫</span>
                                            </div>
                                            <div class='body-product-cart'>
                                                <div class='heading__text'>Thành tiền</div>
                                                <span class = 'heading__text--primary totalPrice'></span>
                                            </div>
                                            <div>
                                                <button class='btn btn--full-width' type='submit'>XÁC NHẬN THANH TOÁN</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>          
                            </div>
                        </div>";
                        echo "<script type=\"text/javascript\">
                                var totalPrice = document.getElementsByClassName('totalPrice');

                                totalField = totalPrice.length;
                                for( var i = 0; i < totalField; i++)
                                {
                                    totalPrice[i].innerHTML = '" . number_format($totalPrice, 0, ',', '.') . " ₫';
                                }
                            </script>";
                    }
                    else{
                        echo "
                        <div class='last-section'>
                            <div class='grid wide'>
                                <div class='product-cart-top row'>
                                    <div class='col l-8 l-o-2'>
                                    <div class='cart-page-inner'>
                                            <div class='heading'>
                                                <span class = 'heading__text' >GIỎ HÀNG TRỐNG</span>
                                            </div>
                                            <div class='empty-cart__img'>
                                                <img src='img/emptycart.svg' alt=''>
                                            </div>
                                            <p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>
                                            <div style='text-align: center;'>
                                                <a class='btn' href='./product-list.php'><span class='' >MUA SẮM NGAY</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";  
                    }
                ?>
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
                        <p class="footer__text">© 2021 Bản quyền thuộc về Team ... </p>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->
        </div>
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </body>
    <script>
        document.addEventListener("DOMContentLoaded",function() {
            var trangthai="under120";
            var menu = document.getElementById('header');
            window.addEventListener("scroll",function(){
                var x = pageYOffset;
                if(x > 120){
                    if(trangthai == "under120")
                    {
                        trangthai="over120";
                        menu.classList.add('header-shrink');
                    }
                }
                else if(x <= 120){
                    if(trangthai=="over120"){
                    menu.classList.remove('header-shrink');
                    trangthai="under120";}
                }
            })
        })
    </script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script src="js/paymentMethod.js"></script>
        <script src="js/getProvinceVN.js"></script>
</html>
>>>>>>> Stashed changes
