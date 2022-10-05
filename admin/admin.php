<?php
    session_start();
	$dbhost = 'localhost';
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
    }
    else{
        header('Location: admin-login.html');
    }

    if($_SESSION['authority'] == 2){
        header('Location: transaction-management.php');
    }
    
    function getAuthority($authority) {
        if ($authority == 2) {
            return "Nhân viên";
        }
        else {
            return "Chủ";
        }
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
                            <a href="admin.php" class="nav-item nav-link active">QUẢN LÝ THÔNG TIN</a>
                            <a href="transaction-management.php" class="nav-item nav-link">QUẢN LÝ ĐƠN HÀNG</a>
                            <a href="product-management.php" class="nav-item nav-link">QUẢN LÝ SẢN PHẨM</a>
                            <a href="add-item.php" class="nav-item nav-link">THÊM SẢN PHẨM</a>
                        </div>
                        <div class="navbar-nav ml-auto">
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
        
        
        <!-- Breadcrumb End --><!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">QUẢN LÝ ADMIN</li>
                </ul>
            </div>
        </div>
        <div class="my-account">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="admin-list-nav" data-toggle="pill" href="#admin-list-tab" role="tab">Danh sách Admin</a>
                            <a class="nav-link" id="new-admin-nav" data-toggle="pill" href="#new-admin-tab" role="tab">Thêm Admin</a>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="admin-list-tab" role="tabpanel" aria-labelledby="admin-list-nav">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mã admin</th>
                                                <th>Tên</th>
                                                <th>Số điện thoại</th>
                                                <th>Đổi mật khẩu</th>
                                                <th>Phân quyền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sql1 = "SELECT * FROM `admin`";
                                                $rs1 = $conn->query($sql1);
                                                if (!$rs1) {
                                                    die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                                                    exit();
                                                }
                                                while($row = $rs1->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>". $row["admin_id"] ."</td>";
                                                    echo "<td>" . $row['admin_name'] . "</td>";
                                                    echo "<td>". $row["admin_phone"] ."</td>";
                                                    echo "<td><a class ='btn' href='change-admin-password.php?id=" . $row['admin_id'] . "'><i class='fas fa-cogs'></i></a></td>";
                                                    echo "<td>" . getAuthority($row['authority']) . "</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="new-admin-tab" role="tabpanel" aria-labelledby="new-admin-nav">
                                <form class="add-item" method="post" action="add-admin.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Tên Admin</label>
                                            <input class="form-control" type="text" name="name" placeholder="Tên">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Số điện thoại</label>
                                            <input class="form-control" type="text" name="phone" placeholder="Số điện thoại">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Mật khẩu</label>
                                            <input class="form-control" type="password" name="pass">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Phân quyền</label>
                                            <input  class="form-control" type="text" name="authority" placeholder="1: Chủ, 2: Nhân viên">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn" type="submit">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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