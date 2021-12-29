<?php 
    session_start();
    require_once('./database/connectDB.php');
    require_once('./display.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
        $tableCart = 'cart';
        $column = 'user_id';
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
    }
    else{
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
        <div id="toast"></div>
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
                            <a href="./account.php" class="header__icon-link">
                                <i class="header__icon bi bi-clipboard-check"></i>
                            </a>
                            <a href="./account.php" class="header__link header__user-orders">Đơn hàng</a>
                        </div>
                        <div class="header__item header__user">
                            <?php
                                echo "
                                <a href='./account.php' class='header__icon-link'>";
                                    if(!isset($_SESSION['img_url'])){
                                        echo "<i class='header__icon bi bi-person'></i>";
                                    }
                                    else {
                                        echo "<img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">";
                                    }
                                echo "
                                </a>
                                <a href='./account.php' class='header__link header__user-login'>". $name ."</a>";
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
                            <a href="#" class="header__icon-link">
                                <i class="header__icon bi bi-cart3"></i>
                                <?php 
                                    if($productInCart > 0) echo "<span class='header__cart-notice'>".$productInCart." </span>";
                                ?>
                            </a>
                            <a href="#" class="header__link">
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
                                            <a href="#" class="btn btn--full-width">Xem giỏ hàng</a>
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
                            <li class="path-link "><a href="index.php">Trang chủ</a></li>
                            <li class="path-link "><i class="bi bi-chevron-right"></i></li>
                            <li class="path-link active">Giỏ hàng</li>
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
                        echo "<div class='grid wide'>
                            <div class='last-section'>
                                <div class='row'>
                                    <div class='col l-8'>
                                        <div class='product-cart-wrap'>
                                            <div class='heading'>
                                                <span class = 'heading__text' >Danh sách sản phẩm</span>
                                                <span class = 'heading__text--primary totalPrice'></span>
                                            </div>
                                            <div class='cart__list-item' id='scrollbar'>";
                                            $totalPrice = 0;
                                            foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                                $id_product = $row['product_id'];
                                                $tableName = 'product';
                                                $column = 'product_id';

                                                $productInfo = getRowWithValue( $tableName, $column, $id_product);

                                                echo "<div class='cart-item'>
                                                    <a href='product-detail.php?product_id=".$productInfo['product_id']."'><img class='cart-item__img' src='" . $productInfo['image_link'] . "' alt='Image'></a>
                                                    <div class='cart-item__info'>
                                                        <a class='cart-item__name' href='product-detail.php?product_id=".$productInfo['product_id']."'>
                                                            ".$productInfo['product_name']."
                                                        </a>
                                                        <div class='cart-item__brand'>Thương hiệu<a href='' class='brand__text'>".$productInfo['brand_id']."</a></div>
                                                    </div>
                                                    <div class='cart-item__quantity'>
                                                        <form id = 'cart-item__quantity--change'>
                                                            <div onclick = 'minusQtyInCart(".$productInfo['product_id'].");' class = 'btn-minus'><i class='fa fa-minus'></i></div>
                                                            <input onchange='inputQtyInCart(".$productInfo['product_id'].");' class = 'quantity-input' type='text' value='".$row['qty']."' name='".$productInfo['product_id']."' id ='".$productInfo['product_id']."'>
                                                            <div onclick = 'plusQtyInCart(".$productInfo['product_id'].");' class = 'btn-plus'><i class='fas fa-plus'></i></div>
                                                        </form>
                                                        <a class='cart-item__delete' href='database/deleteCartItem.php?user_id=". $row['user_id']."&product_id=".$row['product_id']."'>Xoá</a>
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
                                    </div>
                                    <div class='col l-4'>
                                        <div class='cart_checkout'>
                                            <div class='heading'>
                                                <div class='heading__text'>Thành tiền</div>
                                                <span class = 'heading__text--primary totalPrice'></span>
                                            </div>
                                            <a class='btn btn--full-width' href='./checkout.php'>TIẾP TỤC THANH TOÁN</a>
                                        </div>
                                    </div>  
                                </div>          
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
                        echo "<div class='last-section'>
                            <div class='grid wide'>
                                <div class='row'>
                                    <div class='col l-8 l-o-2'>";
                                    echo "<div class='cart-page-inner'>
                                            <div class='heading'>
                                                <span class = 'heading__text' >GIỎ HÀNG TRỐNG</span>
                                            </div>";
                                            echo "<div class='empty-cart__img'>";
                                                echo "<img src='img/emptycart.svg' alt=''>";
                                            echo "</div>";
                                            echo "<p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>
                                            <div style='text-align: center;'>
                                                <a class='btn' name = 'submit' id='submit' type='submit' href='product-list.php#product-view'><span class='' >MUA SẮM NGAY</span></a>
                                            </div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "</div>";    
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
    <script src="js/cart.js"></script>
</html>