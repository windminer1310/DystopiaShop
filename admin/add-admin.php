<?php
    $dbhost = 'localhost:33066';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
    if ($conn->connect_error) {
        die("Lỗi không thể kết nối!");
        exit();
    }
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['pass']) && isset($_POST['authority']) && ($_POST['authority'] == 1 || $_POST['authority'] == 2)) {
        $sql = "INSERT INTO `admin` (admin_name, admin_phone, admin_password, authority) VALUES ('" . $_POST['name'] . "', '" . $_POST['phone'] . "', MD5('" . $_POST['pass'] . "'), " . $_POST['authority'] . ")";
        $rs = $conn->query($sql);
        if (!$rs) {
            echo "Không thể thêm!";
        }
        else {
            header("Location: admin.php");
            exit();
        }
    }
?>