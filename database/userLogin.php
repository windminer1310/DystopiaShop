<?php
    session_start();
    include('connectDB.php');
    
    if (isset($_POST["phone"])){
        $getPhone =   $_POST["phone"];
    }
    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }

    $userTable = 'user';
    $column = 'user_phone';
    $userInfo = getRowWithValue( $userTable, $column, $getPhone);
    displayStatus($userInfo, $getPassword);

    function displayStatus($userInfo, $getPassword){
        if($userInfo) {
            $passHash = $userInfo['user_password'];
            if(password_verify($getPassword, $passHash)){
                setLoginValueToSession($userInfo);
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

    function setLoginValueToSession($userInfo){
        $_SESSION['name'] = $userInfo['user_name'];
        $_SESSION['id'] = $userInfo['user_id'];
        
    }

    function displayFailInfomation(){
        echo 'Không tìm thấy thông tin tài khoản';
    }

    function displayFailPassword(){
        echo 'Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu';
    }

?>
