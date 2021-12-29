<?php 
    session_start();
    require_once('./connectDB.php');
    if(isset($_SESSION['admin_id']) && isset($_SESSION['authority'])){
        if($_SESSION['authority'] != "1"){
            header('Location: index.php');
        }
        $user_id = $_SESSION['admin_id'];
    }
    else{
        header('Location: admin.php');
    }


    if (isset($_POST["admin-password--new"]) && isset($_POST["id__admin"])){
        $getNewPassword =  $_POST["admin-password--new"];
        $getIdAdmin =  $_POST["id__admin"];
    }else{
        header('Location: index.php');
    }
    
    $options = [
        'cost' => 10,
    ];

    $hashNewtPw = password_hash($getNewPassword, PASSWORD_BCRYPT, $options);

    $tableAdmin = 'admin';
    $adminTable = 'admin_id';

    $checkUserCurrentPw = getRowWithValue( $tableAdmin, $adminTable, $getIdAdmin );

    if($checkUserCurrentPw) {
        if(updateAdminPassword($getIdAdmin , $hashNewtPw)){
            echo "Đổi mật khẩu thành công!";
        }
        else {
            echo "Đổi mật khẩu thất bại!";
        }
    }
    
    
    function updateAdminPassword($user_id , $newPassword) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment adding in password only if change password was checked
		$statement = $databaseConnection->prepare( '
			UPDATE
				admin
			SET
                admin_password=:admin_password
			WHERE
                admin_id=:admin_id
		' );

		$params = array( //params 
			'admin_password' => trim( $newPassword ),
			'admin_id' => trim( $user_id )
		);
		// run the sql statement
		return $statement->execute( $params );
	}
?>