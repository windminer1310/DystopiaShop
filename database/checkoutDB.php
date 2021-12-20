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
        && isset($_POST["ward"]) && isset($_POST["address"]) && isset($_POST["note"])){
        $getPhone =  $_POST["phone"];
        $getName =  $_POST["name"];
        $getEmail =  $_POST["email"];
        $getCity=  $_POST["city"];
        $getDistrict =  $_POST["district"];
        $getWard =  $_POST["ward"];
        $getAddress =  $_POST["address"];
        $getNote =  $_POST["note"];
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
?>