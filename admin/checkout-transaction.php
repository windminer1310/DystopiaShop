<?php
    session_start();
    require_once('../moneyPoint.php');
    $servername = "localhost:33066";
    $username = "root";
    $password = "";
    $dbname = "database";

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


    $id_transaction = $_GET['id_transaction'];
    
    $dbhost = 'localhost:33066';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");

    $sqlTransaction = "SELECT * FROM `transaction` WHERE transaction_id = $id_transaction";
    $rs = $conn->query($sqlTransaction);
    if (!$rs) {
        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
        exit();
    }
    $row = $rs->fetch_array(MYSQLI_ASSOC);

    $amountArray = explode( '-', $row['amount']);
    $productArray = explode( '-', $row['product_id']);
    $totalPrice = $row['payment'];
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
                        <a href="transaction-management.php" class="nav-item nav-link">QUẢN LÝ ĐƠN HÀNG</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <div class="header__navbar-item header__navbar-user">
                            <img class = "avatar-img" src="../img/avatar.jpg"/>
                            <span class="header__navbar-user-name"><?php echo $name; ?></span>
                    
                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-item header__navbar-user-item--separate">
                                    <a href="logout.php">Đăng xuất</a>
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
        
        <!-- Cart Start -->
        <div class="cart-page">
            <?php
                echo "<div class='container-fluid'>";
                    echo "<div class='row'>";
                        echo "<div class='col-lg-8'>";
                        echo "<div class='cart-page-inner-title'>";
                        echo "<h4 style= 'text-align: center; font-size: 18px;
                        font-weight: 600; margin-bottom: 0px;'>
                        Mã đơn hàng:  ".$id_transaction."</h4 class = 'text-align: center'>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='col-lg-8'>";
                            echo "<div class='cart-page-inner'>";
                                    echo "<div class='table-responsive'>";
                                        echo "<table class='table table-bordered'>";
                                            echo "<thead class='thead-dark'>";
                                                echo "<tr>";
                                                    echo "<th class ='header-checkout_text'>Sản phẩm</th>";
                                                    echo "<th class ='header-checkout_text'>Đơn giá</th>";
                                                    echo "<th class ='header-checkout_text'>Số lượng</th>";
                                                    echo "<th class ='header-checkout_text'>Thành tiền</th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody class='align-middle'>";
                                                    for($count = 0; $count < count($productArray); $count++){
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo "<div class='img'>";
                                                    $qslProduct = "SELECT * FROM `product` WHERE product_id = '$productArray[$count]'";
                                                    $rs1 = $conn->query($qslProduct);
                                                    if (!$rs1) {
                                                        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                        exit();
                                                    }
                                                    $productInfo = $rs1->fetch_array(MYSQLI_ASSOC);
                                                    echo "<a href='product-detail.php?id=".$productInfo['product_id']."'><img src='../" . $productInfo['image_link'] . "' alt='Image'></a>";
                                                    echo "<p>" . $productInfo['product_name'] . "</p>";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    $price = 0;
                                                    if ($productInfo['discount'] == 0){
                                                        $price = $productInfo['price']; 
                                                    }else{
                                                        $price = ($productInfo['price'] - ($productInfo['price'] * $productInfo['discount'] * 0.01));
                                                    }
                                                    echo "<td>" . number_format($row['price'], 0, ',', '.') . "đ". "</td>";
                                                    $amountOfProduct = $amountArray[$count];
                                                    echo "<td>" . $amountOfProduct ."</td>";
                                                    $sumPrice = $price * $amountOfProduct;
                                                    echo "<td>" . moneyPoint($sumPrice) . "đ</td>";
                                                    }  
                                                    echo "<tr>";
                                                    echo "<td></td>";
                                                    echo "<td></td>";
                                                    echo "<td class = 'header-checkout_text'>Tổng</td>";
                                                    $shipCost = 35000;
                                                    echo "<td><p class = 'title-checkout-text' style = 'margin: 5px 0px;'>(Ship: ".moneyPoint($shipCost)."đ)</p>
                                                    <h5 style ='font-size: 18px; font-weight: 600;  color: rgb(235, 33, 1);'>". moneyPoint($totalPrice) ."đ</h5></td>";
                                                    echo "</tr>";
                                            echo "</tbody>";
                                        echo "</table>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                        
            ?>
        </div>
        <!-- Cart End -->
        
           
        
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
    </body>
</html>

