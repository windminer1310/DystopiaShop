<?php
    session_start();
    require_once('../database/connectDB.php');
    
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

    if($_SESSION['authority'] == 2){
        header('Location: transaction-management.php');
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

        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet" >
        <link href="../css/home.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/admin.css" rel="stylesheet">
    </head>
    <body>   
        <!-- Header Start -->
        <header class="header ">
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
                        <a href="./transaction-management.php" class="header__link">
                            QUẢN LÝ ĐƠN HÀNG
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="./product-management.php" class="header__link header__link--active">
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
                    <li class="path-link"><a href="">CẬP NHẬT SỐ LƯỢNG SẢN PHẨM</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <div class="featured-product">
            <div class='grid wide'>
                <div class='row'>
                    <div class='col l-4'>
                        <div>
                            <div class='heading'>
                                <div class="heading__text">Số lượng sản phẩm trong kho</div>
                            </div>
                            <div class="list-info-order">
                                <label class='label__data-list' for="product-qty">Chọn xem sản phẩm</label>
                                <input list="product-qty" name="product__data-list" id="product__data-list">
                                <datalist id="product-qty">
                                <?php 
                                    $tableProduct = 'product';
                                    $getProductRow = getRowWithTable($tableProduct);

                                    foreach ($row = $getProductRow->fetchAll() as $value => $row){
                                        echo "<option value='".$row['product_id']." - ".$row['amount']."'>";
                                    }        
                                ?>
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class='col l-8'>
                        <div>
                            <div class='heading-with-btn'>
                                <input type="file" id="input__file-location" accept=".xls, .xlsx">
                                <div class="btn btn--white" id="choose-file">Nhập</div>
                                <div class="btn" id='submit'>Cập nhật</div>
                            </div>
                            <div class="list-info-order">
                                <table id='table-data'></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='product__error-line' style="display: none;"></div>
    </body>
</html>

<script src="../js/updateProductQtyWithExcel.js"></script>
<script src="https://unpkg.com/read-excel-file@4.x/bundle/read-excel-file.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

