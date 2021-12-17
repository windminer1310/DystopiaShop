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

    
    $tableCart = 'cart';
    $column = 'user_id';
    $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);

    $numburProductInCart = $getCartRow->rowCount();
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
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="./css/home.css">
</head>

<body>

    <!-- Header Start -->
    <header class="header">
        <div class="grid wide">
            <div class="header-with-search">
                <div class="header__logo">
                    <a href="#" class="header__logo-link">
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
                    <a class="header__icon-link" href="">
                        <i class="header__icon bi bi-person"></i>
                    </a>
                    <a href="" class="header__link header__user-login"><?php echo $name;?></a>

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
                        if($numburProductInCart > 0){
                            echo "<span class='header__cart-notice'>".$numburProductInCart." </span>";
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
                                        $price = 0;
                                        if ($productInfo['discount'] == 0){
                                            $price = $productInfo['price']; 
                                        }else{
                                            $price = $productInfo['price'] * (100 - $productInfo['discount']) / 100;
                                        }
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

    <!-- Main Slider Start -->
    <div class="homepage grid wide">
        <div class="row">
            <div class="col l-2">
                <nav class="home-category">
                    <ul class="category-list">
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=laptop"><i class="category-item__icon bi bi-laptop"></i>Laptop & Macbook</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=vi xử lý"><i class="category-item__icon bi bi-cpu"></i>Bộ vi xử lý</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=vga"><i class="category-item__icon bi bi-cpu"></i>Card màn hình</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=ổ+cứng"><i class="category-item__icon bi bi-motherboard"></i>Bo mạch chủ</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=chuột"><i class="category-item__icon bi bi-hdd"></i>Ổ cứng</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=chuột"><i class="category-item__icon bi bi-memory"></i>RAM - Bộ nhớ</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=màn+hình"><i class="category-item__icon bi bi-display"></i>Màn hình máy tính</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=bàn+phím"><i class="category-item__icon bi bi-pc"></i>Thùng máy tính</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=tai+nghe"><i class="category-item__icon bi bi-mouse2"></i>Chuột & Bàn phím</a>
                        </li>
                        <li class="category-item">
                            <a class="category-item__link" href="product-list.php?search=loa"><i class="category-item__icon bi bi-speaker"></i>Thiết bị âm thanh</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col l-8">
                <div class="main-slider normal-slider">
                    <div class="main-slider-item">
                        <img class="main-img" src="img/ad-img/asus-tuf-ads.jpg" alt="Slider Image" />
                    </div>
                    <div class="main-slider-item">
                        <img class="main-img" src="img/ad-img/acer-predator-triton-300-ads.jpg" alt="Slider Image" />
                    </div>
                    <div class="main-slider-item">
                        <img class="main-img" src="img/ad-img/msi-raider-ge66-ads.jpg" alt="Slider Image" />
                    </div>
                    <div class="main-slider-item">
                        <img class="main-img" src="img/ad-img/lenovo-yoga-9-ads.jpg" alt="Slider Image" />
                    </div>
                </div>
            </div>
            <div class="col l-2">
                <div class="left-img">
                    <div class="img-item">
                        <img src="./img/msi-rtx-3090.png" alt="Hình ảnh"/>
                    </div>
                    <div class="img-item">
                        <img src="./img/msi-meg-z590-godlike.jpg" alt="Hình ảnh"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Slider End -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="grid no-padding">
            <div class="brand-slider">
                <div class="brand-item"><img src="img/brand/msi-logo.png" alt=""></div>
                <div class="brand-item"><img src="img/brand/acer-logo.jpg" alt=""></div>
                <div class="brand-item"><img src="img/brand/asus-logo.png" alt=""></div>
                <div class="brand-item"><img src="img/brand/cooler-master-logo.png" alt=""></div>
                <div class="brand-item"><img src="img/brand/lenovo-logo.png" alt=""></div>  
                <div class="brand-item"><img src="img/brand/hp-logo.png" alt=""></div>
                <div class="brand-item"><img src="img/brand/gigabyte-logo.png" alt=""></div>                
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Featured Product Start -->
    <div class="product featured-product">
        <div class="grid wide">
            <div class="section">
                <div class="section-title">
                    Sản phẩm nổi bật
                </div>
                <div class="featured-product__list-item row align-items-center product-slider product-slider-5">
                <?php
                    $tableName = 'product';
                    $column = 'sold';
                    $numberOfValues = 10;
                    
                    foreach(getRowWithNFeaturedProducts($tableName, $column, $numberOfValues)->fetchAll() as $value => $row) {
                    	echo "<div class='col l-10-2'>";
                            echo "<a class='product-item' href='product-detail.php?id=" . $row['product_id'] . "'>";  
                                if ($row['discount'] != 0) {
                                    displayDiscountTagWithHtml($row['discount']);
                                }                                         
                                echo "<div class='product-item__img' style='background-image: url(". $row['image_link'] .");'></div>"; 
                                echo "<h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>";
                                echo "<div class='product-item__price'>";
                                    if ($row['discount'] != 0) {
                                        $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                        echo "<span class = 'product-item__current-price'>" . number_format($discount, 0, ',','.') . " ₫</span>";
                                        echo "<span class = 'product-item__original-price'>" .  number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                    }
                                    else{
                                        echo "<span class = 'product-item__current-price'>" . number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                    }
                                echo "</div>";
                            echo "</a>";
                    	echo "</div>";
                    }
            	?>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Product End -->
    
    <!-- Sản phẩm đang giảm giá -->
    <div id="sale">
        <?php 
        $numProductInAPage = 10;
        $count_product = 0;
        $firstPageActive = 1;
        
        $allDiscountProduct = getDiscountProducts();

        $totalProduct = $allDiscountProduct->rowCount();
        $totalPage = $totalProduct/$numProductInAPage;
                    
        if($totalPage > floor($totalPage)){
            for($countPage = 1; $countPage <= floor($totalPage)+1; $countPage++){

                if($countPage == $firstPageActive) echo "<div class='product sale-product product-page__active'>";
                else echo "<div class='product sale-product'>";

                echo "<div class='grid wide'>
                    <div class='section'>
                        <div class='section-title'>
                            Đang khuyến mãi
                        </div>
                        <div class='product__list-item'>
                            <div class='row'>";
                            foreach(getDiscountProductsInPage($count_product, $numProductInAPage)->fetchAll() as $value => $row) {
                                echo "<div class='col l-10-2'>";
                                    echo "<a class='product-item' href='product-detail.php?id=" . $row['product_id'] . "'>"; 
                                        displayDiscountTagWithHtml($row['discount']);                       
                                        echo "<div class='product-item__img' style='background-image: url(". $row['image_link'] .");'></div>"; 
                                        echo "<h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>";
                                        echo "<div class='product-item__price'>";  
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<span class = 'product-item__current-price'>" . number_format($discount, 0, ',','.') . " ₫</span>";
                                            echo "<span class = 'product-item__original-price'>" .  number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                        echo "</div>";
                                    echo "</a>";
                                echo "</div>";            
                                $count_product++; 
                            }  
                        echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            }
        }
        ?>

        <div class="list-product_btn">
            <div class="grid wide">
                <ul class="pagination justify-content-center">
                    <?php
                        $totalProduct = $allDiscountProduct->rowCount();
                        $totalPage = $totalProduct/$numProductInAPage;
                        displayListPageButton($totalPage, 'sale');
                    ?>
                </ul>
            </div>
        </div>           
    </div>                   

    <!-- MAP & FEATURE -->
    <!-- Cần fix giao diện :( -->
    <div class="map-and-feature">
        <div class="grid wide">
            <div class="row">
                <div class="col l-9">
                    <!-- Google Map Start -->
                    <div class="contact-map-wrap">
                        <iframe title="google-map" class="contact-map" src="<?php echo ADDRESS_GOOGLE_URL ?>"></iframe>
                    </div>
                    <!-- Google Map End -->
                </div>
                <div class="col l-3">
                    <div class="features">
                        <div class="feature-content">
                            <i class="fab fa-cc-mastercard"></i>
                            Thanh toán an toàn
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-truck"></i>
                            Giao hàng toàn quốc
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-sync-alt"></i>
                            Đổi trả trong vòng 7 ngày
                        </div>
                        <div class="feature-content">
                            <i class="fa fa-comments"></i>
                            Hổ trợ 24/7
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        // Bắt sự kiện nhấn nút chuyển trang khuyến mãi sản phẩm
        const $ = document.querySelector.bind(document);
        const $$ = document.querySelectorAll.bind(document);

        const tabs = $$('.sale-product');
        const pages = $$('.page-item');

        pages.forEach((page, index, ) => {
            const tab = tabs[index];

            page.onclick = function () {

                $('.page-item.active').classList.remove('active');
                $('.sale-product.product-page__active').classList.remove('product-page__active');

                this.classList.add('active');
                tab.classList.add('product-page__active');
            }
        });

        // Bắt sự kiện cuộn chuột
        document.addEventListener("DOMContentLoaded",function() {
            
            var trangthai="under120";

            var cartList = document.querySelectorAll('div.header__cart-list');
            cartList = cartList[0];
            var menu = document.querySelectorAll('header.header');
            menu = menu[0];
            var userMenu = document.querySelectorAll('ul.header__user-menu');
            userMenu = userMenu[0];

            window.addEventListener("scroll",function(){
                var x = pageYOffset;
                if(x > 120){
                    if(trangthai == "under120")
                    {
                        trangthai="over120";
                        menu.classList.add('header-shrink');
                        cartList.classList.add('header__fix-shrink');
                        userMenu.classList.add('header__fix-shrink');
                    }
                }
                else if(x <= 120){
                    if(trangthai=="over120"){
                        menu.classList.remove('header-shrink');
                        cartList.classList.remove('header__fix-shrink');
                        userMenu.classList.remove('header__fix-shrink');

                        trangthai="under120";}
                    }
            
            })
        })

        
    </script>
    
</body>

</html>