<?php
    require_once('./connectDB.php');
    
    if (isset($_GET["admin_id"])){
        $getAdminId =  $_GET["admin_id"];
    }


    $adminTable = 'admin';
    $adminIdColumn = 'admin_id';

    if(deleteRowWithValue($adminTable, $adminIdColumn, $getAdminId)){
        echo "<script>
            alert('Xóa nhân viên thành công!');
            window.location.href = '../admin/admin.php';
        </script>";
    }
    else{
        echo "<script>
            alert('Xóa nhân viên Thất bại!');
            window.location.href = '../admin/admin.php';
        </script>";
    }

    
?>