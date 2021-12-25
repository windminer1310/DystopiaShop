<<<<<<< Updated upstream
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

if (isset($_POST["phone"])){
    $getPhone =  $_POST["phone"];
}

if (isset($_POST["password"])){
    $getPassword =  $_POST["password"];
}


$md5Password = md5($getPassword);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8");

$sql = "SELECT * FROM admin WHERE admin_phone = '$getPhone' AND admin_password = '$md5Password' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['name'] = $row['admin_name'];
    $_SESSION['id'] = $row['admin_id'];
    $_SESSION['authority'] = $row['authority'];
    echo $row['authority'];
} else {
    echo '<div class="fail-auth__form">Đăng nhập thất bại, vui lòng kiểm tra lại các thông tin!</div>';
}
$conn->close();
 
?>
=======
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

if (isset($_POST["phone"])){
    $getPhone =  $_POST["phone"];
}

if (isset($_POST["password"])){
    $getPassword =  $_POST["password"];
}


$md5Password = md5($getPassword);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8");

$sql = "SELECT * FROM `admin` WHERE admin_phone = '$getPhone' AND admin_password = '$md5Password' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['name'] = $row['admin_name'];
    $_SESSION['id'] = $row['admin_id'];
    $_SESSION['authority'] = $row['authority'];
    echo $row['authority'];
} else {
    echo '<div class="auth__form--fail">Đăng nhập thất bại, vui lòng kiểm tra lại các thông tin!</div>';
}
$conn->close();
 
?>
>>>>>>> Stashed changes
