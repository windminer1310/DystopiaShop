<?php
    session_start();
    
    require_once('../database/connectDB.php');
    require_once('../display-function.php');

    if(isset($_SESSION['admin_name']) && isset($_SESSION['admin_id']) && isset($_SESSION['authority'])){
        $eachPartName = preg_split("/\ /",$_SESSION['admin_name']);
        $countName = count($eachPartName);
        if($countName == 1){
            $name = $eachPartName[$countName-1];
        }
        else{
            $name = $eachPartName[$countName-2] . " " . $eachPartName[$countName-1];
        }
        $user_id = $_SESSION['admin_id'];
    }
    else{
        header('Location: admin-login.html');
    }

    $id_transaction = $_GET['id_transaction'];
    $transactionTable = 'transaction';
    $transactionColumn = 'transaction_id';
    $transaction = getRowWithValue($transactionTable, $transactionColumn, $id_transaction);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>

        <!-- Favicon -->
        <link href="../img/favicon.ico" rel="icon">

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
        <link rel="stylesheet" href="../css/grid.css">

        <!-- <link href="css/style.css" rel="stylesheet"> -->
        <link href="../css/home.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
    </head>

    <body>
        
        <!-- Header Start -->
        <header class="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./user-login.php" class="header__logo-link">
                            <img src="../img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="admin.php" class="header__link">
                            QUẢN LÝ NHÂN SỰ
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="transaction-management.php" class="header__link header__link--active">
                            QUẢN LÝ ĐƠN HÀNG
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="product-management.php" class="header__link">
                            QUẢN LÝ SẢN PHẨM
                        </a>
                    </div>
                    
                    <div class="header__item header__user">
                        <a class='header__icon-link' href=''>
                            <i class='header__icon bi bi-person'></i>
                        </a>
                        <a href='' class='header__link header__user-login'><?php echo $name;?></a>
                        

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
                    <li class="path-link "><a href="transaction-management.php">QUẢN LÝ ĐƠN HÀNG</a></li>
                    <li class="path-link ">></li>
                    <li class="path-link " >CHI TIẾT ĐƠN HÀNG: <?php echo $id_transaction; ?></a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <div class='product featured-product'>
            <div class='grid wide'>
                <div class='row'>
                <div class='col l-7'>
                    <div>
                        <div class='header-product-cart'>
                            <span class = 'header__text-field' >Thông tin Sản phẩm</span>
                            <span class = 'product-item__current-price totalPrice'></span>
                        </div>
                        <?php
                            echo "<div class='list-product-cart'>";
                            $productsID = explode( '-', $transaction["product_id"]);  
                            $amountOfProducts = explode( '-', $transaction["amount"]); 
                            $totalPrice = 0;
                            for ($i = 0; $i < count($productsID) ; $i++){
                                $id_product = $productsID[$i];
                                $tableName = 'product';
                                $column = 'product_id';

                                $productInfo = getRowWithValue( $tableName, $column, $id_product);
                                echo "<div class='product-cart__item'>
                                    <a href='update-product.php?id=".$productInfo['product_id']."'><img class='product-img__cart-page' src='../" . $productInfo['image_link'] . "' alt='Image'></a>
                                    <div class='product-info__cart-page'>
                                        <a class='product-name__cart-page' href='update-product.php?id=".$productInfo['product_id']."'>
                                            ".$productInfo['product_name']."
                                        </a>";
                                        echo "<div class='product-brand__cart-page'>Thương hiệu<a href='' class='product-brand__text'>".$productInfo['brand_id']."</a></div>
                                    </div>
                                    <div class='product-quantity__cart-page'>".$amountOfProducts[$i]."</div>
                                    <div class='product-price__cart-page'>";
                                            $totalPrice += $productInfo['price']*$amountOfProducts[$i];
                                            echo "<span class = 'product-cart__current-price'>" . number_format($productInfo['price'], 0, ',', '.') . " ₫</span>";
                                    echo "</div>
                                </div>";
                            }
                        echo "</div>";
                        ?>
                    </div>
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
                                <span class='text-order__item'>".$transaction['status']."</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Thời gian:</span>";
                                    $dateTime = explode( ' ', $transaction["date"]);
                                    echo "<span class='text-order__item'>". dayOfDate($dateTime[0]).", ".$dateTime[1]."  ". dateFormat($dateTime[0])."</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Giảm giá:</span>";
                                    $totalDiscountPrice = $totalPrice - $transaction['payment'];
                                    echo "<span class='text-order__item'>-".number_format($totalDiscountPrice, 0, ',', '.')." ₫</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Thành tiền:</span>
                                    <span class='text-order__item product-cart__current-price'>".number_format($transaction['payment'], 0, ',', '.')." ₫</span>
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
                                    <span class='text-order__item'>".$transaction['user_name']."</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Hình thức giao hàng:</span>
                                    <span class='text-order__item'>Viet hoang</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Địa chỉ:</span>
                                    <span class='text-order__item'>".displayAddress($transaction['address'])."</span>
                                </div>
                                <div class='info__order'>
                                    <span class = 'header-text-order__item'>Số điện thoại:</span>
                                    <span class='text-order__item'>".$transaction['user_phone']."</span>
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
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
    </body>
</html>

