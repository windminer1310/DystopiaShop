<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["phone"])){
        $getPhone =   $_POST["phone"];
    }

    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }


    $databaseNameTable = 'admin';
    $column = 'admin_phone';
    $userInfoWithPhone = getRowWithValue($databaseNameTable, $column, $getPhone );

    displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword);


    function displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword){
        if($userInfoWithPhone) {
            $passHash = $userInfoWithPhone['admin_password'];
            if(password_verify($getPassword, $passHash)){
                setLoginValueToSession($userInfoWithPhone);
                echo '';
            }
            else{
                displayFailPassword();
            }
        }
        else{
            displayFailInfomation();
        }
    }


    function setLoginValueToSession($userInfoWithPhone){
        $_SESSION['admin_name'] = $userInfoWithPhone['admin_name'];
        $_SESSION['admin_id'] = $userInfoWithPhone['admin_id'];
        $_SESSION['authority'] = $userInfoWithPhone['authority'];
    }

    function displayFailInfomation(){
        echo '<div class="fail-auth__form">Đăng nhập thất bại, vui lòng kiểm tra lại các thông tin!</div>';
    }

    function displayFailPassword(){
        echo '<div class="fail-auth__form">Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu đăng nhập!</div>';
    }


?>
