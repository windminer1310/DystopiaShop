<?php
    require_once('../database/connectDB.php');

    if(isset($_GET['category_id'])){
        $deleteCategory = deleteRowWithValue('category', 'category_id', $_GET['category_id']);
        if($deleteCategory){
            echo "<script>alert('Xóa loại sản phẩm thành công!')
                window.location.href = 'update-product-category-brand.php'
                </script>";
        }
        else{
            echo "<script>alert('Xóa loại sản phẩm thất bại!')
                window.location.href = 'update-product-category-brand.php'
                </script>";
        }
    }
    if(isset($_GET['brand_id'])){
        $deleteBrand = deleteRowWithValue('brand', 'brand_id', $_GET['brand_id']);
        if($deleteBrand){
            echo "<script>alert('Xóa thương hiệu sản phẩm thành công!')
                window.location.href = 'update-product-category-brand.php'
                </script>";
        }
        else {
            echo "<script>alert('Xóa thương hiệu sản phẩm thất bại!')
                window.location.href = 'update-product-category-brand.php'
                </script>";
        }
    }
?>