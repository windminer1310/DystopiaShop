<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["phone"]) && isset($_POST["password"])){
        $getPhone =   $_POST["phone"];
        $getPassword =  $_POST["password"];
    }else{
        header('Location: ../admin/admin-login.php');//
    }

    $adminTable = 'admin';
    $column = 'admin_phone';
    $employee = getRowWithValue($adminTable, $column, $getPhone );
    checkLogin($employee, $getPassword);

    function checkLogin($employee, $getPassword){
        if($employee) {
            $passHash = $employee['admin_password'];
            if(password_verify($getPassword, $passHash)){
                loginWithSession($employee);
                echo '';
            }
            else{
                errorFailPassword();
            }
        }
        else{
            errorFailInfo();
        }
    }

    function loginWithSession($employee){
        $_SESSION['admin_name'] = $employee['admin_name'];
        $_SESSION['admin_id'] = $employee['admin_id'];
        $_SESSION['authority'] = $employee['authority'];
    }
    function errorFailInfo(){
        echo "Tài khoản không tồn tại";
    }
    function errorFailPassword(){
        echo "Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu đăng nhập";
    }


?>