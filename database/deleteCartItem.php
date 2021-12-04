<?php 
    include('connectDB.php');
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];


    $deleteCartItem = deleteRowWithTwoValue('cart', 'user_id', $user_id, 'product_id', $product_id);

    if (!$deleteCartItem) {
        header("Location: ../cart.php");
    } else {
        echo "<script>alert('Xóa thất bại')</script>";
        header("Location: ../cart.php");
    }

?>