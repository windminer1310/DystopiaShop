<?php
    session_start();
    include('connectDB.php');

    if (!isset($_POST["qty_add"]) || !isset($_POST["product_id"]) || !isset($_POST['is_in_cart'])){
        header('Location: ../product-list.php');
    }
    $totalAdd =  $_POST["qty_add"];
    $product_id = $_POST["product_id"];
    $isInCart = $_POST['is_in_cart'];

    $user_id = $_SESSION['id'];
    $productInfo = getRowWithValue('product', 'product_id', $product_id);
   
    if ($productInfo) {
        $qtyP = $productInfo['quantity'];
        $userCartInfo = getRowWithTwoValue('cart', 'user_id', $user_id, 'product_id', $product_id);
        if($userCartInfo && $isInCart = "0"){
            $totalAdd += $userCartInfo['qty'];
        }
        if($qtyP >= $totalAdd){
            if($userCartInfo){
                $updateCartStatus = updateCart($user_id ,$product_id, $totalAdd);
                statusUpdate($updateCartStatus);
            }else{
                $insertCartStatus = insertCart($user_id, $product_id, $totalAdd);
                statusUpdate(!$insertCartStatus);
            }
        }else{
            echo "0";
        }
    }else{
        echo "-2";
    }

    function insertCart($user_id, $product_id, $qty){
        $conn = getDatabaseConnection();
        $statement = $conn->prepare( '
            INSERT INTO
            cart (
                user_id,
                product_id,
                qty
            )
            VALUES (
                :user_id,
                :product_id,
                :qty
            )
        ' );
        $success = $statement->execute( array(
            'user_id' => trim( $user_id ),
            'product_id' => trim( $product_id ),
            'qty' => $qty,
        ) );
        return $success;
    }

    function updateCart( $user_id , $product_id, $quantity) {
		$conn = getDatabaseConnection();
		$statement = $conn->prepare( '
			UPDATE
				`cart`
			SET
                qty = :qty
			WHERE
                user_id = :user_id and 
                product_id = :product_id
		' );
		$params = array( 
			'user_id' => trim($user_id),
			'product_id' => trim($product_id),
            'qty' => $quantity
		);
		$statement->execute($params);
	}

    function statusUpdate($status){
        if (!$status) {
            echo "1";
        }else {
            echo '-1';
        }
    }
?>