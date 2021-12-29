<?php  
    $id = $_GET['id'];
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    if ($conn->connect_error) {
        echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
    }

    $sql1 = "SELECT * FROM `transaction` WHERE id = " . $id;
    $info = NULL;
    $rs1 = $conn->query($sql1);
    while($row = $rs1->fetch_assoc()) {
    	$info = $row;
    }
    
    $sql2 = "UPDATE `transaction` SET status = 4 WHERE id = " . $id;
    $rs2 = $conn->query($sql2);

    $sql1 = "SELECT * FROM `transaction` WHERE id = " . $id;
    $info = NULL;
    $rs1 = $conn->query($sql1);
    $row = $rs1->fetch_assoc();
    $listB = explode('-',$row['product_id']);
    $listQty = explode('-',$row['amount']);
    $temp = "";

    for($i = 0; $i < count($listB); $i++){
        $sqlB = "SELECT * FROM product WHERE id = $listB[$i]";
        $rsB = $conn->query($sqlB);
        $rowB = $rsB->fetch_assoc();
        $qty = $rowB['amount'] + $listQty[$i];
        $sold = $rowB['sold'] - $listQty[$i];
        $temp = "UPDATE `product` SET amount = $qty, sold = $sold WHERE id = " . $listB[$i];
        $rstemp = $conn->query($temp);
      }

    header("Location: account.php");
    exit();
?>