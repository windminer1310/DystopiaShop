<?php
	$dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    $sql = "";
    if (isset($_GET['category_id'])) {
    	$sql = "DELETE FROM `category` WHERE category_id = '" . $_GET['category_id'] . "';";
    }
    if (isset($_GET['brand_id'])) {
    	$sql = "DELETE FROM `brand` WHERE brand_id = '" . $_GET['brand_id'] . "';";
    }
    
    $rs = $conn->query($sql);

    if ($rs) {
        echo "<script language='javascript'>window.alert('Đã xóa khỏi cơ sở dữ liệu!');</script>";
    }
    else {
        echo "<script language='javascript'>window.alert('Không thể xóa khỏi cơ sở dữ liệu!');</script>";
    }

    header("Location: product-management.php");
    exit();
?>