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
                            <a href="product-list.php" class="nav-item nav-link">Sản phẩm</a>
                            <a href="custom-pc.html" class="nav-item nav-link">Xây dựng cấu hình</a>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="header__navbar-item header__navbar-user">
                                <img class = "avatar-img" src=<?php echo $_SESSION['img_url']; ?> alt="">
                                <span class="header__navbar-user-name"><?php echo $name;?></span>

                                <ul class="header__navbar-user-menu">
                                    <li class="header__navbar-user-item">
                                        <a href="">Tài khoản của tôi</a>
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
                    <li class="breadcrumb-item active">Tài khoản của tôi</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- My Account Start -->
        <div class="my-account">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i class="fa fa-shopping-bag"></i>Lịch sử mua hàng</a>
                            <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab"><i class="fa fa-user"></i>Tài khoản</a>
                            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt"></i>Đăng xuất</a>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                                <div class="table-responsive" style="overflow-y: auto; height: 400px;">
                                    <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                        <thead class="thead-dark" style="position: sticky; top: 0;">
                                            <tr>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Mã đơn hàng</th>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Sản phẩm</th>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Ngày đặt</th>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Địa chỉ</th>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Tổng tiền</th>
                                                <th style="box-shadow: inset 0 0 2px #000000;">Trạng thái</th>
                                                <th style = "border-color: white white white white;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $tableTransaction = 'transaction';
                                                $column = 'user_id';
                                                $getTransactiontRow = getAllRowWithValue($tableTransaction, $column, $user_id);

                                                foreach ($row = $getTransactiontRow->fetchAll() as $value => $row){
                                                    echo "<tr>";
                                                    echo "<td>". $row["transaction_id"] ."</td>";
                                                    echo "<td><a class ='btn' href='submit-checkout.php?id_transaction=" . $row['transaction_id'] . "'>Xem</a></td>";
                                                    $dateTime = explode( ' ', $row["date"]);
                                                    echo "<td>". dayOfDate($dateTime[0]).", ". dateFormat($dateTime[0]).", ".$dateTime[0]."</td>";
                                                    echo "<td>". $row['address']."</td>";
                                                    echo "<td>". $row["payment"] ."đ</td>";
                                                    echo "<td>". approveStatus($row["status"]) ."</td>";
                                                    if($row['status']<2){
                                                        echo "<td style='border-color: white white white white;'><a href='cancel-transaction.php?id=". $row['transaction_id'] ." 'class = 'fail-auth__form btn'>Hủy đơn</a></td>";
                                                    }
                                                    
                                                    
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>               
                                    </table>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                                <h5>Đổi mật khẩu</h5>
                                <form action = "database/changePassword.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" type="password" name = "password" id = "password" placeholder="Mật khẩu hiện tại" required>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="password" name = "newPassword" id = "newPassword" placeholder="Mật khẩu mới" required>
                                        </div>
                                        <div class="col-md-12">
                                            <button type = "submit" class="btn">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- My Account End -->
        
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
=======
<?php 
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('shop_info/shop-info.php');
    require_once('database/connectDB.php');
    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        $name = displayUserName($_SESSION['name']);
        $user_id = $_SESSION['id'];
        $tableCart = 'cart';
        $column = 'user_id';
        $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
        $productInCart = $getCartRow->rowCount();
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
                            <a href="#" class="header__icon-link">
                                <i class="header__icon bi bi-pc-display"></i>
                            </a>
                            <a href="#" class="header__link">
                                Cấu hình PC
                            </a>
                        </div>
                        <div class="header__item">
                            <a class="header__icon-link" href="">
                                <i class="header__icon bi bi-clipboard-check"></i>
                            </a>
                            <a href="#" class="header__link header__user-orders">Đơn hàng</a>
                        </div>
                        <div class="header__item header__user">
                            <?php
                                echo "<a class='header__icon-link' href='#'>";
                                if(!isset($_SESSION['img_url'])){
                                    echo "<i class='header__icon bi bi-person'></i>";
                                }else {
                                    echo "<img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">";
                                }
                                echo "</a>
                                <a href='#' class='header__link header__user-login'>". $name ."</a>";
                            ?>
                            <ul class="header__user-menu">
                                <li class="header__user-item">
                                    <a href="#">Tài khoản của tôi</a>
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
                                if($productInCart > 0){echo "<span class='header__cart-notice'>".$productInCart." </span>";}
                                ?>
                            </a>
                            <a href="./cart.php" class="header__link">
                                Giỏ hàng
                            </a>
                            <?php
                                $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
                                $count = $getCartRow->rowCount();
                                if(cartIsEmpty($count)){
                                    echo "<div class='header__cart-list header__cart--no-item'>
                                        <img src='./img/emptycart.svg' alt='Giỏ hàng trống' class='header__cart-no-cart-img'>
                                        <span class='header__cart-list-no-cart-msg'>Chưa có sản phẩm</span>
                                    <?div>";
                                }else{
                                    echo "<div class='header__cart-list'>
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
                                                echo "<li class='header__cart-item'>
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
                            <li class="path-link ">Tài khoản cá nhân</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                <div class="last-section">
                    <div class='grid wide'>
                        <div class='row'>
                            <div class='col l-3'>
                                <div class='user__nav'>
                                    <div class='user-nav__item user-nav__item--active'>
                                        <i class="header__icon bi bi-person"></i>
                                        <span class='user-nav__text'>Thông tin tài khoản</span>
                                    </div>
                                    <div class='user-nav__item'>
                                        <i class="header__icon bi bi-clipboard-check"></i>
                                        <span class='user-nav__text'>Quản lý đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col l-9'>
                                <div class="user-account__content user-account__content--active">
                                    <div class="row">
                                        <div class='col l-7'>
                                            <div class='user-account__info'>
                                                <div class='heading'>
                                                    <div class = 'heading__text' >Thông tin tài khoản</div>
                                                </div>
                                                <div class='user-account__form'>
                                                    <?php
                                                        $tableUser = 'user';
                                                        $column = 'user_id';
                                                        $userRow = getRowWithValue( $tableUser, $column, $user_id);
                                                    echo "<div class = 'form__item'>
                                                        <p class = 'form__label'>Họ và tên</p>
                                                        <input id = 'user-name' name = 'user-name' class = 'form__input' type='text' disabled placeholder='".$userRow['user_name']."'>
                                                    </div>
                                                    <div class = 'form__item'>
                                                        <p class = 'form__label'>Email</p>
                                                        <input id = 'user-email' name = 'user-email' class = 'form__input' type='text' disabled placeholder='".$userRow['user_email']."'>
                                                    </div>
                                                    <div class = 'form__item'>
                                                        <p class = 'form__label'>Số điện thoại</p>
                                                        <input id = 'user-phone' name = 'user-phone' class = 'form__input' type='text' disabled placeholder='".$userRow['user_phone']."'>
                                                    </div>";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            if(!isset($_SESSION['img_url'])){
                                                echo "
                                                <div class='col l-5'>
                                                    <div class='user-account__password'>
                                                        <div class='heading'>
                                                            <div class = 'heading__text'>Đổi mật khẩu</div>
                                                            <div id='password-change__notify'></div>
                                                        </div>
                                                        <form class='user-account__form' id='change-password-form'>
                                                            <div class = 'form__item'>
                                                                <p class = 'form__label'>Mật khẩu cũ <span class = 'must-input-icon'>(*)</span></p>
                                                                <input id = 'current-password' name = 'current-password' class = 'form__input' type='password' required onkeyup='checkedPassword();'>
                                                            </div>
                                                            <div class = 'form__item'>
                                                                <p class = 'form__label'>Mật khẩu mới <span class = 'must-input-icon'>(*)</span></p>
                                                                <input id = 'new-password' name = 'new-password' class = 'form__input' type='password' required minlength='8' placeholder='Phải có độ dài lớn hơn 7 kí tự' onkeyup='checkedPassword();'>
                                                            </div>
                                                            <div class = 'form__item '>
                                                                <div class='with-spacebetween-icon'>
                                                                    <p class = 'form__label'>Nhập lại mật khẩu mới <span class = 'must-input-icon'>(*)</span></p>
                                                                    <div class='status-icon'>
                                                                    </div>
                                                                </div>
                                                                <input id = 'new-password-checked' name = 'new-password-checked' class = 'form__input' type='password' required autocomplete='on' placeholder='Phải có độ dài lớn hơn 7 kí tự' onkeyup='checkedPassword();' minlength='8'>
                                                            </div>
                                                            <div class='update-input__field'>
                                                                <div id='change-password' class='btn btn--disabled' disabled type='submit' onclick='changePasswordStatus();'>Đổi mật khẩu</div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="user-account__content">
                                    <div class="user-account__order">
                                        <div class='heading'>
                                            <div class="grid">
                                                <div class="row no-gutters">
                                                    <div class='table__col-title col l-2'  >Mã đơn hàng</div>
                                                    <div class='table__col-title col l-4'  >Danh sách sản phẩm</div>
                                                    <div class='table__col-title col l-2'  >Ngày đặt hàng</div>
                                                    <div class='table__col-title col l-2'  >Tổng tiền</div>
                                                    <div class='table__col-title col l-2'  >Trạng thái</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='order__list-item' id='scrollbar'>
                                            <?php   
                                                $tableOrder = 'order';
                                                $getOrderRow = getAllRowWithValue($tableOrder, $column, $user_id);
                                                foreach ($row = $getOrderRow->fetchAll() as $value => $row){
                                                    echo "
                                                    <div class='row no-gutters info-order__item'>
                                                        <a class='col l-2' href='submit-checkout.php?order_id=" . $row['order_id'] . "'>
                                                        ". $row["order_id"] ."</a>
                                                        <p class='col l-4' >".$row["list_product"]."</p>
                                                        <p class='col l-2' >".date("d-m-Y h:i A", strtotime($row['order_date']))."</p>
                                                        <p class='col l-2' >". number_format($row["amount"], 0, ',', '.') ." đ</p>
                                                        <p class='col l-2' >Đã được xác nhận</p>
                                                    </div>"; 
                                                }
                                            ?>
                                        </div> 
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
    <script src="js/changePassword.js"></script>
    <script src="js/main.js"></script>
    <script>
        const $ = document.querySelector.bind(document);
        const $$ = document.querySelectorAll.bind(document);
        const fields = $$('.user-account__content');
        const items = $$('.user-nav__item');
        items.forEach((item, index) => {
            const field = fields[index];
            item.onclick = function () {
                $('.user-nav__item.user-nav__item--active').classList.remove('user-nav__item--active');
                $('.user-account__content.user-account__content--active').classList.remove('user-account__content--active');
                field.classList.add('user-account__content--active');
                this.classList.add('user-nav__item--active');
            }
        });
        function checkedPassword(){
            var currentPassword = document.getElementById('current-password');
            var newPassword = document.getElementById('new-password');
            var newCheckedPassword = document.getElementById('new-password-checked');
            var minLengthPw = 8;


            if(passwordForm(currentPassword, minLengthPw) && 
                passwordForm(newPassword, minLengthPw) && 
                passwordForm(newCheckedPassword, minLengthPw)) {

                if(newPassword.value === newCheckedPassword.value) {
                    document.getElementsByClassName('status-icon')[0].innerHTML = '<i class="fas fa-check-circle auth__form--success"></i>';

                    document.getElementById("change-password").removeAttribute("disabled");
                    document.getElementById("change-password").classList.remove('btn--disabled');
                }
                else{
                    document.getElementsByClassName('status-icon')[0].innerHTML = '';
                    document.getElementById("change-password").classList.add('btn--disabled');
                }
            }
            else {

                document.getElementById("change-password").classList.add('btn--disabled');
            }
        }
        function passwordForm(password, minLength){
            if (password.value.length >= minLength) return true;
            return false;
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
>>>>>>> Stashed changes
</html>