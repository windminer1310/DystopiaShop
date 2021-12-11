<?php
    function makeFacebookApiCall( $endpoint, $params ) {
		// open curl call, set endpoint and other curl params
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );

		// get curl response, json decode it, and close curl
		$fbResponse = curl_exec( $ch );
		$fbResponse = json_decode( $fbResponse, TRUE );
		curl_close( $ch );

		return array( // return response data
			'endpoint' => $endpoint,
			'params' => $params,
			'has_errors' => isset( $fbResponse['error'] ) ? TRUE : FALSE, // boolean for if an error occured
			'error_message' => isset( $fbResponse['error'] ) ? $fbResponse['error']['message'] : '', // error message
			'fb_response' => $fbResponse // actual response from the call
		);
	}

    function getFacebookLoginUrl(){

        $endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';

        $params = array(
            'client_id' => FB_APP_ID,
            'redirect_uri' => FB_REDIRECT_URI,
            'state' => FB_APP_STATE,
            'scope' => 'email',
            'auth_type' => 'rerequest'
        );
        return $endpoint . '?' . http_build_query($params);
    }

    function getAccessTokenWithCode( $code ) {
		// endpoint for getting an access token with code
		$endpoint = FB_GRAPH_DOMAIN . FB_GRAPH_VERSION . '/oauth/access_token';

		$params = array( // params for the endpoint
			'client_id' => FB_APP_ID,
			'client_secret' => FB_APP_SECRET,
			'redirect_uri' => FB_REDIRECT_URI,
			'code' => $code
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}

    function tryAndLoginWithFacebook( $get ) {
		// assume fail
		$status = 'fail';
		$message = '';

		// reset session vars
		$_SESSION['fb_access_token'] = array();
		$_SESSION['fb_user_info'] = array();

		if ( isset( $get['error'] ) ) { // error comming from facebook GET vars
			$message = $get['error_description'];
		} 
		else { // no error in facebook GET vars
			// get an access token with the code facebook sent us
			$accessTokenInfo = getAccessTokenWithCode( $get['code'] );

			if ( $accessTokenInfo['has_errors'] ) { // there was an error getting an access token with the code
				$message = $accessTokenInfo['error_message'];
			} 
			else { // we have access token! 
				// set access token in the session
				$_SESSION['fb_access_token'] = $accessTokenInfo['fb_response']['access_token'];

				// get facebook user info with the access token
				$fbUserInfo = getFacebookUserInfo( $_SESSION['fb_access_token'] );

				if ( !$fbUserInfo['has_errors'] && !empty( $fbUserInfo['fb_response']['id'] ) && !empty( $fbUserInfo['fb_response']['email'] ) ) { // facebook gave us the users id/email
					// 	all good!
					$status = 'ok';

					// save user info to session
					$_SESSION['fb_user_info'] = $fbUserInfo['fb_response'];

					$databaseNameTable = 'user';
					// check for user with facebook id
					$userInfoWithId = getRowWithValue( $databaseNameTable, 'fb_user_id', $fbUserInfo['fb_response']['id'] );

					// check for user with email
					$userInfoWithEmail = getRowWithValue( $databaseNameTable, 'user_email', $fbUserInfo['fb_response']['email'] );

					if ( !$userInfoWithId || !$userInfoWithEmail) { // user hasn't logged in with facebook before
						$info = $fbUserInfo['fb_response'];
						insertRow($info);
                        $userInfoWithId = getRowWithValue( $databaseNameTable, 'fb_user_id', $fbUserInfo['fb_response']['id'] );
					}
                    
					$userInfo = getRowWithValue( $databaseNameTable, 'user_id', $userInfoWithId['user_id'] );

					$_SESSION['name'] = $userInfo['user_name'];
        			$_SESSION['id'] = $userInfo['user_id'];
					$_SESSION['img_url'] = $fbUserInfo['fb_response']['picture']['data']['url'];

					loggedInRedirect(); 

				} else {
					$message = 'Invalid creds';
				}
			}
		}

		return array( // return status and message of login
			'status' => $status,
			'message' => $message,
		);
	}

    function getFacebookUserInfo($accessToken){
        $endpoint = FB_GRAPH_DOMAIN . 'me';

		$params = array( // params for the endpoint
			'fields' => 'first_name,last_name,email,picture',
			'access_token' => $accessToken
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
    }
?>