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
    
    