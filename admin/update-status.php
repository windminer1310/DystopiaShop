<?php  
    $id = $_GET['id'];
    $getStatus = $_GET['status'];
    $dbhost = 'localhost ';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, "database");

    if ($conn->connect_error) {
        echo "<h5>Không thể kết nối cơ sở dữ liệu!</h5>";
    }

    $sql1 = "SELECT * FROM `transaction` WHERE transaction_id = " . $id;
    $info = NULL;
    $rs1 = $conn->query($sql1);
    $row = $rs1->fetch_assoc();
    $listB = explode('-',$row['product_id']);
    $listQty = explode('-',$row['amount']);
    $temp = "";
    $info = $row;

    $status = 0;
    if($getStatus == "cancel"){
      $status = 4;
      for($i = 0; $i < count($listB); $i++){
          $sqlB = "SELECT * FROM product WHERE product_id = '$listB[$i]'";
          $rsB = $conn->query($sqlB);
          $rowB = $rsB->fetch_assoc();
          $qty = $rowB['amount'] + $listQty[$i];
          $sold = $rowB['sold'] - $listQty[$i];
          $temp = "UPDATE `product` SET amount = $qty, sold = $sold WHERE product_id = '$listB[$i]'";
          $rstemp = $conn->query($temp);
      }
    }else {
        if ($info['status'] == 0) {
          $status = 1;
          for($i = 0; $i < count($listB); $i++){
              $sqlB = "SELECT * FROM product WHERE product_id = '$listB[$i]'";
              $rsB = $conn->query($sqlB) or die($conn->error);;
              $rowB = $rsB->fetch_assoc();
              $qty = $rowB['amount'] - $listQty[$i];
              $sold = $rowB['sold'] + $listQty[$i];
              $temp = "UPDATE `product` SET amount = $qty, sold = $sold WHERE product_id = '" . $listB[$i] . "'";
              $rstemp = $conn->query($temp);
          }
        }
        elseif ($info['status'] == 1) {
          $status = 2;
        }
        elseif ($info['status'] == 2) {
          $status = 3;
        }
    }
    

    $sql2 = "UPDATE `transaction` SET status = " . $status . " WHERE transaction_id = " . $id;
    $rs2 = $conn->query($sql2);

    header("Location: transaction-management.php");
    exit();
?>