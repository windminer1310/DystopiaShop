<<<<<<< Updated upstream
<?php
    session_start();
    require_once('display-function.php');
    require_once('shop_info/shop-info.php');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $eachPartName = preg_split("/\ /",$_SESSION['name']);
        $countName = count($eachPartName);

        $user_id = $_SESSION['id'];
        
        if($countName == 1){
            $name = $eachPartName[$countName-1];
        }
        else{
            $name = $eachPartName[$countName-2] . " " . $eachPartName[$countName-1];
        }
    }
    else{
        header('Location: index.php');
    }

    $id_transaction = $_GET['id_transaction'];
    
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");

    $sqlTransaction = "SELECT * FROM `transaction` WHERE transaction_id = $id_transaction";
    $rs = $conn->query($sqlTransaction);
    if (!$rs) {
        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
        exit();
    }
    $row = $rs->fetch_array(MYSQLI_ASSOC);

    $amountArray = explode( '-', $row['amount']);
    $productArray = explode( '-', $row['product_id']);
    $totalPrice = $row['payment'];
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
                        <a href="login.php" class="nav-item nav-link active">Trang chủ</a>
                        <a href="product-list.php" class="nav-item nav-link">Sản phẩm</a>
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
                    <form method="get" action="view-product-list.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search">
                            <button><i class="fa fa-search" type="submit"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="login.php">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="product-list.php">Sản phẩm</a></li>
                    <li class="breadcrumb-item"><a href="cart.php">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active">Đơn hàng</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <?php
                echo "<div class='container-fluid'>";
                    echo "<div class='row'>";
                        echo "<div class='col-lg-8'>";
                        echo "<div class='cart-page-inner-title'>";
                        echo "<h4 style= 'text-align: center; font-size: 18px;
                        font-weight: 600; margin-bottom: 0px;'>
                        Mã đơn hàng:  ".$id_transaction."</h4 class = 'text-align: center'>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='col-lg-8'>";
                            echo "<div class='cart-page-inner'>";
                                    echo "<div class='table-responsive'>";
                                        echo "<table class='table table-bordered'>";
                                            echo "<thead class='thead-dark'>";
                                                echo "<tr>";
                                                    echo "<th class ='header-checkout_text'>Sản phẩm</th>";
                                                    echo "<th class ='header-checkout_text'>Đơn giá</th>";
                                                    echo "<th class ='header-checkout_text'>Số lượng</th>";
                                                    echo "<th class ='header-checkout_text'>Thành tiền</th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody class='align-middle'>";
                                                    for($count = 0; $count < count($productArray); $count++){
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo "<div class='img'>";
                                                    $qslProduct = "SELECT * FROM `product` WHERE product_id = '$productArray[$count]'";
                                                    $rs1 = $conn->query($qslProduct);
                                                    if (!$rs1) {
                                                        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                        exit();
                                                    }
                                                    $productInfo = $rs1->fetch_array(MYSQLI_ASSOC);
                                                    echo "<a href='product-detail.php?id=".$productInfo['product_id']."'><img src='" . $productInfo['image_link'] . "' alt='Image'></a>";
                                                    echo "<p>" . $productInfo['product_name'] . "</p>";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    $price = 0;
                                                    if ($productInfo['discount'] == 0){
                                                        $price = $productInfo['price']; 
                                                    }else{
                                                        $price = ($productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01));
                                                    }
                                                    echo "<td>" . number_format($row['price'], 0, ',', '.') . "đ". "</td>";
                                                    $amountOfProduct = $amountArray[$count];
                                                    echo "<td>" . $amountOfProduct ."</td>";
                                                    $sumPrice = $price * $amountOfProduct;
                                                    echo "<td>" . $sumPrice . "đ</td>";
                                                    }  
                                                    echo "<tr>";
                                                    echo "<td></td>";
                                                    echo "<td></td>";
                                                    echo "<td class = 'header-checkout_text'>Tổng</td>";
                                                    $shipCost = 35000;
                                                    echo "<td><p class = 'title-checkout-text' style = 'margin: 5px 0px;'>(Ship: ".$shipCost."đ)</p>
                                                    <h5 style ='font-size: 18px; font-weight: 600;  color: rgb(235, 33, 1);'>". $totalPrice ."đ</h5></td>";
                                                    echo "</tr>";
                                            echo "</tbody>";
                                        echo "</table>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                        
            ?>
        </div>
        <!-- Cart End -->
        
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
    </body>
</html>

=======
<?php
    session_start();
    require_once('display-function.php');
    require_once('shop_info/shop-info.php');
    require_once('database/connectDB.php');
    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
        $orderTable = 'order';
        $tableCart = 'cart';
        $column = 'user_id';
        $orderColumn = 'order_id';
        $orderId = $_GET['order_id'];
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
        $userHaveOrder = getRowWithTwoValue($orderTable, $column, $user_id , $orderColumn, $orderId);
        if(!$userHaveOrder) {
            header('Location: cart.php');
        }
    }else{
        header('Location: index.php');
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

                        <div class="header__item">
                            <a href="./my-account.php" class="header__icon-link">
                                <i class="header__icon bi bi-clipboard-check"></i>
                            </a>
                            <a href="./my-account.php" class="header__link header__user-orders">Đơn hàng</a>
                        </div>
                        <div class="header__item header__user">
                            <?php
                                echo "
                                <a href='./my-account.php' class='header__icon-link'>";
                                    if(!isset($_SESSION['img_url'])){
                                        echo "<i class='header__icon bi bi-person'></i>";
                                    }
                                    else {
                                        echo "<img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">";
                                    }
                                echo "
                                </a>
                                <a href='./my-account.php' class='header__link header__user-login'>". $name ."</a>";
                            ?>
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
                                    if($productInCart > 0) echo "<span class='header__cart-notice'>".$productInCart." </span>";
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
                                            <a href="#" class="header__cart-view-cart">Xem giỏ hàng</a>
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
                <div class="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link "><a href="index.php">Trang chủ</a></li>
                            <li class="path-link ">></li>
                            <li class="path-link "><a href="./my-account.php">Tài khoản cá nhân</a></li>
                            <li class="path-link ">></li>
                            <li class="path-link " >CHI TIẾT ĐƠN HÀNG: <?php echo $orderId; ?></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                <div class='section'>
                    <div class='grid wide'>
                        <div class='row'>
                            <div class='col l-7'>
                                <div class="order-detail__products">
                                    <div class='heading'>
                                        <span class = 'heading__text' >Thông tin sản phẩm</span>
                                        <span class = 'heading__text--primary totalPrice'></span>
                                    </div>
                                    <div class='cart__list-item' id="scrollbar">
                                        <?php
                                            $productsID = explode( '-', $userHaveOrder["list_product"]);  
                                            $QtyOfProducts = explode( '-', $userHaveOrder["list_qty"]); 
                                            $totalPrice = 0;
                                            for ($i = 0; $i < count($productsID) ; $i++){
                                                $id_product = $productsID[$i];
                                                $tableName = 'product';
                                                $column = 'product_id';
                                                $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                                echo "<div class='cart-item'>
                                                    <a href='product-detail.php?id=".$productInfo['product_id']."'><img class='cart-item__img' src='" . $productInfo['image_link'] . "' alt='Image'></a>
                                                    <div class='cart-item__info'>
                                                        <a class='cart-item__name' href='product-detail.php?id=".$productInfo['product_id']."'>".$productInfo['product_name']."</a>
                                                        <div class='cart-item__brand'>Thương hiệu<a href='' class='brand__text'>".$productInfo['brand_id']."</a></div>
                                                    </div>
                                                    <div class='cart-item__quantity'>".$QtyOfProducts[$i]."</div>
                                                    <div class='cart-item__price'>                             
                                                        <span class = 'cart-item__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>
                                                    </div>
                                                </div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='col l-5'>
                                <div class="order-detail__info">
                                    <div class='heading'>
                                        <span class = 'heading__text' >Thông tin đơn hàng</span>
                                    </div>
                                    <div class='user-info__order'> 
                                        <?php
                                            echo "<div class='info__order'>
                                            <span class = 'header-text-order__item'>Trạng thái:</span>
                                            <span class='text-order__item'>".$userHaveOrder['order_status']."</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Thời gian đặt hàng:</span>
                                                <span class='text-order__item'>".date("d-m-Y h:i A", strtotime($userHaveOrder['order_date']))."</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Phương thức giao hàng:</span>
                                                <span class='text-order__item'>Viet hoang</span>
                                            </div>";
                                        ?>
                                    </div>
                                </div>
                                <div class="order-detail__receiver">
                                    <div class='heading'>
                                        <span class = 'heading__text' >Thông tin người nhận</span>
                                    </div>
                                    <?php
                                        echo "<div class='user-info__order'> 
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Họ tên người nhận:</span>
                                                <span class='text-order__item'>".$userHaveOrder['ship_name']."</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Địa chỉ:</span>
                                                <span class='text-order__item'>".displayAddress($userHaveOrder['ship_address'])."</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Số điện thoại:</span>
                                                <span class='text-order__item'>".$userHaveOrder['ship_phone']."</span>
                                            </div>
                                        </div>";
                                    ?>
                                </div>
                                <div class="order-detail__transaction">
                                    <div class='heading'>
                                        <span class = 'heading__text' >Thông tin thanh toán</span>
                                    </div>
                                    <?php
                                        echo "<div class='user-info__order'> 
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Mã giao dịch:</span>
                                                <span class='text-order__item'>111111111</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Phương thức thanh toán:</span>
                                                <span class='text-order__item'>Chuyển khoản Momo</span>
                                            </div>
                                            <div class='info__order'>
                                                <span class = 'header-text-order__item'>Số tiền</span>
                                                <span class='text-order__item'>100đ</span>
                                            </div>
                                        </div>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
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
        document.addEventListener("DOMContentLoaded",function() {
            var trangthai="under120";
            var menu = document.getElementById('header');
            var cartList = document.querySelectorAll('div.header__cart-list');
            cartList = cartList[0];
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

                        trangthai="under120";
                    }
                }
            
            })
        })
    </script>
</html>
>>>>>>> Stashed changes
