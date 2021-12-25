<<<<<<< Updated upstream

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
    $hash = password_hash($getPassword, PASSWORD_BCRYPT, $options);

    $databaseConnection = getDatabaseConnection();

    // create our sql statment
    $statement = $databaseConnection->prepare( '
        INSERT INTO
        user (
            user_name,
            user_email,
            user_phone,
            user_password,
            fb_user_id
        )
        VALUES (
            :user_name,
            :user_email,
            :user_phone,
            :user_password,
            :fb_user_id
        )
    ' );

    // execute sql with actual values
    $success = $statement->execute( array(
        'user_email' => trim( $getEmail ),
        'user_name' => trim( $getName ),
        'user_phone' => $getPhone,
        'user_password' => $hash,
        'fb_user_id' => '',
    ) );

    if ($success) {
        echo '<div class="succes-auth__form">Đăng ký thành công!</div>';
    } else {
        echo '<div class="fail-auth__form">Số điện thoại đã được sử dụng!</div>';
    } 
 
?>


=======

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
    $hash = password_hash($getPassword, PASSWORD_BCRYPT, $options);

    $databaseConnection = getDatabaseConnection();

    // create our sql statment
    $statement = $databaseConnection->prepare( '
        INSERT INTO
        user (
            user_name,
            user_email,
            user_phone,
            user_password,
            fb_user_id
        )
        VALUES (
            :user_name,
            :user_email,
            :user_phone,
            :user_password,
            :fb_user_id
        )
    ' );

    // execute sql with actual values
    $success = $statement->execute( array(
        'user_email' => trim( $getEmail ),
        'user_name' => trim( $getName ),
        'user_phone' => $getPhone,
        'user_password' => $hash,
        'fb_user_id' => '',
    ) );

    if ($success) {
        echo '<div class="auth__form--success">Đăng ký thành công!</div>';
    } else {
        echo '<div class="auth__form--fail">Số điện thoại đã được sử dụng!</div>';
    } 
 
?>


>>>>>>> Stashed changes
