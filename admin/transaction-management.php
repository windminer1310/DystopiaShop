<<<<<<< Updated upstream
<?php
    require_once('../moneyPoint.php');
    session_start();
	$dbhost = 'localhost:33066';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
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
        $author = $_SESSION['authority'];
    }
    else{
        header('Location: admin-login.html');
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
                            <?php
                                if($author == 1){
                                    echo "<a href='admin.php' class='nav-item nav-link'>QUẢN LÝ THÔNG TIN</a>";
                                    echo "<a href='transaction-management.php' class='nav-item nav-link active'>QUẢN LÝ ĐƠN HÀNG</a>";
                                    echo "<a href='product-management.php' class='nav-item nav-link'>QUẢN LÝ SẢN PHẨM</a>";
                                    echo "<a href='add-item.php' class='nav-item nav-link'>THÊM SẢN PHẨM</a>";
                                }else{
                                    echo "<a href='transaction-management.php' class='nav-item nav-link active'>QUẢN LÝ ĐƠN HÀNG</a>";
                                }
                            ?>
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
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">QUẢN LÝ ĐƠN HÀNG</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <div class="my-account">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="incompleted-nav" data-toggle="pill" href="#incompleted-tab" role="tab"><i class="fa fa-shopping-bag"></i>Đơn hàng chưa hoàn thành</a>
                            <a class="nav-link " id="completed-nav" data-toggle="pill" href="#completed-tab" role="tab"><i class="fa fa-shopping-bag"></i>Đơn hàng đã xử lý</a>
                            
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="incompleted-tab" role="tabpanel" aria-labelledby="incompleted-nav">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Sản phẩm</th>
                                                <th>Ngày đặt</th>
                                                <th>Địa chỉ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sqlTransaction = "SELECT * FROM `transaction` WHERE status != 4 and status != 3";
                                                $rs1 = $conn->query($sqlTransaction);
                                                if (!$rs1) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while($row = $rs1->fetch_assoc()){
                                                    echo "<tr>";
                                                    echo "<td>". $row["transaction_id"] ."</td>";
                                                    echo "<td><a class ='btn' href='checkout-transaction.php?id_transaction=" . $row['transaction_id'] . "'>Xem</a></td>";
                                                    $dateTime = explode( ' ', $row["date"]);
                                                    echo "<td>". dayOfDate($dateTime[0]).", ". dateFormat($dateTime[0]).", ".$dateTime[0]."</td>";
                                                    echo "<td>". $row['address']."</td>";
                                                    echo "<td>". moneyPoint($row["payment"]) ."đ</td>";
                                                    echo "<td><a href='update-status.php?id=". $row['transaction_id'] ."&status=progress' class = 'btn'>". changeStatus($row['status']) . "</a>
                                                    <a href='update-status.php?id=". $row['transaction_id'] ."&status=cancel' class = 'fail-auth__form btn'>Hủy đơn</a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="completed-tab" role="tabpanel" aria-labelledby="completed-nav">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Sản phẩm</th>
                                                <th>Ngày đặt</th>
                                                <th>Địa chỉ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sqlTransaction = "SELECT * FROM `transaction` WHERE status = 4 or status = 3";
                                                $rs1 = $conn->query($sqlTransaction);
                                                if (!$rs1) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while($row = $rs1->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>". $row["transaction_id"] ."</td>";
                                                    echo "<td><a class ='btn' href='checkout-transaction.php?id_transaction=" . $row['transaction_id'] . "'>Xem</a></td>";
                                                    $dateTime = explode( ' ', $row["date"]);
                                                    echo "<td>". dayOfDate($dateTime[0]).", ". dateFormat($dateTime[0]).", ".$dateTime[0]."</td>";
                                                    echo "<td>". $row['address']."</td>";
                                                    echo "<td>". moneyPoint($row["payment"]) ."đ</td>";
                                                    echo "<td>". approveStatus($row["status"]) ."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
    </body>
=======
<?php
    require_once('../moneyPoint.php');
    session_start();
	$dbhost = 'localhost ';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
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
        $author = $_SESSION['authority'];
    }
    else{
        header('Location: admin-login.html');
    }


    
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <title>Dystopia Store</title>
        <link rel="icon" href="./img/favicons/favicon-32x32.png">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="database" name="keywords">
        <meta content="database" name="description">

         
         

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
                            <?php
                                if($author == 1){
                                    echo "<a href='admin.php' class='nav-item nav-link'>QUẢN LÝ THÔNG TIN</a>";
                                    echo "<a href='transaction-management.php' class='nav-item nav-link active'>QUẢN LÝ ĐƠN HÀNG</a>";
                                    echo "<a href='product-management.php' class='nav-item nav-link'>QUẢN LÝ SẢN PHẨM</a>";
                                    echo "<a href='add-item.php' class='nav-item nav-link'>THÊM SẢN PHẨM</a>";
                                }else{
                                    echo "<a href='transaction-management.php' class='nav-item nav-link active'>QUẢN LÝ ĐƠN HÀNG</a>";
                                }
                            ?>
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
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">QUẢN LÝ ĐƠN HÀNG</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <div class="my-account">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="incompleted-nav" data-toggle="pill" href="#incompleted-tab" role="tab"><i class="fa fa-shopping-bag"></i>Đơn hàng chưa hoàn thành</a>
                            <a class="nav-link " id="completed-nav" data-toggle="pill" href="#completed-tab" role="tab"><i class="fa fa-shopping-bag"></i>Đơn hàng đã xử lý</a>
                            
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="incompleted-tab" role="tabpanel" aria-labelledby="incompleted-nav">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Sản phẩm</th>
                                                <th>Ngày đặt</th>
                                                <th>Địa chỉ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sqlTransaction = "SELECT * FROM `transaction` WHERE status != 4 and status != 3";
                                                $rs1 = $conn->query($sqlTransaction);
                                                if (!$rs1) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while($row = $rs1->fetch_assoc()){
                                                    echo "<tr>";
                                                    echo "<td>". $row["transaction_id"] ."</td>";
                                                    echo "<td><a class ='btn' href='checkout-transaction.php?id_transaction=" . $row['transaction_id'] . "'>Xem</a></td>";
                                                    $dateTime = explode( ' ', $row["date"]);
                                                    echo "<td>". daysOfWeek($dateTime[0]).", ". dateFormat($dateTime[0]).", ".$dateTime[0]."</td>";
                                                    echo "<td>". $row['address']."</td>";
                                                    echo "<td>". moneyPoint($row["payment"]) ."đ</td>";
                                                    echo "<td><a href='update-status.php?id=". $row['transaction_id'] ."&status=progress' class = 'btn'>". changeStatus($row['status']) . "</a>
                                                    <a href='update-status.php?id=". $row['transaction_id'] ."&status=cancel' class = 'auth__form--fail btn'>Hủy đơn</a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="completed-tab" role="tabpanel" aria-labelledby="completed-nav">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Sản phẩm</th>
                                                <th>Ngày đặt</th>
                                                <th>Địa chỉ</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sqlTransaction = "SELECT * FROM `transaction` WHERE status = 4 or status = 3";
                                                $rs1 = $conn->query($sqlTransaction);
                                                if (!$rs1) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while($row = $rs1->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>". $row["transaction_id"] ."</td>";
                                                    echo "<td><a class ='btn' href='checkout-transaction.php?id_transaction=" . $row['transaction_id'] . "'>Xem</a></td>";
                                                    $dateTime = explode( ' ', $row["date"]);
                                                    echo "<td>". daysOfWeek($dateTime[0]).", ". dateFormat($dateTime[0]).", ".$dateTime[0]."</td>";
                                                    echo "<td>". $row['address']."</td>";
                                                    echo "<td>". moneyPoint($row["payment"]) ."đ</td>";
                                                    echo "<td>". approveStatus($row["status"]) ."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
    </body>
>>>>>>> Stashed changes
</html>