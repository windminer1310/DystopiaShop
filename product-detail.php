<<<<<<< Updated upstream
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

    $productInCart = $getCartRow->rowCount();

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
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/base.css" rel="stylesheet">
    </head>

    <body>
        
        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="user-login.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="product-list.php" class="nav-item nav-link active">Sản phẩm</a>
                            <a href="custom-pc.html" class="nav-item nav-link">Xây dựng cấu hình</a>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="header__navbar-item header__navbar-user">
                                <img class = "avatar-img" src=<?php echo $_SESSION['img_url']; ?> alt="">
                                <span class="header__navbar-user-name"><?php echo $name; ?></span>
                        
                                <ul class="header__navbar-user-menu">
                                    <li class="header__navbar-user-item">
                                        <a href="my-account.php">Tài khoản của tôi</a>
                                    </li>
                                    <li class="header__navbar-user-item header__navbar-user-item--separate">
                                        <a href="logout.php">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->      
        
        <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="user-login.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <form method="get" action="product-list.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search">
                            <button><i class="fa fa-search" type="submit"></i></button>
                        </div>
                    </form>
                    <div class="col-md-3">
                        <div class="user">
                        <a href="cart.php" class="btn cart">
                            <i class="fa fa-shopping-cart"></i>
                            <?php 
                            if($productInCart > 0){
                                notifyCart($productInCart);
                            }
                            ?>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="user-login.php">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="product-list.php">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product Detail Start -->
        <div class="product-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="product-detail-top">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class='product-item__img'>
                                    	<?php echo "<img src='" . $info['image_link'] . "' alt='Product Image' width='300'>"; ?>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product-content">
                                        <div class="title-product"><h2><?php echo $info['product_name'] ?></h2></div>
                                        <div class="price">
                                            <h4 class="header-checkout_text">Giá gốc:</h4>
                                            <p style="color: black"><?php echo number_format($info['price'], 0, ',', '.') ."đ";?></p>
                                        </div>
                                        <div class="price">
                                            <h4 class = "header-checkout_text">Giá mới:</h4>
                                            <p><?php
                                                    if ($info['discount'] == 0){
                                                        echo number_format($info['price'], 0, ',', '.') ."đ"; 
                                                    }else{
                                                        $discount = $info['price'] - ($info['price'] * $info['discount'] * 0.01);
                                                        echo number_format($discount, 0, ',', '.') ."đ - GIảm " . $info['discount'] . "%";
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                            <div class="quantity">
                                                <h4 class = "header-checkout_text">Số lượng:</h4>
                                                <form id = "product-to-cart">
                                                    <div onclick = "minus_qty();" class = "btn-minus"><i class="fa fa-minus"></i></div>
                                                    <input class = "quantity-product quantity quantity-input"type="text" value="1" name="amountProduct" id ="amountProduct">
                                                    <div onclick = "plus_qty();" class = "btn-plus"><i class="fas fa-plus"></i></div>
                                                </form>
                                            </div>
                                            <h4 class = "header-checkout_text" style="font-weight: 600; font-size: 15px;">Hàng trong kho: <?php echo $info['amount']; ?></h4>
                                        <div class="action">
                                            <?php 
                                                if ($info['amount'] > 0) {
                                                    echo "<a style = 'margin-top: 20px'class='btn' name = 'submit' id='submit' type='submit' onclick=' addToCart(); return false' href=''><i class='fa fa-shopping-cart'></i>Thêm vào giỏ hàng</a>";
                                                }
                                                else {
                                                    echo "<a style = 'margin-top: 20px'class='btn';' href=''><i class='fa fa-shopping-cart'></i>Đã hết hàng</a>";
                                                }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row product-detail-bottom">
                            <div class="col-lg-12">
                                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="admin-list-nav" data-toggle="pill" href="#description" role="tab">Mô tả</a>
                                    <a class="nav-link" id="new-admin-nav" data-toggle="pill" href="#specification" role="tab">Thông tin thêm</a>
                                </div>
                                <div class="tab-content">
                                    <div id="description" class="container tab-pane active">
                                        <h4>Mô tả</h4>
                                        <p>
                                            <?php echo $info['description']; ?> 
                                        </p>
                                    </div>
                                    <div id="specification" class="container tab-pane fade">
                                        <h4>Thông tin thêm</h4>
                                        <ul>
                                            <li>Năm ra mắt: <?php echo $info['date_first_available']; ?></li>
                                        </ul>
                                        <ul>
                                            <li>Thương hiệu: <?php echo $info['brand_id']; ?></li>
                                        </ul>
                                        <ul>
                                            <li>Loại sản phẩm: <?php echo $info['category_id']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget category">
                            <h2 class="title">Loại sản phẩm</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php                                    
                                        $table_category = 'category';
                                        foreach(getRowWithTable($table_category)->fetchAll() as $value => $row) {
                                            echo "<li class='nav-item'><a class='nav-link' href='view-product-list.php?id=1&search=" . $row['category_name'] . "'>" . $row['category_name'] . "</a>";
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                        
                        <div class="sidebar-widget widget-slider">
                            <div class="sidebar-slider normal-slider">
                                <?php
                                    $tableName = 'product';
                                    $column = 'sold';
                                    $numberOfValues = 5;
                                    foreach(getRowWithNFeaturedProducts($tableName, $column, $numberOfValues)->fetchAll() as $value => $row){
                                        echo "<div class='product-item'>";
                                        echo "<div class='product-item__img'>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'>";
                                        echo "<img src='" . $row['image_link'] . "' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='#'><i class='fa fa-cart-plus'></i></a>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-info'>";
                                        echo "<h2>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3><span>" . number_format($discount, 0, ',', '.') . "đ - Giảm " . $row['discount'] . "%</span></h3>";
                                        }
                                        else {
                                            echo "<h3><span>" . number_format($row['price'], 0, ',', '.') . "đ</span></h3>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                    }

                                ?>
                            </div>
                        </div>

                        
                        <div class="sidebar-widget category">
                            <h2 class="title">Thương hiệu</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php
                                        $table_brand = 'brand';
                                        foreach(getRowWithTable($table_brand)->fetchAll() as $value => $row) {
                                            echo "<li class='nav-item'><a class='nav-link' href='view-product-list.php?id=1&search=" . $row['brand_name'] . "'>" . $row['brand_name'] . "</a>";
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Product Detail End -->        

        
        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Liên lạc</h2>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i><?php echo SHOP_ADDRESS ?></p>
                                <p><i class="fa fa-envelope"></i><?php echo SHOP_EMAIL ?></p>
                                <p><i class="fa fa-phone"></i><?php echo SHOP_PHONE ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Theo dõi chúng tôi</h2>
                            <div class="contact-info">
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-facebook-f"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a href=""><i class="fab fa-instagram"></i></a>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Thông tin về công ty</h2>
                            <ul>
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Điều khoản và điều kiện</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Thông tin mua hàng</h2>
                            <ul>
                                <li><a href="#">Chính sách thanh toán</a></li>
                                <li><a href="#">Chính sách giao hàng</a></li>
                                <li><a href="#">Chính sách hoàn trả</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row payment align-items-center">
                    <div class="col-md-6">
                        <div class="payment-method">
                            <h2>Chấp nhận thanh toán</h2>
                            <img src="img/payment-method.png" alt="Payment Method" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
=======
<?php  
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('shop_info/shop-info.php');

    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
    }
	else{
        header('Location: product-list.php?product_id=page_num=1');
    }
    $_SESSION['product-id'] = $product_id;
	$table_product = 'product';
    $column_product = 'product_id';
    $value = $product_id;
	foreach(getAllRowWithValue( $table_product, $column_product, $value)->fetchAll() as $value => $row){
		$info = $row;
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
        <link rel="stylesheet" href="lib/slick/slick.css">
        <link rel="stylesheet" href="lib/slick/slick-theme.css">
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
                        
                        <?php
                        if(isset($_SESSION['name']) && isset($_SESSION['id'])){
                            echo "
                            <div class='header__item'>
                                <a class='header__icon-link' href='./my-account.php'>
                                    <i class='header__icon bi bi-clipboard-check'></i>
                                </a>
                                <a href='./my-account.php' class='header__link header__user-orders'>Đơn hàng</a>
                            </div>
                            <div class='header__item header__user'>
                                <a class='header__icon-link' href='./my-account.php'>"; 
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
                                        <a href='./my-account.php'>Tài khoản của tôi</a>
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
                                            $productLink = 'product-detail.php?id='.$productInfo['product_id'];
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
                                        <a href='./cart.php' class='header__cart-view-cart'>Xem giỏ hàng</a>
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
                                <a href='#' class='header__icon-link' onclick='mustInput()'>
                                    <i class='header__icon bi bi-cart3'></i>
                                </a>
                                <a href='#' class='header__link' onclick='mustInput()'>
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
                <div class="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link "><a href="index.php">Trang chủ</a></li>
                            <li class="path-link ">></li>
                            <li class="path-link "><a href="product-list.php">Sản phẩm</a></li>
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
                <div class="product-detail">
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
                                        <span class = "title-text__small" >Hàng trong kho: <?php echo $info['quantity']; ?></span>
                                    </div>
                                    
                                    <div class="top-border__line"></div>

                                    <div class="btn-product__detail">
                                        <?php
                                        
                                            if ($info['quantity'] > 0) {
                                                if (isset($_SESSION['name']) && isset($_SESSION['id'])){
                                                    echo "
                                                    <a class='btn' name = 'submit' id='submit' type='submit' onclick='' href=''>MUA NGAY</a>
                                                    <a class='btn btn--white' name = 'submit' id='submit' type='submit' onclick=' addToCart(); return false' href=''>THÊM VÀO GIỎ HÀNG</a>";
                                                }else{
                                                    echo "
                                                    <a class='btn' name = 'submit' id='submit' type='submit' onclick=' mustInput();' href=''>MUA NGAY</a>
                                                    <a class='btn btn--white' name = 'submit' id='submit' type='submit' onclick=' mustInput();' href=''>THÊM VÀO GIỎ HÀNG</a>";
                                                }
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
        </div>
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>  
    </body>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        <!-- Template Javascript -->
        <script src="js/addCart.js"></script>
        <script src="js/main.js"></script>
    <script>
        const $ = document.querySelector.bind(document);
        const $$ = document.querySelectorAll.bind(document);
        const tabsImgs = $$('.img-display');
        const listImgs = $$('.list-img-item');
        listImgs.forEach((img, index) => {
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
        document.addEventListener("DOMContentLoaded",function() {
            var trangthai="under120";
            var menu = document.getElementById('header');
            window.addEventListener("scroll",function(){
                var x = pageYOffset;
                if(x > 120){
                    if(trangthai == "under120")
                    {
                        trangthai="over120";
                        menu.classList.add('header-shrink');
                    }
                }
                else if(x <= 120){
                    if(trangthai=="over120"){
                    menu.classList.remove('header-shrink');
                    trangthai="under120";}
                }
            })
        })
    </script>
>>>>>>> Stashed changes
</html>