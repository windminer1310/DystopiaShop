<?php
    require_once('../moneyPoint.php');
    session_start();
    $dbhost = 'localhost:33066';
    $dbuser = 'root';
    $dbpass = '';


    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    if ($conn->connect_error) {
        die("Không thể kết nối!");
        exit();
    }

    mysqli_set_charset($conn,"utf8");

    if(isset($_SESSION['name']) && isset($_SESSION['id']) && isset($_SESSION['authority'])){
        $eachPartName = preg_split("/\ /",$_SESSION['name']);
        $countName = count($eachPartName);
        if($countName == 1){
            $name = $eachPartName[$countName-1];
        }
        else{
            $name = $eachPartName[$countName-2] . " " . $eachPartName[$countName-1];
        }
        $user_id = $_SESSION['id'];
    }
    else{
        header('Location: admin-login.html');
    }

    if($_SESSION['authority'] == 2){
        header('Location: transaction-management.php');
    }

    $sort = 0;
    $price_from = 0;
    $search = NULL;
    $page_number = 1;
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }
    if (isset($_GET['price_from'])) {
        $price_from = $_GET['price_from'];
    }
    if (isset($_GET['search']) && strlen($_GET['search']) == 0) {
        header('Location: product-management.php');
    }else if( isset($_GET['search'])){
        $search = $_GET['search'];
    }
    if (isset($_GET['id'])) {
        $page_number = $_GET['id'];    
    }
    
 ?>
 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dystopia</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="database" name="keywords">
        <meta content="database" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="../lib/slick/slick.css" rel="stylesheet">
        <link href="../lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
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
                            <a href="admin.php" class="nav-item nav-link">QUẢN LÝ THÔNG TIN</a>
                            <a href="transaction-management.php" class="nav-item nav-link">QUẢN LÝ ĐƠN HÀNG</a>
                            <a href="product-management.php" class="nav-item nav-link active">QUẢN LÝ SẢN PHẨM</a>
                            <a href="add-item.php" class="nav-item nav-link">THÊM SẢN PHẨM</a>
                        </div>
                        <div class="header__navbar-item header__navbar-user">
                            <img class = "avatar-img" src="../img/avatar.jpg"/>
                            <span class="header__navbar-user-name"><?php echo $name;?></span>

                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-item header__navbar-user-item--separate">
                                    <a href="logout.php" >Đăng xuất</a>
                                </li>
                            </ul>
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
                            <a href="admin.php">
                                <img src="../img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <form method="get" action="product-management.php?" class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm" name="search" value = '<?php echo $search; ?>'>
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
                    <li class="breadcrumb-item active">QUẢN LÝ SẢN PHẨM</li>
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
                                                        if (isset($_GET['sort'])) {
                                                            $sort_name = "";
                                                            if ($sort == 1) {
                                                                $sort_name = "Mới nhất";
                                                            }
                                                            elseif ($sort == 3) {
                                                                $sort_name = "Giá từ thấp đến cao";
                                                            }
                                                            elseif ($sort == 4) {
                                                                $sort_name = "Giá từ cao đến thấp";
                                                            }
                                                            else {
                                                                $sort_name = "Bán chạy nhất";
                                                            }
                                                            echo "<div class='dropdown-toggle' data-toggle='dropdown'>". $sort_name ."</div>";
                                                        }
                                                        else {
                                                            echo "<div class='dropdown-toggle' data-toggle='dropdown'>Sắp xếp theo</div>";
                                                        }
                                                    ?>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php
                                                            $link1 = "product-management.php?id=1";
                                                            if (isset($_GET['price_from'])) {
                                                                $link1 = $link1 . "&price_from=" . $price_from;
                                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                                    $link1 = $link1 . "&search=" . $search;
                                                                }
                                                            }
                                                            else {
                                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                                    $link1 = $link1 . "&search=" . $search;
                                                                }
                                                                
                                                            }
                                                            echo "<a href='" . $link1 . "&sort=1' class='dropdown-item'>Mới nhất</a>";
                                                            echo "<a href='" . $link1 . "&sort=2' class='dropdown-item'>Bán chạy nhất</a>";
                                                            echo "<a href='" . $link1 . "&sort=3' class='dropdown-item'>Giá từ thấp đến cao</a>";
                                                            echo "<a href='" . $link1 . "&sort=4' class='dropdown-item'>Giá từ cao đến thấp</a>";
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product-price-range">
                                                <div class="dropdown">
                                                    <?php
                                                        if (isset($_GET['price_from'])) {
                                                            $price_from_name = "";
                                                            if ($price_from == 1) {
                                                                $price_from_name = "Dưới 1.000.000đ";
                                                            }
                                                            elseif ($price_from == 2) {
                                                                $price_from_name = "1.000.000đ - 10.000.000đ";
                                                            }
                                                            elseif ($price_from == 3) {
                                                                $price_from_name = "10.000.000đ - 50.000.000đ";
                                                            }
                                                            else {
                                                                $price_from_name = "Trên 50.000.000đ";
                                                            }
                                                            echo "<div class='dropdown-toggle' data-toggle='dropdown'>". $price_from_name ."</div>";
                                                        }
                                                        else {
                                                            echo "<div class='dropdown-toggle' data-toggle='dropdown'>Tầm giá</div>";
                                                        }
                                                    ?>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php
                                                            $link2 = "product-management.php?id=1";
                                                            if (isset($_GET['sort'])) {
                                                                $link2  = $link2 . "&sort=" . $sort;
                                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                                    $link2 = $link2 . "&search=" . $search;
                                                                }
                                                            }
                                                            else {
                                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                                    $link2 = $link2 . "&search=" . $search;
                                                                }
                                                            }
                                                            echo "<a href='" . $link2 . "&price_from=1' class='dropdown-item'>Dưới 1.000.000đ</a>";
                                                            echo "<a href='" . $link2 . "&price_from=2' class='dropdown-item'>1.000.000đ - 10.000.000đ</a>";
                                                            echo "<a href='" . $link2 . "&price_from=3' class='dropdown-item'>10.000.000đ - 50.000.000đ</a>";
                                                            echo "<a href='" . $link2 . "&price_from=4' class='dropdown-item'>Trên 50.000.000đ</a>";
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
                                $numProductInAPage = 28;
                                echo "<div class='col-lg-12' style = 'display: contents;'>";
                                while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                                    if($count_product >= ($page_number-1) * $numProductInAPage && $count_product < ($page_number-1) * $numProductInAPage + $numProductInAPage){
                                        echo "<div class='col-md-3'>";
                                        if ($row['discount'] != 0) {
                                        echo "<div class='product-item__sale-off'>";
                                        echo "<span class = 'product-item__sale-off-percent'>".$row['discount']."%</span>";
                                        echo "</div>";
                                        }
                                        echo "<div class='product-item'>";                                            
                                        echo "<div class='product-image'>";
                                        echo "<a href='product-detail-admin.html?id=" . $row['product_id'] . "'>";
                                        echo "<img src='../" . $row['image_link'] . "?>' alt='Product Image'>";
                                        echo "</a>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='delete-product.php?id=" . $row['product_id'] . "'><i class='far fa-trash-alt'></i></a>";
                                        echo "<a href='update-product.php?id=" . $row['product_id'] . "'><i class='fas fa-cogs'></i></a>";
                                        echo "<a href='product-detail-admin.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-price' style='height: 100px;'>";
                                        echo "<h2 style = 'line-height: 20px;
                                        max-height: 40px;
                                        overflow: hidden;
                                        flex: 1;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        -webkit-line-clamp: 2;'>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3 style = 'position: absolute; bottom: 27px; '><span>" . number_format($discount, 0, ',','.') . " đ</span></h3>";
                                            echo "<h3 style='position: absolute; bottom: 7px; text-decoration: line-through; color: #888888; font-size:13px; font-weight: 500;'><span>" . number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                                        }
                                        else{
                                            echo "<h3 style = 'position: absolute; bottom: 27px; '><span>" . number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
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
                                        if($totalPage > floor($totalPage)){
                                            for($count = 1; $count <= floor($totalPage)+1; $count++){
                                                $link = "product-management.php?id=" . $count;
                                                if (isset($_GET['sort'])) {
                                                    $link = $link . "&sort=" . $sort;
                                                }
                                                if (isset($_GET['price_from'])) {
                                                    $link = $link . "&price_from=" . $price_from;
                                                }
                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                   $link = $link . "&search=" . $search;
                                                }
                                                if($count == $page_number) 
                                                    echo "<li class='page-item active'><a class='page-link' href='" . $link . "'>" . $count . "</a></li>";
                                                else 
                                                    echo "<li class='page-item'><a class='page-link' href='" . $link . "'>" . $count . "</a></li>";
                                            }
                                        }
                                        else {
                                            for($count = 1; $count < floor($totalPage)+1; $count++){
                                                $link = "product-management.php?id=" . $count;
                                                if (isset($_GET['sort'])) {
                                                    $link = $link . $sort;
                                                }
                                                if (isset($_GET['price_from'])) {
                                                    $link = $link . $price_from;
                                                }
                                                if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
                                                   $link = $link . "&search=" . $search;
                                                }
                                                if($count == $page_number) 
                                                    echo "<li class='page-item active'><a class='page-link' href='" . $link . "'>" . $count . "</a></li>";
                                                else 
                                                    echo "<li class='page-item'><a class='page-link' href='" . $link . "'>" . $count . "</a></li>";
                                            }
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination Start -->
                    </div>
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget category">
                            <h2 class="title">Loại sản phẩm</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php                                    
                                        $sql1 = "SELECT * FROM `category`";
                                        $rs1 = $conn->query($sql1);
                                        if (!$rs1) {
                                            die("Lỗi không thể truy xuất cơ sỡ dữ liệu!");
                                            exit();
                                        }
                                        while ($row = $rs1->fetch_array(MYSQLI_ASSOC)) {
                                            echo "<li class='nav-item'><a class='nav-link' href='product-management.php?id=1&search=" . $row['category_name'] . "'>" . $row['category_name'] . "</a>";
                                            echo "<a href='delete-category.php?category_id=" . $row['category_id'] . "'><i class='far fa-trash-alt'></i></a></li>";
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                        <div class="sidebar-widget category">
                            <h2 class="title">Thương hiệu</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php
                                        $sql2 = "SELECT * FROM `brand`";
                                        $rs2 = $conn->query($sql2);
                                        if (!$rs2) {
                                            die("Lỗi không thể truy xuất cơ sỡ dữ liệu!");
                                            exit();
                                        }
                                        while ($row = $rs2->fetch_array(MYSQLI_ASSOC)) {
                                            echo "<li class='nav-item'><a class='nav-link' href='product-management.php?id=1&search=" . $row['brand_name'] . "'>" . $row['brand_name'] . "</a>";
                                            echo "<a href='delete-category.php?brand_id=" . $row['brand_id'] . "'><i class='far fa-trash-alt'></i></a></li>";
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
        <!-- Product List End -->     
       
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