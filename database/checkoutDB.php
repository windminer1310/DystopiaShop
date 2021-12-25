<<<<<<< Updated upstream
<?php 
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";

    if(isset($_SESSION['id']) && $_SESSION['totalPrice']){
        $user_id = $_SESSION['id'];
        $totalPrice = $_SESSION['totalPrice'];
    }

    if (isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["city"]) && isset($_POST["district"])
        && isset($_POST["ward"]) && isset($_POST["address"]) && isset($_POST["message"])){
        $getPhone =  $_POST["phone"];
        $getName =  $_POST["name"];
        $getEmail =  $_POST["email"];
        $getCity=  $_POST["city"];
        $getDistrict =  $_POST["district"];
        $getWard =  $_POST["ward"];
        $getAddress =  $_POST["address"];
        $getmessage =  $_POST["message"];
    }
    else{
        header('Location: ../checkout.php');
    }

    $specificAddress = $getCity ."-". $getDistrict ."-". $getWard ."-". $getAddress;

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn,"utf8");

    $sqlCart = "SELECT * FROM `cart` WHERE user_id = $user_id";
    $rs = $conn->query($sqlCart);
    if (!$rs) {
        die("Lỗi không thể truy xuất cơ sở dữ liệu!");
        exit();
    }
    $productIdPattern = "";
    $productAmountPattern = "";
    $count = 0;
    $totalRow = $rs->num_rows;
    while ($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $count++;
        if($count == $totalRow ){
            $productIdPattern .= $row['product_id'];
            $productAmountPattern .= $row['qty'];
        }
        else{
            $productIdPattern .= $row['product_id'] . "-";
            $productAmountPattern .= $row['qty'] . "-";
        }
    }

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentDate = date('Y-m-d H:i:s');

    $sql = "INSERT INTO transaction (status, address, user_id, user_name, user_email, user_phone, amount, product_id, payment, message, date)
    VALUES (0, '$specificAddress', $user_id, '$getName', '$getEmail', '$getPhone', '$productAmountPattern', '$productIdPattern', $totalPrice, '$getmessage', '$currentDate')";
    $sqlDelete = "DELETE FROM cart WHERE user_id = $user_id";

    $conn->query($sqlDelete);
    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Thanh toán thành công vui lòng truy cập tài khoản cá nhân để xem Thông tin về đơn hàng!');
            window.location.href = '../my-account.php';
        </script>";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $listB = explode('-',$productIdPattern);
    $listQty = explode('-',$productAmountPattern);
    $temp = "";

    for($i = 0; $i < count($listB); $i++){
        $sqlB = "SELECT * FROM product WHERE id = $listB[$i]";
        $rsB = $conn->query($sqlB);
        $rowB = $rsB->fetch_assoc();
        $qty = $rowB['amount'] - $listQty[$i];
        $sold = $rowB['sold'] + $listQty[$i];
        $temp = "UPDATE `product` SET amount = $qty, sold = $sold WHERE id = " . $listB[$i];
        $rstemp = $conn->query($temp);
      }

    $conn->close();
=======
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
            window.location.href = '../my-account.php';
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
>>>>>>> Stashed changes
?>