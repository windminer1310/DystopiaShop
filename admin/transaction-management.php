<?php
    require_once('../display.php');
    require_once('../database/connectDB.php');
    session_start();

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
        $author = $_SESSION['authority'];
    }
    else{
        header('Location: admin-login.html');
    }

    $day = "";
    $status = "";
    $sqlArray = [];
    $filterQuery = "SELECT * FROM `order` ";

    if (isset($_GET['status']) && strlen(trim($_GET['status'])) == 1 ) {
        $status = $_GET['status'];
        if($status != "" && (int)$status >= 0 && (int)$status <= 4){
            $sqlStatus = " `order_status` = ".$status." ";
            array_push($sqlArray, $sqlStatus);
            $filterQuery = "SELECT * FROM `order` WHERE ";
        }
    }

    if (isset($_GET['day'])) {
        $day = $_GET['day'];
        if($day == "1" || $day == "7" || $day == "30"){
            $currentDate = date('Y-m-d h:i:s');
            $startDate = date('Y-m-d h:i:s', strtotime('-'.(int)$day.' day', strtotime($currentDate)));
            $sqlDate = " `order_date` BETWEEN \"".$startDate."\" AND \"".$currentDate."\"";
            array_push($sqlArray, $sqlDate);
            $filterQuery = "SELECT * FROM `order` WHERE ";
        };
    }
    

    $sqlArray = join(" AND ", $sqlArray);
    $filterQuery = $filterQuery.$sqlArray;

?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <title>Dystopia Store</title>
        <link rel="icon" href="../img/favicons/favicon-32x32.png">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <!-- CSS Libraries -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <!-- Template Stylesheet -->
        <link href="../css/grid.css" rel="stylesheet">
        <link href="../css/base.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
    </head>
    <body>
        <div id="page-container">
            <!-- Header Start -->
            <header id="header">
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
                            <a href="./transaction-management.php" class="header__link header__link--active">
                                QUẢN LÝ ĐƠN HÀNG
                            </a>
                        </div>
                        <div class="header__item">
                            <a href="./product-management.php" class="header__link">
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
                                    <a href="./my-account.php">Tài khoản của tôi</a>
                                </li>
                                <li class="header__user-item">
                                    <a href="./logout.php" >Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Header End --> 
            <div id="content-wrap">
                <!-- Breadcrumb Start -->
                <div id="breadcrumb">
                    <div class="grid wide">
                        <ul class="list-path-link">
                            <li class="path-link"><a href="">QUẢN LÝ ĐƠN HÀNG</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                <div class='last-section'>
                    <div class='grid wide'>
                        <div class=' row'>
                            <div class='col l-3'>
                                <div class='user__nav'>
                                    <div class='user-nav__item user-nav__item--active'>
                                        <i class="header__icon bi bi-card-list"></i>
                                        <span class='user-nav__text'>Quản lý đơn hàng</a></span>
                                    </div>
                                    <div class="user-nav__item-fake">
                                        <div class="user-nav__text">Trạng thái</div>
                                        <select id="order-status" onchange="selectOrderStatus()">
                                            <option value="">Tất cả đơn hàng</option>
                                            <option value="0">Chờ xử lý</option>
                                            <option value="1">Đã được xác nhận</option>
                                            <option value="2">Đang vận chuyển</option>
                                            <option value="3">Đã hoàn thành</option>
                                            <option value="4">Đã huỷ đơn</option>
                                        </select>
                                    </div>
                                    <div class="user-nav__item-fake">
                                        <div class="user-nav__text">Thời gian</div>
                                        <select id="order-date" onchange="selectOrderDate()">
                                            <option value="" >Tất cả</option>
                                            <option value="1">Hôm nay</option>
                                            <option value="7">7 ngày qua</option>
                                            <option value="30">30 ngày qua</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='col l-9'>
                                <div class='user-account__content user-account__content--active'>
                                    <div class="user-account__order">
                                            <div class='heading'>
                                                <div class="grid">
                                                    <div class="row no-gutters">
                                                        <div class='table__col-title col l-2'  >Mã đơn hàng</div>
                                                        <div class='table__col-title col l-4'  >Danh sách sản phẩm</div>
                                                        <div class='table__col-title col l-2'  >Ngày đặt hàng</div>
                                                        <div class='table__col-title col l-2'  >Tổng tiền</div>
                                                        <div class='table__col-title col l-2'  >Trạng thái</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order__list-item" id="scrollbar">
                                                <?php
                                                    $conn = getDatabaseConnection();
                                                    $stmt = $conn->prepare($filterQuery);
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    $stmt->execute();
                                                    foreach ($row = $stmt->fetchAll() as $value => $row){
                                                        echo "<div class='row no-gutters info-order__item'>
                                                            <a class='col l-2' href='checkout-transaction.php?id_transaction=" . $row['order_id'] . "'>
                                                            ". $row["order_id"] ."</a>
                                                            <p class='col l-4'>". $row['list_product'] ."</p>
                                                            <p class='col l-2'>". date("d-m-Y h:i A", strtotime($row['order_date']))."</p>
                                                            <p class='col l-2'>". number_format($row["amount"], 0, ',', '.') ." đ</p>
                                                            <p class='col l-2'>".$row['order_status']."</p>
                                                        </div>";
                                                    }
                                                ?>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>              
    </body>
    <script>
        function updateSelection(){
            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            
            var statusSelect = document.getElementById("order-status").options;
            if($_GET['status'] == 0) statusSelect[1].setAttribute("selected","selected"); 
            else if($_GET['status'] == 1) statusSelect[2].setAttribute("selected","selected"); 
            else if($_GET['status'] == 2) statusSelect[3].setAttribute("selected","selected"); 
            else if($_GET['status'] == 3) statusSelect[4].setAttribute("selected","selected"); 
            else if($_GET['status'] == 4) statusSelect[5].setAttribute("selected","selected"); 
            else statusSelect[0].setAttribute("selected","selected"); 

            var daySelect = document.getElementById("order-date").options;
            if($_GET['day'] == 1) daySelect[1].setAttribute("selected","selected"); 
            else if($_GET['day'] == 7) daySelect[2].setAttribute("selected","selected"); 
            else if($_GET['day'] == 30) daySelect[3].setAttribute("selected","selected"); 
            else daySelect[0].setAttribute("selected","selected");
        }
        updateSelection();
        function selectOrderStatus(){
            var e = document.getElementById("order-status");
            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            var link = "./transaction-management.php?";
            var status = "";
            var day = "";

            if(e.value != "") status = "status="+e.value;
            if($_GET['day']) day = "day="+$_GET['day'];
            var filter = [status, day]

            x = filter.join('&');
            link = link + x;

            window.location.href = link; 
        }
        function selectOrderDate(){
            var e = document.getElementById("order-date");

            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            var link = "./transaction-management.php?";
            var status = "";
            var day = "";

            if(e.value != "") day = "day="+e.value;
            if($_GET['status']) status = "status="+$_GET['status'];
            var filter = [status, day]

            x = filter.join('&');
            link = link + x;

            window.location.href = link; 
        }
    </script>
</html>