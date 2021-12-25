<<<<<<< Updated upstream
<?php
    session_start();

    
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

    function add2DB($sql) {
        $dbhost = 'localhost:33066';
        $dbuser = 'root';
        $dbpass = '';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

        if ($conn->connect_error) {
            echo "<script language='javascript'>window.alert('Không thể kết nối vào cơ sở dữ liệu!');</script>";
        }
        else {
            $rs = $conn->query($sql);
            if (!$rs) {
                echo "<script language='javascript'>window.alert('Không thể thêm vào cơ sở dữ liệu!');</script>";
            }
            else {
                echo "<script language='javascript'>window.alert('Đã thêm vào cơ sở dữ liệu!');</script>";
            }
        } 
        mysqli_set_charset($conn,"utf8");
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
                            <a href="product-management.php" class="nav-item nav-link">QUẢN LÝ SẢN PHẨM</a>
                            <a href="add-item.php" class="nav-item nav-link active">THÊM SẢN PHẨM</a>
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
                </div>
            </div>
        </div>
        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb" style= "margin-bottom: 30px;">
                    <li class="header-checkout_text">THÊM SẢN PHẨM</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Add category Start -->
        <div class="add">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">    
                        <form class="add-item" method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mã loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: LH01" name="category_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: Vi xử lý" name="category_name">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['category_name']) && isset($_POST['category_id'])) {
                                    $sql = "INSERT INTO `category` (category_id, category_name) VALUES ('" . $_POST['category_id'] . "','" . $_POST['category_name'] . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                        <form class="add-item" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mã thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="VD: BR01" name="brand_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="VD: Asus" name="brand_name">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['brand_name']) && isset($_POST['brand_id'])) {
                                    $sql = "INSERT INTO `brand` (brand_id, brand_name) VALUES ('" . $_POST['brand_id'] . "','" . $_POST['brand_name'] . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="add-item" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="category_id" list="category_list">
                                    <datalist id="category_list">
                                        <?php 
                                            $dbhost = 'localhost:33066';
                                            $dbuser = 'root';
                                            $dbpass = '';
                                            $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
                                            $sql1 = "SELECT * FROM category ORDER BY category_id";
                                            if ($conn->connect_error) {
                                                echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
                                            }
                                            else {
                                                $rs1 = $conn->query($sql1);
                                                if (!$rs1) {
                                                    echo "<h5>Không thể thêm vào cơ sở dữ liệu!</h5>";
                                                }
                                                else {
                                                    while ($row = $rs1->fetch_array(MYSQLI_ASSOC)) {
                                                        echo "<option value='" . $row['category_id'] . "'>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label>Thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="brand_id" list="brand_list">
                                    <datalist id="brand_list">
                                        <?php 
                                            $dbhost = 'localhost:33066';
                                            $dbuser = 'root';
                                            $dbpass = '';
                                            $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
                                            $sql1 = "SELECT * FROM brand ORDER BY brand_id";
                                            if ($conn->connect_error) {
                                                echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
                                            }
                                            else {
                                                $rs1 = $conn->query($sql1);
                                                if (!$rs1) {
                                                    echo "<h5>Không thể thêm vào cơ sở dữ liệu!</h5>";
                                                }
                                                else {
                                                    while ($row = $rs1->fetch_array(MYSQLI_ASSOC)) {
                                                        echo "<option value='" . $row['brand_id'] . "'>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label>Mã sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="product_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: Chuột Logitech G102" name="product_name">
                                </div>
                                <div class="col-md-6">
                                    <label>Giá (đã có VAT)</label>
                                    <input class="form-control" type="text" placeholder="VD: 250000" name="price">
                                </div>
                                <div class="col-md-6">
                                    <label>Nội dung</label>
                                    <textarea class="form-control" type="text" placeholder="Nội dung" name="description"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Giảm giá</label>
                                    <input class="form-control" type="text" placeholder="VD: 50" name="discount">
                                </div>
                                <div class="col-md-6">
                                    <label>Link ảnh</label>
                                    <input class="form-control" type="text" placeholder="VD: img/..." name="image_link">
                                </div>
                                <div class="col-md-6">
                                    <label>Năm ra mắt</label>
                                    <input class="form-control" type="text" placeholder="VD:2021" name="date_first_available">
                                </div>
                                <div class="col-md-6">
                                    <label>Số lượng trong kho</label>
                                    <input class="form-control" type="text" placeholder="VD: 500" name="amount">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['category_id']) && isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['brand_id'])  && isset($_POST['price'])  && isset($_POST['description'])  && isset($_POST['discount'])  && isset($_POST['image_link'])  && isset($_POST['date_first_available'])  && isset($_POST['amount'])) {
                                    $sql = "INSERT INTO `product` (category_id, product_id, product_name, brand_id, price, description, discount, image_link, date_first_available, amount, saledate) VALUES ('" . $_POST['category_id'] . "', '" . $_POST['product_id'] . "', '" . $_POST['product_name'] . "', '" . $_POST['brand_id'] . "', " . $_POST['price'] . ", '" . $_POST['description'] . "', " . $_POST['discount'] . ", '" . $_POST['image_link'] . "', " . $_POST['date_first_available'] . ", " . $_POST['amount'] . ", '" . date("Y-m-d") . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add category End -->


    </body>
=======
<?php
    session_start();

    
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

    function add2DB($sql) {
        $dbhost = 'localhost ';
        $dbuser = 'root';
        $dbpass = '';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

        if ($conn->connect_error) {
            echo "<script language='javascript'>window.alert('Không thể kết nối vào cơ sở dữ liệu!');</script>";
        }
        else {
            $rs = $conn->query($sql);
            if (!$rs) {
                echo "<script language='javascript'>window.alert('Không thể thêm vào cơ sở dữ liệu!');</script>";
            }
            else {
                echo "<script language='javascript'>window.alert('Đã thêm vào cơ sở dữ liệu!');</script>";
            }
        } 
        mysqli_set_charset($conn,"utf8");
    }

    
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <title>Dystopia Store</title>
        <link rel="icon" href="./img/favicons/favicon-32x32.png">

         
         

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
                            <a href="product-management.php" class="nav-item nav-link">QUẢN LÝ SẢN PHẨM</a>
                            <a href="add-item.php" class="nav-item nav-link active">THÊM SẢN PHẨM</a>
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
                </div>
            </div>
        </div>
        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb" style= "margin-bottom: 30px;">
                    <li class="header-checkout_text">THÊM SẢN PHẨM</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Add category Start -->
        <div class="add">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">    
                        <form class="add-item" method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mã loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: LH01" name="category_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: Vi xử lý" name="category_name">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['category_name']) && isset($_POST['category_id'])) {
                                    $sql = "INSERT INTO `category` (category_id, category_name) VALUES ('" . $_POST['category_id'] . "','" . $_POST['category_name'] . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                        <form class="add-item" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mã thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="VD: BR01" name="brand_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="VD: Asus" name="brand_name">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['brand_name']) && isset($_POST['brand_id'])) {
                                    $sql = "INSERT INTO `brand` (brand_id, brand_name) VALUES ('" . $_POST['brand_id'] . "','" . $_POST['brand_name'] . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="add-item" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Loại sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="category_id" list="category_list">
                                    <datalist id="category_list">
                                        <?php 
                                            $dbhost = 'localhost ';
                                            $dbuser = 'root';
                                            $dbpass = '';
                                            $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
                                            $sql1 = "SELECT * FROM category ORDER BY category_id";
                                            if ($conn->connect_error) {
                                                echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
                                            }
                                            else {
                                                $rs1 = $conn->query($sql1);
                                                if (!$rs1) {
                                                    echo "<h5>Không thể thêm vào cơ sở dữ liệu!</h5>";
                                                }
                                                else {
                                                    while ($row = $rs1->fetch_array(MYSQLI_ASSOC)) {
                                                        echo "<option value='" . $row['category_id'] . "'>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label>Thương hiệu</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="brand_id" list="brand_list">
                                    <datalist id="brand_list">
                                        <?php 
                                            $dbhost = 'localhost ';
                                            $dbuser = 'root';
                                            $dbpass = '';
                                            $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
                                            $sql1 = "SELECT * FROM brand ORDER BY brand_id";
                                            if ($conn->connect_error) {
                                                echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
                                            }
                                            else {
                                                $rs1 = $conn->query($sql1);
                                                if (!$rs1) {
                                                    echo "<h5>Không thể thêm vào cơ sở dữ liệu!</h5>";
                                                }
                                                else {
                                                    while ($row = $rs1->fetch_array(MYSQLI_ASSOC)) {
                                                        echo "<option value='" . $row['brand_id'] . "'>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label>Mã sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="Mã" name="product_id">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên sản phẩm</label>
                                    <input class="form-control" type="text" placeholder="VD: Chuột Logitech G102" name="product_name">
                                </div>
                                <div class="col-md-6">
                                    <label>Giá (đã có VAT)</label>
                                    <input class="form-control" type="text" placeholder="VD: 250000" name="price">
                                </div>
                                <div class="col-md-6">
                                    <label>Nội dung</label>
                                    <textarea class="form-control" type="text" placeholder="Nội dung" name="description"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Giảm giá</label>
                                    <input class="form-control" type="text" placeholder="VD: 50" name="discount">
                                </div>
                                <div class="col-md-6">
                                    <label>Link ảnh</label>
                                    <input class="form-control" type="text" placeholder="VD: img/..." name="image_link">
                                </div>
                                <div class="col-md-6">
                                    <label>Năm ra mắt</label>
                                    <input class="form-control" type="text" placeholder="VD:2021" name="date_first_available">
                                </div>
                                <div class="col-md-6">
                                    <label>Số lượng trong kho</label>
                                    <input class="form-control" type="text" placeholder="VD: 500" name="amount">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Thêm</button>
                                </div>
                            </div>
                            <br>
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['category_id']) && isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['brand_id'])  && isset($_POST['price'])  && isset($_POST['description'])  && isset($_POST['discount'])  && isset($_POST['image_link'])  && isset($_POST['date_first_available'])  && isset($_POST['amount'])) {
                                    $sql = "INSERT INTO `product` (category_id, product_id, product_name, brand_id, price, description, discount, image_link, date_first_available, amount, saledate) VALUES ('" . $_POST['category_id'] . "', '" . $_POST['product_id'] . "', '" . $_POST['product_name'] . "', '" . $_POST['brand_id'] . "', " . $_POST['price'] . ", '" . $_POST['description'] . "', " . $_POST['discount'] . ", '" . $_POST['image_link'] . "', " . $_POST['date_first_available'] . ", " . $_POST['amount'] . ", '" . date("Y-m-d") . "');";
                                    add2DB($sql);
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add category End -->


    </body>
>>>>>>> Stashed changes
</html>