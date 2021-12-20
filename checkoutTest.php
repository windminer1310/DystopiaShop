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

    $totalPrice = 0;
    $bankingMethod = 'banking-method';
    $cashMethod = 'cash-method';
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
                    <li class="path-link "><a href="product-list.php">Sản phẩm</a></li>
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
                echo "<div class='product featured-product padding__map'>
                    <div class='grid wide'>
                        <form method = 'POST' action='database/checkoutDB.php'>
                            <div class='product-cart-top row'>
                                <div class='col l-7'>
                                    <div class='list-info__checkout'>
                                        <h5  class = 'header__text-field'>Địa chỉ nhận hàng</h5>
                                        <div class = 'one-field-checkout'>
                                            <p class = 'title-checkout-text'>Họ tên <span class = 'must-input-icon'>(*)</span></p>
                                            <input id = 'name' name = 'name' class = 'auth-form__input' type='text' placeholder='Nhập tên của bạn' required>
                                        </div>
                                        <div class = 'two-field-checkout'>
                                        <div class = 'size-s-field'>
                                            <p class = 'title-checkout-text'>Số điện thoại <span class = 'must-input-icon'>(*)</span></p>
                                            <input id = 'phone' name = 'phone' class = 'auth-form__input' type='text' pattern='[0-9]+' placeholder='Nhập số điện thoại' required>
                                        </div>
                                        <div class = 'size-s-field'>
                                            <p class = 'title-checkout-text'>Email <span class = 'must-input-icon'>(*)</span></p>
                                            <input id = 'email' name = 'email' class = 'auth-form__input' type='text' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,4}$' placeholder='Nhập Email của bạn' required>
                                        </div>
                                        </div>
                                        <h5  class = 'header__text-field'>Địa chỉ nhận hàng</h5>
                                        <div class = 'two-field-checkout'>
                                            <div class = 'size-s-field'>
                                                <p class = 'title-checkout-text'>Tỉnh/Thành phố <span class = 'must-input-icon'>(*)</p>
                                                <select id = 'city' name = 'city' class='auth-form__input' required 
                                                    onclick='startDistrict(); startWard();'>
                                                </select>
                                            </div>
                                            <div class = 'size-s-field'>
                                                <p class = 'title-checkout-text'>Quận/Huyện <span class = 'must-input-icon'>(*)</p>
                                                <select id = 'district' name = 'district' class='auth-form__input' onclick='startWard();'>
                                                </select>
                                            </div>
                                        </div>
                                        <div class = 'two-field-checkout'>
                                            <div class = 'size-s-field'>
                                                <p class = 'title-checkout-text'>Phường/xã</p>
                                                <select id = 'ward' name = 'ward' class='auth-form__input' required></select>
                                            </div>
                                            <div class = 'size-s-field'>
                                                <p class = 'title-checkout-text'>Địa chỉ cụ thể <span class = 'must-input-icon'>(*)</span></p>
                                                <input id = 'address' name = 'address' class = 'auth-form__input' type='text' required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            <div class='col l-5'>
                                <div class='list-info__checkout'>
                                    <div class='header-product-cart'>
                                        <h5  class = 'header__text-field'>Thông tin đơn hàng</h5>
                                        <a href='./product-list.php' class='back-to-cart__text'>Chỉnh sửa</a>
                                    </div>
                                    <div class='list-product-info__checkout'>";
                                        $tableCart = 'cart';
                                        $column = 'user_id';
                                        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

                                        foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                            $id_product = $row['product_id'];
                                            $tableName = 'product';
                                            $column = 'product_id';

                                            $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                        echo "<div class='item-product-info__checkout'> 
                                                <a href='product-detail.php?id=". $productInfo['product_id'] ."' >
                                                    <img class='product-img__cart-page' src='". $productInfo['image_link'] ."'>
                                                </a>
                                                <div class='product-info__cart-page'>
                                                    <a href='product-detail.php?id=". $productInfo['product_id'] ."'  class='product-name__cart-page'>
                                                        ".$productInfo['product_name']."
                                                    </a>
                                                    <div class='product-brand__cart-page'>Số lượng: ".$row['qty']."</div>
                                                </div>
                                                <div class='product-price__cart-page'>";
                                                    if($productInfo['discount'] == 0){
                                                        $totalPrice += $productInfo['price']*$row['qty'];
                                                        echo "<span class = 'product-cart__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                    }
                                                    else{
                                                        $discountPrice = $productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01);
                                                        $totalPrice += $discountPrice*$row['qty'];
        
                                                        echo "<span class = 'product-cart__current-price'>" . number_format($discountPrice, 0, ',', '.') . " ₫</span>
                                                        <span class = 'product-cart__original-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                    }
                                                echo "</div>
                                            </div>";
                                        }
                                    echo "</div>
                                </div>
                            </div>
                            <div class='col l-7'>
                                <div class='note-payment-info__checkout form-after'>
                                <h5 class = 'header__text-field'>Ghi chú cho đơn hàng</h5>
                                <div class = 'one-field-checkout'>
                                    <input id = 'note' name = 'note' class = 'auth-form__input' type='text' placeholder='Nhập thông tin ghi chú cho nhà bán hàng'>
                                </div>
                                <h5 class = 'header__text-field'>Phương thức thanh toán <span class = 'must-input-icon'>(*)</span></h5>
                                <div class = 'payment-method'>
                                    <label for='banking' class = 'payment-method__box' id='banking-method' >
                                        <input hidden class='payment-method__label' type='radio' name = 'payment_type' value='banking' id='banking'>
                                        <div>
                                            <p style = 'margin-top: 0px' class = 'title-checkout-text'>Thanh toán qua Internet Banking</p>
                                            <p class = 'checkout-text payment-method__text'>MoMo, Paypal</p>
                                        </div>  
                                        <div class = 'checked-payment-method'>
                                            <i class='fas fa-money-check-alt payment-icon'></i>
                                        </div>      
                                    </label>
                                    <label for='cash' class = 'payment-method__box active-method' id='cash-method' >
                                        <input hidden class='payment-method__label' type='radio' name = 'payment_type' value='cash' id='cash' checked required>
                                        <div >
                                            <p style = 'margin-top: 0px' class = 'title-checkout-text'>Thanh toán khi nhận hàng</p>
                                            <p class = 'checkout-text payment-method__text'>Thanh toán bằng tiền mặt khi nhận hàng tại nhà hoặc showroom</p>
                                        </div>     
                                        <div class = 'checked-payment-method'>
                                            <i class='fas fa-money-bill payment-icon'></i>
                                        </div>     
                                    </label>
                                </div>
                                </div>
                            </div> 
                            <div class='col l-5'>
                                <div class='form-after'>  
                                    <div class='product-cart__checkout'>
                                        <div class='body-product-cart'>
                                            <div class='header__text-field-sub'>Tạm tính</div>
                                            <span class = 'totalPrice product-item__sub-price'></span>
                                        </div>
                                        <div class='body-product-cart'>
                                            <div class='header__text-field-sub'>Phí vận chuyển</div>
                                            <span class = 'product-item__sub-price'>0 ₫</span>
                                        </div>
                                        <div class='body-product-cart'>
                                            <div class='header__text-field'>Thành tiền</div>
                                            <span class = 'product-item__current-price totalPrice'></span>
                                        </div>
                                        <div>
                                            <button class='btn btn--full-width' type='submit'>XÁC NHẬN THANH TOÁN</button>
                                        </div>
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
            echo "<div class='product featured-product padding__map'>
                <div class='grid wide'>
                    <div class='product-cart-top row'>
                        <div class='col l-8 l-o-2'>";
                        echo "<div class='cart-page-inner'>
                                <div class='header-product-cart'>
                                    <span class = 'header__text-field' >GIỎ HÀNG TRỐNG</span>
                                </div>";
                                echo "<div class='empty-cart__img'>";
                                    echo "<img src='img/emptycart.svg' alt=''>";
                                echo "</div>";
                                echo "<p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>
                                <div style='text-align: center;'>
                                    <a class='btn' href='product-list.php#product-view'><span class='' >MUA SẮM NGAY</span></a>
                                </div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            echo "</div>";  
        }
        ?>
        
                 
    

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
