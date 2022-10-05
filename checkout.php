<?php 
    session_start();
    require_once('moneyPoint.php');
    
	$dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");
    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $eachPartName = preg_split("/\ /",$_SESSION['name']);
        $user_id = $_SESSION['id'];
        $countName = count($eachPartName);
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

    $totalProductPrice = 0;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>
        <meta charset="UTF-8">

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
                            <img class = "avatar-img" src="img/avatar.jpg"/>
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
                    <div class="col-md-2">
                        <div class="logo">
                            <a href="login.php">
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
                    <li class="breadcrumb-item"><a href="login.php">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="product-list.php">Sản phẩm</a></li>
                    <li class="breadcrumb-item"><a href="cart.php">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active">Xác nhận thanh toán</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <div class="container-fluid">
                <form method = "POST" action="database/checkoutDB.php">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart-page-inner">
                                <div class="table-responsive">
                                    <h5 class = "header-checkout_text">Thông tin người nhận hàng</h5>
                                    <div class = "one-field-checkout">
                                        <p class = "title-checkout-text">Họ tên <span class = "must-input-icon">(*)</span></p>
                                        <input id = "name" name = "name" class = "auth-form__input" type="text" placeholder="Nhập tên của bạn" required>
                                    </div>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Số điện thoại <span class = "must-input-icon">(*)</span></p>
                                            <input id = "phone" name = "phone" class = "auth-form__input" type="text" pattern="[0-9]+" placeholder="Nhập số điện thoại" required>
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Email <span class = "must-input-icon">(*)</span></p>
                                            <input id = "email" name = "email" class = "auth-form__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,4}$" placeholder="Nhập Email của bạn" required>
                                        </div>
                                    </div>
                                    <h5 style="margin-top: 30px;" class = "header-checkout_text">Địa chỉ nhận hàng</h5>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Tỉnh/Thành phố <span class = "must-input-icon">(*)</span></p>
                                            <input id = "city" name = "city" class = "auth-form__input" type="text" required>
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Quận/Huyện</p>
                                            <input id = "district" name = "district" class = "auth-form__input" type="text">
                                        </div>
                                    </div>
                                    <div class = "two-field-checkout">
                                        <div class = "size-s-field">
                                            <p class = "title-checkout-text">Phường/xã</p>
                                            <input id = "ward" name = "ward" class = "auth-form__input" type="text">
                                        </div>
                                        <div class = "size-s-field left-field">
                                            <p class = "title-checkout-text">Địa chỉ cụ thể <span class = "must-input-icon">(*)</span></p>
                                            <input id = "address" name = "address" class = "auth-form__input" type="text" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-page-inner">
                                <div class="row">
                                    <div class="col-md-11 header-checkout">
                                        <div>
                                            <h5 class = "header-checkout_text">Thông tin đơn hàng</h5>
                                        </div>
                                        <div>
                                            <a href="cart.php">Chỉnh sửa</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="cart-summary view-info_checkout">
                                            <?php 
                                                $sqlCart = "SELECT * FROM `cart` WHERE user_id = $user_id";
                                                $rs = $conn->query($sqlCart);
                                                if (!$rs) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while ($row = $rs->fetch_array(MYSQLI_ASSOC)){
                                                    $id_product = $row['product_id'];
                                                    $qslProduct = "SELECT * FROM `product` WHERE product_id = '$id_product'";
                                                    $rs1 = $conn->query($qslProduct);
                                                    if (!$rs1) {
                                                        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                        exit();
                                                    }
                                                    $productInfo = $rs1->fetch_array(MYSQLI_ASSOC);
                                                    echo "<div class='cart-content-info'>";
                                                        echo "<div><a href='product-detail.php?id=". $productInfo['product_id'] ."' ><img class = 'img-checkout' src='". $productInfo['image_link'] ."' alt='Image'></a></div>";
                                                        echo "<div class = 'right-checkout_info'>";
                                                            echo "<p class = 'title-checkout-text_info'>".$productInfo['product_name']."</p>";
                                                            echo "<p class = 'title-checkout-text_info-num'>Số lượng: ".$row['qty']."</p>";
                                                            $price = 0;
                                                            if ($productInfo['discount'] == 0){
                                                                $price = $productInfo['price']; 
                                                            }else{
                                                                $price = ($productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01));
                                                            }
                                                            $sumPrice = $price * $row['qty'];
                                                            $totalProductPrice += $sumPrice;
                                                            echo "<p class = 'header-checkout_text'>".moneyPoint($sumPrice)."đ</p>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="cart-page-inner">
                                <div class="table-responsive">
                                    <h5 class = "header-checkout_text">Ghi chú cho đơn hàng</h5>
                                    <div class = "one-field-checkout">
                                        <input id = "message" name = "message" class = "auth-form__input" type="text" placeholder="Nhập thông tin ghi chú cho nhà bán hàng">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-page-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cart-summary">
                                            <div class="cart-content">
                                                <p class = "checkout-text">Tổng giá<span class = "checkout-price"><?php echo moneyPoint($totalProductPrice) ?>đ</span></p>

                                                <p class = "checkout-text">Phí vận chuyển<span class = "checkout-price">
                                                    <?php 
                                                        $shippingPrice = 35000;
                                                        echo moneyPoint($shippingPrice) 
                                                    ?>đ</span>
                                                </p>

                                                <h2>Thành tiền<span class = "total-checkout-price" >
                                                    <?php 
                                                        $totalPrice = $totalProductPrice + $shippingPrice;
                                                        $_SESSION['totalPrice'] = $totalPrice;
                                                        echo moneyPoint($totalPrice); 
                                                    ?>đ</span>
                                                </h2>
                                            </div>
                                            <div class="cart-btn">
                                                <button type="submit">XÁC NHẬN THANH TOÁN</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
                                <p><i class="fa fa-map-marker"></i>Số 2 đường Võ Oanh phường 25 quận Bình Thạnh</p>
                                <p><i class="fa fa-envelope"></i>dystopia@gmail.com</p>
                                <p><i class="fa fa-phone"></i>0969 966 696</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Theo dõi chúng tôi</h2>
                            <div class="contact-info">
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-faceproduct-f"></i></a>
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
