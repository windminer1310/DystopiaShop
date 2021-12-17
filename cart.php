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
                    
                    <div class="header__item header__navbar-user">
                        <a class="header__icon-link" href="">
                            <img class = "header__avatar-img" src=<?php echo $_SESSION['img_url']; ?> alt="">
                        </a>
                        <a href="" class="header__link header__user-login"><?php echo $name;?></a>

                        <ul class="header__navbar-user-menu">
                            <li class="header__navbar-user-item">
                                <a href="./my-account.php">Tài khoản của tôi</a>
                            </li>
                            <li class="header__navbar-user-item header__navbar-user-item--separate">
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
                    <li class="path-link "><a href="index.php">Trang chủ</a></li>
                    <li class="path-link ">></li>
                    <li class="path-link "><a href="view-product-list.php">Sản phẩm</a></li>
                    <li class="path-link ">></li>
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
            if(!cartIsEmpty($count)){
                echo "<div class='product featured-product padding__map'>
                    <div class='grid wide'>
                        <div class='product-cart-top row'>
                            <div class='col l-8'>
                                <div class='header-product-cart'>
                                    <span class = 'product-cart__text' >Tổng tiền</span>
                                    <span class = 'product-item__current-price totalPrice'></span>
                                </div>
                                <div class='list-product-cart'>";
                                
                                $totalPrice = 0;
                                foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                    $id_product = $row['product_id'];
                                    $tableName = 'product';
                                    $column = 'product_id';

                                    $productInfo = getRowWithValue( $tableName, $column, $id_product);

                                    echo "<div class='product-cart__item'>
                                        <a href='product-detail.php?id=".$productInfo['product_id']."'><img class='product-img__cart-page' src='" . $productInfo['image_link'] . "' alt='Image'></a>
                                        <div class='product-info__cart-page'>
                                            <a class='product-name__cart-page' href='product-detail.php?id=".$productInfo['product_id']."'>
                                                ".$productInfo['product_name']."
                                            </a>
                                            <div class='product-brand__cart-page'>Thương hiệu<a href='' class='product-brand__text'>".$productInfo['brand_id']."</a></div>
                                        </div>
                                        <div class='product-quantity__cart-page'>
                                            <form id = 'product-to-cart__page'>
                                                <div onclick = 'minus_qty(".$productInfo['product_id'].");' class = 'btn-minus'><i class='fa fa-minus'></i></div>
                                                <input onfocusout='input_qty(".$productInfo['product_id'].");' class = 'quantity-product quantity-input'type='text' value='".$row['qty']."' name='".$productInfo['product_id']."' id ='".$productInfo['product_id']."'>
                                                <div onclick = 'plus_qty(".$productInfo['product_id'].");' class = 'btn-plus'><i class='fas fa-plus'></i></div>
                                            </form>
                                            <div class='text-delete-product__cart'>
                                                <a href='database/deleteCartItem.php?user_id=". $row['user_id']."&product_id=".$row['product_id']."'>Xoá</a>
                                            </div>
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
                        <div class='col l-4'>
                            <div class='product-cart__checkout'>
                                
                                <div class='body-product-cart'>
                                    <div class='product-cart__text'>Thành tiền</div>
                                    <span class = 'product-item__current-price totalPrice'></span>
                                </div>
                                <div>
                                    <a class='text-checkout-cart__product' href='./checkout.php'><div class = 'btn btn--full-width'>TIẾP TỤC THANH TOÁN</div></a>
                                </div>
                            </div>
                        </div>  
                        </div>          
                    </div>
                </div>";
                echo "<script type=\"text/javascript\">
                        var totalPrice = document.getElementsByClassName('totalPrice');
                        totalPrice[0].innerHTML = '" . number_format($totalPrice, 0, ',', '.') . " ₫';
                        totalPrice[1].innerHTML = '" . number_format($totalPrice, 0, ',', '.') . " ₫';
                    </script>";
        }
        else{
            echo "<div class='product featured-product padding__map'>
                <div class='grid wide'>
                    <div class='product-cart-top row'>
                        <div class='col l-8 l-o-2'>";
                        echo "<div class='cart-page-inner'>
                                <div class='header-product-cart'>
                                    <span class = 'product-cart__text' >GIỎ HÀNG TRỐNG</span>
                                </div>";
                                echo "<div class='empty-cart__img'>";
                                    echo "<img src='img/emptycart.svg' alt=''>";
                                echo "</div>";
                                echo "<p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>
                                <div style='text-align: center;'>
                                    <a class='btn-buy__product btn-primary-color' name = 'submit' id='submit' type='submit' href='product-list.php#product-view'><span class='btn-buy__text' >MUA SẮM NGAY</span></a>
                                </div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            echo "</div>";    
        }
        ?>
        

        <!-- Cart End -->
        
    

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
        <script src="js/addCart.js"></script>
        <script>
            function minus_qty(productId){
                var qtyOfProduct = Number(document.getElementById(productId).value)
                if(qtyOfProduct > 1){
                    document.getElementById(productId).value = Number(qtyOfProduct) - 1;
                    updateToCartInCartPage(productId);
                }
                
            }
            function plus_qty(productId){
                document.getElementById(productId).value = Number(document.getElementById(productId).value) + 1;
                updateToCartInCartPage(productId);
            }

            function input_qty(productId){
                var qtyOfProduct = Number(document.getElementById(productId).value)
                if(qtyOfProduct > 0){
                    updateToCartInCartPage(productId);
                }
            }
        </script>
        
    </body>
</html>
