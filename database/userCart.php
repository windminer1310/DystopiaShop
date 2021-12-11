<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["amountProduct"])){
        $getQuantity =  $_POST["amountProduct"];
    }

    $user_id = $_SESSION['id'];
    $product_id = $_SESSION['cart-product'];


    // $sql = "SELECT * FROM cart WHERE user_id = $user_id and product_id = '$product_id'";
    // $rs = $conn->query($sql);

    $tableName = 'cart';
    $userColumn = 'user_id';
    $productIdColumn = 'product_id';

    $userCartInfo = getRowWithTwoValue($tableName, $userColumn, $user_id, $productIdColumn, $product_id);

    $tableProduct = 'product';
    $productIdInfo = getRowWithValue($tableProduct, $productIdColumn, $product_id);

    


    if ($productIdInfo) {
        $amountB = $productIdInfo['amount'];
        if($amountB >= $getQuantity){
            if($userCartInfo){
                $qty = $userCartInfo['qty'] + $getQuantity;
                $updateStatusCart = updateCartInfo($user_id , $product_id, $qty);
                alertUpdateCartStatus(!$updateStatusCart);
            }
            else{
                $statusCart = insertCart($user_id, $product_id, $getQuantity);
                alertUpdateCartStatus($statusCart);
            }
        }else{
            echo "Số lượng sách không đủ để cung cấp.";
        }
    }else{
        echo "Truy xuất dữ liệu thất bại!";
        echo "Vui lòng liên hệ bộ phận CSKH.";
    }

    function insertCart($user_id, $product_id, $getQuantity){
        $databaseConnection = getDatabaseConnection();

        // create our sql statment
        $statement = $databaseConnection->prepare( '
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

        // execute sql with actual values
        $success = $statement->execute( array(
            'user_id' => trim( $user_id ),
            'product_id' => trim( $product_id ),
            'qty' => $getQuantity,
        ) );
        return $success;
    }

    function updateCartInfo( $user_id , $product_id, $quantity) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment adding in password only if change password was checked
		$statement = $databaseConnection->prepare( '
			UPDATE
				cart
			SET
                qty = :qty
			WHERE
                user_id = :user_id and 
                product_id = :product_id
		' );

		$params = array( //params 
			'user_id' => trim( $user_id ),
			'product_id' => trim( $product_id ),
            'qty' => $quantity
		);
		// run the sql statement
		$statement->execute( $params );
	}

    function alertUpdateCartStatus($statusCart){
        if ($statusCart) {
            echo "Cập nhật giỏ hàng thành công!";
        }else {
            echo 'Cập nhật giỏ hàng thất bại!';
        }
    }
?>