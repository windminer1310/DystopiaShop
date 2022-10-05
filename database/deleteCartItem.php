<?php 

    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    mysqli_set_charset($conn,"utf8");


    $sql = "DELETE FROM cart WHERE user_id=$user_id and product_id='$product_id'";


    if ($conn->multi_query($sql) === TRUE) {
        header("Location: ../cart.php");
    } else {
        echo 'Xóa thất bại!';
    }
    $conn->close();

?>