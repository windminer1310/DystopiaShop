<?php
    require_once('../database/connectDB.php');

    if (
    isset($_GET['category']) &&   
    isset($_GET['brand']) &&
    isset($_GET['price']) &&
    isset($_GET['amount']) &&
    isset($_GET['discount']) &&
    isset($_GET['description']) &&
    isset($_GET['product_id']) &&
    isset($_GET['product_name']) &&
    isset($_GET['image_link']) &&
    isset($_GET['date_first_available']) ){
        $category =  $_GET['category'];
        $brand =  $_GET['brand'];
        $price =  $_GET['price'];
        $amount =  $_GET['amount'];
        $discount =  $_GET['discount'];
        $description =  $_GET['description'];
        $product_id = $_GET['product_id'];
        $product_name = $_GET['product_name'];
        $image_link = $_GET['image_link'];
        $date_first_available = $_GET['date_first_available'];
    }
    else{
        header('./update-product.php');
    }

    $categoryInfo = getRowWithValue('category', 'category_name', $category);

    $brandInfo = getRowWithValue('brand', 'brand_name', $brand);

    $updateProduct = updateProduct($product_id, $categoryInfo['category_id'], $brandInfo['brand_id'],
                                $product_name, $date_first_available, $price, $discount, $amount, $image_link, $description );

    if($updateProduct) {
        echo "<script>alert('Chỉnh sửa sản phẩm thành công!')
        window.location.href = 'update-product.php?id=" . $product_id ."'
        </script>";
    }
    else {
        echo "<script>alert('Chỉnh sửa sản phẩm thất bại!')
        window.location.href = 'update-product.php?id=" . $product_id ."'
        </script>";
    }


    
?>