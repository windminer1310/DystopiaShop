<?php  
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('shop_info/shop-info.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        headToPage('product-list.php');
    }


    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
	else{
        header('Location: view-product-list.php?id=page_num=1');
    }

	$info = NULL;

    $table_product = 'product';
    $column_product = 'product_id';
    $value = $id;
	foreach(getAllRowWithValue( $table_product, $column_product, $value)->fetchAll() as $value => $row){
		$info = $row;
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
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="./css/home.css">
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
        <div class="product featured-product">
            <div class="grid wide">
                <div class="row">
                    <div class="product-detail-top col l-9">
                        <div class="col l-4">
                            <div class='product__img'>
                                <?php 
                                    $totalImageProduct = 5;
                                    $indexNumberImg = -5;
                                    for($i = 1; $i <= $totalImageProduct; $i++){
                                        if($i == 1) echo "<img class='img-display img-display--active' src='" .substr_replace($info['image_link'],(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
                                        else echo "<img class='img-display ' src='" .substr_replace($info['image_link'],(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
                                    }
                                ?>
                                <div class='product__list-img'>
                                    <?php 
                                        $totalImageProduct = 5;
                                        $indexNumberImg = -5;
                                        for($i = 1; $i <= $totalImageProduct; $i++){
                                            if($i == 1) echo "<img class='list-img-item list-img-item--active' src='" .substr_replace($info['image_link'],(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
                                            else echo "<img class='list-img-item' src='" .substr_replace($info['image_link'],(string)$i, $indexNumberImg, 1). "' alt='Product Image'>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col l-8">
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
                                            <h4 class = '' style='color: white;'>G:</h4>
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
                                                    echo "<a class='btn-buy__product' name = 'submit' id='submit' type='submit' onclick=' mustInput();' href=''><span class='btn-buy__text' >MUA NGAY</span></a>
                                                    <a class='btn-buy__product' name = 'submit' id='submit' type='submit' onclick=' mustInput();' href=''><span class='btn-buy__text' >THÊM VÀO GIỎ HÀNG</span></a>";
                                        }
                                        else {
                                            echo "<a class='';' href=''>Đã hết hàng</a>";
                                        }

                                    ?>                                            
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- <div class="product-detail-bottom">
                    <div class="col c-4">
                        <div class='product-content'>
                            dsadsadsa
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Product Detail End -->
        

        

        
        
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