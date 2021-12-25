<<<<<<< Updated upstream
<?php
    session_start();
    require_once('display-function.php');
    require_once('session.php');
    require_once('database/connectDB.php');
    require_once('search-product-with-link.php');
    require_once('shop_info/shop-info.php');

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
        header('Location: product-list.php');
    }
    else if( isset($_GET['search'])){
        $search = $_GET['search'];
    }
    if (isset($_GET['page_num'])) {
        $page_number = $_GET['page_num'];    
    }
    else {
        $page_number = 1;
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
                            <a href="login.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <form method="get" action="product-list.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search" value = '<?php echo $search; ?>'>
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
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Sản phẩm</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product List Start -->
        <div class="product-view">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-view-top">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="product-info-range">
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
                            <?php                               
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

                                if (!$rs) {
                                    die("Không có sản phẩm nào để hiển thị!");
                                    exit();
                                }
                                $count_product = 0;
                                $numProductInAPage = 30;
                                echo "<div class='col-lg-12' style = 'display: contents;'>";
                                while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                                    if($count_product >= ($page_number-1)*$numProductInAPage && $count_product < ($page_number-1)*$numProductInAPage + $numProductInAPage){
                                        echo "<div class='col-md-3'>";
                                        if ($row['discount'] != 0) {
                                            displayDiscountTagWithHtml($row['discount']);
                                        }
                                        echo "<div class='product-item'>";                                            
                                        echo "<div class='product-item__img'>";
                                        echo "<a href='product-detail.html?id=" . $row['product_id'] . "'>";
                                        echo "<img src='" . $row['image_link'] . "?>' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-info' style='height: 100px;'>";
                                        echo "<h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3 class = 'product-item__current-price'><span>" . number_format($discount, 0, ',','.') . " đ</span></h3>";
                                            echo "<h3 class = 'product-item__original-price'><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        else{
                                            echo "<h3 class = 'product-item__current-price'><span>" . number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                    if( $count_product == (($page_number-1)*$numProductInAPage + $numProductInAPage)) break;
                                    $count_product++;                                 
                                }
                                echo "</div>";
                            ?>                         
                        </div>
                        <!-- Pagination Start -->
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php
                                        $totalProduct = mysqli_num_rows($rs);
                                        $totalPage = $totalProduct/$numProductInAPage;
                                        displayListPageButton($totalPage, $sort, $search, $price_from, $page_number)
                                    ?>
                                </ul>
                            </nav>
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
                                            echo "<li class='nav-item'><a class='nav-link' href='product-list.php?id=1&search=" . $row['category_name'] . "'>" . 
                                            $row['category_name'] . "</a>";
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
                                    foreach(getRowWithNFeaturedProducts($tableName, $column, $numberOfValues)->fetchAll() as $value => $row) {
                                        echo "<div class='product-item'>";
                                        echo "<div class='product-item__img'>";
                                        echo "<a href='product-detail.php?id=" . $row['product_id'] . "'>";
                                        echo "<img src='" . $row['image_link'] . "' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='#'><i class='fa fa-cart-plus'></i></a>";
                                        echo "<a href='product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-info'>";
                                        echo "<h2>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3 class = 'product-item__current-price' style = 'font-size: 17px;'><span>" . number_format($discount, 0, ',','.') . " đ</span></h3>";
                                            echo "<h3 class = 'product-item__original-price' style = 'font-size: 15px;'><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        else{
                                            echo "<p class = 'product-item__current-price '>" . number_format($row['price'], 0, ',', '.') . " đ</p>";
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
                                            echo "<li class='nav-item'><a class='nav-link' href='product-list.php?id=1&search=" . $row['brand_name'] . "'>" . $row['brand_name'] . "</a>";
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
        <script src="js/main.js"></script>
        <script>
            function continue_page(){
                let currentPage = document.getElementsByClassName("active")[2].value;
                alert(currentPage) ;
            }
        </script>
    </body>
=======
<?php
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('search-product-with-link.php');
    require_once('shop_info/shop-info.php');

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
        header('Location: product-list.php');
    }
    else if( isset($_GET['search'])){
        $search = $_GET['search'];
    }

    $conn = getDatabaseConnection();

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
        <!-- Stylesheet -->
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
                        <form class="header__search" method="get" action="product-list.php?">
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
                <!-- Product List Start -->
                <div id="product-view">
                    <div id="filter">
                        <div class=" grid wide">
                            <div class="row product-view__filter">
                                <span class="product-filter__label">Sắp xếp theo</span>
                                <button class="product-filter__btn btn btn--white btn--text-size">Phổ biến</button>
                                <button class="product-filter__btn btn btn--white btn--text-size">Mới nhất</button>
                                <button class="product-filter__btn btn btn--white btn--text-size">Giá tăng dần</button>
                                <button class="product-filter__btn btn btn--white btn--text-size">Giá giảm dần</button>                     
                            
                                <div class="product-filter__price">
                                    <input type="text" maxlength="14" class="input__price" placeholder="Giá thấp nhất" value>-<input type="text" maxlength="14" class="input__price" placeholder="Giá cao nhất" value>
                                    <button class="product-filter__btn-price btn btn--text-size">Tìm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $numProductInAPage = 20;
                    $count_product = 0;

                    $productTable = 'product';
                    $allProducts = getRowWithTable($productTable);

                    $totalProduct = $allProducts->rowCount();
                    $totalPage = $totalProduct/$numProductInAPage;
                            
                    if($totalPage > floor($totalPage)){
                        for($count = 1; $count <= floor($totalPage)+1; $count++){
                            if($count == 1){
                                echo "<div class='product-page-wrap product-page__active'>";
                            }
                            else{
                                echo "<div class='product-page-wrap'>";
                            }
                            echo "
                            <div class='grid wide product'>
                                <div class='section'>
                                    <div class='section-header'>
                                        <div class='section-header__title'>
                                            Danh sách sản phẩm
                                        </div>
                                    </div>
                                    <div class='product__list-item'>
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
                                            $statement = $conn->prepare($sql . " LIMIT ". $count_product . " , " .$numProductInAPage);
                                            $statement->setFetchMode( PDO::FETCH_ASSOC );
                                            $statement->execute();
                                            foreach ($statement->fetchAll() as $value => $row) {
                                                echo "
                                                    <div class='col l-10-2'>
                                                        <a class='product-item' href='product-detail.php?product_id=" . $row['product_id'] . "'>";  
                                                            if ($row['discount'] != 0) {
                                                                showDiscountTag($row['discount']);
                                                            }                                          
                                                            echo "
                                                            <div class='product-item__img' style='background-image: url(". $row['image_link'] .");'></div> 
                                                            <h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>
                                                            <div class='product-item__price'>";  
                                                                if ($row['discount'] != 0) {
                                                                    $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                                                    echo "
                                                                    <span class = 'product-item__current-price'>" . number_format($discount, 0, ',','.') . " ₫</span>
                                                                    <span class = 'product-item__original-price'>" .  number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                                                }
                                                                else{
                                                                    echo "<span class = 'product-item__current-price'>" . number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                                                }
                                                            echo "
                                                            </div>
                                                        </a>
                                                    </div>";
                                                $count_product++;  
                                            }     
                                        echo "</div>        
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
                                    $totalProductAfterSearch = $count_product;
                                    $totalPage = $totalProductAfterSearch/$numProductInAPage;
                                    displayListPageButton($totalPage, 'product-view');
                                ?>
                            </ul>
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
    <script src="js/main.js"></script>
    <script>
        const $ = document.querySelector.bind(document);
        const $$ = document.querySelectorAll.bind(document);
        const tabs = $$('.product-page-wrap');
        const pages = $$('.page-item');
        pages.forEach((page, index, ) => {
            const tab = tabs[index];

            page.onclick = function () {

                $('.page-item.active').classList.remove('active');
                $('.product-page-wrap.product-page__active').classList.remove('product-page__active');

                this.classList.add('active');
                tab.classList.add('product-page__active');
            }
        });
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