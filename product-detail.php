<?php  
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('shop_info/shop-info.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
	else{
        header('Location: product-list.php?id=page_num=1');
    }


	$table_product = 'product';
    $column_product = 'product_id';
    $value = $id;
	foreach(getAllRowWithValue( $table_product, $column_product, $value)->fetchAll() as $value => $row){
		$info = $row;
	}

    if(hasUserInfoSession($_SESSION['name'], $_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
    }
    else{
        headToIndexPage();
    }

    $tableCart = 'cart';
    $column = 'user_id';
    $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

    $numburProductInCart = $getCartRow->rowCount();

    $_SESSION['cart-product'] = $id;
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
                        <a href="user-login.php#sale" class="header__icon-link">
                            <i class="header__icon bi bi-tags"></i>
                        </a>
                        <a href="user-login.php#sale" class="header__link">
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


                    <div class="header__item header__cart-wrap">
                        <a href="./cart.php" class="header__icon-link">
                            <i class="header__icon bi bi-cart3"></i>
                            <?php 
                                if($numburProductInCart > 0){
                                    echo "<span class='header__cart-notice'>".$numburProductInCart." </span>";
                                }
                            ?>
                        </a>
                        <a href="./cart.php" class="header__link">
                            Giỏ hàng
                        </a>
                        
                        <!-- No cart: header__cart-list--no-cart -->
                        <div class="header__cart-list header__cart-list--no-cart">
                            <!-- <img src="./img/emptycart.svg" alt="" class="header__cart-no-cart-img">
                            <span class="header__cart-list-no-cart-msg">
                                        Chưa có sản phẩm
                            </span> -->

                            <h4 class="header__cart-heading">Sản phẩm đã thêm</h4>
                            <ul class="header__cart-list-item">
                                    <li class="header__cart-item">
                                        <img src="https://hanoicomputercdn.com/media/product/58177_asus_strix_lc_360_rgb_black_8.png" alt="" class="header__cart-img">
                                        <div class="header__cart-item-info">
                                            <div class="header__cart-item-head">
                                                <h4 class="header__cart-item-name">Asus ROG Strix</h4>
                                                <div class="header__cart-item-price-wrap">
                                                    <span class="header__cart-item-price">10.000.000đ</span>
                                                    <span class="header__cart-item-multiply">x</span>
                                                    <span class="header__cart-item-qnt">2</span>
                                                </div>
                                            </div>
                                            <div class="header__cart-item-body">
                                                <span class="header__cart-item-description">
                                                        Phân loại: Bạc
                                                    </span>
                                                <span class="header__cart-item-remove">Xóa</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            <!-- <a href="/" onclick="mustInput();" class="header__cart-view-cart btn btn--primary">Xem giỏ hàng</a> -->
                        </div>
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
        <div class="product featured-product padding__map">
            <div class="grid wide">
                    <div class="product-detail-top col l-9">
                        <div class="col l-5">
                            <div class='product__img'>
                                <?php 
                                    $totalImageProduct = 5;
                                    $indexNumberImg = -5;
                                    displayNImgProductView($info['image_link'], $totalImageProduct, $indexNumberImg);
                                ?>
                            <div class='product__list-img'>
                                <?php 
                                    displayListNImgProduct($info['image_link'], $totalImageProduct, $indexNumberImg);
                                ?>
                            </div>
                            </div>
                        </div>
                        <div class="col l-7">
                            <div class="product-content">
                                <div class="title-product">
                                    <h2>
                                        <?php echo $info['product_name'] ?>
                                    </h2>
                                </div>
                                <div class="brand-product">
                                    <span class = "title-text__small" >Thương hiệu </span>
                                    <a href="" class="brand-link">
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
                                        <input class = "quantity-product quantity-input"type="text" value="1" name="amountProduct" id ="amountProduct">
                                        <div onclick = "plus_qty();" class = "btn-plus"><i class="fas fa-plus"></i></div>
                                    </form>
                                </div>
                                <div class = "remain-products">
                                    <span class = "title-text__small" >Hàng trong kho: <?php echo $info['amount']; ?></span>
                                </div>
                                
                                <div class="top-border__line"></div>

                                <div class="btn-product__detail">
                                    <?php 
                                        if ($info['amount'] > 0) {
                                                    echo "<a class='btn' name = 'submit' id='submit' type='submit' onclick='' href=''><span class='btn-buy__text' >MUA NGAY</span></a>
                                                    <a class='btn btn--white' name = 'submit' id='submit' type='submit' onclick=' addToCart(); return false' href=''><span class='btn-buy__text' >THÊM VÀO GIỎ HÀNG</span></a>";
                                        }
                                        else {
                                            echo "<a class='';' href=''>Đã hết hàng</a>";
                                        }

                                    ?>                                            
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- Product Detail End -->
    
        <!-- MAP & FEATURE -->
    

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
        <script src="js/addCart.js"></script>
        <script src="js/main.js"></script>
        <script>
            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            const tabsImgs = $$('.img-display');
            const listImgs = $$('.list-img-item');

            listImgs.forEach((img, index, ) => {
                const tab = tabsImgs[index];

                img.onmouseover = function () {

                    $('.img-display.img-display--active').classList.remove('img-display--active');
                    $('.list-img-item.list-img-item--active').classList.remove('list-img-item--active');

                    tab.classList.add('img-display--active');
                    this.classList.add('list-img-item--active');

                }
            });

            function minus_qty(){
                if(document.getElementById("amountProduct").value > 1){
                    document.getElementById("amountProduct").value -= 1;
                }
                
            }
            function plus_qty(){
                document.getElementById("amountProduct").value = Number(document.getElementById("amountProduct").value) + 1;
            }

        </script>
    </body>
</html>