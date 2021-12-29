<?php
    session_start();
    require_once('../display-function.php');
    require_once('../database/connectDB.php');

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Không thể kết nối!");
        exit();
    }

    mysqli_set_charset($conn,"utf8");
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

    $search = NULL;
    if (isset($_GET['search']) && strlen($_GET['search']) == 0) {
        header('Location: product-management.php');
    }else if( isset($_GET['search'])){
        $search = $_GET['search'];
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
        <link href="../lib/slick/slick.css" rel="stylesheet">
        <link href="../lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet" >
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
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
                    <form class="header__search" method="get" action="product-management.php?">
                        <input type="text" class="header__search-input" placeholder="Tìm kiếm sản phẩm" name="search" value="<?php echo $search; ?>">
                        <button class="header__search-btn">
                            <i class="header__search-btn-icon bi bi-search" type="submit"></i>
                        </button>
                    </form>
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
                    <li class="path-link "><a href="user-login.php">QUẢN LÝ SẢN PHẨM</a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Product List Start -->
        <div id="product-view">
        <?php 
            $numProductInAPage = 20;
            $count_product = 0;

            $productTable = 'product';
            $allProducts = getRowWithTable($productTable);

            $totalProduct = $allProducts->rowCount();
            $totalPage = $totalProduct/$numProductInAPage;
                    
            if($totalPage > floor($totalPage)){
                for($count = 1; $count <= floor($totalPage)+1; $count++){
                    if($count == 1){
                        echo "<div class='product sale-product product-page__active'>";
                    }
                    else{
                        echo "<div class='product sale-product'>";
                    }
                echo "<div class='grid wide'>
                    <div class='section'>
                        <div class='section-title'>
                            Sản phẩm
                        </div>
                        <div class='product__list-item'>
                            <div class='row'> ";                            
                                    $sql = "SELECT * FROM `product`";
                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                        $sql = $sql . " WHERE product_name LIKE '%" . $search . "%' OR category_id = 
                                        (SELECT category_id FROM `category` WHERE category_name LIKE '%" . $search . "%') OR brand_id = 
                                        (SELECT brand_id FROM `brand` WHERE brand_name LIKE '%" . $search . "%') OR description LIKE '%" . $search . "%'";
                                    }
                                    $rs = $conn->query($sql);

                                    foreach ($conn->query($sql . " LIMIT ". $count_product . " , " .$numProductInAPage)->fetch_all(MYSQLI_ASSOC) as $value => $row) {
                                            echo "<div class='col l-10-2'>";
                                                echo "<a class='product-item' href='update-product.php?product_id=" . $row['product_id'] . "'>";  
                                                    if ($row['discount'] != 0) {
                                                        displayDiscountTagWithHtml($row['discount']);
                                                    }                                          
                                                    echo "<div class='product-item__img' style='background-image: url(../". $row['image_link'] .");'></div>"; 
                                                    echo "<h2 class = 'product-item__name'>" . $row['product_name'] . "</h2>";
                                                    echo "<div class='product-item__price'>";  
                                                        if ($row['discount'] != 0) {
                                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                                            echo "<span class = 'product-item__current-price'>" . number_format($discount, 0, ',','.') . " ₫</span>";
                                                            echo "<span class = 'product-item__original-price'>" .  number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                                        }
                                                        else{
                                                            echo "<span class = 'product-item__current-price'>" . number_format($row['price'], 0, ',', '.') . " ₫</span>";
                                                        }
                                                    echo "</div>";
                                                echo "</a>";
                                            echo "</div>";
                                            $count_product++;  
                                        }     
                                    echo "</div>                     
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>";
                }
            }
            ?>
            
            <div class="list-product_btn">
                <div class="grid wide">
                    <ul class="pagination justify-content-center">
                        <?php
                            $totalProductAfterSearch = $count_product;
                            $totalPage = $totalProductAfterSearch/$numProductInAPage;
                            displayListPageButton($totalPage, 'product-view');
                        ?>
                    </ul>
                </div>
            </div>                        
        </div>
       
        <!-- Back to Top -->
        <!-- <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a> -->
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>
            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            const tabs = $$('.sale-product');
            const pages = $$('.page-item');

            pages.forEach((page, index, ) => {
                const tab = tabs[index];

                page.onclick = function () {
                    $('.page-item.active').classList.remove('active');
                    $('.sale-product.product-page__active').classList.remove('product-page__active');

                    this.classList.add('active');
                    tab.classList.add('product-page__active');
                }
            });
        </script>
    </body>
</html>