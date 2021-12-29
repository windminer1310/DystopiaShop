<?php 
    session_start();
    require_once('./connectDB.php');

    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    }

    if (isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["city"]) && isset($_POST["district"]) && isset($_POST["ward"])){
        $getPhone =  $_POST["phone"];
        $getName =  $_POST["name"];
        $getCity=  $_POST["city"];
        $getDistrict =  $_POST["district"];
        $getWard =  $_POST["ward"];
        $getAddress =  $_POST["address"];
        $getNote =  $_POST["note"]." ";
    }
    else{
        header('Location: ../checkout.php');
    }


    $specificAddress = $getCity ."-". $getDistrict ."-". $getWard ."-". $getAddress;
    $totalPrice = 0;
    $discountAmount = 0;
    $productIdPattern = "";
    $productQtyPattern = "";
    $count = 0;
    $tableCart = 'cart';
    $column = 'user_id';
    $getCartRow = getAllRowWithValue($tableCart, $column, $user_id);
    $count = $getCartRow->rowCount();
    foreach ($row = $getCartRow->fetchAll() as $value => $row){
        $count++;
        if($count == $count){
            $productIdPattern .= $row['product_id'];
            $productQtyPattern .= $row['qty'];
        }
        else{
            $productIdPattern .= $row['product_id'] . "-";
            $productQtyPattern .= $row['qty'] . "-";
        }
        $product_id = $row['product_id'];
        $tableName = 'product';
        $column = 'product_id';
        $productInfo = getRowWithValue( $tableName, $column, $product_id);
        $quantity = $row['qty'];
        $price = $productInfo['price'] * (100 - $productInfo['discount']) / 100;
        $totalPrice += $price*$quantity;
        $discountAmount += $productInfo['price']*$quantity - $price;
    }

    $date = new DateTime(null, new DateTimeZone('Asia/Ho_Chi_Minh'));
    $date = $date->getTimestamp();
    $order_id = time();
    $conn = getDatabaseConnection();
    $sql = "INSERT INTO `order` (order_id, user_id, transaction_id, order_status, order_date, amount, discount_amount, ship_name, ship_phone, ship_address, order_note, list_product, list_qty) 
    VALUES ('$order_id', '$user_id',NULL, -1, CURRENT_TIMESTAMP(), $totalPrice, $discountAmount, '$getName', '$getPhone', '$specificAddress', '$getNote', '$productIdPattern', '$productQtyPattern')";
    
    $sqlDelete = "DELETE FROM `cart` WHERE user_id = $user_id";
    
    $conn->query($sqlDelete);
    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Thanh toán thành công vui lòng truy cập tài khoản cá nhân để xem Thông tin về đơn hàng!');
            window.location.href = '../account.php';
        </script>";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $listProduct = explode('-',$productIdPattern);
    $listQty = explode('-',$productQtyPattern);
    $temp = "";

    for($i = 0; $i < count($listProduct); $i++){
        $sqlB = "SELECT * FROM product WHERE id = $listProduct[$i]";
        $rsB = $conn->query($sqlB);
        $rowB = $rsB->fetch_assoc();
        $qty = $rowB['quantity'] - $listQty[$i];
        $sold = $rowB['sold'] + $listQty[$i];
        $temp = "UPDATE `product` SET quantity = $qty, sold = $sold WHERE id = " . $listProduct[$i];
        $rstemp = $conn->query($temp);
      }

    $conn->close();
?>