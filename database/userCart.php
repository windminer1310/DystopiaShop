<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";


    if (isset($_POST["amountProduct"])){
        $getQuantity =  $_POST["amountProduct"];
    }


    $user_id = $_SESSION['id'];
    $product_id = $_SESSION['cart-product'];


    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM cart WHERE user_id = $user_id and product_id = '$product_id'";
    $rs = $conn->query($sql);
    $sql1 = "";
    
    $sqlB = "SELECT * FROM product WHERE product_id = '$product_id'";
    $rsB = $conn->query($sqlB);
    $sqlB1 = "";
    
    if ($rsB->num_rows > 0) {
        $rowB = $rsB->fetch_assoc();
        $amountB = $rowB['amount'];
        if($amountB >= $getQuantity){
            if($rs->num_rows > 0){
                $row = $rs->fetch_assoc();
                $qty = $row['qty'] + $getQuantity;
                $sql1 = "UPDATE cart SET qty = $qty WHERE user_id = $user_id and product_id = '$product_id'";
            }
            else{
                $sql1 = "INSERT INTO cart (user_id, product_id, qty) VALUES($user_id, '$product_id', $getQuantity)";
            }
            if ($conn->multi_query($sql1) === TRUE) {
                echo "Thêm sản phẩm vào giỏ hàng thành công!";
            }else {
                echo 'Thêm sản phẩm vào giỏ hàng thất bại!';
            }
        }else{
            echo "Số lượng sách không đủ để cung cấp.";
        }
    }else{
        echo "Truy xuất dữ liệu thất bại!";
        echo "Vui lòng liên hệ bộ phận CSKH.";
    }

    $conn->close();

?>