<!DOCTYPE html>
<html>
<body>
    <?php
    	$dbhost = 'localhost:33066';
        $dbuser = 'root';
        $dbpass = '';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");
        $id = $_GET['id'];
        if ($conn->connect_error) {
            die("Lỗi không thể kết nối!");
            exit();
        }

        $sql = "DELETE FROM `product` WHERE product_id = '" . $id . "';";

        $rs = $conn->query($sql);
        header("Location: product-management.php");
        exit();
    ?>
</body>
</html>