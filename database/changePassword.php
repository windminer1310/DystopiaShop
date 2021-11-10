<?php 
    session_start();
    $servername = "localhost:33066";
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

?>