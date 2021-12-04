<?php
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('search-product-with-link.php');
    require_once('shop_info/shop-info.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        headToPage('product-list.php');
    }

    $sort = 0;
    $price_from = 0;
    $search = NULL;
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }
    if (isset($_GET['price_from'])) {
        $price_from = $_GET['price_from'];
    }
    if (isset($_GET['search']) && strlen($_GET['search']) == 0) {
        header('Location: view-product-list.php');
    }else if( isset($_GET['search'])){
        $search = $_GET['search'];
    }
    if (isset($_GET['page_num'])) {
        $page_number = $_GET['page_num'];    
    }
    else {
        $page_number = 1;
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    mysqli_set_charset($conn,"utf8");
    if ($conn->connect_error) {
        die("Không thể kết nối!");
        exit();
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
                            <a href="index.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="view-product-list.php" class="nav-item nav-link active">Sản phẩm</a>
                            <a href="" onclick="mustInput();" class="nav-item nav-link">Giỏ hàng</a>
                        </div>
                            <div class="navbar-nav ml-auto">
                                <a href="register.html" class="nav-item nav-link ">Đăng ký</a>
                                <a href="login.php" class="nav-item nav-link ">Đăng nhập</a>
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
                            <a href="index.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <form method="get" action="view-product-list.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search" value = '<?php echo $search; ?>'>
                            <button><i class="fa fa-search" type="submit"></i></button>
                        </div>
                    </form>
                    <div class="col-md-3">
                        <div class="user">
                        <a onclick="mustInput();" class="btn cart">
                            <i class="fa fa-shopping-cart"></i>
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
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Sản phẩm</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product List Start -->
        <div class="product-view">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-view-top">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="product-short">
                                                <div class="dropdown">
                                                    <?php
                                                        displayDescribeDropdownTag($sort);
                                                    ?>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php
                                                            searchProductWithDescribeDropdownTag($price_from, $search);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product-price-range">
                                                <div class="dropdown">
                                                    <?php
                                                        displayDropdownTagPriceArea($price_from);
                                                    ?>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php
                                                            searchProductWithDropdownTagPriceArea($sort, $search);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php                               
                                $sql = "SELECT * FROM `product`";
                                if (isset($_GET['price_from'])) {
                                    if ($_GET['price_from'] == 1) {
                                        $sql = $sql . " WHERE price <= 1000000";
                                    }
                                    elseif ($_GET['price_from'] == 2) {
                                        $sql = $sql . " WHERE price > 1000000 AND price <= 10000000";
                                    }
                                    elseif ($_GET['price_from'] == 3) {
                                        $sql = $sql . " WHERE price > 10000000 AND price <= 50000000";
                                    }
                                    else {
                                        $sql = $sql . " WHERE price > 50000000";
                                    }
                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                        $sql = $sql . " AND (product_name LIKE '%" . $search . "%' OR category_id = 
                                        (SELECT category_id FROM `category` WHERE category_name LIKE '%" . $search . "%') OR brand_id = 
                                        (SELECT brand_id FROM `brand` WHERE brand_name LIKE '%" . $search . "%') OR description LIKE '%" . $search . "%')";
                                    }
                                }
                                else {
                                    if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                        $sql = $sql . " WHERE product_name LIKE '%" . $search . "%' OR category_id = 
                                        (SELECT category_id FROM `category` WHERE category_name LIKE '%" . $search . "%') OR brand_id = 
                                        (SELECT brand_id FROM `brand` WHERE brand_name LIKE '%" . $search . "%') OR description LIKE '%" . $search . "%'";
                                    }
                                }
                                if (isset($_GET['sort'])) {
                                    if ($_GET['sort'] == 1) {
                                        $sql = $sql . " ORDER BY saledate DESC";
                                    }
                                    elseif ($_GET['sort'] == 3) {
                                        $sql = $sql . " ORDER BY price ASC";
                                    }
                                    elseif ($_GET['sort'] == 4) {
                                        $sql = $sql . " ORDER BY price DESC";
                                    }
                                    else {
                                        $sql = $sql . " ORDER BY sold DESC";
                                    }
                                }
                                $rs = $conn->query($sql);

                                if (!$rs) {
                                    die("Không có sản phẩm nào để hiển thị!");
                                    exit();
                                }
                                $count_product = 0;
                                $numProductInAPage = 30;
                                echo "<div class='col-lg-12' style = 'display: contents;'>";
                                while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                                    if($count_product >= ($page_number-1)*$numProductInAPage && $count_product < ($page_number-1)*$numProductInAPage + $numProductInAPage){
                                        echo "<div class='col-md-3'>";
                                        if ($row['discount'] != 0) {
                                            displayDiscountTagWithHtml($row['discount']);
                                        }
                                        echo "<div class='product-item'>";                                            
                                        echo "<div class='product-image'>";
                                        echo "<a href='product-detail.html?id=" . $row['product_id'] . "'>";
                                        echo "<img src='" . $row['image_link'] . "?>' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-price'>";
                                        echo "<h2 class = 'product-tag__name'>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3 class = 'product-current__price'><span>" . number_format($discount, 0, ',','.') . " đ</span></h3>";
                                            echo "<h3 class = 'product-discount__price'><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        else{
                                            echo "<h3 class = 'product-current__price'><span>" . number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                    if( $count_product == (($page_number-1)*$numProductInAPage + $numProductInAPage)) break;
                                    $count_product++;                                 
                                }
                                echo "</div>";
                            ?>                         
                        </div>
                        <!-- Pagination Start -->
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php
                                        $totalProduct = mysqli_num_rows($rs);
                                        $totalPage = $totalProduct/$numProductInAPage;
                                        displayListPageButton($totalPage, $sort, $search, $price_from, $page_number)
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>           
                    
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget category">
                            <h2 class="title">Loại sản phẩm</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php    
                                        $table_category = 'category';
                                        foreach(getRowWithTable($table_category)->fetchAll() as $value => $row) {
                                            echo "<li class='nav-item'><a class='nav-link' href='view-product-list.php?id=1&search=" . 
                                            $row['category_name'] . "'>" . 
                                            $row['category_name'] . "</a>";
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                        
                        <div class="sidebar-widget widget-slider">
                            <div class="sidebar-slider normal-slider">
                                <?php
                                    $tableName = 'product';
                                    $column = 'sold';
                                    $numberOfValues = 5;
                                    foreach(getRowWithNFeaturedProducts($tableName, $column, $numberOfValues)->fetchAll() as $value => $row) {
                                        echo "<div class='product-item'>";
                                        echo "<div class='product-image'>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'>";
                                        echo "<img src='" . $row['image_link'] . "' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-price'>";
                                        echo "<h2 class = 'product-tag__name' style = 'font-size: 20px;'>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3 class = 'product-current__price' style = 'font-size: 17px;'><span>" . number_format($discount, 0, ',','.') . " đ</span></h3>";
                                            echo "<h3 class = 'product-discount__price' style = 'font-size: 15px;'><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        else{
                                            echo "<h3 class = 'product-current__price ' style = 'font-size: 17px;'><span>" . number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                    }

                                ?>
                            </div>
                        </div>

                        
                        <div class="sidebar-widget category">
                            <h2 class="title">Thương hiệu</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php
                                        $table_brand = 'brand';
                                        foreach(getRowWithTable($table_brand)->fetchAll() as $value => $row) {
                                            echo "<li class='nav-item'><a class='nav-link' 
                                            href='view-product-list.php?id=1&search=" . $row['brand_name'] . "'>" . 
                                            $row['brand_name'] . "</a>";
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        
        
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
        <script>
            function continue_page(){
                let currentPage = document.getElementsByClassName("active")[2].value;
                alert(currentPage) ;
            }
            function mustInput(){
                alert('Vui lòng đăng nhập!');
            }
        </script>
    </body>
</html>