<?php  
    session_start();
    require_once('display-function.php');
    require_once('database/connectDB.php');
    require_once('session.php');
    require_once('shop_info/shop-info.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
        headToPage('product-list.php');
    }


    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
	else{
        header('Location: view-product-list.php?id=page_num=1');
    }

	$info = NULL;

    $table_product = 'product';
    $column_product = 'product_id';
    $value = $id;
	foreach(getAllRowWithValue( $table_product, $column_product, $value)->fetchAll() as $value => $row){
		$info = $row;
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
                            <a href="" onclick = "mustInput();" class="nav-item nav-link">Giỏ hàng</a>
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
                            <input type="text" placeholder="Tìm kiếm" name="search">
                            <button><i class="fa fa-search" type="submit"></i></button>
                        </div>
                    </form>
                    <div class="col-md-3">
                        <div class="user">
                        <a href="" onclick = "mustInput();" class="btn cart">
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
                    <li class="breadcrumb-item"><a href="view-product-list.php">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product Detail Start -->
        <div class="product-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="product-detail-top">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class='product-image'>
                                    	<?php echo "<img src='" . $info['image_link'] . "' alt='Product Image' width='300'>"; ?>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product-content">
                                        <div class="title-product"><h2><?php echo $info['product_name'] ?></h2></div>
                                        <?php
                                            if ($info['discount'] == 0)
                                            {
                                                echo "<div class='price'>
                                                <h4 class = 'header-checkout_text'>Giá:</h4>
                                                <p>" . number_format($info['price'], 0, ',', '.') . "đ</p>
                                                </div>
                                                <div class='price'>
                                                    <h4 class = 'header-checkout_text' style='color: white;'>G:</h4>
                                                </div>";

                                            }
                                            else
                                            {
                                                $discount = $info['price'] - ($info['price'] * $info['discount'] * 0.01);
                                                echo "<div class='price'>
                                                    <h4 class='header-checkout_text'>Giá mới:</h4>
                                                    <p>" .
                                                        number_format($discount, 0, ',', '.') 
                                                        .
                                                        "đ
                                                    </p>
                                                </div>
                                                <div class='price'>
                                                    <h4 class = 'header-checkout_text'>Giá gốc:</h4>
                                                    <p class='product-discount__none'>" .number_format($info['price'], 0, ',', '.') ."đ;</p>
                                                </div>";
                                            }
                                        ?>
                                            <div class="quantity">
                                                <h4 class = "header-checkout_text">Số lượng:</h4>
                                                <form id = "product-to-cart">
                                                    <div onclick = "minus_qty();" class = "btn-minus"><i class="fa fa-minus"></i></div>
                                                    <input class = "quantity-product quantity quantity-input"type="text" value="1" name="amountProduct" id ="amountProduct">
                                                    <div onclick = "plus_qty();" class = "btn-plus"><i class="fas fa-plus"></i></div>
                                                </form>
                                            </div>
                                            <h4 class = "header-checkout_text" style="font-weight: 600; font-size: 15px;">Hàng trong kho: <?php echo $info['amount']; ?></h4>
                                        <div class="action">
                                            <?php 
                                                if ($info['amount'] > 0) {
                                                    echo "<a style = 'margin-top: 20px'class='btn' name = 'submit' id='submit' type='submit' onclick=' mustInput();' href=''><i class='fa fa-shopping-cart'></i>Thêm vào giỏ hàng</a>";
                                                }
                                                else {
                                                    echo "<a style = 'margin-top: 20px'class='btn';' href=''><i class='fa fa-shopping-cart'></i>Đã hết hàng</a>";
                                                }
                                            ?>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row product-detail-bottom">
                            <div class="col-lg-12">
                                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="admin-list-nav" data-toggle="pill" href="#description" role="tab">Mô tả</a>
                                    <a class="nav-link" id="new-admin-nav" data-toggle="pill" href="#specification" role="tab">Thông tin thêm</a>
                                </div>
                                <div class="tab-content">
                                    <div id="description" class="container tab-pane active">
                                        <h4>Mô tả</h4>
                                        <p>
                                            <?php echo $info['description']; ?> 
                                        </p>
                                    </div>
                                    <div id="specification" class="container tab-pane fade">
                                        <h4>Thông tin thêm</h4>
                                        <ul>
                                            <li>Năm ra mắt: <?php echo $info['date_first_available']; ?></li>
                                        </ul>
                                        <ul>
                                            <li>Thương hiệu: <?php echo $info['brand_id']; ?></li>
                                        </ul>
                                        <ul>
                                            <li>Loại sản phẩm: <?php echo $info['category_id']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
                                            echo "<li class='nav-item'><a class='nav-link' href='view-product-list.php?id=1&search=" . $row['category_name'] . "'>" . $row['category_name'] . "</a>";
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
                                        echo "<a href='#'><i class='fa fa-cart-plus'></i></a>";
                                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='product-price'>";
                                        echo "<h2>" . $row['product_name'] . "</h2>";
                                        if ($row['discount'] != 0) {
                                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                                            echo "<h3><span>" . number_format($discount, 0, ',', '.') . "đ - Giảm " . $row['discount'] . "%</span></h3>";
                                        }
                                        else {
                                            echo "<h3><span>" . number_format($row['price'], 0, ',', '.') . "đ</span></h3>";
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
                                            echo "<li class='nav-item'><a class='nav-link' href='view-product-list.php?id=1&search=" . $row['brand_name'] . "'>" . $row['brand_name'] . "</a>";
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
        <!-- Product Detail End -->
        

        
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
        <script src="js/addCart.js"></script>
        <script src="js/main.js"></script>
        <script>
            function minus_qty(){
                if(document.getElementById("amountProduct").value > 1){
                    document.getElementById("amountProduct").value -= 1;
                }
                
            }
            function plus_qty(){
                document.getElementById("amountProduct").value = Number(document.getElementById("amountProduct").value) + 1;
            }
        </script>
    </body>
</html>