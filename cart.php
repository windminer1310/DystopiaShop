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
