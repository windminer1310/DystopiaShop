<?php
    session_start();
    require_once('display-function.php');
    require_once('shop_info/shop-info.php');
    require_once('database/connectDB.php');


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
        headToIndexPage();
    }

    $id_transaction = $_GET['id_transaction'];
    
    $transactionTable = 'transaction';
    $userColumn = 'user_id';
    $transactionColumn = 'transaction_id';


    $userHaveTransaction = getRowWithTwoValue($transactionTable, $userColumn, $user_id , $transactionColumn, $id_transaction);

    if(!$userHaveTransaction) {
        header('Location: my-account.php');
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
        <link href="css/home.css" rel="stylesheet">
        <link href="css/base.css" rel="stylesheet">
    </head>

    <body>
        
     <!-- Header Start -->
     <header class="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./user-login.php" class="header__logo-link">
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

                    <!-- Đã đăng nhập -->
                    <div class="header__item">
                        <a class="header__icon-link" href="">
                            <i class="header__icon bi bi-clipboard-check"></i>
                        </a>
                        <a href="" class="header__link header__user-orders">Đơn hàng</a>
                    </div>
                    
                    <div class="header__item header__user">
                    <?php 
                        if(!isset($_SESSION['img_url'])){
                            echo "<a class='header__icon-link' href=''>
                                <i class='header__icon bi bi-person'></i>
                            </a>
                            <a href='' class='header__link header__user-login'>". $name ."</a>";
                        }
                        else {
                            echo "<a class='header__icon-link' href=''>
                                <img class = 'header__avatar-img' src=". $_SESSION['img_url'] .">
                            </a>
                            <a href='' class='header__link header__user-login'>". $name ."</a>";
                        }
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


                </div>
            </div>
        </header>
        <!-- Header End -->
        
        <!-- Breadcrumb Start -->
        <div class="homepage">
            <div class="grid wide">
                <ul class="path-homepage">
                    <li class="path-link "><a href="user-login.php">Trang chủ</a></li>
                    <li class="path-link ">></li>
                    <li class="path-link ">Tài khoản cá nhân</a></li>
                    <li class="path-link ">></li>
                    <li class="path-link " >CHI TIẾT ĐƠN HÀNG: <?php echo $id_transaction; ?></a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <div class='product featured-product padding__map'>
            <div class='grid wide'>
                <div class='row'>
                <div class='col l-7'>
                        <div class='header-product-cart'>
                            <span class = 'header__text-field' >Thông tin Sản phẩm</span>
                            <span class = 'product-item__current-price totalPrice'></span>
                        </div>
                        <?php
                            echo "<div class='list-product-cart'>";
                            $productsID = explode( '-', $userHaveTransaction["product_id"]);  
                            $amountOfProducts = explode( '-', $userHaveTransaction["amount"]); 
                            $totalPrice = 0;

                            for ($i = 0; $i < count($productsID) ; $i++){

                                $id_product = $productsID[$i];
                                $tableName = 'product';
                                $column = 'product_id';

                                $productInfo = getRowWithValue( $tableName, $column, $id_product);

                                echo "<div class='product-cart__item'>
                                    <a href='product-detail.php?id=".$productInfo['product_id']."'><img class='product-img__cart-page' src='" . $productInfo['image_link'] . "' alt='Image'></a>
                                    <div class='product-info__cart-page'>
                                        <a class='product-name__cart-page' href='product-detail.php?id=".$productInfo['product_id']."'>
                                            ".$productInfo['product_name']."
                                        </a>
                                        <div class='product-brand__cart-page'>Thương hiệu<a href='' class='product-brand__text'>".$productInfo['brand_id']."</a></div>
                                    </div>
                                    <div class='product-quantity__cart-page'>".$amountOfProducts[$i]."</div>
                                    
                                    <div class='product-price__cart-page'>";
                                        if($productInfo['discount'] == 0){
                                            $totalPrice += $productInfo['price']*$amountOfProducts[$i];
                                            echo "<span class = 'product-cart__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                        }
                                        else{
                                            $discountPrice = $productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01);
                                            $totalPrice += $discountPrice*$amountOfProducts[$i];

                                            echo "<span class = 'product-cart__current-price'>" . number_format($discountPrice, 0, ',', '.') . " ₫</span>
                                            <span class = 'product-cart__original-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                        }

                                    echo "</div>
                                </div>";
                            }
                        echo "</div>";
                        ?>
                    </div>
                    <div class='col l-5'>
                        <div >
                            <div class='header-product-cart'>
                                <span class = 'header__text-field' >Thông tin đơn hàng</span>
                            </div>
                            <div class='user-info__order'> 
                                <?php
                                    echo "<div class='info__order'>
                                    <span class = 'header-text-order__item'>Trạng thái đơn hàng:</span>
                                    <span class='text-order__item'>".$userHaveTransaction['status']."</span>
                                    </div>
                                    <div class='info__order'>
                                        <span class = 'header-text-order__item'>Thời gian:</span>";
                                        $dateTime = explode( ' ', $userHaveTransaction["date"]);
                                        echo "<span class='text-order__item'>". dayOfDate($dateTime[0]).", ".$dateTime[1]."  ". dateFormat($dateTime[0])."</span>
                                    </div>";
                                ?>

                            </div>
                        </div>
                        <div>
                            <div class='header-product-cart'>
                                <span class = 'header__text-field' >Thông tin người nhận</span>
                            </div>
                            <?php
                                echo "<div class='user-info__order'> 
                                    <div class='info__order'>
                                        <span class = 'header-text-order__item'>Họ tên người nhận:</span>
                                        <span class='text-order__item'>".$userHaveTransaction['user_name']."</span>
                                    </div>
                                    <div class='info__order'>
                                        <span class = 'header-text-order__item'>Hình thức giao hàng:</span>
                                        <span class='text-order__item'>Viet hoang</span>
                                    </div>
                                    <div class='info__order'>
                                        <span class = 'header-text-order__item'>Địa chỉ:</span>
                                        <span class='text-order__item'>".displayAddress($userHaveTransaction['address'])."</span>
                                    </div>
                                    <div class='info__order'>
                                        <span class = 'header-text-order__item'>Số điện thoại:</span>
                                        <span class='text-order__item'>".$userHaveTransaction['user_phone']."</span>
                                    </div>
                                </div>";
                            ?>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>                   
        
    
        
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

