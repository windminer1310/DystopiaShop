<?php
    session_start();
    require_once('../database/connectDB.php');

	if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
    };
    
    $productInfo = getRowWithValue('product', 'product_id', $product_id);

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
                    <li class="path-link"><a href="">CẬP NHẬT SẢN PHẨM</a></li>
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
                                <span class='text-user__account'>Quản lý</a></span>
                            </div>
                            <div class='user-nav__item user-nav__item-active'>
                                <i class="header__icon bi bi-bookmark-dash"></i>
                                <span class='text-user__account'>Cập nhật sản phẩm</span>
                            </div>
                            <div class='user-nav__item'>
                                <i class="header__icon bi bi-bookmark-plus"></i>
                                <span class='text-user__account'>Thêm sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class='col l-9'>
                        <div class=" field-user__account field-user__account--active">
                            <div class='header-user__account'>
                                <div class = 'header__text-field' >Cập nhật sản phẩm:</div>
                                <div class = 'header__id-product-field'> <?php echo $productInfo['product_id']; ?></div>
                            </div>
                            <form action="./modify-product.php" method="$_GET">
                                <div class="add-admin-form">
                                    <div class="row">
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Loại sản phẩm</p>
                                            <?php
                                                $categoryName = getRowWithValue('category', 'category_id', $productInfo['category_id']);
                                                echo "<input class = 'input__field' list='categories' name='category'  value='".$categoryName['category_name']."'>
                                                <datalist id='categories'>";

                                                $getCategoriesRow = getRowWithColumnOrderBy( 'category', 'category_name');
                                                foreach ($row = $getCategoriesRow->fetchAll() as $value => $row){
                                                    echo "<option value='".$row['category_name']."'>";
                                                }
                                                echo "</datalist>";
                                            ?>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Thương hiệu</p>
                                            <?php
                                                $brandName = getRowWithValue('brand', 'brand_id', $productInfo['brand_id']);
                                                echo "<input class = 'input__field' list='brands' name='brand' id='brand' value='".$brandName['brand_name']."'>
                                                <datalist id='brands'>";

                                                $getBrandsRow = getRowWithColumnOrderBy( 'brand', 'brand_name');
                                                foreach ($row = $getBrandsRow->fetchAll() as $value => $row){
                                                    echo "<option value='".$row['brand_name']."'>";
                                                }
                                                echo "</datalist>";
                                            ?>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Mã sản phẩm</p>
                                            <input class = 'input__field'  id="product_id" name="product_id" required value='<?php echo $productInfo['product_id'] ?>'>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='input-element col l-4' >
                                            <p class = 'title-input'>Tên sản phẩm</p>
                                            <input class = 'input__field'  id="product_name" name="product_name" required value='<?php echo $productInfo['product_name'] ?>'>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Năm phát hành</p>
                                            <input class = 'input__field'  id="date_first_available" name="date_first_available" required value='<?php echo $productInfo['date_first_available'] ?>'>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Giá (đã có VAT)</p>
                                            <input class = 'input__field'  id="price" name="price" required value='<?php echo $productInfo['price'] ?>'>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Giảm giá (%)</p>
                                            <input class = 'input__field'  id="discount" name="discount" required value='<?php echo $productInfo['discount'] ?>'>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Số lượng trong kho</p>
                                            <input class = 'input__field'  id="amount" name="amount" required value='<?php echo $productInfo['amount'] ?>'>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Nguồn ảnh</p>
                                            <input class = 'input__field'  id="image_link" name="image_link" required value='<?php echo $productInfo['image_link'] ?>'>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='input-element col l-8'>
                                            <p class = 'title-input'>Mô tả sản phẩm</p>
                                            <textarea class = 'textarea__field'  id="description" name="description" ><?php echo $productInfo['description'] ?></textarea>
                                        </div>

                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Mô tả sản phẩm</p>
                                            <!-- <img src="../img/LAPTOP/ACER/1810659/1.png" alt=""> -->
                                        </div>
                                    </div>
                                    <div class='submit-btn'>
                                        <input id='' class='btn' type='submit' value="Cập nhật">
                                        <?php 
                                            echo "<div onclick='deleteProductWarning(".$productInfo['product_id'].")' id='' class='btn' >Xóa</div>";
                                        ?>
                                        <a href="import-excel-file.php" class='btn btn--white'>Nhập từ Excel</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class=" field-user__account">
                            <div class='header-user__account'>
                                <div class = 'header__text-field' >Thêm sản phẩm</div>
                            </div>
                            <div class="add-admin-form">
                                <form action="add-new-product.php" method="$_GET">
                                    <div class="row">
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Loại sản phẩm</p>
                                            <?php
                                                echo "<input class = 'input__field' list='categories' name='category' id='category' required>
                                                <datalist id='categories'>";

                                                $getCategoriesRow = getRowWithColumnOrderBy( 'category', 'category_name');
                                                foreach ($row = $getCategoriesRow->fetchAll() as $value => $row){
                                                    echo "<option value='".$row['category_name']."'>";
                                                }
                                                echo "</datalist>";
                                            ?>
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Thương hiệu</p>
                                            <?php
                                                echo "<input class = 'input__field' list='brands' name='brand' id='brand' required>
                                                <datalist id='brands'>";

                                                $getBrandsRow = getRowWithColumnOrderBy( 'brand', 'brand_name');
                                                foreach ($row = $getBrandsRow->fetchAll() as $value => $row){
                                                    echo "<option value='".$row['brand_name']."'>";
                                                }
                                                echo "</datalist>";
                                            ?>
                                        </div>

                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Mã sản phẩm</p>
                                            <input class = 'input__field'  id="product_id" name="product_id" required>
                                        </div>
                                     </div>

                                    <div class="row">
                                        <div class='input-element col l-4' >
                                            <p class = 'title-input'>Tên sản phẩm</p>
                                            <input class = 'input__field'  id="product_name" name="product_name" required >
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Năm phát hành</p>
                                            <input class = 'input__field'  id="date_first_available" name="date_first_available" required >
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Giá (đã có VAT)</p>
                                            <input class = 'input__field'  id="price" name="price" required >
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Giảm giá (%)</p>
                                            <input class = 'input__field'  id="discount" name="discount" required >
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Số lượng trong kho</p>
                                            <input class = 'input__field'  id="amount" name="amount" required >
                                        </div>
                                        <div class='input-element col l-4'>
                                            <p class = 'title-input'>Nguồn ảnh</p>
                                            <input class = 'input__field'  id="image_link" name="image_link" required >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='input-element col l-8'>
                                            <p class = 'title-input'>Mô tả sản phẩm</p>
                                            <textarea class = 'textarea__field'  id="description" name="description" ></textarea>
                                        </div>
                                    </div>
                                    <div class='submit-btn'>
                                        <input class='btn' type='submit' value="Thêm">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
        <script>
            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            const fields = $$('.field-user__account');
            const items = $$('.user-nav__item');

            items.forEach((item, index) => {
                const field = fields[index];

                item.onclick = function () {
                    $('.user-nav__item.user-nav__item-active').classList.remove('user-nav__item-active');
                    $('.field-user__account.field-user__account--active').classList.remove('field-user__account--active');

                    field.classList.add('field-user__account--active');
                    this.classList.add('user-nav__item-active');
                }
            });

            function deleteProductWarning($id){
                if (confirm('Bạn có muốn tiếp tục xóa sản phẩm '+ $id)) {
                    window.location.href = './delete-product.php?product_id='+$id;
                }
            }
        </script>
    </body>
</html>