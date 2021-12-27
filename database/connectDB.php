<?php
    
    function getDatabaseConnection() {
        $host = 'localhost';
        $db_name = 'database';
        $db_user = 'root';
        $db_password = '';
        try { // connect to database and return connections
            $conn = new PDO( 'mysql:host=' . $host . ';dbname=' . $db_name, $db_user, $db_password );
            $conn->exec("set names utf8");
            return $conn;
        } catch ( PDOException $e ) { // connection to database failed, report error message
            return $e->getMessage();
        }
    }

    function getRowWithValue( $tableName, $column, $value ) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				' . $tableName . '
			WHERE
				' . $column . ' = :' . $column
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			$column => trim( $value )
		) );

		// get and return user
		$result = $statement->fetch();
		return $result;
	}
    
	function getAllRowWithValue( $tableName, $column, $value ){
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				' . $tableName . '
			WHERE
				' . $column . ' = :' . $column
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			$column => trim( $value )
		) );

		// get and return user
		return $statement;
	}

	function getRowWithNFeaturedProducts( $tableName, $column, $numberOfValues) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare('
			SELECT
				*
			FROM
				' . $tableName . '
			ORDER BY
				' . $column . ' DESC LIMIT ' . $numberOfValues
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();
		return $statement;
	}

	function getRowWithTable($tableName){
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				' . $tableName
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();

		return $statement;
	}


    function deleteRowWithTwoValue($tableName, $firstColumn, $firstValue , $secondColumn, $secondValue ) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			DELETE
			FROM
				' . $tableName . '
			WHERE
				' . $firstColumn . ' = :' . $firstColumn . ' AND ' 
                  . $secondColumn . ' = :' . $secondColumn

		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			$firstColumn => trim( $firstValue ),
            $secondColumn => trim( $secondValue )
		) );

		// get and return result

		$result = $statement->fetch();
		return $result;
	}

	function deleteRowWithValue($tableName, $firstColumn, $firstValue) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			DELETE
			FROM
				' . $tableName . '
			WHERE
				' . $firstColumn . ' = :' . $firstColumn 

		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$result = $statement->execute( array(
			$firstColumn => trim( $firstValue )
		) );

		// get and return result
		return $result;
	}


    function getRowWithTwoValue($tableName, $firstColumn, $firstValue , $secondColumn, $secondValue ) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				' . $tableName . '
			WHERE
				' . $firstColumn . ' = :' . $firstColumn . ' AND ' 
                  . $secondColumn . ' = :' . $secondColumn

		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			$firstColumn => trim( $firstValue ),
            $secondColumn => trim( $secondValue )
		) );

		// get and return result

		$result = $statement->fetch();
		return $result;
	}

	// Lấy sản phẩm đang giảm giá
	function getDiscountProducts() {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare('
			SELECT
				*
			FROM
				product
			WHERE
				discount > 0
		');

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();
		return $statement;
	}
	
	function getDiscountProductsInPage($start, $totalProductInPage) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare('
			SELECT
				*
			FROM
				product
			WHERE
				discount > 0
			LIMIT ' . $start . ' , ' . $totalProductInPage
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();
		return $statement;
	}
    
	function getProductsInPage($start, $totalProductInPage) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare('
			SELECT
				*
			FROM
				product
			LIMIT ' . $start . ' , ' . $totalProductInPage
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();
		return $statement;
	}

	function getAllTransactionNotCompletedForDays( $tableName, $column, $days){
		$currentDate = date("Y-m-d");

		$startDate = date('Y-m-d', strtotime('-'.$days.' day', strtotime($currentDate)));
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				' . $tableName . '
			WHERE
				' . $column . ' != 3 and '
				  . $column . ' != 4 and '
				  . 'date BETWEEN "'. $startDate .'" AND "'. $currentDate .'"'
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute();

		// get and return user
		return $statement;
	}

    function getAllTransactionWithStatus( $tableName, $column, $status){
		// get database connection
		$databaseConnection = getDatabaseConnection();

		if($status == 'finish'){
			$statement = $databaseConnection->prepare( '
				SELECT
					*
				FROM
					' . $tableName . '
				WHERE
					' . $column . ' =  3 or '
					. $column . ' =  4'
			);
		}
		else{
			$statement = $databaseConnection->prepare( '
				SELECT
					*
				FROM
					' . $tableName . '
				WHERE
					' . $column . ' !=  3 or '
					. $column . ' !=  4'
			);
		}

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute();

		// get and return user
		return $statement;
	}

	function getAllTransactionWithStatusAndDate( $tableName, $column, $status, $days){
		$currentDate = date("Y-m-d");

		$startDate = date('Y-m-d', strtotime('-'.$days.' day', strtotime($currentDate)));
		// get database connection
		$databaseConnection = getDatabaseConnection();

		if($status == 'finish'){
			$statement = $databaseConnection->prepare( '
				SELECT
					*
				FROM
					' . $tableName . '
				WHERE
					(' . $column . ' =  3 or '
					. $column . ' =  4) and'
					. ' date BETWEEN "'. $startDate .'" AND "'. $currentDate .'"'
			);
		}
		else{
			$statement = $databaseConnection->prepare( '
				SELECT
					*
				FROM
					' . $tableName . '
				WHERE
					(' . $column . ' !=  3 or '
					. $column . ' !=  4) and'
					. ' date BETWEEN "'. $startDate .'" AND "'. $currentDate .'"'
			);
		}

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute();

		// get and return user
		return $statement;
	}

	function getRowWithColumnOrderBy( $tableName, $column) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare('
			SELECT
				*
			FROM
				' . $tableName . '
			ORDER BY
				' . $column 
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );

		$statement->execute();
		return $statement;
	}

	function updateProduct( $product_id , $category, $brand, $product_name, $date_first_available, $price, $discount, $amount, $img_link, $description) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment adding in password only if change password was checked
		$statement = $databaseConnection->prepare( '
			UPDATE
				product
			SET
                product_id = :product_id ,
				category_id = :category_id ,
				brand_id = :brand_id ,
				product_name = :product_name ,
				date_first_available = :date_first_available ,
				price = :price ,
				discount = :discount ,
				amount = :amount ,
				image_link = :image_link ,
				description = :description
			WHERE
			product_id = :product_id
		' );
		$params = array( //params 
			'product_id' => trim( $product_id ),
			'category_id' => trim( $category ),
			'brand_id' => trim( $brand ),
			'product_name' => trim( $product_name ),
			'date_first_available' => trim( $date_first_available ),
			'price' => trim( $price ),
			'discount' => trim( $discount ),
			'amount' => trim( $amount ),
			'image_link' => trim( $img_link ),
			'description' => trim( $description )
		);
		// run the sql statement
		$statement->execute( $params );
		return $statement;
	}

	function addProduct($product_id , $category, $brand, $product_name, $date_first_available, $price, $discount, $amount, $img_link, $description, $sold) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment adding in password only if change password was checked
		$statement = $databaseConnection->prepare( '
			INSERT INTO
			product (
				product_id,
				category_id,
				brand_id,
				product_name,
				date_first_available,
				price,
				discount,
				amount,
				image_link,
				description,
				sold
			)
			VALUES (
				:product_id,
				:category_id,
				:brand_id,
				:product_name,
				:date_first_available,
				:price,
				:discount,
				:amount,
				:image_link,
				:description,
				:sold
			)
		' );
		$params = array( //params 
			'product_id' => trim( $product_id ),
			'category_id' => trim( $category ),
			'brand_id' => trim( $brand ),
			'product_name' => trim( $product_name ),
			'date_first_available' => trim( $date_first_available ),
			'price' => trim( $price ),
			'discount' => trim( $discount ),
			'amount' => trim( $amount ),
			'image_link' => trim( $img_link ),
			'description' => trim( $description ) ,
			'sold' => trim( $sold )
		);
		// run the sql statement
		$statement->execute( $params );
		return $statement;
	}

	function updateProductQuantity( $product_id , $quantity, $totalProduct) {
		// get database connection
		$databaseConnection = getDatabaseConnection();


		$statement = $databaseConnection->prepare( '
			UPDATE
				product
			SET
                amount = :amount 
			WHERE
				product_id = :product_id
		' );

		for($i = 0; $i < $totalProduct; $i++){
			$params[$i] = array( //params 
				'product_id' => trim( $product_id[$i] ),
				'amount' => trim( $quantity[$i] )
			);
			// run the sql statement
	
			$statement->execute( $params[$i] );
		}
		
		return $statement;
	}

	function addTableWithTwoValue($table, $firstColumn, $firstValue, $secondColumn, $secondValue ){
        $databaseConnection = getDatabaseConnection();

        // create our sql statment
        $statement = $databaseConnection->prepare( '
            INSERT INTO
            '.$table.' (
                '.$firstColumn.',
                '.$secondColumn.'
            )
            VALUES (
                :firstValue,
                :secondValue
            )
        ' );

        // execute sql with actual values
        $success = $statement->execute( array(
            'firstValue' => trim( $firstValue ),
            'secondValue' => trim( $secondValue  )
        ) );
        return $success;
    }