<<<<<<< Updated upstream
<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["phone"])){
        $getPhone =   $_POST["phone"];
    }

    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }

    $databaseNameTable = 'user';
    $column = 'user_phone';
    $userInfoWithPhone = getRowWithValue( $databaseNameTable, $column, $getPhone );

    displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword);




    function displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword){
        if($userInfoWithPhone) {
            $passHash = $userInfoWithPhone['user_password'];
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
        $_SESSION['name'] = $userInfoWithPhone['user_name'];
        $_SESSION['id'] = $userInfoWithPhone['user_id'];
    }

    function displayFailInfomation(){
        echo '<div class="fail-auth__form">Đăng nhập thất bại, vui lòng kiểm tra lại các thông tin!</div>';
    }

    function displayFailPassword(){
        echo '<div class="fail-auth__form">Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu đăng nhập!</div>';
    }

?>
=======
<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["phone"])){
        $getPhone =   $_POST["phone"];
    }

    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }

    $databaseNameTable = 'user';
    $column = 'user_phone';
    $userInfoWithPhone = getRowWithValue( $databaseNameTable, $column, $getPhone);
    displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword);

    function displayStatusAfterLoginWithPassword($userInfoWithPhone, $getPassword){
        if($userInfoWithPhone) {
            $passHash = $userInfoWithPhone['user_password'];
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
        $_SESSION['name'] = $userInfoWithPhone['user_name'];
        $_SESSION['id'] = $userInfoWithPhone['user_id'];
        
    }

    function displayFailInfomation(){
        echo '<div class="auth__form--fail">Đăng nhập thất bại, vui lòng kiểm tra lại các thông tin!</div>';
    }

    function displayFailPassword(){
        echo '<div class="auth__form--fail">Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu đăng nhập!</div>';
    }

?>
>>>>>>> Stashed changes
