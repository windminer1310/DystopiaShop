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

    $hashNewPw = password_hash($getNewPassword, PASSWORD_BCRYPT, $options);
    $tableName = 'user';
    $userTable = 'user_id';
    $user = getRowWithValue( $tableName, $userTable, $user_id );

    if($user) {
        $passHash = $user['user_password'];
        if (password_verify($getPassword, $passHash)) {
            $status = updatePassword($user_id , $hashNewPw);
            if(!$status){
                echo "1";
            }else{
                echo "-2";
            }
        }
        else {
            echo "-1";
        }
    }
    
    function updatePassword($user_id , $newPassword) {
		$databaseConnection = getDatabaseConnection();
		$statement = $databaseConnection->prepare( '
			UPDATE
				user
			SET
                user_password = :user_password
			WHERE
                user_id = :user_id
		' );
		$params = array(
			'user_id' => trim( $user_id ),
			'user_password' => trim($newPassword)
		);
		$statement->execute( $params );
	}
?>