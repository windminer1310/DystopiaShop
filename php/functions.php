<?php
	/**
	 * Get DB connection
	 *
	 * @param void
	 *
	 * @return db connection
	 */
	function getDatabaseConnection() {
		try { // connect to database and return connections
			$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS );
			$conn->exec("set names utf8");
			return $conn;
		} catch ( PDOException $e ) { // connection to database failed, report error message
			return $e->getMessage();
		}
	}

	/**
	 * Get row from a table with a value
	 *
	 * @param string $tableName
	 * @param string $column
	 * @param string $value
	 *
	 * @return array $info
	 */
	function getRowWithValue( $tableName, $column, $value ) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				`' . $tableName . '`
			WHERE
				' . $column . ' = :' . $column
		);

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			$column => trim( $value )
		) );

		// get and return user
		$user = $statement->fetch();
		return $user;
	}

	/**
	 * Get user with email address
	 *
	 * @param array $email
	 *
	 * @return array $userInfo
	 */
	function getUserWithEmailAddress( $email ) {
		// get database connection
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			SELECT
				*
			FROM
				`user`
			WHERE
                user_email = :user_email
		' );

		// execute sql with actual values
		$statement->setFetchMode( PDO::FETCH_ASSOC );
		$statement->execute( array(
			'user_email' => $email
		) );

		// get and return user
		$user = $statement->fetch();
		return $user;
	}

	function insertRow( $info ){
		$databaseConnection = getDatabaseConnection();

		// create our sql statment
		$statement = $databaseConnection->prepare( '
			INSERT INTO
				user (
					user_name,
					user_email,
					user_phone,
					user_password,
					fb_user_id
				)
			VALUES (
				:user_name,
				:user_email,
				:user_phone,
				:user_password,
				:fb_user_id
			)
		' );
		
		// execute sql with actual values
		$statement->execute( array(
			'user_name' => trim( $info['first_name'] . " " . $info['last_name']),
			'user_email' => trim( $info['email'] ),
			'user_phone' => isset($info['id'] ) ? "FB" . $info['id'] : '',
			'user_password' => hashPassword(newKey()),
			'fb_user_id' => isset( $info['id'] ) ? $info['id'] : '',
		) );
        
	}

	function newKey( $length = 32 ) {
		$time = md5( uniqid() ) . microtime();
		return substr( md5( $time ), 0, $length );
	}

	function hashPassword($getPassword){
		$options = [
			'cost' => 10,
		];
		$hash = password_hash($getPassword, PASSWORD_BCRYPT, $options);
		return $hash;
	}


	/**
	 * Redirect to homepage
	 */
	function loggedInRedirect() {
		header( 'location: index.php' );
	}


	