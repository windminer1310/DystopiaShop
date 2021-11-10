<?php  
    session_start();
    require_once('../moneyPoint.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
	else{
        header('Location: admin.php');
    }

	$dbhost = 'localhost:33066';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");

	$sql = "SELECT * FROM `product` WHERE product_id='" . $id . "'";
	$rs = $conn->query($sql);
	if (!$rs) {
	    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
	    exit();
	}
	$info = NULL;
	while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
		$info = $row;
	}

    if(isset($_SESSION['name']) && isset($_SESSION['id']) && isset($_SESSION['authority'])){
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
        <link href="../img/favicon.ico" rel="icon">

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
                            <a href="product-management.php" class="nav-item nav-link">QUẢN LÝ SẢN PHẨM</a>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="header__navbar-item header__navbar-user">
                                <img class = "avatar-img" src="../img/avatar.jpg"/>
                                <span class="header__navbar-user-name"><?php echo $name; ?></span>
                        
                                <ul class="header__navbar-user-menu">
                                    <li class="header__navbar-user-item header__navbar-user-item--separate">
                                        <a href="../logout.php">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
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
                </div>
            </div>
        </div>
        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
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
                                    	<?php echo "<img src='../" . $info['image_link'] . "' alt='Product Image' width='300'>"; ?>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product-content">
                                        <div class="title-product">
                                            <h2><?php echo $info['product_name'] ?></h2>
                                        </div>
                                        <div class="price">
                                            <h4 class = "header-checkout_text">Giá:</h4>
                                            <p><?php echo number_format($info['price'], 0, ',', '.'); ?>đ</p>
                                        </div>
                                        <h4 class = "header-checkout_text" style="font-weight: 600; font-size: 15px;">Hàng trong kho: <?php echo $info['amount']; ?></h4>
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
                                        $sql1 = "SELECT * FROM `category`";
                                        $rs1 = $conn->query($sql1);
                                        if (!$rs1) {
                                            die("Lỗi không thể truy xuất cơ sở dữ liệu!");
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
                                            die("Lỗi không thể truy xuất cơ sở dữ liệu!");
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
        <!-- Product Detail End -->
        
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="../js/addCart.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>