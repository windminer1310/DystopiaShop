<<<<<<< Updated upstream
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

    $totalPrice = 0;

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
                            <a href="user-login.php" class="nav-item nav-link ">Trang chủ</a>
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
                    <li class="breadcrumb-item active">Giỏ hàng</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <?php
                echo "<div class='container-fluid'>";
                    echo "<div class='row'>";
                        $tableCart = 'cart';
                        $column = 'user_id';
                        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
                    
                        $count = $getCartRow->rowCount();
                        if(cartIsEmpty($count)){
                            echo "<div class='col-lg-8'>";
                                echo "<div class='cart-page-inner'>";
                                        echo "<div class='table-responsive'>";
                                            echo "<table class='table table-bordered'>";
                                                echo "<thead class='thead-dark'>";
                                                    echo "<tr>";
                                                        echo "<th class ='header-checkout_text'>Sản phẩm</th>";
                                                        echo "<th class ='header-checkout_text'>Đơn giá</th>";
                                                        echo "<th class ='header-checkout_text'>Số lượng</th>";
                                                        echo "<th class ='header-checkout_text'>Tổng tiền</th>";
                                                        echo "<th class ='header-checkout_text'>Xóa</th>";
                                                    echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody class='align-middle'>";
                                                    foreach ($row = $getCartRow->fetchAll() as $value => $row) {
                                                        echo "<tr>";
                                                        echo "<td>";
                                                        echo "<div class='img'>";

                                                        $id_product = $row['product_id'];
                                                        $tableName = 'product';
                                                        $column = 'product_id';

                                                        $productInfo = getRowWithValue( $tableName, $column, $id_product);
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
                                                        echo "<td>" .number_format($price, 0, ',', '.')."đ". "</td>";
                                                        echo "<td>";
                                                        echo "<div class='quantity'>";
                                                        echo "<form  class='minus-plus-product'>";
                                                            echo "<div onclick = 'minus_qty();' class = 'btn-minus' ><i class='fa fa-minus'></i></div>";
                                                            echo "<input class = 'quantity-product quantity quantity-input'type='text' value='". $row['qty'] ."' name='amountProduct' id ='amountProduct' onclick='addToCart();'>";
                                                            echo "<div onclick = 'plus_qty();' class = 'btn-plus'><i class='fas fa-plus'></i></div>";
                                                        echo "</form>";
                                                        echo "</div>";
                                                        "</td>";
                                                        $sumPrice = $price * $row['qty'];
                                                        $totalPrice += $sumPrice;
                                                        echo "<td>" . number_format($sumPrice, 0, ',', '.') . "đ</td>";
                                                        echo "<td><a class='btn cart' href='database/deleteCartItem.php?user_id=". $row['user_id']."&product_id=".$row['product_id']."'><i class='fa fa-trash'></i></a></td>";
                                                        
                                                    }        
                                                echo "</tbody>";
                                            echo "</table>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                                    echo "<div class='col-lg-4'>";
                                        echo "<div class='cart-page-inner'>";
                                            echo "<div class='row'>";
                                            echo "<div class='col-md-10 header-cart'>";
                                                echo "<h4 class ='header-checkout_text'>Tổng giá trị giỏ hàng</h4>";
                                            echo "</div>";
                                            echo "<div class='col-md-12'>";
                                                echo "<div class='cart-summary'>";
                                                    echo "<div class='cart-content'>";
                                                        echo "<p class = 'checkout-text'>Tạm tính<span class = 'checkout-price'>" . number_format($totalPrice, 0, ',', '.'). "đ</span></p>";
                                                        echo "<h2>Thành tiền<span class = 'total-checkout-price' > " .number_format($totalPrice, 0, ',', '.'). "đ</span></h2>";
                                                    echo "</div>";
                                                    echo "<form  action='checkout.php'>";
                                                    echo "<div class='cart-btn'>";
                                                        echo "<button type='submit'>TIẾP TỤC THANH TOÁN</button>";
                                                    echo "</div>";
                                                    echo "</form>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        }
                        else{
                            echo "<div class='col-lg-2'>";
                            echo "</div>";
                            echo "<div class='col-lg-8'>";
                                echo "<div class='cart-page-inner'>";
                                    echo "<div class='table-responsive'>";
                                        echo "<h4 class = 'header-checkout_text'>GIỎ HÀNG TRỐNG</h4>";
                                        echo "<div style = 'height: 200px; display: flex; align-item: center; justify-content: center;
                                                            margin-top: 40px; margin-bottom: 60px;'>";
                                            echo "<img src='img/emptycart.svg' alt=''>";
                                        echo "</div>";
                                        echo "<p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>";
                                        echo "<div style = 'text-align: center;'>";
                                        echo " <a class='btn continue-checkout' href='product-list.php'></i>TIẾP TỤC MUA SẮM</a>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
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
        <script src="js/addCart.js"></script>
        <script>
            function minus_qty(){
                if(document.getElementById("amountProduct").value > 1){
                    document.getElementById("amountProduct").value -= 1;
                    console.log(document.getElementById("amountProduct").value);
                    // minusToCartOneByOne();
                }
                
            }
            function plus_qty(){
                document.getElementById("amountProduct").value = Number(document.getElementById("amountProduct").value) + 1;
                console.log(document.getElementById("amountProduct").value);
                // addToCartOneByOne();
            }
        </script>
    </body>
</html>
=======
<?php 
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('shop_info/shop-info.php');
    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
        $tableCart = 'cart';
        $column = 'user_id';
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
    }
    else{
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
                            <a href="#" class="header__icon-link">
                                <i class="header__icon bi bi-cart3"></i>
                                <?php 
                                    if($productInCart > 0) echo "<span class='header__cart-notice'>".$productInCart." </span>";
                                ?>
                            </a>
                            <a href="#" class="header__link">
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
                        echo "<div class='grid wide'>
                            <div class='last-section'>
                                <div class='row'>
                                    <div class='col l-8'>
                                        <div class='product-cart-wrap'>
                                            <div class='heading'>
                                                <span class = 'heading__text' >Danh sách sản phẩm</span>
                                                <span class = 'heading__text--primary totalPrice'></span>
                                            </div>
                                            <div class='cart__list-item' id='scrollbar'>";
                                            $totalPrice = 0;
                                            foreach ($row = $getCartRow->fetchAll() as $value => $row){
                                                $id_product = $row['product_id'];
                                                $tableName = 'product';
                                                $column = 'product_id';

                                                $productInfo = getRowWithValue( $tableName, $column, $id_product);

                                                echo "<div class='cart-item'>
                                                    <a href='product-detail.php?id=".$productInfo['product_id']."'><img class='cart-item__img' src='" . $productInfo['image_link'] . "' alt='Image'></a>
                                                    <div class='cart-item__info'>
                                                        <a class='cart-item__name' href='product-detail.php?id=".$productInfo['product_id']."'>
                                                            ".$productInfo['product_name']."
                                                        </a>
                                                        <div class='cart-item__brand'>Thương hiệu<a href='' class='brand__text'>".$productInfo['brand_id']."</a></div>
                                                    </div>
                                                    <div class='cart-item__quantity'>
                                                        <form id = 'cart-item__quantity--change'>
                                                            <div onclick = 'minus_qty(".$productInfo['product_id'].");' class = 'btn-minus'><i class='fa fa-minus'></i></div>
                                                            <input onfocusout='input_qty(".$productInfo['product_id'].");' class = 'quantity-product quantity-input'type='text' value='".$row['qty']."' name='".$productInfo['product_id']."' id ='".$productInfo['product_id']."'>
                                                            <div onclick = 'plus_qty(".$productInfo['product_id'].");' class = 'btn-plus'><i class='fas fa-plus'></i></div>
                                                        </form>
                                                        <a class='cart-item__delete' href='database/deleteCartItem.php?user_id=". $row['user_id']."&product_id=".$row['product_id']."'>Xoá</a>
                                                    </div>
                                                    
                                                    <div class='cart-item__price'>";
                                                        if($productInfo['discount'] == 0){
                                                            $totalPrice += $productInfo['price']*$row['qty'];
                                                            echo "<span class = 'cart-item__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                        }
                                                        else{
                                                            $discountPrice = $productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01);
                                                            $totalPrice += $discountPrice*$row['qty'];

                                                            echo "<span class = 'cart-item__current-price'>" . number_format($discountPrice, 0, ',', '.') . " ₫</span>
                                                            <span class = 'cart-item__original-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                                        }

                                                    echo "</div>
                                                </div>";
                                            }
                                        echo "</div>
                                        </div>
                                    </div>
                                    <div class='col l-4'>
                                        <div class='cart_checkout'>
                                            <div class='heading'>
                                                <div class='heading__text'>Thành tiền</div>
                                                <span class = 'heading__text--primary totalPrice'></span>
                                            </div>
                                            <a class='btn btn--full-width' href='./checkout.php'>TIẾP TỤC THANH TOÁN</a>
                                        </div>
                                    </div>  
                                </div>          
                            </div>
                        </div>";
                        echo "<script type=\"text/javascript\">
                                var totalPrice = document.getElementsByClassName('totalPrice');
                                
                                totalField = totalPrice.length;
                                for( var i = 0; i < totalField; i++)
                                {
                                    totalPrice[i].innerHTML = '" . number_format($totalPrice, 0, ',', '.') . " ₫';
                                }
                            </script>";
                    }
                    else{
                        echo "<div class='section'>
                            <div class='grid wide'>
                                <div class='row'>
                                    <div class='col l-8 l-o-2'>";
                                    echo "<div class='cart-page-inner'>
                                            <div class='heading'>
                                                <span class = 'heading__text' >GIỎ HÀNG TRỐNG</span>
                                            </div>";
                                            echo "<div class='empty-cart__img'>";
                                                echo "<img src='img/emptycart.svg' alt=''>";
                                            echo "</div>";
                                            echo "<p id='text-cart__empty'>Chưa có sản phẩm trong giỏ hàng của bạn!</p>
                                            <div style='text-align: center;'>
                                                <a class='btn' name = 'submit' id='submit' type='submit' href='product-list.php#product-view'><span class='' >MUA SẮM NGAY</span></a>
                                            </div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "</div>";    
                    }
                ?>
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
        document.addEventListener("DOMContentLoaded",function() {
            // Bắt sự kiện cuộn chuột
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
