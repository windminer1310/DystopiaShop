<?php
    require_once('../database/connectDB.php');

    $product_id = $_GET['product_id'];


    $tableName = 'product';
    $productColumn = 'product_id';

    $deleteProduct = deleteRowWithValue($tableName, $productColumn, $product_id);

    if($deleteProduct) {
        echo "<script>alert('Xóa sản phẩm thành công!')
        window.location.href = 'product-management.php'
        </script>";
    }
    else{
        echo "<script>alert('Xóa sản phẩm thất bại!')
        window.location.href = 'update-product.php?id=" . $product_id ."'
        </script>";
    }

?>
