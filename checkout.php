<?php 
    session_start();
    require_once('./database/connectDB.php');
    require_once('./display.php');

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
        header('Location: ./index.php');
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
                        <form class="header__search" method="get" action="./product-list.php?">
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
                            <a class="header__icon-link" href="./account.php">
                                <i class="header__icon bi bi-clipboard-check"></i>
                            </a>
                            <a href="./account.php" class="header__link header__user-orders">Đơn hàng</a>
                        </div>
                        <div class="header__item header__user">
                            <?php 
                                if(!isset($_SESSION['img_url'])){
                                    echo "<a class='header__icon-link' href='./account.php'>
                                        <i class='header__icon bi bi-person'></i>
                                    </a>
                                    <a href='' class='header__link header__user-login'>". $name ."</a>";
                                }
                                else {
                                    echo "<a class='header__icon-link' href='./account.php'>
                                        <img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">
                                    </a>
                                    <a href='' class='header__link header__user-login'>". $name ."</a>";
                                }
                            ?>
                            <ul class="header__user-menu">
                                <li class="header__user-item">
                                    <a href="./account.php">Tài khoản của tôi</a>
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
                                if($count <= 0){
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
                                                $productLink = 'product-detail.php?product_id='.$productInfo['product_id'];
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
                                            <a href="./cart.php" class="btn btn--full-width">Xem giỏ hàng</a>
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
                <div id="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link "><a href="./index.php">Trang chủ</a></li>
                            <li class="path-link "><i class="bi bi-chevron-right"></i></li>
                            <li class="path-link "><a href="./cart.php">Giỏ hàng</a></li>
                            <li class="path-link "><i class="bi bi-chevron-right"></i></li>
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
                    if($count > 0){
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
                                                            <select id = 'city' name = 'city' class='form__input' required onchange='startDistrict();'>
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
                                                            <p class = 'form__label'>Địa chỉ cụ thể <span class = 'must-input-icon'>(*)</span></p>
                                                            <input id ='address' name ='address' class = 'form__input' type='text' required>
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
                                                            <a href='product-detail.php?product_id=". $productInfo['product_id'] ."'  class='cart-item__name'>
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
                                                <button class='btn btn--full-width' type='submit'> TIẾP TỤC THANH TOÁN</button>
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
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Trung tâm trợ giúp</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Hướng dẫn mua hàng</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Chính sách thanh toán</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Chính sách giao hàng</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Chính sách hoàn trả</a>
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
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Giới thiệu</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Tuyển dụng</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Chính sách bảo mật</a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">Điều khoản</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col l-10-2">
                            <h3 class="footer__heading">Theo dõi</h3>
                            <ul class="footer-list">
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">
                                        <i class="footer-item__icon fab fa-twitter-square"></i> Twitter
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">
                                        <i class="footer-item__icon fab fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">
                                        <i class="footer-item__icon fab fa-linkedin"></i> LinkedIn
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">
                                        <i class="footer-item__icon fab fa-instagram"></i> Instagram
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer-item__link">
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
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer__download-app-link">
                                        <img src="./img/download/google_play.png" alt="Google play" class="footer__download-app-img">
                                    </a>
                                    <a href="<?php echo"javascript:void(0)"?>" class="footer__download-app-link">
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
            </footer>
            <!-- Footer End -->
        </div>
        <!-- Back to Top -->
        <a id="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </body>
        <!-- Template Javascript -->
        <script src="js/display.js"></script>
        <script src="js/paymentMethod.js"></script>
        <script src="js/getAddress.js"></script>
        <script>startProvince();</script>
</html>