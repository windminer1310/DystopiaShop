<?php
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('search-product-with-link.php');
    require_once('shop_info/shop-info.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        headToPage('product-list.php');
    }

    $sort = 0;
    $price_from = 0;
    $search = NULL;
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }
    if (isset($_GET['price_from'])) {
        $price_from = $_GET['price_from'];
    }
    if (isset($_GET['search']) && strlen($_GET['search']) == 0) {
        header('Location: view-product-list.php');
    }else if( isset($_GET['search'])){
        $search = $_GET['search'];
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    mysqli_set_charset($conn,"utf8");
    if ($conn->connect_error) {
        die("Không thể kết nối!");
        exit();
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
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
                        <a href="index.php" class="header__logo-link">
                            <img src="img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <form class="header__search" method="get" action="view-product-list.php?">
                        <input type="text" class="header__search-input" placeholder="Tìm kiếm sản phẩm" name="search">
                        <button class="header__search-btn">
                            <i class="header__search-btn-icon bi bi-search" type="submit"></i>
                        </button>
                    </form>
                    <div class="header__item">
                        <a href="" class="header__icon-link">
                            <i class="header__icon bi bi-tags"></i>
                        </a>
                        <a href="" class="header__link">
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

                    <!-- Chưa đăng nhập -->
                    <div class="header__item">
                        <a class="header__icon-link" href="./register.php">
                            <i class="header__icon bi bi-person-plus"></i>
                        </a>
                        <a href="./registerphp" class="header__link header__user-register">Đăng ký</a>
                    </div>

                    <div class="header__item">
                        <a class="header__icon-link" href="./login.php">
                            <i class="header__icon bi bi-person"></i>
                        </a>
                        <a href="./login.php" class="header__link header__user-login">Đăng nhập</a>
                    </div>

                    <!-- Đã đăng nhập -->
                    <!-- <div class="header__item">
                        <a class="header__icon-link" href="">
                            <i class="header__icon bi bi-clipboard-check"></i>
                        </a>
                        <a href="" class="header__link header__user-orders">Đơn hàng</a>
                    </div>
                    <div class="header__item">
                        <a class="header__icon-link" href="">
                            <i class="header__icon bi bi-person"></i>
                        </a>
                        <a href="" class="header__link header__user-login">Hữu Lộc</a>
                    </div> -->


                    <div class="header__item header__cart-wrap">
                        <a href="" class="header__icon-link">
                            <i class="header__icon bi bi-cart3"></i>
                        </a>
                        <a href="" class="header__link">
                            Giỏ hàng
                        </a>

                        <!-- <span class="header__cart-notice">3</span> -->
                        <!-- No cart: header__cart-list--no-cart -->
                        <div class="header__cart-list header__cart-list--no-cart">
                            <img src="./img/emptycart.svg" alt="" class="header__cart-no-cart-img">
                            <span class="header__cart-list-no-cart-msg">
                                        Chưa có sản phẩm
                                    </span>

                            <!-- <h4 class="header__cart-heading">Sản phẩm đã thêm</h4> -->
                            <!-- <ul class="header__cart-list-item">
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
                                </ul> -->

                            <!-- <a href="/" onclick="mustInput();" class="header__cart-view-cart btn btn--primary">Xem giỏ hàng</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <div class="homepage">
            <div class=" grid wide">
                <div class="product-view-top">
                    <div class="l-5">
                        <div class="product-short">
                            <div class="dropdown">
                                <?php
                                    displayDescribeDropdownTag($sort);
                                ?>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                        searchProductWithDescribeDropdownTag($price_from, $search);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-5">
                        <div class="product-short">
                            <div class="dropdown">
                                <?php
                                    displayDropdownTagPriceArea($price_from);
                                ?>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                        searchProductWithDropdownTagPriceArea($sort, $search);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        <!-- Product List Start -->
        
        <?php 
        $numProductInAPage = 10;
        $count_product = 0;
        $allDiscountProduct = getDiscountProducts();

        $totalProduct = $allDiscountProduct->rowCount();
        $totalPage = $totalProduct/$numProductInAPage;
                
        if($totalPage > floor($totalPage)){
            for($count = 1; $count <= floor($totalPage)+1; $count++){
                if($count == 1){
                    echo "<div class='product sale-product product-page__active'>";
                }
                else{
                    echo "<div class='product sale-product'>";
                }
            echo "<div class='grid wide'>
                <div class='section'>
                    <div class='section-title'>
                        Sản phẩm
                    </div>
                    <div class='sale-product__list-item'>
                        <div class='row'> ";                            
                                $sql = "SELECT * FROM `product`";
                                if (isset($_GET['price_from'])) {
                                    if ($_GET['price_from'] == 1) {
                                        $sql = $sql . " WHERE price <= 1000000";
                                    }
                                    elseif ($_GET['price_from'] == 2) {
                                        $sql = $sql . " WHERE price > 1000000 AND price <= 10000000";
                                    }
                                    elseif ($_GET['price_from'] == 3) {
                                        $sql = $sql . " WHERE price > 10000000 AND price <= 50000000";
                                    }
                                    else {
                                        $sql = $sql . " WHERE price > 50000000";
                                    }
                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                        $sql = $sql . " AND (product_name LIKE '%" . $search . "%' OR category_id = 
                                        (SELECT category_id FROM `category` WHERE category_name LIKE '%" . $search . "%') OR brand_id = 
                                        (SELECT brand_id FROM `brand` WHERE brand_name LIKE '%" . $search . "%') OR description LIKE '%" . $search . "%')";
                                    }
                                }
                                else {
                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                        $sql = $sql . " WHERE product_name LIKE '%" . $search . "%' OR category_id = 
                                        (SELECT category_id FROM `category` WHERE category_name LIKE '%" . $search . "%') OR brand_id = 
                                        (SELECT brand_id FROM `brand` WHERE brand_name LIKE '%" . $search . "%') OR description LIKE '%" . $search . "%'";
                                    }
                                }
                                if (isset($_GET['sort'])) {
                                    if ($_GET['sort'] == 1) {
                                        $sql = $sql . " ORDER BY saledate DESC";
                                    }
                                    elseif ($_GET['sort'] == 3) {
                                        $sql = $sql . " ORDER BY price ASC";
                                    }
                                    elseif ($_GET['sort'] == 4) {
                                        $sql = $sql . " ORDER BY price DESC";
                                    }
                                    else {
                                        $sql = $sql . " ORDER BY sold DESC";
                                    }
                                }
                                $rs = $conn->query($sql);

                                foreach ($conn->query($sql . "LIMIT ". $count_product . " , " .$numProductInAPage)->fetch_all(MYSQLI_ASSOC) as $value => $row) {
                                        echo "<div class='col l-10-2'>";
                                            echo "<a class='product-item' href='view-product-detail.php?id=" . $row['product_id'] . "'>";  
                                                if ($row['discount'] != 0) {
                                                    displayDiscountTagWithHtml($row['discount']);
                                                }                                          
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
                                echo "</div>                     
                            </div>       
                        </div>
                    </div>
                </div>
            </div>";
            }
        }
        ?>
        
        <div class="list-product_btn">
            <div class="grid wide">
                <ul class="pagination justify-content-center">
                    <?php
                        $totalProduct = $allDiscountProduct->rowCount();
                        $totalPage = $totalProduct/$numProductInAPage;
                        displayListPageButtonViewProduct($totalPage);
                    ?>
                </ul>
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
        <!-- <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a> -->

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>
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

            document.addEventListener("DOMContentLoaded",function() {
                // Bắt sự kiện cuộn chuột
                var trangthai="under120";
                var cartList = document.querySelectorAll('div.header__cart-list');
                cartList = cartList[0];
                var menu = document.querySelectorAll('header.header');
                var menu = menu[0];
                window.addEventListener("scroll",function(){
                    var x = pageYOffset;
                    if(x > 120){
                        if(trangthai == "under120")
                        {
                            trangthai="over120";
                            menu.classList.add('header-shrink');
                            cartList.classList.add('header__cart-fix-shrink');
                        }
                    }
                    else if(x <= 120){
                        if(trangthai=="over120"){
                        menu.classList.remove('header-shrink');
                        cartList.classList.remove('header__cart-fix-shrink');
                        trangthai="under120";}
                    }
                
                })
            })
        </script>
    
</body>

</html>