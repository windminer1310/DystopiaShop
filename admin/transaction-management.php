<?php
    require_once('../display-function.php');
    require_once('../database/connectDB.php');
    session_start();

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
        $author = $_SESSION['authority'];
    }
    else{
        header('Location: admin-login.html');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>

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
        <link href="../css/grid.css" rel="stylesheet" >
        <link href="../css/home.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/admin.css" rel="stylesheet">
    </head>

    <body>        
        
        <!-- Header Start -->
        <header class="header">
            <div class="grid wide">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./admin.php" class="header__logo-link">
                            <img src="../img/logo.png" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="./admin.php" class="header__link">
                            QUẢN LÝ NHÂN SỰ
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="./transaction-management.php" class="header__link header__link--active">
                            QUẢN LÝ ĐƠN HÀNG
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="./product-management.php" class="header__link">
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
                    <li class="path-link"><a href="">QUẢN LÝ ĐƠN HÀNG</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <div class='featured-product padding__map'>
            <div class='grid wide'>
                <div class=' row'>
                    <div class='col l-3'>
                        <div class='feild-user__nav'>
                            <div class='header-user-nav__item'>
                                <i class="header__icon bi bi-card-list"></i>
                                <span class='text-user__account'>Quản lý đơn hàng</a></span>
                            </div>
                        </div>
                    </div>
                    <div class='col l-9 field-user__account field-user__account--active'>
                        <div class='header-user__account' style="display: flex; justify-content:space-between;">
                            <div class = 'header__text-field' >Đơn hàng</div>
                                <select onchange="location = this.value;">
                                    <option value="transaction-management.php">Tất cả đơn hàng</option>
                                    <?php   
                                        $arrayOrderStatusFilter = ['finish', 'not-finish'];
                                        $arrayOrderNameFilter = ['Đã hoàn thành', 'Chưa hoàn thành'];
                                        $totalStatus = count($arrayOrderStatusFilter);
                                        
                                        if(!isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                            for($i = 0; $i < $totalStatus; $i++){
                                                echo "<option value='transaction-management.php?order_status=".
                                                $arrayOrderStatusFilter[$i]."'>".$arrayOrderNameFilter[$i]."</option>";
                                            }
                                        }
                                        if(isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                            for($i = 0; $i < $totalStatus; $i++){
                                                echo "<option value='transaction-management.php?order_status=".
                                                $arrayOrderStatusFilter[$i]."&sort_day=".$_GET['sort_day']."'>".$arrayOrderNameFilter[$i]."</option>";
                                            }
                                        }
                                        if(!isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                            for($i = 0; $i < $totalStatus; $i++){
                                                if($arrayOrderStatusFilter[$i] == $_GET['order_status']){
                                                    echo "<option selected value='transaction-management.php?order_status=".
                                                    $arrayOrderStatusFilter[$i]."'>".$arrayOrderNameFilter[$i]."</option>";
                                                }
                                                else{
                                                    echo "<option value='transaction-management.php?order_status=".
                                                    $arrayOrderStatusFilter[$i]."'>".$arrayOrderNameFilter[$i]."</option>";
                                                }
                                            }
                                        }
                                        if(isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                            for($i = 0; $i < $totalStatus; $i++){
                                                if($arrayOrderStatusFilter[$i] == $_GET['order_status']){
                                                    echo "<option selected value='transaction-management.php?order_status=".
                                                    $arrayOrderStatusFilter[$i]."&sort_day=".$_GET['sort_day']."'>".$arrayOrderNameFilter[$i]."</option>";
                                                }
                                                else{
                                                    echo "<option value='transaction-management.php?order_status=".
                                                    $arrayOrderStatusFilter[$i]."&sort_day=".$_GET['sort_day']."'>".$arrayOrderNameFilter[$i]."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <select onchange="location = this.value;">
                                    <option value="transaction-management.php">Thời gian</option>
                                    <?php   
                                        $arrayDateFilter = [30, 7, 1];
                                        $total = count($arrayDateFilter);
                                        
                                        if(!isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                            for($day = 0; $day < $total; $day++){
                                                echo "<option value='transaction-management.php?sort_day=".
                                                $arrayDateFilter[$day]."'>".$arrayDateFilter[$day]."</option>";
                                            }
                                        }
                                        if(isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                            for($day = 0; $day < $total; $day++){
                                                if($arrayDateFilter[$day] == $_GET['sort_day']){
                                                    echo "<option selected value='transaction-management.php?sort_day=".$arrayDateFilter[$day]."'>".
                                                    $arrayDateFilter[$day]."</option>";
                                                }
                                                else{
                                                    echo "<option value='transaction-management.php?sort_day=".$arrayDateFilter[$day]."'>".
                                                    $arrayDateFilter[$day]."</option>";
                                                }
                                            }
                                        }
                                        if(!isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                            for($day = 0; $day < $total; $day++){
                                                echo "<option value='transaction-management.php?sort_day=".
                                                $arrayDateFilter[$day]."&order_status=".$_GET['order_status']."'>".$arrayDateFilter[$day]."</option>";
                                            }
                                        }
                                        if(isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                            for($day = 0; $day < $total; $day++){
                                                if($arrayDateFilter[$day] == $_GET['sort_day']){
                                                    echo "<option selected value='transaction-management.php?sort_day=".$arrayDateFilter[$day]."&order_status=".$_GET['order_status']."'>".
                                                    $arrayDateFilter[$day]."</option>";
                                                }
                                                else{
                                                    echo "<option value='transaction-management.php?sort_day=".$arrayDateFilter[$day]."&order_status=".$_GET['order_status']."'>".
                                                    $arrayDateFilter[$day]."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                        </div>
                        <div class='list-info-order'>
                            <div class='header-info-order'>
                                <div class='header-text-order__item id-order__item'  >Mã đơn hàng</div>
                                <div class='header-text-order__item product-order__item'>Mã sản phẩm</div>
                                <div class='header-text-order__item date-order__item'  >Ngày đặt</div>
                                <div class='header-text-order__item address-order__item'  >Địa chỉ</div>
                                <div class='header-text-order__item price-order__item'  >Tổng tiền</div>
                                <div class='header-text-order__item status-order__item'  >Trạng thái</div>
                            </div>
                            <?php   
                                $tableTransaction = 'transaction';
                                $column = 'status';

                                // $zz = getAllTransactionNotCompletedForDays($tableTransaction, $column, 1)->rowCount();
                                if(isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                    $getTransactiontRow = getAllTransactionNotCompletedForDays($tableTransaction, $column, $_GET['sort_day']);
                                }
                                if(!isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                    $getTransactiontRow = getAllTransactionWithStatus($tableTransaction, $column, $_GET['order_status']);
                                }
                                if(!isset($_GET['sort_day']) && !isset($_GET['order_status'])){
                                    $getTransactiontRow = getRowWithTable($tableTransaction);
                                }
                                if(isset($_GET['sort_day']) && isset($_GET['order_status'])){
                                    $getTransactiontRow = getAllTransactionWithStatusAndDate($tableTransaction, $column,$_GET['order_status'], $_GET['sort_day']);
                                }
                                foreach ($row = $getTransactiontRow->fetchAll() as $value => $row){
                                    echo "<div class='info-order__item'>
                                        <a class='text-order__item id-order__item' href='checkout-transaction.php?id_transaction=" . $row['transaction_id'] . "'>
                                        ". $row["transaction_id"] ."
                                        </a>
                                        <span class='text-order__item product-order__item' >". $row['product_id'] ."</span>";
                                        $dateTime = explode( ' ', $row["date"]);
                                        echo "<span class='text-order__item date-order__item' >". dayOfDate($dateTime[0]).", ".$dateTime[1]."  ". dateFormat($dateTime[0])."</span>
                                        <span class='text-order__item address-order__item' >". displayAddress($row['address'])."</span>
                                        <span class='text-order__item price-order__item product-cart__current-price' >". number_format($row["payment"], 0, ',', '.') ." đ</span>
                                        <div class='info-btn btn btn--text-size status-order__item' >".$row['status']."</div>
                                    </div>";
                                }
                            ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <script>
            // if(location.search == "?ga"){
            //     console.log(1);
            // }
            // else {
            //     console.log(2);
            // }
            console.log(location.search);
        </script>
    </body>
</html>