<?php
header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

if(isset($_SESSION['id']) && $_SESSION['totalPrice']){
    $user_id = $_SESSION['id'];
    $totalPrice = $_SESSION['totalPrice'];
}


$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

$partnerCode = 'MOMOXJF020211213';
$accessKey = 'GaQkkJK2t6OyLUH4';
$secretKey = 'GGCLGGadsZrL3waPeF0eOD1zZyzZfGd0';
$orderId = "MM".time()."";
$orderInfo = "Thanh toán cho đơn hàng: ".$orderId;
$amount = (int)$totalPrice/1000;
$autoCapture = false;
$redirectUrl = "https://a1e6-2402-800-629d-bbe1-b845-1456-fd0d-671c.ngrok.io/DystopiaShop/Momo/result.php";
$ipnUrl = "https://a1e6-2402-800-629d-bbe1-b845-1456-fd0d-671c.ngrok.io/DystopiaShop/Momo/ipn_momo.php";
$requestId = time() . "";
$requestType = "captureWallet";
$extraData = "";

//before sign HMAC SHA256 signature
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . 
            "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . 
            "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array('partnerCode' => $partnerCode,
    'requestId' => $requestId,
    'amount' => (int)$amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'autoCapture' => $autoCapture,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature);
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);  // decode json


if($jsonResult['orderId'] == $orderId && $jsonResult['resultCode'] == "0"){
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

    $orderInfoDB = $productIdPattern.'soluong'.$productAmountPattern;

    $sql = "INSERT INTO test_order (orderId, user_id, orderInfo, amount)
    VALUES ('$orderId','$user_id','$orderInfoDB',$amount)";
    $rs_order = $conn->query($sql);
    if (!$rs_order){
        echo "
        <script>
            alert('Có lỗi xảy ra trong quá trình khởi tạo thanh toán!');
            window.location.href = '../checkoutTest.php';
        </script>";
    }
    header('Location: ' . $jsonResult['payUrl']);
    $conn->close();

    
}

?>


