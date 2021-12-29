
<?php
    include('connectDB.php');
    
    if (isset($_POST["name"])){
        $getName =  $_POST["name"];
    }
    if (isset($_POST["email"])){
        $getEmail =  $_POST["email"];
    }
    if (isset($_POST["phone"])){
        $getPhone =  $_POST["phone"];
    }
    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }
    $options = [
        'cost' => 10,
    ];

    $checkPhone = getRowWithValue( 'user', 'user_phone', $getPhone);
    $checkEmail = getRowWithValue( 'user', 'user_email', $getEmail);
    if($checkPhone == false && $checkEmail == false){
        $hash = password_hash($getPassword, PASSWORD_BCRYPT, $options);
        $conn = getDatabaseConnection();
        $statement = $conn->prepare( '
            INSERT INTO
            user (
                user_id,
                user_name,
                user_email,
                user_phone,
                user_password,
                fb_user_id
            )
            VALUES (
                :user_id,
                :user_name,
                :user_email,
                :user_phone,
                :user_password,
                :fb_user_id
            )
        ' );
        $success = $statement->execute( array(
            'user_id' => time(),
            'user_email' => trim($getEmail),
            'user_name' => trim($getName),
            'user_phone' => $getPhone,
            'user_password' => $hash,
            'fb_user_id' => ''
        ));
        if ($success) {
            echo '<div class="auth__form--success">Đăng ký thành công</div>';
        } else {
            echo '<div class="auth__form--fail">Đã có lỗi xảy ra. Vui lòng thử lại sau.</div>';
        }
    }else{
        echo '<div class="auth__form--fail">Số điện thoại hoặc email đã được sử dụng</div>';
    }

    
    // echo "<script>alert(".$success.")</script>";
     
 
?>


