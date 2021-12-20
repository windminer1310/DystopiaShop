<?php 
    session_start();
    require_once('./connectDB.php');

    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    }
    else{
        header('Location: index.php');
    }

    if (isset($_POST["current-password"])){
        $getPassword =  $_POST["current-password"];
    }

    if (isset($_POST["new-password"])){
        $getNewPassword =  $_POST["new-password"];
    }


    
    
    $options = [
        'cost' => 10,
    ];

    $hashNewtPw = password_hash($getNewPassword, PASSWORD_BCRYPT, $options);

    $tableName = 'user';
    $userTable = 'user_id';

    $checkUserCurrentPw = getRowWithValue( $tableName, $userTable, $user_id );


    if($checkUserCurrentPw) {
        $passHash = $checkUserCurrentPw['user_password'];
        if (password_verify($getPassword, $passHash)) {

            // updatePassword($user_id , $hashNewtPw);
            echo '<div class="succes-auth__form"> (Đổi mật khẩu thành công)</div>';
        }
        else {
            echo '<div class="fail-auth__form"> (Nhập mật khẩu cũ không đúng)</div>';
        }
    }
    
    function updatePassword($user_id , $newPassword) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment adding in password only if change password was checked
		$statement = $databaseConnection->prepare( '
			UPDATE
				user
			SET
                user_password = :user_password
			WHERE
                user_id = :user_id and 
                user_password = :user_password
		' );

		$params = array( //params 
			'user_id' => trim( $user_id ),
			'user_password' => trim( $newPassword )
		);
		// run the sql statement
		$statement->execute( $params );
	}
?>