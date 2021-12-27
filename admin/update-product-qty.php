<?php 
    require_once('../database/connectDB.php');
    if(isset($_GET['product_id']) && isset($_GET['qty'])){

    }

    $list_product_id = $_GET['product_id'];
    $list_product_qty = $_GET['qty'];
    $totalProduct = count($list_product_id);


    $updateProductWithExcelFile = updateProductQuantity( $list_product_id , $list_product_qty, $totalProduct);

    if($updateProductWithExcelFile) {
        echo ('Cập nhật số lượng sản phẩm thành công!');
    }
    else {
        echo ('Cập nhật số lượng sản phẩm Thất bại!');
    }

?>