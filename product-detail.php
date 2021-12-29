<?php  
    session_start();
    require_once('database/connectDB.php');
    require_once('display.php');

    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
    }
	else{
        header('Location: ./product-list.php');
    }

	$table_product = 'product';
    $column_product = 'product_id';
    $info = getRowWithValue($table_product, $column_product, $product_id);

    if(!$info){
        header('Location: ./product-list.php'); // San pham k ton tai
    }

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];

        $tableCart = 'cart';
        $column = 'user_id';
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
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
                                <img src="./img/logo.png" alt="Logo" class="header__logo-img">
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
                            <a href="#" class="header__icon-link">
                                <i class="header__icon bi bi-pc-display"></i>
                            </a>
                            <a href="#" class="header__link">
                                Cấu hình PC
                            </a>
                        </div>
                        
                        <?php
                        if(isset($_SESSION['name']) && isset($_SESSION['id'])){
                            echo "
                            <div class='header__item'>
                                <a href='./account.php' class='header__icon-link'>
                                    <i class='header__icon bi bi-clipboard-check'></i>
                                </a>
                                <a href='./account.php' class='header__link header__user-orders'>Đơn hàng</a>
                            </div>
                            <div class='header__item header__user'>
                                <a class='header__icon-link' href='./account.php'>"; 
                                    if(!isset($_SESSION['img_url'])){
                                        echo "<i class='header__icon bi bi-person'></i>";
                                    }
                                    else {
                                        echo "<img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">";
                                    }
                                echo "
                                </a>
                                <a href='' class='header__link header__user-login'>". $name ."</a>
                                <ul class='header__user-menu'>
                                    <li class='header__user-item'>
                                        <a href='./account.php'>Tài khoản của tôi</a>
                                    </li>
                                    <li class='header__user-item'>
                                        <a href='./logout.php' >Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                            <div class='header__item header__cart-wrap'>
                                <a href='./cart.php' class='header__icon-link'>
                                    <i class='header__icon bi bi-cart3'></i>";
                                if($productInCart > 0){
                                    echo "<span class='header__cart-notice'>".$productInCart."</span>";
                                }
                                echo "
                                </a>
                                <a href='./cart.php' class='header__link'>Giỏ hàng</a>";
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
                                    echo "
                                    <div class='header__cart-list'>
                                        <h4 class='header__cart-heading'>Sản phẩm đã thêm</h4>
                                        <ul class='header__cart-list-item' id='scrollbar'>";
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

                                            echo "
                                            <li class='header__cart-item'>
                                                <a href='".$productLink."' class='header__cart-img-link'><img src='".$img."' alt='Ảnh sản phẩm' class='header__cart-img'></a>
                                                    <div class='header__cart-item-info'>
                                                    <a href='".$productLink."' class='header__cart-item-name'>".$productName."</a>
                                                        <span class='header__cart-item-qnt'>Số lượng: ".$quantity."</span>
                                                        <span class='header__cart-item-price'>Đơn giá: ".number_format($price, 0, ',', '.')."đ</span>                  
                                                    </div>
                                                </li>
                                            ";
                                        }
                                        echo "
                                        </ul>
                                        <div class='header__cart-footer'>
                                            <h4 class='cart-footer__title'>Tổng tiền sản phẩm</h4>
                                            <div class='cart-footer__total-price'>".number_format($totalPrice, 0, ',', '.')."đ</div>
                                        </div>
                                        <a href='./cart.php' class='btn btn--full-width'>Xem giỏ hàng</a>
                                    </div>";
                                }
                            echo "
                            </div>";
                        }else{
                            echo "
                            <div class='header__item'>
                                <a class='header__icon-link' href='./register.php'>
                                    <i class='header__icon bi bi-person-plus'></i>
                                </a>
                                <a href='./register.php' class='header__link header__user-register'>Đăng ký</a>
                            </div>
                            <div class='header__item'>
                                <a class='header__icon-link' href='./login.php'>
                                    <i class='header__icon bi bi-person'></i>
                                </a>
                                <a href='./login.php' class='header__link header__user-login'>Đăng nhập</a>
                            </div>
                            <div class='header__item header__cart-wrap'>
                                <a href='javascript:void(0)' class='header__icon-link' onclick=showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\")'>
                                    <i class='header__icon bi bi-cart3'></i>
                                </a>
                                <a href='javascript:void(0)' class='header__link' onclick=showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\")'>
                                    Giỏ hàng
                                </a>   
                            </div>";
                        }
                        ?>
                        
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
                            <li class="path-link "><a href="product-list.php">Sản phẩm</a></li>
                            <li class="path-link "><i class="bi bi-chevron-right"></i></li>
                            <li class="path-link active">
                                <?php 
                                    echo $info['product_name'];
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->  
                <!-- Product Detail Start -->
                <div class="product-detail">
                    <div class="grid wide">
                        <div class="info-product-wrap col l-9">
                            <div class="col l-5">
                                <div class='product__img'>
                                    <?php 
                                        $totalImageProduct = 5;
                                        $indexNumberImg = -5;
                                        displayImgProductView($info['image_link'], $totalImageProduct, $indexNumberImg);
                                    ?>
                                <div class='product__list-img'>
                                    <?php 
                                        displayListImgProduct($info['image_link'], $totalImageProduct, $indexNumberImg);
                                    ?>
                                </div>
                                </div>
                            </div>
                            <div class="col l-7">
                                <div class="product__info">
                                    <div class="title-product">
                                        <h2>
                                            <?php echo $info['product_name'] ?>
                                        </h2>
                                    </div>
                                    <div class="brand-product">
                                        <span class = "title-text__small" >Thương hiệu </span>
                                        <a href="#" class="brand-link">
                                            <?php echo $info['brand_id'] ?>
                                        </a>
                                    </div>
                                    <?php
                                        if ($info['discount'] == 0)
                                        {
                                            echo "<div class = 'price-product'>
                                                <h3 class='product-item__current-price-detail'>" . number_format($info['price'], 0, ',', '.') . " ₫</h3>
                                                <h4 class = '' style='color: white;'>None</h4>
                                            </div>";
                                        }
                                        else
                                        {
                                            $discount = $info['price'] - ($info['price'] * $info['discount'] * 0.01);
                                            echo "<div class = 'price-product'>
                                                <h3 class='product-item__current-price-detail'>" .
                                                    number_format($discount, 0, ',', '.') 
                                                    .
                                                    " ₫
                                                </h3>
                                                <p class='product-item__original-price'>" .number_format($info['price'], 0, ',', '.') ." ₫</p>
                                            </div>";
                                                
                                        }
                                    ?>

                                    <div class="choose-quantity__product">
                                        <span class = "title-text__small" >Số lượng:</span>
                                        <form id = "product-to-cart">
                                            <div onclick = "minus_qty();" class = "btn-minus"><i class="fa fa-minus"></i></div>
                                            <input class = "quantity-input"type="text" value="1" id ="<?php echo $product_id?>">
                                            <div onclick = "plus_qty();" class = "btn-plus"><i class="fas fa-plus"></i></div>
                                        </form>
                                    </div>
                                    <div class = "remain-products">
                                        <span class = "title-text__small" >Hàng trong kho: <?php echo $info['quantity']; ?></span>
                                    </div>
                                    
                                    <div class="top-border__line"></div>

                                    <div class="product-detail__btn">
                                        <?php
                                        
                                            if ($info['quantity'] > 0) {
                                                if (isset($_SESSION['name']) && isset($_SESSION['id'])){
                                                    echo "
                                                    <button class='btn' name = 'submit' id='submit' type='submit' onclick='' href=''>MUA NGAY</button>
                                                    <button class='btn btn--white' onclick=' addToCart(\"".$product_id."\"); return false' href='javascript:void(0);'>THÊM VÀO GIỎ HÀNG</button>";
                                                }else{
                                                    echo "
                                                    <button class='btn' onclick='showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\");' href='javascript:void(0)'>MUA NGAY</button>
                                                    <button class='btn btn--white' onclick='showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\");' href='javascript:void(0)'>THÊM VÀO GIỎ HÀNG</button>";
                                                }
                                            }
                                            else {
                                                echo "<button class='btn btn--white btn--disabled'>Đã hết hàng</button>";
                                            }
                                        ?>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Detail End -->            
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
        <!-- Back to Top -->
        <a id="back-to-top"><i class="fa fa-chevron-up"></i></a>  
    </body>
        <!-- Template Javascript -->
        <script src="js/display.js"></script>
        <script src="js/cart.js"></script>
</html>