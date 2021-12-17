<?php
    session_start();
    include('connectDB.php');

    if (isset($_POST["amountProduct"])){
        $getQuantity =  $_POST["amountProduct"];
    }

    if (isset($_POST["idProductCart"])){
        $getProductId =  $_POST["idProductCart"];
    }

    $user_id = $_SESSION['id'];

    $productIdColumn = 'product_id';


    $tableProduct = 'product';
    $productIdInfo = getRowWithValue($tableProduct, $productIdColumn, $getProductId);



    if ($productIdInfo) {
        $amountB = $productIdInfo['amount'];
        if($amountB >= $getQuantity){
            $updateStatusCart = updateCartInfo($user_id , $getProductId, $getQuantity);
            alertUpdateCartStatus(!$updateStatusCart);
        }else{
            echo "Số lượng sản phẩm không đủ để cung cấp.";
        }
    }else{
        echo "Truy xuất dữ liệu thất bại!";
        echo "Vui lòng liên hệ bộ phận CSKH.";
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
            'qty' => trim( $quantity )
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