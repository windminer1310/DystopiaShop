
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";


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

$md5Password = md5($getPassword);


$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8");


$sql = "INSERT INTO user (user_name, user_email, user_phone, user_password) 
    VALUES('$getName', '$getEmail', '$getPhone', '$md5Password')";


if ($conn->multi_query($sql) === TRUE) {
    echo '<div class="succes-auth__form">Đăng ký thành công!</div>';
} else {
    echo '<div class="fail-auth__form">Số điện thoại đã được sử dụng!</div>';
}

$conn->close();    
 
?>
