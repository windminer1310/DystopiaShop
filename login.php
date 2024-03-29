<?php 
    session_start();
    require_once('moneyPoint.php');

    if(isset($_SESSION['name']) && isset($_SESSION['id'])){
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
        header('Location: index.php');
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");

    $sqlCart = "SELECT * FROM `cart` WHERE user_id = $user_id";
    $rs = $conn->query($sqlCart);
    if (!$rs) {
        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
        exit();
    }
    $productInCart = $rs->num_rows;

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
                        <a href="#" class="nav-item nav-link active">Trang chủ</a>
                        <a href="product-list.php" class="nav-item nav-link">Sản phẩm</a>
                        <a href="custom-pc.html" class="nav-item nav-link">Xây dựng cấu hình</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <div class="header__navbar-item header__navbar-user">
                            <img class = "avatar-img" src="img/avatar.jpg"/>
                            <span class="header__navbar-user-name"><?php echo $name;?></span>

                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-item">
                                    <a href="my-account.php">Tài khoản của tôi</a>
                                </li>
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
                    <a href="cart.php" class="btn cart">
                        <i class="fa fa-shopping-cart"></i>
                        <?php 
                        if($productInCart > 0){
                            echo "<div class='notify-cart'>";
                            echo "<span style='color: var(--white-color); font-size: 10px;'>".$productInCart."</span>";
                            echo "</div>";
                        }
                        ?>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Main Slider Start -->
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <nav class="navbar bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=laptop"><i class="bi bi-laptop"></i>Laptop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=vi xử lý"><i class="bi bi-cpu"></i>Vi xử lý</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=vga"><i class="bi bi-cpu"></i>VGA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=ổ+cứng"><i class="bi bi-hdd"></i>Ổ cứng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=màn+hình"><i class="bi bi-display"></i>Màn hình</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=chuột"><i class="bi bi-mouse2"></i>Chuột</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=bàn+phím"><i class="bi bi-keyboard"></i>Bàn phím</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=tai+nghe"><i class="bi bi-headphones"></i>Tai nghe</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-product-list.php?page_num=1&search=loa"><i class="bi bi-speaker"></i>Loa</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6">
                    <div class="header-slider normal-slider">
                        <div class="header-slider-item">
                            <img class="header-img" src="img/ad-img/asus-tuf-ads.jpg" alt="Slider Image" />
                        </div>
                        <div class="header-slider-item ">
                            <img class="header-img" src="img/ad-img/acer-predator-triton-300-ads.jpg" alt="Slider Image" />
                        </div>
                        <div class="header-slider-item">
                            <img class="header-img" src="img/ad-img/msi-raider-ge66-ads.jpg" alt="Slider Image" />
                        </div>
                        <div class="header-slider-item">
                            <img class="header-img" src="img/ad-img/lenovo-yoga-9-ads.jpg" alt="Slider Image" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="header-img">
                        <div class="img-item">
                        	<img src="img/msi-rtx-3090.png"/>
                            <div class="img-text">
                            </div>
                        </div>
                        <div class="img-item">
                        	<img src="img/msi-meg-z590-godlike.jpg"/>
                            <a class="img-text">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Slider End -->

    <!-- Featured Product Start -->
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Sản phẩm nổi bật</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
            	<?php
                    $sql3 = "SELECT * FROM `product` ORDER BY sold DESC LIMIT 10";
                    $rs3 = $conn->query($sql3);
                    if (!$rs3) {
                        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
                        exit();
                    }
                    while ($row = $rs3->fetch_array(MYSQLI_ASSOC)) {
                    	echo "<div class='col-lg-3'>";
                        if ($row['discount'] != 0) {
                        echo "<div class='product-item__sale-off'>";
                        echo "<span class = 'product-item__sale-off-percent'>".$row['discount']."%</span>";
                        echo "</div>";
                        }
                    	echo "<div class='product-item'>";                                            
                        echo "<div class='product-image'>";
                        echo "<a href='view-product-detail.html?id=" . $row['product_id'] . "'>";
                        echo "<img src='" . $row['image_link'] . "?>' alt='Product Image'>";
                        echo "</a>";
                        echo "<div class='product-action'>";
                        echo "<a href='view-product-detail.php?id=" . $row['product_id'] . "'><i class='fa fa-search'></i></a>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='product-price' style='height: 100px; padding:10px 50px 0;'>";
                        echo "<h2 style = 'line-height: 20px;
                        max-height: 40px;
                        overflow: hidden;
                        flex: 1;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        -webkit-line-clamp: 2;'>" . $row['product_name'] . "</h2>";
                        if ($row['discount'] != 0) {
                            $discount = $row['price'] - ($row['price'] * $row['discount'] * 0.01);
                            echo "<h3 style = 'position: absolute; bottom: 27px; '><span>" .  number_format($discount, 0, ',','.') . " đ</span></h3>";
                            echo "<h3 style='position: absolute; bottom: 7px; text-decoration: line-through; color: #888888; font-size:13px; font-weight: 500;'><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                        }
                        else{
                            echo "<h3 style = 'position: absolute; bottom: 27px; '><span>" .  number_format($row['price'], 0, ',', '.') . " đ</span></h3>";
                        }
                    	echo "</div>";
                    	echo "</div>";
                    	echo "</div>";
                    }
            	?>
            </div>
        </div>
    </div>
    <!-- Featured Product End -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                <div class="brand-item"><img src="img/brand/msi-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>
                <div class="brand-item"><img src="img/brand/acer-logo.jpg" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>
                <div class="brand-item"><img src="img/brand/asus-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>
                <div class="brand-item"><img src="img/brand/cooler-master-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>
                <div class="brand-item"><img src="img/brand/lenovo-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>  
                <div class="brand-item"><img src="img/brand/gigabyte-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>  
                <div class="brand-item"><img src="img/brand/hp-logo.png" alt=""></div>
                <div class="brand-item"><img src="" alt=""></div>              
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Category Start-->
    <div class="category">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="category-item ch-400">
                    	<img src="img/ad-img/case.jpg"/>
                        <a class="category-name" href="view-product-list.php?search=vỏ+case">
                            <p>CASE</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-250">
                    	<img src="img/ad-img/mainboard.jpg"/>
                        <a class="category-name" href="view-product-list.php?search=bo+mạch+chủ">
                            <p>MAINBOARD</p>
                        </a>
                    </div>
                    <div class="category-item ch-150">
                    	<img src="img/ad-img/vga.jpg"/>
                        <a class="category-name" href="view-product-list.php?search=vga">
                            <p>VGA</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-150">
                    	<img src="img/ad-img/monitor.jpg"/>
                        <a class="category-name" href="view-product-list.php?search=màn+hình">
                            <p>MONITOR</p>
                        </a>
                    </div>
                    <div class="category-item ch-250">
                    	<img src="img/ad-img/cpu.png"/>
                        <a class="category-name" href="view-product-list.php?search=vi+xử+lý">
                            <p>CPU</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-400">
                    	<img src="img/ad-img/laptop.jpg"/>
                        <a class="category-name" href="view-product-list.php?search=latop">
                            <p>LAPTOP</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category End-->

    <!-- Feature Start-->
    <div class="feature">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fab fa-cc-mastercard"></i>
                        <h2>Thanh toán an toàn</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-truck"></i>
                        <h2>Giao hàng toàn quốc</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-sync-alt"></i>
                        <h2>Đổi trả trong vòng 7 ngày</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-comments"></i>
                        <h2>Hổ trợ 24/7</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End-->

    <!-- Call to Action Start -->
    <div class="call-to-action">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Liên hệ với Dystopia</h1>
                </div>
                <div class="col-md-6">
                    <a href="tel:0123456789">0966-696-969</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

    <!-- Google Map Start -->
    <div class="contact">
        <div class="container-fluid">
            <div class="row">
            
                <div class="col-lg-12">
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0835321075647!2d106.71489441488534!3d10.804914192302194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a405e4245f%3A0x64cd17debf114781!2zMiBWw7UgT2FuaCwgUGjGsOG7nW5nIDI1LCBCw6xuaCBUaOG6oW5oLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1627547869109!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map End -->

    <!-- Footer Start -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Liên lạc</h2>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i>Số 2 đường Võ Oanh phường 25 quận Bình Thạnh</p>
                            <p><i class="fa fa-envelope"></i>dystopia@gmail.com</p>
                            <p><i class="fa fa-phone"></i>0966-696-969</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Theo dõi chúng tôi</h2>
                        <div class="contact-info">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-faceproduct-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Thông tin về cửa hàng</h2>
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
        function mustInput(){
            alert('Vui lòng đăng nhập!');
        }
    </script>
    
</body>

</html>