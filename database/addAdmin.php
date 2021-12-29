<?php
    include('connectDB.php');

    if (isset($_POST["admin_name"]) && isset($_POST["admin_phone"]) && isset($_POST["admin_password"]) && isset($_POST["authority"])){
        $getName =  $_POST["admin_name"];
        $getPhone =  $_POST["admin_phone"];
        $getPassword =  $_POST["admin_password"];
        $getAuthority =  $_POST["authority"];
    }
    
    $options = [
        'cost' => 10,
    ];

    $hashNewtPw = password_hash($getPassword, PASSWORD_BCRYPT, $options);

    if(addAdmin($getName, $getPhone, $hashNewtPw, $getAuthority )){
        echo "<script>
            alert('Thêm nhân viên thành công!');
            window.location.href = '../admin/admin.php';
        </script>";
    }
    else{
        echo "<script>
            alert('Thêm nhân viên Thất bại, số điện thoại bị trùng!');
            window.location.href = '../admin/admin.php';
        </script>";
    }

    function addAdmin($name, $phone, $password, $authority ){
        $databaseConnection = getDatabaseConnection();

        // create our sql statment
        $statement = $databaseConnection->prepare( '
            INSERT INTO
            admin (
                admin_id,
                admin_name,
                admin_phone,
                admin_password,
                authority
            )
            VALUES (
                :admin_id,
                :admin_name,
                :admin_phone,
                :admin_password,
                :authority
            )
        ' );

        // execute sql with actual values
        $success = $statement->execute( array(
            'admin_id' => time(),
            'admin_name' => trim( $name ),
            'admin_phone' => trim( $phone ),
            'admin_password' => trim( $password ),
            'authority' => $authority,
        ) );
        return $success;
    }
?>