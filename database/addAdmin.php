<?php
    include('connectDB.php');


    if (isset($_POST["admin__name"])){
        $getName =  $_POST["admin__name"];
    }

    if (isset($_POST["admin__phone"])){
        $getPhone =  $_POST["admin__phone"];
    }

    if (isset($_POST["admin__password"])){
        $getPassword =  $_POST["admin__password"];
    }

    if (isset($_POST["authority"])){
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
                admin_name,
                admin_phone,
                admin_password,
                authority
            )
            VALUES (
                :admin_name,
                :admin_phone,
                :admin_password,
                :authority
            )
        ' );

        // execute sql with actual values
        $success = $statement->execute( array(
            'admin_name' => trim( $name ),
            'admin_phone' => trim( $phone ),
            'admin_password' => trim( $password ),
            'authority' => $authority,
        ) );
        return $success;
    }
?>