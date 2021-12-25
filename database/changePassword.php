<<<<<<< Updated upstream
<?php 
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";

    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    }
    else{
        header('Location: index.php');
    }

    if (isset($_POST["password"])){
        $getPassword =  $_POST["password"];
    }

    if (isset($_POST["newPassword"])){
        $getNewPassword =  $_POST["newPassword"];
    }

    $md5Password = md5($getPassword);
    $md5NewPassword = md5($getNewPassword);

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE `user` SET password = '$md5NewPassword' WHERE user_id = $user_id and password = '$md5Password'";
    echo mysqli_query($conn, $sql);

    $sql1 = "SELECT password FROM `user` WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql1);
    /* Chỗ này bị lỗi "Argument #1 ($result) must be of type mysqli_result" */
    $row = mysqli_fetch_assoc($result);

    echo $row['password'];
    echo "\n";
    echo $md5NewPassword;
    if ($row['password'] === $md5NewPassword) {
        echo "
        <script>
            alert('Thay đổi mật khẩu thành công, vui lòng đăng nhập lại!');
            window.location.href = '../logout.php';
        </script>";
    }
    else {
        echo "
        <script>
            alert('Thay đổi mật khẩu thất bại, vui lòng nhập lại!');
            window.location.href = '../my_account.php#account-tab';
        </script>";
    }
      
    $conn->close();

=======
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
            echo '<div class="auth__form--success"> (Đổi mật khẩu thành công)</div>';
        }
        else {
            echo '<div class="auth__form--fail"> (Nhập mật khẩu cũ không đúng)</div>';
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
>>>>>>> Stashed changes
?>