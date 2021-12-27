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
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/grid.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
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
                        <a href="admin.php" class="header__link">
                            QUẢN LÝ NHÂN SỰ
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="transaction-management.php" class="header__link">
                            QUẢN LÝ ĐƠN HÀNG
                        </a>
                    </div>
                    <div class="header__item">
                        <a href="product-management.php" class="header__link header__link--active">
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
                    <li class="path-link"><a href="">CẬP NHẬT LOẠI SẢN PHẨM VÀ THƯƠNG HIỆU</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <div class='featured-product'>
            <div class='grid wide'>
                <div class=' row'>
                    <div class='col l-3'>
                        <div class='feild-user__nav'>
                            <div class='header-user-nav__item'>
                                <i class="header__icon bi bi-card-list"></i>
                                <span class='text-user__account'>Loại sản phẩm & thương hiệu</a></span>
                            </div>
                        </div>
                    </div>
                    <div class='col l-9'>
                        <div class=" field-user__account field-user__account--active">
                            <div>
                                <div class='header-user__account'>
                                    <div class = 'header__text-field' >Loại sản phẩm</div>
                                </div>
                                <form action="">
                                    <div class="add-admin-form">
                                        <div class="row">
                                            <div class='input-element col l-4'>
                                                <ul id='scrollbar' class='list-name'>
                                                    <?php 
                                                        $categoryRow = getRowWithTable('category');
                                                        foreach ($row = $categoryRow->fetchAll() as $value => $row){
                                                            echo "<li id='".$row['category_id']."' class='list-name__item list--category-name' >".$row['category_id']." - ".$row['category_name']."</li>";
                                                        }           
                                                    ?>
                                                </ul>
                                            </div>
                                            <form method="GET">
                                                <div class='input-element col l-4' >
                                                    <p class = 'title-input'>Mã loại sản phẩm</p>
                                                    <input class = 'input__field'  id="category_id" name="category_id" required >
                                                </div>
                                                <div class='input-element col l-4' >
                                                    <p class = 'title-input'>Tên loại sản phẩm</p>
                                                    <input class = 'input__field'  id="category_name" name="category_name" required >
                                                    <div class="row">
                                                        <div class="col l-6">
                                                            <div class='submit-btn'>
                                                                <input class='btn btn--full-width' type='submit' value="Thêm">
                                                            </div>
                                                        </div>
                                                        <div class="col l-6">
                                                            <div class='submit-btn'>
                                                                <a class='btn btn--full-width btn--white' id='delete-category' type='submit' >Xóa</a>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                            if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['category_id']) && isset($_GET['category_name'])) {
                                                                $addCategory = addTableWithTwoValue('category', 'category_id', $_GET['category_id'], 'category_name', $_GET['category_name']);
                                                                if($addCategory){
                                                                    echo "<script>alert('Cập nhật loại sản phẩm thành công!');
                                                                        window.location.href = 'update-product-category-brand.php'
                                                                    </script>";
                                                                }
                                                                else{
                                                                    echo "<script>alert('Cập nhật loại sản phẩm thất bại!');
                                                                    window.location.href = 'update-product-category-brand.php'
                                                                    </script>";
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> 
                                </form>             
                            </div>
                            <div style="margin-top: 24px;">
                                <div class='header-user__account'>
                                    <div class = 'header__text-field' >Thương hiệu</div>
                                </div>   
                                <form method="GET">
                                    <div class="add-admin-form">
                                        <div class="row">
                                                <div class='input-element col l-4'>
                                                    <ul id='scrollbar' class='list-name'>
                                                        <?php 
                                                            $brandRow = getRowWithTable('brand');
                                                            foreach ($row = $brandRow->fetchAll() as $value => $row){
                                                                echo "<li id='".$row['brand_id']."' class='list-name__item list--brand-name'>".$row['brand_id']." - ".$row['brand_name']."</li>";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class='input-element col l-4' >
                                                    <p class = 'title-input'>Mã thương hiệu</p>
                                                    <input class = 'input__field'  id="brand_id" name="brand_id" required >
                                                </div>
                                                <div class='input-element col l-4' >
                                                    <p class = 'title-input'>Tên thương hiệu</p>
                                                    <input class = 'input__field'  id="brand_name" name="brand_name" required >
                                                    <div class="row">
                                                        <div class="col l-6">
                                                            <div class='submit-btn'>
                                                                <input class='btn btn--full-width' type='submit' value="Thêm">
                                                            </div>
                                                        </div>
                                                        <div class="col l-6">
                                                            <div class='submit-btn'>
                                                                <a id="delete-brand" class='btn btn--full-width btn--white' type='submit'>Xóa</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <?php 
                                                if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['brand_id']) && isset($_GET['brand_name'])) {
                                                    $addBrand = addTableWithTwoValue('brand', 'brand_id', $_GET['brand_id'], 'brand_name', $_GET['brand_name']);
                                                    if($addBrand){
                                                        echo "<script>alert('Cập nhật thương hiệu sản phẩm thành công!');
                                                        window.location.href = 'update-product-category-brand.php'
                                                        </script>";
                                                    }
                                                    else{
                                                        echo "<script>alert('Cập nhật thương hiệu sản phẩm thất bại!');
                                                        window.location.href = 'update-product-category-brand.php'
                                                        </script>";
                                                    }
                                                }
                                            ?>
                                        </div> 
                                    </div>    
                                </form>                  
                            </div>         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            const listCategorys = $$('.list--category-name');
            listCategorys.forEach((category, index) => {
                category.onclick = function () {

                    if( $('.list--category-name.list-name__item--active') != null){
                        $('.list--category-name.list-name__item--active').classList.remove('list-name__item--active');
                    }
                    this.classList.add('list-name__item--active')

                    var deleteCategoryId = 'delete-product-category-brand.php?category_id=' + this.id;

                    var deleteBtn = document.getElementById('delete-category');
                    deleteBtn.href = deleteCategoryId;
                }
            });

            const listBrands = $$('.list--brand-name');
            listBrands.forEach((brand, index) => {
                brand.onclick = function () {
                    if( $('.list--brand-name.list-name__item--active') != null){
                        $('.list--brand-name.list-name__item--active').classList.remove('list-name__item--active');
                    }
                    this.classList.add('list-name__item--active')

                    var deleteBrandId = 'delete-product-category-brand.php?brand_id=' + this.id;

                    var deleteBtn = document.getElementById('delete-brand');
                    deleteBtn.href = deleteBrandId;
                }
            });
        </script>
    </body>
</html>