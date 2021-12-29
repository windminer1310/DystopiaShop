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
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- CSS Libraries --> 
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">
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
                        <a href="#" class="header__logo-link">
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
                    <?php
                        if(isset($_SESSION['name']) && isset($_SESSION['id'])){
                            echo "
                            <div class='header__item'>
                                <a class='header__icon-link' href='./account.php'>
                                    <i class='header__icon bi bi-clipboard-check'></i>
                                </a>
                                <a href='./account.php' class='header__link header__user-orders'>Đơn hàng</a>
                            </div>
                            <div class='header__item header__user'>
                                <a href='./account.php' class='header__icon-link'>"; 
                                    if(!isset($_SESSION['img_url'])){
                                        echo "<i class='header__icon bi bi-person'></i>";
                                    }
                                    else {
                                        echo "<img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">";
                                    }
                                echo "
                                </a>
                                <a href='./account.php' class='header__link header__user-login'>". $name ."</a>
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
                                <a href='javascript:void(0)' class='header__icon-link' onclick='showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\")'>
                                    <i class='header__icon bi bi-cart3'></i>
                                </a>
                                <a href='javascript:void(0)' class='header__link' onclick='showInfoToast(\"Vui lòng đăng nhập để tiếp tục!\")'>
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
            <!-- Main Slider Start -->
            <div class="homepage grid wide">
                <div class="row">
                    <div class="col l-2 m-0 c-0">
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
                    <div class="col l-8 m-12 c-12">
                        <div class="main-slider normal-slider">
                            <div class="main-slider-item">
                                <img class="main-img" src="img/ads/asus-tuf-ads.jpg" alt="Slider Image" />
                            </div>
                            <div class="main-slider-item">
                                <img class="main-img" src="img/ads/acer-predator-triton-300-ads.jpg" alt="Slider Image" />
                            </div>
                            <div class="main-slider-item">
                                <img class="main-img" src="img/ads/msi-raider-ge66-ads.jpg" alt="Slider Image" />
                            </div>
                            <div class="main-slider-item">
                                <img class="main-img" src="img/ads/lenovo-yoga-9-ads.jpg" alt="Slider Image" />
                            </div>
                        </div>
                    </div>
                    <div class="col l-2 m-0 c-0">
                        <div class="right-img">
                            <div class="img-item">
                                <img src="./img/panel1.jpg" alt="Hình ảnh"/>
                            </div>
                            <div class="img-item">
                                <img src="./img/panel3.jpg" alt="Hình ảnh"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Slider End -->
            <!-- Brand Start -->
            <div id="brand">
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
            <div class="section">
                <div class="grid wide product">
                    <div class="section">
                        <div class="section-header">
                            <div class="section-header__title">
                                Sản phẩm nổi bật
                            </div>
                        </div>
                        <div class="featured-product__list-item row align-items-center product-slider product-slider-5">
                        <?php
                            $tableName = 'product';
                            $column = 'sold';
                            $numberOfValues = 10;
                            
                            foreach(getRowWithNFeaturedProducts($tableName, $column, $numberOfValues)->fetchAll() as $value => $row) {
                                echo "<div class='col l-10-2'>";
                                    echo "<a class='product-item' href='product-detail.php?product_id=" . $row['product_id'] . "'>";  
                                        if ($row['discount'] != 0) {
                                            showDiscountTag($row['discount']);
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
                            if($countPage == $firstPageActive) echo "<div class='product-page-wrap product-page__active'>";
                            else echo "<div class='product-page-wrap'>";
                                echo "
                                <div class='grid wide product'>
                                    <div class='section'>
                                        <div class='section-header'>
                                            <div class='section-header__title'>
                                                Đang khuyến mãi
                                            </div>
                                        </div>
                                        <div class='product__list-item'>
                                            <div class='row'>";
                                                foreach(getDiscountProductsInPage($count_product, $numProductInAPage)->fetchAll() as $value => $row) {
                                                    echo "
                                                    <div class='col l-10-2'>
                                                        <a class='product-item' href='product-detail.php?product_id=" . $row['product_id'] . "'>"; 
                                                            showDiscountTag($row['discount']);                       
                                                            echo "
                                                            <div class='product-item__img' style='background-image: url(". $row['image_link'] .");'></div>
                                                            <h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>
                                                            <div class='product-item__price'>"; 
                                                                $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                                                echo "
                                                                <span class = 'product-item__current-price'>" . number_format($discount, 0, ',','.') . " ₫</span>
                                                                <span class = 'product-item__original-price'>" .  number_format($row['price'], 0, ',', '.') . " ₫</span>
                                                            </div>
                                                        </a>
                                                    </div>";            
                                                    $count_product++; 
                                                }  
                                            echo "
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    }
                ?>
            </div>
            <div class="pagination">
                <div class="grid wide">
                    <ul class="pagination_list-btn">
                        <?php
                            $totalProduct = $allDiscountProduct->rowCount();
                            $totalPage = $totalProduct/$numProductInAPage;
                            displayListPageButton($totalPage, 'sale');
                        ?>
                    </ul>
                </div>
            </div>
            <!-- MAP & FEATURE -->
            <div class="last-section">
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
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/display.js"></script>
    <script src="js/slide.js"></script>
</html>