<?php

class MPAdminUserController extends MPArticleAdminController{
	protected $config;
	protected $con;
	protected $mpArticle;
	public $helpers;
	private $Mailchimp;
	
	public $data;

	private $salt;

	public function __construct($opts){
		$this->config = $opts['config'];
		$this->con = new Connector($this->config);
		$this->mpArticle = $opts['mpArticle'];

		$this->data = false;

		$this->helpers = new AdminControllerHelpers(array('config' => $this->config));
		$this->MailChimp = new  Mailchimp( MAIL_CHIMP_API );
		$this->salt = 'w?LO4?}1l!EZLFBri,5KGek>41t<q|wH_1D`DWA<f~K-]GIo$.2yR:Y9a&k|4-RQ';
	}


/**
 * 	Redirects the user, after logging in
 *	Depending on the user_type 
 */
	public function redirectAfterLogin(){
		$user = $this->getUserInfo();
		
		$config = $this->config;
			return "<script>setTimeout(function(){window.location = \"".$config['this_admin_url']."\dashboard\"}, 10);</script>";
	}


/**
 * Updates the given user's SUCCESSFUL logins to users.user_logins + 1 in the database.
 * Takes a user (array) as argument.
 */

	private function updateNumberOfLogins($user){
		//	Change first_login to 0
		$user_email = $user['user_email'];
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE users SET user_login_count = user_login_count + 1 WHERE user_email = '{$user_email}' "
		));	
		if($result === true) {
			return array('hasError' => false);
		} else  {
			return $result;
		}
	}

	public function userAlreadyExists($post){
		//	Set defaults so undefined indexes don't throw errors in the queryString...
		$postDefaults = array(
			'user_name-s' => '',
			'user_login_input' => '', 
			'user_email-e' => '',
			'user_first_name-s' => '',
			'user_last_name-s' => ''
		);
		
		$post = array_merge($postDefaults, $post);

		$queryOptions = array(
			'queryString' => "SELECT * FROM users 
							WHERE user_email = :email 
							LIMIT 0, 1",
			'queryParams' => [
				//':userName' => filter_var(trim($post['user_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				':email' => filter_var(trim($post['user_email-e']), FILTER_SANITIZE_STRING, PDO::PARAM_STR)
				//':first' => filter_var(trim($post['user_first_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				//':last' => filter_var(trim($post['user_last_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR)
			],
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		return $this->performQuery($queryOptions);
	}

	protected function checkPassword($username, $password){
		$username = filter_var($username, FILTER_SANITIZE_URL);
		$password = filter_var($password, FILTER_SANITIZE_URL);

		$this_user = $this->find_salt($username);
		$hashed_password = crypt($password, '$2a$12$' . $this_user);

		//Query for username and password...
		$options = array(
			'queryString' => "SELECT * FROM users WHERE user_name = :username AND user_hashed_password = :password LIMIT 0, 1",
			'queryParams' => array(':username' => $username, ':password' => $hashed_password),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		$q = $this->performQuery($options);

		if($q && count($q)){
			return true;
		} 
		return false;
	}

	public function getUserInfo(){
		if(!isset($_SESSION['user_id'])) return false;
		$options = array(
			'queryString' => "SELECT * FROM users as u 
							INNER JOIN (user_logins as ul, user_types as ut, user_permissions as up, article_contributors as c) 

							ON (u.user_id = ul.user_id 
							AND c.contributor_email_address = u.user_email
							AND u.user_type = ut.user_type 
							AND ut.user_type = up.user_type) 

							WHERE u.user_id = :userId 
							AND ul.user_login_valid = 1",
			'queryParams' => array(':userId' => $_SESSION['user_id']),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		return $this->performQuery($options);
	}

	public function checkPermission($perm){
		if(!isset($perm) || empty($perm)) return false;
		if(isset($this->data[$perm]) && $this->data[$perm] == 1) return true;
		return false;
	}

	/* Begin User Article Verification Functions */

	public function checkUserCanEditOthers($dataType = 'article', $id){

		if ($dataType == 'contributor'){
			if (!$this->checkPermission('user_permission_show_other_contributors')){
			// If the user can not edit other contributors, check if the info is THIS contributor
				 return ($this->data['user_email'] == $id) ? true : false;
			} else {
			// The user is an admin or has permissions to edit other contributors.
				return true;
			}
		}		

		if ($dataType == 'article'){
			$articlesArray = $this->getUserArticleIds();
			if (!$this->checkPermission('user_permission_show_other_user_articles')){
			// If the user can not edit other user articles, check if the user wrote the article	
				return ( !in_array($id, $articlesArray) )? false : true;	
			} else {
			// The user is an admin or has permissions to edit other user's articles.
				return true;
			}
		}
	}

	private function getUserArticleIds(){
		$articleIdsArray = array();
		$options = array(
			'queryString' => "SELECT a.article_id 
				FROM article_contributor_articles as a_c_a
				INNER JOIN (articles as a, article_contributors as a_c)
				ON a.article_id = a_c_a.article_id
				AND a_c_a.contributor_id = a_c.contributor_id
				WHERE a_c.contributor_email_address = :userEmail",
			'queryParams' => array(':userEmail' => $this->data['user_email']),
			//'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		$articles = $this->performQuery($options);

		if( $articles ){
			foreach($articles as $articleId){
				//	Since the query above is only returning 1 row, it will return a string, if the user only has one added one article...
				if (is_array($articleId)){
					//	the user has more than one user article...articleId will === array
					$articleIdsArray[] = $articleId['article_id'];
				} else {
					//	the user has only one user article...articleId will === string
					$articleIdsArray[] = $articleId;
				}
				
			}
			if (is_array($articleIdsArray)){
				return $articleIdsArray;
			} else {
				return false;
			}
		}else{
			return false;
		}
	}

	private function resetUserTimeout($userLoginId){

			$options = array(
				'updateString' => "UPDATE user_logins SET user_login_creation_date = now() WHERE user_login_id = :loginId",
				'updateParams' => array(':loginId' => $userLoginId)
			);
			$q = $this->performUpdate($options);
			if(!$q) return $this->helpers->returnStatus(500);
			else return array(
				'hasError' => false, 
				'message' => "Thanks!  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\">Here</a>" 
			);
	}

	public function getLoginStatus(){
		if(!isset($_SESSION['login_hash']) || !isset($_SESSION['user_id'])) return false;
		$options = array(
			'queryString' => "SELECT * FROM user_logins WHERE user_id = :userId AND user_login_hash = :hash AND user_login_valid = 1 LIMIT 0, 1",
			'queryParams' => array(':userId' => $_SESSION['user_id'], ':hash' => filter_var(trim(hash('sha256', $_SESSION['login_hash'].$this->salt)), FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		return $this->performQuery($options);
	}

/************			********
***
Password reset methods
***
*************			*******/

	public function getUsernameByEmail($userEmail){
		$options = array(
			'queryString' => "SELECT user_name FROM users as u 
							WHERE u.user_email = :userEmail",
			'queryParams' => array(':userEmail' => $userEmail),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		$result = $this->performQuery($options);
		return array_shift($result);
	}

	protected function getPasswordResettingUser($post){
		if(!isset($post['user_email-e'])) return false;
		$options = array(
			'queryString' => "SELECT * FROM users as u 
							INNER JOIN (user_password_resets as upr, article_contributors as c) 

							ON u.user_email = upr.reset_user_email 
							AND c.contributor_email_address = u.user_email

							WHERE u.user_email = :email
							AND upr.reset_verification_code = :code
							AND upr.reset_valid = 1
							AND u.user_verified = 1",
			'queryParams' => array(':email' => $post['user_email-e'], ':code' => $post['code']),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		return $this->performQuery($options);
	}

	public function getResetAttempts($email){
		if(!isset($email)) return array();
		$options = array(
			'queryString' => "SELECT * FROM user_password_resets WHERE reset_user_email = :email AND reset_valid = 0",
			'queryParams' => array(':email' => $email),
			'bypassCache' => true
		);
		return $this->performQuery($options);
	}

	public function initializePasswordReset($post){
		$email = $post['user_email-e'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$verificationCode = $this->generateHash();
		$timestamp = time();

		//	Check to see if that email address exists
		if (!$user = $this->usernameExists($email)) {
			return array('hasError' => true, 'message' => "Oops! This email address is not in our system.");
		}
		if($this->config['host'] != 'localhost'){		
			date_default_timezone_set('America/Detroit');
		} else {
			date_default_timezone_set('America/New_York');
		}
		//	Store it in the db
		$queryOptions = array(
			'updateString' => "INSERT INTO user_password_resets 
								( reset_user_email, reset_user_ip, reset_verification_code, reset_valid, reset_creation_time) 
								VALUES 
								( :reset_user_email, :reset_user_ip, :reset_verification_code, 1, NOW() );",
			'updateParams' => array(
				':reset_user_email' => filter_var(trim($email), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				':reset_user_ip' => $ip,
				':reset_verification_code' => filter_var($verificationCode, FILTER_SANITIZE_STRING, PDO::PARAM_STR) )
		);

		$userName = $this->getUsernameByEmail($queryOptions['updateParams'][':reset_user_email']);
		//	perform insert...store the hash
		$result = $this->performUpdate($queryOptions);

		//Get login attempts that are still pending
		//$resetAttempts = $this->getResetAttempts($email);

		// $resetsStillWaiting = array();
		// if($resetAttempts && count($resetAttempts)){
		// 	//Loop through pending logins to check for possible brute force
		// 	foreach($resetAttempts as $arr){
		// 		//Only count if pending login is within 15 minutes
		// 		if(isset($arr['reset_valid']) && isset($arr['reset_creation_time']) && $arr['reset_valid'] == 0 && $this->helpers->compareTimes(time(), strtotime($arr['reset_creation_time']), 111115)) {
		// 				$resetsStillWaiting[] = $arr;
		// 		}
		// 	}
		// }

		//Prevent login in case of possible brute force attack.  Will naturally resolve itself due to 15 min time limit above
		// if(count($resetsStillWaiting) >= 2) return array(
		// 	'hasError' => true, 
		// 	'message' => "Sorry, looks like you've tried to log in too many times recently.  Wait a bit and try again!"
		// );

		//	Send the email with the link.com?hash
		if($result){
			if(!$resetEmail = $this->sendEmail(array(
				'email' => $queryOptions['updateParams'][':reset_user_email'],
				'hashUrl' => $this->config['this_admin_url'].'reset_password/'.urldecode(trim($verificationCode)),
				'action' => 'reset the password for',
				'subject' => $this->mpArticle->data['article_page_visible_name']." Reset Password Email",
				'username' => $userName
			))
			) {
				return $resetEmail;
			}
			//	Success...	
			$r = $this->helpers->returnStatus(200);
			$r['message'] = "We've sent an email to the address provided that will allow you to reset your password.";
			return $r;					
		}else return $this->helpers->returnStatus(500);
	}

	public function verifyPasswordReset($hash){
		if(!isset($hash)) return $this->helpers->returnStatus(500);

		$user = $this->performQuery(array(
			'queryString' => 'SELECT * FROM user_password_resets WHERE reset_verification_code = :reset_verification_code LIMIT 0, 1',
			'queryParams' => array(':reset_verification_code' => filter_var($hash, FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		));		
			//Locally Only
			//Otherwise should be Detroit
			$tz = date_default_timezone_get();
			date_default_timezone_set('America/New_York');
	//	If the password reset attempt is stale, set reset_valid of all this user's attempts to 0 and return hasError...
			if(!$this->helpers->compareTimes(time(), strtotime($user['reset_creation_time']), 15)) {
				return array( 'hasError' => true, 'message' => "Sorry, your reset has expired.  You can login <a href=\"".$this->config['this_admin_url'].'login/'."\">HERE</a>." );
			}
			date_default_timezone_set($tz);

	//	Check and see if the user exists, and the user is verified...
		if($user && $user['reset_valid'] == 1){
			return array("hasError" => false, "message" => "Please enter your new password below.", "email" => $user['reset_user_email']);
		} else {
			return array("hasError" => true, "message" => "This reset is invalid.");
		}
	}

	private function invalidateResets($reset_user_email){
		$queryOptions = array(
			'updateString' => "UPDATE user_password_resets SET reset_valid = 0 WHERE reset_user_email = :reset_user_email;",
			'updateParams' => array(
				':reset_user_email' => filter_var( trim($reset_user_email), FILTER_SANITIZE_STRING, PDO::PARAM_STR) )
		);
		$result = $this->performUpdate($queryOptions);
		return $result;
	}

	public function resetPassword($post){
		$password_1 = $post['user_password1-s'];
		$password_2 = $post['user_password2-s'];

		$params = $this->helpers->compileParams($post);
		$user = $this->getPasswordResettingUser($post);
		$salt = $user['user_salt'];

		if($password_1 == "" || $password_2 == ""){
			return array('hasError' => true, 'message' => "Oops!  You must fill out both password fields.", 'email' => $user['user_email']);
		}

		if($password_1 != $password_2){
			return array('hasError' => true, 'message' => "Oops!  Your passwords do not match.", 'email' => $user['user_email']);
		}

		//	Change the password
		$hashed_password = crypt($password_2, '$2a$12$' . $salt);
		$params = array(":user_hashed_password" => $hashed_password) + $params;
		$post = array("user_hashed_password-s" => $hashed_password) + $post;

		unset($post['pwd_change']);
		unset($post['code']);
		unset($post['user_password1-s']);
		unset($post['user_password2-s']);		
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE users SET {pairs} WHERE user_id = ".$user['user_id'],
			'post' => $post
		));
		if($result === true) {
			//	Invalidate all other user's resets...
			$invalidate = $this->invalidateResets($user['user_email']);
			return array('resetComplete' => true, 'email' => $user['user_email'],  'hasError' => false, 'message' => "Your password has been changed, <br /><br />Please LOGIN with your new password.");
		} else {
			return $result;
		}
	}

/***

End password reset methods

***/


	//DO LOGIN VERIFICATION
	public function doVerification($hash){
		//Check for needed variables in session and for matching session and input hashes
		if(!isset($_SESSION['login_hash']) || !isset($_SESSION['user_id']) || $_SESSION['login_hash'] !== $hash) return $this->helpers->returnStatus(500);

		//Query for pending logins
		$options = array(
			'queryString' => "SELECT * FROM user_logins WHERE user_id = :userId AND user_login_hash = :hash AND user_login_valid = 0 LIMIT 0, 1",
			'queryParams' => array(':userId' => $_SESSION['user_id'], ':hash' => filter_var(trim(hash('sha256', $hash.$this->salt)), FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);

		$q = $this->performQuery($options);
		if($q && count($q)){
			//	Check to see if same browser
			if($q['user_login_ua'] != $_SERVER['HTTP_USER_AGENT']){
				return array(
					'hasError' => true, 
					'message' => "Sorry, it looks like you're not who you say you are.  For your protection, we've cancelled your login.  Please try again <a href=\"".$this->config['this_admin_url'].'login/'."\">here</a>."
				);
			}
			// //Check for same IP address
			if($q['user_login_ip'] !== $_SERVER['REMOTE_ADDR']) return array(
				'hasError' => true, 
				'message' => "Sorry, it looks like you're trying to log in from a different computer.  For your protection, we've cancelled your login.  Please try again <a href=\"".$this->config['this_admin_url'].'login/'."\">here</a>."
			);
			// //Check if the user has clicked the email link within 15 minutes
			//Timezone hack to get around different server timezones
			$tz = date_default_timezone_get();
			
			//Locally Only Otherwise should be Detroit
			if($this->config['host'] != 'localhost'){		
				date_default_timezone_set('America/Detroit');
			} else {
				date_default_timezone_set('America/New_York');
			}
			// var_dump(PHP_SESSION_ACTIVE); die;
			// if(!$this->helpers->compareTimes(time(), strtotime($q['user_login_creation_date']), 120))
			if( session_status() === (PHP_SESSION_ACTIVE ? TRUE : FALSE) ) return array(
			 	'hasError' => true, 
			 	'message' => "Sorry, your session has expired.  Please try again <a href=\"".$this->config['this_admin_url'].'login/'."\">here</a>."
			 );
			date_default_timezone_set($tz);
			
			// //Invalidate all user tokens
			if(!$invalidate = $this->invalidateAllTokens()) return $this->helpers->returnStatus(500);
			
			// //Validate just this login attempt (identified by the unique row id)
			$options = array(
				'updateString' => "UPDATE user_logins SET user_login_valid = 1 WHERE user_login_id = :loginId",
				'updateParams' => array(':loginId' => $q['user_login_id'])
			);
			$q = $this->performUpdate($options);
			if(!$q) return $this->helpers->returnStatus(500);
			else return array(
				'hasError' => false, 
				'message' => "Thanks!  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."/dashboard\">here</a>" 
			);
		}else return $this->helpers->returnStatus(500);
	}

	protected function find_salt($userInput) {
		$options = array(
			'queryString' => "SELECT user_salt From users WHERE (user_name = :userName) OR (user_email = :userEmail) LIMIT 0, 1",
			'queryParams' => array(':userName' => $userInput, ':userEmail' => $userInput),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		$q = $this->performQuery($options);

		if($q && count($q)){
			return array_shift($q);
		} else {
			return array(
				'hasError' => true, 
				//	This used to send message to user that we had sent her an email...
				'message' => "You are trying to be tricky....this user doesn't exist."
			);
		}
	}

	/* Begin Login Functions */
	public function handleLogin($post){
		//Check if user-input matches any users on file
		//	get the user with the username given in the post

		if(!$user = $this->usernameExists($post['user_login_input'])) {
			return array(
			'hasError' => true, 
			'message' => "Sorry, but can't find you in our system. Please try again, or register."
			);
		}


		$userInput = filter_var($post['user_login_input'], FILTER_SANITIZE_URL);
		$password = filter_var($post['user_login_password_input'], FILTER_SANITIZE_URL);
		$salt = $this->find_salt($userInput);

		$hashed_password = crypt($password, '$2a$12$' . $salt);

		//Initialize session variable
		$_SESSION = array();

		//Store user id in session
		$_SESSION['user_id'] = $user['user_id'];

		//Generate the session hash for this session
		$sessionHash = $this->generateHash();

		//Generate C_T value for FB USERS
		//if(isset($post['user_facebook_id-s']) && $post['user_facebook_id-s']){
		$_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
		//}

		//Log the login hash in the browser to lock the session to just this browser
		$_SESSION['login_hash'] = $sessionHash;
		
		//Check for user verification
		if(!$user['user_verified']) return array(
			'hasError' => true, 
			'message' => "Sorry, it looks like you've registered, but haven't verified your account yet.  Need us to resend the verification email?  Click <a href=\"".$this->config['this_admin_url'].'activate/resend'."\"><u>here</u></a>!");

		//Get logins attempts that are still pending, in the last 15 minutes
		$loginAttempts = $this->countLoginAttempts($user, 15);

		//	If we're not working locally...
		//	Prevent login in case of possible brute force attack.  If the user has tried to login more than 10 times in the last 15 minutes
		if($this->config['host'] != 'localhost'){
			if($loginAttempts >= 50) return array(
				'hasError' => true, 
				'message' => "Sorry, looks like you've tried to log in too many times recently.  Wait a bit and try again!"
			);
		}	

		$hash = $sessionHash;
	

		//Log the user's login attempt in the database
		if($loggedLogin = $this->logLoginAttempt($user, hash('sha256', $sessionHash.$this->salt)) === false) return $this->helpers->returnStatus(500);
		
		//Query for username and password...
		$options = array(
			'queryString' => "SELECT * FROM users WHERE  user_email = :username AND user_hashed_password = :password LIMIT 0, 1",
			'queryParams' => array(':username' => $post['user_login_input'], ':password' => $hashed_password),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);

		$q = $this->performQuery($options);

		if($q && count($q)){
			$this->updateNumberOfLogins($user);
			$verificationResult = $this->doVerification($hash);
		
			return $verificationResult;
		} else {
			return array(
				'hasError' => true, 
				'message' => "Your username or password is incorrect."
			);
		}
	}

	public function usernameExists($userInput){
		$options = array(
			'queryString' => "SELECT * FROM users WHERE user_name = :userInput OR user_email = :userInput LIMIT 0, 1",
			'queryParams' => array(':userInput' => filter_var(trim($userInput), FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		
		return $this->performQuery($options);
	}

	public function userEmailExists($userInput){
		$options = array(
			'queryString' => "SELECT * FROM users WHERE user_email = :userInput LIMIT 0, 1",
			'queryParams' => array(':userInput' => filter_var(trim($userInput), FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		);
		return $this->performQuery($options);
	}

	public function updateUserImage($data){
		$contributorId = filter_var($data['c_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$contributorImg = filter_var(trim($data['image']), FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$updateImage = $this->performUpdate(array(
			'updateString' => "UPDATE article_contributors SET contributor_image = '".$contributorImg."'  WHERE contributor_id = ".$contributorId
		));


		if($updateImage === true) return true;
		return false;
	}
	/* End Article Updating Function */


/**
 * Returns all of the records of login attemts logged by $user in the last $timeFrame minutes.
 * Takes a user (array) as argument1.
 * Takes a time in minutes (int) as argument2.
 * Defaults to a year ($timeFrame = 525600 minutes)
 */
	public function countLoginAttempts($user, $timeFrame = 525600){
		if(!isset($user['user_id'])) return array();
		$options = array(
			'queryString' => "SELECT *
								FROM user_logins 

								WHERE user_id = :user_id 
								AND (user_login_valid = 0 OR user_login_valid = -1)
								AND user_login_creation_date < NOW()
								AND user_login_creation_date > DATE_SUB(NOW(),INTERVAL {$timeFrame} MINUTE) ",
			'queryParams' => array(':user_id' => $user['user_id']),
			'bypassCache' => true,
			'returnCount' => true
		);
		return $this->performQuery($options);
	}

	public function generateHash(){
		$hash = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
		return $hash;
	}

	public function logLoginAttempt($user, $sessionHash = null){
		if(!isset($user['user_id']) || is_null($sessionHash)) return false;
		$options = array(
			'updateString' => "INSERT INTO user_logins (user_id, user_login_ip, user_login_ua, user_login_hash) VALUES (:userId, :userIp, :userUa, :userHash)",
			'updateParams' => array(
				':userId' => $user['user_id'],
				':userIp' => $_SERVER['REMOTE_ADDR'],
				':userUa' => $_SERVER['HTTP_USER_AGENT'],
				':userHash' => $sessionHash
			),
			'isInsert' => true
		);
		return $this->performUpdate($options);
	}


	public function invalidateAllTokens(){
		if(!isset($_SESSION['user_id'])) return false;
		$options = array(
			'updateString' => "UPDATE user_logins SET user_login_valid = -1 WHERE user_id = ".$_SESSION['user_id']
		);
		return $this->performUpdate($options);
	}

/* End Login Functions */

/* Begin Registration Functions */
	public function doRegistration($post){


		$isReader = false;
		$fromFB = false;
		if(isset($post['from_fb']) && $post['from_fb']) $fromFB = true;

		if(isset($post['isReader']) && $post['isReader']) $isReader = true;
		//var_dump($fromFB);
		if($isReader && !isset($post['user_facebook_id-s'])){
			$post["g-recaptcha-response"] = $post["recaptcha"];
			unset($post["recaptcha"]);
			$post['user_password-s'] = $post['user_password'];
			unset($post["user_password"]);
			$post['user_email_1-e'] = $post['user_email'];
			unset($post["user_email"]);
			unset($post["task"]);
			$post['user_first_name-s'] = $post['name'];
			unset($post["name"]);
			$post['user_type-s'] = 5;
		}

		//	Based on the post data, formulate the hashed password.
		$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);	

		//RECAPTCHA GOOGLE VALIDATION
		// The response from reCAPTCHA
		$resp = null;
		$error = null;
		$reCaptcha = new ReCaptcha( RECAPTCHASECRETKEY );

		// Was there a reCAPTCHA response?
		if( !$fromFB ){
			if($post["g-recaptcha-response"] && !empty($post["g-recaptcha-response"])) {
			    $resp = $reCaptcha->verifyResponse( $_SERVER["REMOTE_ADDR"], $post["g-recaptcha-response"]);
				
				if ($resp != null && !$resp->success) return array('hasError' => true, 'message' => "Oops!  You must verify that you are not a robot!");
	 			
			}else return array('hasError' => true, 'message' => "Oops!  You must verify that you are not a robot!");

			$recaptcha = $post['g-recaptcha-response'];
		}else{
			$recaptcha =true;
		}
		unset($post['g-recaptcha-response']);
		//	Make sure the password match
		if(empty($post['user_password-s'])){
			return array('hasError' => true, 'message' => "Oops!  You must fill out password fields.");
		}
		
		$hashed_password = crypt($post['user_password-s'], '$2a$12$' . $salt);
		//	Unset the password in the past variable, so as not to save it to the db and compile it  in compilePairs()
		
		unset($post['user_password-s']);
		unset($post['user_password_2-s']);

		//	Make sure the email addresses match
		if(empty($post['user_email_1-e'])){
			return array('hasError' => true, 'message' => "Oops!  You must fill out the email field.");
		}
		
		//	Set the email post variable correctly
		$post['user_email-e'] = $post['user_email_1-e'];
		unset($post['user_email_1-e']);

		$pairs = $this->helpers->compilePairs($post, true);
		$params = $this->helpers->compileParams($post);
	
		$unrequired = array('user_last_name');

		//USER NAME
		$username = $this->helpers->generateName(array('input' => $post['user_first_name-s']));
		$username = join(explode(' ', strtolower(preg_replace('/[^A-Za-z0-9- ]/', '', $username))), '-');

		if ($this->usernameExists($username)){
			$rand = rand(1, 100000000);
			$username = $username.'-'.$rand;
		}	
		//$post['user_name-s'] = $username;
		//unset($post['user_name-s']);
		$user = $this->userAlreadyExists($post);

		//IF USER EXISTS AND IS FROM FACEBOOK
		if($user && ( isset($post['user_facebook_id-s']) && $post['user_facebook_id-s'])){
			return $this->handleLogin($post);
		}

		if(!isset($post['user_facebook_id-s'])){
			if ($user['user_email'] == $post['user_email-e']){
				return array('hasError' => true, 'message' => "Oops!  Looks like that email address is already in use.  Did you mean to login instead?  If so, you can do that <a href=\"".$this->config['this_admin_url'].'login/'."\"><u>here</u></a>.");
			}
		}	
		
		$valid = $this->helpers->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		//Verifycation Hash
		$verificationHash = $this->generateHash();

		//SET KEY VALUES FROM USER POST
		$keys = array();
		$values = array();
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		$keys[] = 'user_verification_code';
		$values[] = ':user_verification_code';
		$params[':user_verification_code'] = $verificationHash;
		$post['user_verification_code-nf'] = $verificationHash;

		$keys[] = 'user_hashed_password';
		$values[] = ':user_hashed_password';
		$params[':user_hashed_password'] = $hashed_password;
		$post['user_hashed_password-nf'] = $hashed_password;

		$keys[] = 'user_salt';
		$values[] = ':user_salt';
		$params[':user_salt'] = $salt;
		$post['user_salt-nf'] = $salt;

		if( !$fromFB ){
			$keys[] = 'user_name';
			$values[] = ':user_name';
		}
	
		$params[':user_name'] = $username;
		$post['user_name-nf'] = $username;

		//CREATE USER
		$s = "INSERT INTO users (".join(', ', $keys).") VALUES (".join(', ', $values).")";

		$result = $this->performUpdate(array(
			'updateString' => "INSERT INTO users (".join(', ', $keys).") VALUES (".join(', ', $values).")",
			'updateParams' => $params
		));

		//var_dump($params, $result); die;
		if($result){
			//if(!$isReader){
				
				//Add Contributor Info
				$contributor_name = $post['user_first_name-s'];//.' '.$post['user_last_name-s'];
				$email = $post['user_first_name-s'].' '.$post['user_email-e'];
				$contributor_seo_name  = $this->helpers->generateName(array('input' => $contributor_name ));
				
				if(isset($contributor_seo_name)) $contributor_seo_name = join(explode(' ', strtolower(preg_replace('/[^A-Za-z0-9- ]/', '', $contributor_seo_name))), '-');

				//CHECK IF CONTRIBUTOR INFO ALREADY EXIST
				$dupCheck = $this->mpArticle->getContributors(['contributorSEOName' => $contributor_seo_name] );
				$dupCheckEmail = $this->mpArticle->getContributors(['contributorEmail' => $post['user_email-e'] ] );

				if( count($dupCheck['contributors']) > 0){
					  $rand = rand(1, 100000000);
					  $contributor_seo_name = $contributor_seo_name.'-'.$rand;
				}
				if(count($dupCheckEmail['contributors']) <= 0){
					//REGISTER FROM FACEBOOK
					if(isset($post['user_facebook_id-s']) && $post['user_facebook_id-s']){
						$contributor_image_fb = "http://graph.facebook.com/".$post['user_facebook_id-s']."/picture";
						$contributor_facebook_link = $post['fb_user_link'];
						
						//CREATE CONTRIBUTOR RECORD
						$contributor_id = $this->performUpdate(array(
							'updateString' => "INSERT INTO article_contributors ( contributor_name, contributor_seo_name, contributor_email_address, contributor_image, contributor_facebook_link ) VALUES ('".$contributor_name ."', '".$contributor_seo_name."', '".$post['user_email-e']."', '".$contributor_image_fb."', '".$contributor_facebook_link."')",
							'updateParams' => $params
						));
					}else{

						$contributor_id = $this->performUpdate(array(
							'updateString' => "INSERT INTO article_contributors ( contributor_name, contributor_seo_name, contributor_email_address ) VALUES ('".$contributor_name ."', '".$contributor_seo_name."', '".$post['user_email-e']."')",
							'updateParams' => $params
						));
					}
				}

				//ADD USER TO MAILCHIMP LIST
				$this->registerInMailChimpList($post);

				$_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());

				if( $fromFB ){
					return $this->doUserActivation($verificationHash);
				}else{
					return $this->resendUserVerify($verificationHash);
				}
				//return $this->doUserActivation($verificationHash);
			/*}else{ 
				$_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
				return $this->doUserActivation($verificationHash);

			}*/
		}else return $this->helpers->returnStatus(500);
	
	}	

	public function doRegistrationFromFB($post){
		//	Based on the post data, formulate the hashed password.
		//$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);	
		$fb_user_id = $post['user']['id'];
		$fb_user_first_name = $post['user']['first_name'];
		$fb_user_last_name = $post['user']['last_name'];
		$fb_user_email = $post['user']['email'];
		$fb_user_verified = $post['user']['verified'];
		$fb_user_password = $fb_user_id;
		$fb_user_link = $post['user']['link'];
		$tos_agreed = "1";
		if($fb_user_verified) $tos_agreed = "1";

		$parts = explode("@", $fb_user_email);
		$fb_user_name = str_replace("_", "-", $parts[0]);
		
		//BUILD POST ARRAY
		$arr['user_name-s'] = $fb_user_name;
		$arr['user_facebook_id-s'] = $fb_user_id;
		$arr['user_password-s'] = $fb_user_password;
		$arr['user_password_2-s'] = $fb_user_password;
		$arr['user_email-e'] = $fb_user_email;
		$arr['user_email_1-e'] = $fb_user_email;
		//$arr['user_email_2-e'] = $fb_user_email;
		$arr['user_first_name-s'] = $fb_user_first_name;
		$arr['user_last_name-s'] = $fb_user_last_name;
		$arr['tos_agreed-s'] = $tos_agreed;
		//$arr['user_verified-s'] = 1;
		$arr['from_fb'] = true;
		$arr['user_login_input'] = $fb_user_email;
		$arr['user_login_password_input'] = $fb_user_password;
		$arr['fb_user_link '] = $fb_user_link;
		
		$user = $this->userAlreadyExists($arr);
	
		if($user){
		//LOGIN
			return $this->handleLogin($arr);
		}
		else{
		//REGISTER USER
			return $this->doRegistration($arr);
		}
	}

	//FOLLOW AUTHOR
	public function followAnAuthor($reader_email, $author_id){

		$email = filter_var(trim($reader_email), FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$authorId = $author_id;
		
		$exist = $this->thisfollowerexist($email, $authorId);
		$user_info = $this->getUserInfo();

		if(isset($user_info['user_facebook_id']) && $user_info['user_facebook_id'] && strlen($user_info['user_facebook_id']) > 0 ){
			$contributor_img = $user_info['contributor_image'];
		}else{
			$contributor_img = 'http://images.puckermob.com/articlesites/contributors_redesign/'. $user_info['contributor_image'];
		}
		if( !$exist ){
		
			$result = $this->performUpdate(array(
				'updateString' => "INSERT INTO readers_authors (reader_email, author_id) VALUES ( '".$email."', ".$authorId.") "
			));

			
			if($result) return array('hasError' => false, 'email'=> $email, 'user_img'=>$contributor_img, 'message' => "Awesome! You're successfully following this writer. Check your e-mail for regular updates on their work.");

		}else{
			return array('hasError' => false, 'email'=> $email, 'user_img'=>$contributor_img, 'message' => "Wow! You must really like this writer  - you're already following them! Check out your  <a href='http://www.puckermob.com/admin/following/'>DASHBOARD</a> to see more of their work.");
		}

		return false;
	}

	public function thisfollowerexist( $userInput, $uthor_id){
		$options = array(
			'queryString' => "SELECT * FROM readers_authors WHERE reader_email = :userInput && author_id = :authorId LIMIT 0, 1",
			'queryParams' => array(':userInput' => filter_var(trim($userInput), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
									':authorId' => filter_var($uthor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
							)
		);
	
		$result = $this->performQuery($options);
	
		return $result;
	}
	//FOLLOW AUTHOR

	public function updateUserBillingW9($data){
		$user_id = filter_var($data['user_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$w9_live = $data['w9_sent'];
		
		//Check if record exists
		$recordExist = $this->performQuery(array(
			'queryString' => 'SELECT * FROM user_billing_info WHERE user_id = :user_id',
			'queryParams' => array(':user_id' => $user_id)
		));

			if($recordExist){
				$billing_record =  $this->performUpdate(array(
				'updateString' => "UPDATE user_billing_info SET w9_live = ".$w9_live." WHERE user_id = :userId",
				'updateParams' => array(':userId' => $user_id)
			));
				$message = 'Updated Successfully';

			}else{
				$billing_record = $this->performUpdate(array(
				'updateString' => "INSERT INTO user_billing_info (paypal_email, user_id, w9_live ) VALUES ('', ".$user_id.", ".$w9_live.") ",
				'updateParams' => array(':w9_live'=>$w9_live, ':userId' => $user_id,
				'isInsert' => true)
			));
				
				$message = "Added Successfully";
			}
			
			if($billing_record === true) return array('hasError' => false, 'message' => 'Your user information has been successfully updated');
			else return $result;

	}

	/*CONTRIBUTORS*/
	// public function setContributorEarningsPaid($data){

	// 	$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	// 	$paid = $data['paid'];
	// 	$month = filter_var($data['month'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	// 	$year = filter_var($data['year'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	// 	//Check if record exists

	// 	$next_month = $month;
	// 	$next_year = $year;
	// 	if($next_month == 12){
	// 		$next_month = 1;
	// 		$next_year = $year + 1;
	// 	}else $next_month = $month + 1;
		
	// 	$nextMonthrecord = $this->performQuery(array(
	// 		'queryString' => 'SELECT * FROM contributor_earnings WHERE contributor_id = :contributor_id AND month = :month AND year = :year ',
	// 		'queryParams' => array(':contributor_id' => $contributor_id, ':month' => $next_month, ':year' => $next_year )
	// 	));

	// 	$recordExist = $this->performQuery(array(
	// 		'queryString' => 'SELECT * FROM contributor_earnings WHERE contributor_id = :contributor_id AND month = :month AND year = :year ',
	// 		'queryParams' => array(':contributor_id' => $contributor_id, ':month' => $month, ':year' => $year )
	// 	));

	// 	if($recordExist){
	// 		$payment_record =  $this->performUpdate(array(
	// 			'updateString' => "UPDATE contributor_earnings SET paid = ".$paid." WHERE contributor_id = :contributor_id AND month = :month AND year = :year ",
	// 			'updateParams' => array(':contributor_id' => $contributor_id, ':month' => $month, ':year' => $year )
	// 		));
	// 	}
	// 	if( $nextMonthrecord && $payment_record ){
	// 		if($paid == "true" ){
	// 			$to_be_pay_next_month = $nextMonthrecord['total_earnings']; 
	// 		}else{
	// 			$to_be_pay_next_month = abs($nextMonthrecord['total_earnings'] + $recordExist['total_earnings']);
	// 		}
	// 		$payment_record_next_month =  $this->performUpdate(array(
	// 			'updateString' => "UPDATE contributor_earnings SET to_be_pay = ".$to_be_pay_next_month." WHERE contributor_id = :contributor_id AND month = :month AND year = :year ",
	// 			'updateParams' => array(':contributor_id' => $contributor_id, ':month' => $next_month, ':year' => $next_year )
	// 		));
	// 	}
	// 	return $payment_record ;
	// }

	public function getContributorEarningChartData( $data ){
		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		
		$s = " SELECT DATE_FORMAT(updated_date, '%c/%d') as 'date', sum(pageviews) as 'total_pageviews', sum(usa_pageviews) as  'total_usa_pageviews'
			   FROM google_analytics_data_daily 
			   INNER JOIN (article_contributor_articles, articles, article_categories, categories ) 
					ON  (article_contributor_articles.article_id = google_analytics_data_daily.article_id ) 
					AND ( articles.article_id = google_analytics_data_daily.article_id )
					AND ( articles.article_id = article_categories.article_id )
					AND ( article_categories.cat_id = categories.cat_id )
				WHERE contributor_id = ".$contributor_id." AND DATE_FORMAT(updated_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."' 
				GROUP BY  DATE_FORMAT(updated_date, '%Y-%m-%d') ";
		$result = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		$last_month_data = $this->getContributorEarningChartLastMonthData( $data );
		$array_earnins = [];
		$earnings_chart = [];

		foreach($result as $earnings){
			$earnings_chart['date'] = $earnings['date'];
			$earnings_chart['current_pageviews'] = $earnings['total_usa_pageviews'];

			if( count($last_month_data) > 0){
				foreach($last_month_data as $last_month_earnings){
					if( date('d', strtotime($earnings_chart['date'])) == date('d', strtotime($last_month_earnings['date']))){
						$earnings_chart['last_month_pageviews'] = $last_month_earnings['total_usa_pageviews'];
					}
				}

				$array_earnins[] = $earnings_chart;
			}
			
		}

		return $array_earnins;

	}

	public function getRatePerUser($id, $year, $month){

		$s = "	SELECT 	share_rate 
				FROM `contributor_earnings` 
				WHERE month = $month AND year = $year AND contributor_id = $id
				LIMIT 1 
			";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		return $data;

	}

	public function getContributorEarningChartDataRange($data){
		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$s = "SELECT DATE_FORMAT(updated_date, '%c/%d') as 'date', DATE_FORMAT(updated_date, '%c') as 'month', DATE_FORMAT(updated_date, '%Y') as 'year', sum(pageviews) as 'total_pageviews', sum(usa_pageviews) as  'total_usa_pageviews'
			   FROM google_analytics_data_daily 
			   INNER JOIN (article_contributor_articles, articles, article_categories, categories ) 
					ON  (article_contributor_articles.article_id = google_analytics_data_daily.article_id ) 
					AND ( articles.article_id = google_analytics_data_daily.article_id )
					AND ( articles.article_id = article_categories.article_id )
					AND ( article_categories.cat_id = categories.cat_id )
				WHERE contributor_id = ".$contributor_id." AND DATE_FORMAT(updated_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."' 
				GROUP BY  DATE_FORMAT(updated_date, '%Y-%m-%d') ";

		$result = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		$last_month_data = $this->getContributorEarningChartLastMonthData( $data );
		$array_earnins = [];
		$earnings_chart = [];
		
		if ($result && !isset($result[0])){
			$result = array($result);
		}

		foreach($result as $earnings){
			$earnings_chart['date'] = $earnings['date'];
			$earnings_chart['month'] = $earnings['month'];
			$earnings_chart['year'] = $earnings['year'];
			$rate =  $this->getRatePerUser($contributor_id, $earnings['year'], $earnings['month']);
			$earnings_chart['rate'] = $rate['share_rate'];
			$earnings_chart['current_pageviews'] = $earnings['total_usa_pageviews'];
			//$earnings_chart['last_month_pageviews']  = 0;

			//$array_earnins[] = $earnings_chart;
			if( count($last_month_data) > 0){
				foreach($last_month_data as $last_month_earnings){
					if( date('d', strtotime($earnings_chart['date'])) == date('d', strtotime($last_month_earnings['date']))){
						$earnings_chart['last_month_pageviews'] = $last_month_earnings['total_usa_pageviews'];
						$earnings_chart['last_month'] = $last_month_earnings['month'];
						$earnings_chart['last_month_year'] = $last_month_earnings['year'];
						$rate =  $this->getRatePerUser($contributor_id, $last_month_earnings['year'], $last_month_earnings['month']);
						$earnings_chart['last_month_rate'] = $rate['share_rate'];
					}
				}

				$array_earnins[] = $earnings_chart;
			}
		}
		return $array_earnins;
	}

	public function getContributorEarningChartLastMonthData( $data ){
		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$last_month_start_date = date('Y-m-d', strtotime("last month", strtotime($data['start_date'])));
		$last_month_end_date = date('Y-m-d', strtotime("last month", strtotime($data['end_date'])));
		
		$s = " SELECT DATE_FORMAT(updated_date, '%c/%d') as 'date', DATE_FORMAT(updated_date, '%c') as 'month', DATE_FORMAT(updated_date, '%Y') as 'year', sum(pageviews) as 'total_pageviews', sum(usa_pageviews) as  'total_usa_pageviews'
			   FROM google_analytics_data_daily 
			   INNER JOIN (article_contributor_articles, articles, article_categories, categories ) 
					ON  (article_contributor_articles.article_id = google_analytics_data_daily.article_id ) 
					AND ( articles.article_id = google_analytics_data_daily.article_id )
					AND ( articles.article_id = article_categories.article_id )
					AND ( article_categories.cat_id = categories.cat_id )
				WHERE contributor_id = ".$contributor_id." AND DATE_FORMAT(updated_date, '%Y-%m-%d') BETWEEN '".$last_month_start_date."' AND '".$last_month_end_date."' 
				GROUP BY  DATE_FORMAT(updated_date, '%Y-%m-%d') ";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		return $data;
	}

	public function getContributorEarningChartArticleData($data){

		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		$s = " SELECT articles.article_title, articles.article_seo_title, articles.creation_date, categories.cat_dir_name, SUM(usa_pageviews) as 'usa_pageviews'
			   FROM google_analytics_data_daily 
			   INNER JOIN (article_contributor_articles, articles, article_categories, categories ) 
					ON  (article_contributor_articles.article_id = google_analytics_data_daily.article_id ) 
					AND ( articles.article_id = google_analytics_data_daily.article_id )
					AND ( articles.article_id = article_categories.article_id )
					AND ( article_categories.cat_id = categories.cat_id )
				WHERE contributor_id = ".$contributor_id." AND DATE_FORMAT(google_analytics_data_daily.updated_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'  
				GROUP BY google_analytics_data_daily.article_id ORDER BY usa_pageviews DESC ";
		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
			));

		if ($data && isset($data[0])){
				// If $q is an array of only one row (The set only contains one article), return it inside an array
			return $data;
		} else if ($data && !isset($data[0])){
				// If $q is an array of rows, return it as normal
			$data = array($data);
			return $data;
		} else {
			return false;
		}
	}

	public function getContributorEarningChartArticleDataPerDay($data){

		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$user_type = filter_var($data['user_type'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		if($user_type == 3 ) $user_type = 0;

		$s = " SELECT sum(usa_pageviews) as 'us_pageviews', article_daily_earnings.month, article_daily_earnings.year, updated_date, user_rate.rate
				FROM `article_daily_earnings` 
				INNER JOIN user_rate ON ( user_rate.month = article_daily_earnings.month AND user_rate.year = article_daily_earnings.year)
				WHERE contributor_id = $contributor_id 
					AND  updated_date BETWEEN '".$start_date."' AND DATE_ADD( '".$end_date."' , INTERVAL 1 DAY) 
					AND user_rate.user_type = $user_type
				GROUP BY DATE_FORMAT( updated_date,'%Y-%m-%d') 
				ORDER BY updated_date ASC ";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		if ($data && isset($data[0])){
				// If $q is an array of only one row (The set only contains one article), return it inside an array
			return $data;
		} else if ($data && !isset($data[0])){
				// If $q is an array of rows, return it as normal
			$data = array($data);
			return $data;
		} else {
			return false;
		}
	}

	public function getTop5BloggersByPageviews(){
		$limit = 5;
		$month = date('n');
		$year =  date('Y');

		$s = "	SELECT contributor_name, contributor_seo_name, contributor_earnings.contributor_id, total_us_pageviews, month, year 
				FROM `contributor_earnings` 
				INNER JOIN (article_contributors, users ) 
				ON (article_contributors.contributor_id =  contributor_earnings.contributor_id ) 
				AND  (article_contributors.contributor_email_address = users.user_email) 
				WHERE month = $month AND year = $year AND users.user_type in (3, 8, 9) 
				ORDER BY total_us_pageviews DESC LIMIT $limit ";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		return $data;

	}

	public function getTop5ArticlesByPageviews($limit = 5, $contributor_id){
		$contributor_id = $contributor_id;
		$month = date('n');
		$year = date('Y');

		$s = "	SELECT articles.article_id, articles.article_title, articles.article_seo_title, categories.cat_dir_name, usa_pageviews
				FROM `article_contributor_articles` 
				INNER JOIN (articles, article_categories, categories, google_analytics_data_new) 
				ON  (articles.article_id = article_contributor_articles.article_id ) 
				AND (article_categories.article_id = article_contributor_articles.article_id) 
				AND ( categories.cat_id = article_categories.cat_id)
				AND (google_analytics_data_new.article_id = articles.article_id) 
				WHERE article_contributor_articles.contributor_id = $contributor_id AND month = $month AND year = $year
				ORDER BY usa_pageviews DESC LIMIT $limit ";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'returnRowAsSingleArray' => true
			));

		return $data;

	}

	public function getContributorsArticleList( $contributor_id){

		$contributor_id = filter_var($contributor_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

		$s = "SELECT articles.article_title, articles.article_seo_title, articles.article_id, categories.cat_dir_name FROM article_contributor_articles
		 INNER JOIN ( articles, article_categories, categories)
		 ON ( article_contributor_articles.article_id = articles.article_id 
		 	AND articles.article_id = article_categories.article_id 
		 	AND article_categories.cat_id = categories.cat_id
		 ) 
		WHERE article_contributor_articles.contributor_id = $contributor_id 
		AND articles.article_status = 1 
		ORDER BY articles.article_id DESC";

		$article = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		if ($article && !isset($article[0])){
			$article = array($article);
		}

		return $article;

	}

	public function getLastPostedArticle($contributor_id){
		$contributor_id = filter_var($contributor_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

		$s= "SELECT articles.article_id, articles.creation_date FROM article_contributor_articles
		 INNER JOIN ( articles, article_categories, categories)
		 ON ( article_contributor_articles.article_id = articles.article_id 
		 	AND articles.article_id = article_categories.article_id 
		 	AND article_categories.cat_id = categories.cat_id
		 ) 
		WHERE article_contributor_articles.contributor_id = $contributor_id 
		AND articles.article_status = 1 
		ORDER BY articles.article_id DESC LIMIT 1 ";

		$article = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		return $article;
	}

	public function articlesPublisThisMonth($contributor_id){
		$contributor_id = filter_var($contributor_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$month = date('n');
		$year = date('Y');

		$s= "SELECT count(*) as 'total' FROM article_contributor_articles
		 INNER JOIN ( articles )
		 ON ( article_contributor_articles.article_id = articles.article_id ) 
		WHERE article_contributor_articles.contributor_id = $contributor_id 
		AND articles.article_status = 1 
		AND month(articles.creation_date) = $month 
		AND year(articles.creation_date) = $year ";

		$article = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		return $article;

	}

	public function mostPopularPost($contributor_id){
		$contributor_id = filter_var($contributor_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$month = date('n');
		$year = date('Y');

		$s = "SELECT articles.article_id, articles.article_title, articles.article_seo_title, usa_pageviews, categories.cat_dir_name FROM  google_analytics_data_new
		 INNER JOIN ( articles, article_contributor_articles, article_categories, categories )
		 ON (  google_analytics_data_new.article_id = articles.article_id
		 	AND google_analytics_data_new.article_id = article_contributor_articles.article_id 
		 	AND article_categories.article_id = articles.article_id
		 	AND article_categories.cat_id = categories.cat_id) 
		WHERE article_contributor_articles.contributor_id = $contributor_id 
		AND articles.article_status = 1 
		AND google_analytics_data_new.month = $month 
		AND google_analytics_data_new.year = $year 
		ORDER BY google_analytics_data_new.usa_pageviews DESC LIMIT 3";

		$article = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		if ($article && !isset($article[0])){
			$article = array($article);
		}

		return $article;

	}

	public function getTotalPageViewsDateRange($data){

		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);	
		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		$s = " SELECT SUM(IF(google_analytics_data_daily.usa_pageviews, google_analytics_data_daily.usa_pageviews, 0)) as 'us_pageviews'
				FROM `google_analytics_data_daily` 
				INNER JOIN (  article_contributor_articles ) 
				ON ( article_contributor_articles.article_id = google_analytics_data_daily.article_id ) 
				WHERE  contributor_id = ".$contributor_id." AND DATE_FORMAT(google_analytics_data_daily.updated_date, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' 
			 	GROUP BY contributor_id ";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
		));

		return $data;
	}

	public function getContributorEarningsData($data){

		$start_date = filter_var($data['start_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$end_date = filter_var($data['end_date'],  FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		$s = "SELECT article_contributor_articles.contributor_id, contributor_name, contributor_seo_name,  
			SUM(IF(DATE_FORMAT(articles.creation_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."', 30, 0)) as 'article_rate', 
			SUM(IF(DATE_FORMAT(articles.creation_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."', 1, 0)) as 'total_articles', 
			user_type 
			FROM articles 
	        INNER JOIN (article_contributor_articles, article_contributors, users)
		        ON articles.article_id = article_contributor_articles.article_id
		        AND article_contributor_articles.contributor_id = article_contributors.contributor_id
		        AND article_contributors.contributor_email_address = users.user_email
	        WHERE  users.user_type IN (1,6) and articles.article_status = 1
	   		GROUP BY article_contributor_articles.contributor_id
	        ORDER BY contributor_name";

		$data = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ),
			'bypassCache' => true
			));

		if ($data && !isset($data[0])){
			$data = array($data);
		}

		$contributor_info = []; 
		foreach( $data as $info ){
			$contributor_id = $info['contributor_id'];
			$dataInfo = ['contributor_id' => $contributor_id, 'start_date' => $start_date, 'end_date' => $end_date];
			$dataFromGoogle = $this->getTotalPageViewsDateRange($dataInfo);


			$info['pageviews'] = $dataFromGoogle;
			$contributor_info[] = $info;
		}
		
		return $contributor_info;
	}

	public function registerInMailChimpList($post){
		if($post){
			$email = $post['user_email-e'];
			$fullname = $post['user_first_name-s'];
			$nameArr = explode(" ", $fullname);
			$name = $lastname = '';
	
			if(count($nameArr) > 0 ){
				$name = $nameArr[0];
				$lastname = $nameArr[1];
			}

			$result = $this->MailChimp->call('lists/subscribe', array(
        		'id'                => MAIL_CHIMP_SUBS_LIST,
                'email'             => array('email'=> $email),
                'merge_vars'        => array('FNAME'=>$name, 'LNAME'=>$lastname),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
            ));

		}else return array_merge($this->helpers->returnStatus(500), array('hasError' => true));
	}
	
	//SEND EMAIL TO BLOGGERS TEMPLATE
	public function send_email($opts){
		$options = array_merge(array(
			'email' => '',
			'hashUrl' => '',
			'action' => '',
			'subject' => '',
			'username' => ''
		), $opts);

		$mail = new PHPMailer;
		
		$body='';
		include_once($this->config['include_path_admin'].'emailtemplate.php');

		$mail->isSMTP();												// Set mailer to use SMTP
		$mail->Host = MAIL_HOST;									// Specify main and backup server
		$mail->SMTPAuth = true;											// Enable SMTP authentication
		$mail->Username = MAIL_USER;									// SMTP username
		$mail->Password = MAIL_PASSWORD;								// SMTP password
		$mail->SMTPSecure = MAIL_ENCRYPTION;							// Enable encryption, 'ssl' AND 'tls' accepted
		//$mail ->Port = 465;
		$mail->Port = MAIL_PORT;
		$mail->From = MAIL_USER;
		$mail->FromName = 'PuckerMob';
		$mail->addAddress($opts['email'], $opts['username']);	// Add a recipient
		//$mail->addAddress('ellen@example.com');						// Name is optional
		$mail->addReplyTo(MAIL_USER, 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		$mail->WordWrap = 50;											// Set word wrap to 50 characters
		//$mail->addAttachment('/var/tmp/file.tar.gz');					// Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');			// Optional name
		$mail->isHTML(true);											// Set email format to HTML

		$mail->Subject = $opts['subject'];
		$mail->Body    = $body;
		//$mail->AltBody = 'Thank you for registering with puckermob.com!  Go to '.$options['hashUrl'].' to complete the registration process.';

		if(!$mail->send()) {
		   //return 'Message could not be sent.';
		   //return 'Mailer Error: ' . $mail->ErrorInfo;
		   return array_merge($this->helpers->returnStatus(500), array('hasError' => true));

		   exit;
		}

		//	return 'Message has been sent';
		return true;
	}

	//OLD SEND EMAIL FUNCTION
	public function sendEmail($opts){
		$options = array_merge(array(
			'email' => '',
			'hashUrl' => '',
			'action' => '',
			'subject' => '',
			'username' => ''
		), $opts);

		$body='';
		include_once($this->config['include_path_admin'].'emailtemplate.php');
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "From: ".$this->mpArticle->data['article_page_visible_name']." <".$this->mpArticle->data['article_page_contact_email']."> \n";
		
		if(!$mailSent = mail($options['email'], $options['subject'], $body, $headers)) return array_merge($this->helpers->returnStatus(500), array('hasError' => true));
		return true;
	}

	public function doUserActivation($hash){

		if(!isset($hash)) return $this->helpers->returnStatus(500);

		$user = $this->performQuery(array(
			'queryString' => 'SELECT * FROM users WHERE user_verification_code = :user_verification_code LIMIT 1',
			'queryParams' => array(':user_verification_code' => filter_var($hash, FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		));
		
		if($user){
			
			
			if($user['user_verified'] == 1){
				$r = $this->helpers->returnStatus(200);
				$r['message'] = "Thanks for registering.  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\dashboard\">here</a>.";
				//return $r;
			}


			$q = $this->performUpdate(array('updateString' => "UPDATE users SET user_verified = 1 WHERE user_id = ".$user['user_id']));
			
			$sessionHash = $this->generateHash();
			$_SESSION['login_hash'] = $sessionHash;
			$_SESSION['user_id'] = $user['user_id'];
			
			if(($loginId = $this->logLoginAttempt($user, hash('sha256', $sessionHash.$this->salt))) == false) return $this->helpers->returnStatus(500);

			if(!$invalidate = $this->invalidateAllTokens()) return $this->helpers->returnStatus(500);

			$q = $this->performUpdate(array('updateString' => "UPDATE user_logins SET user_login_valid = 1 WHERE user_login_id = $loginId"));

			if($q){
				$r = $this->helpers->returnStatus(200);
				$r['message'] = "Thanks for registering.  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\dashboard\">here</a>.";
				$r['username'] = $user['user_name'];
				return $r;
			}else return $this->helpers->returnStatus(500);
		}else return $this->helpers->returnStatus(500);
	}


	//SEND USER VERIFY ACCOUNT
	public function resendUserVerify( $hash_code = false ){
		if(!isset($_SESSION['user_id']) && !$hash_code ) $this->helpers->returnStatus(500);

		$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
		
		$queryString = "SELECT * FROM users WHERE user_id = :userId ";
		if($hash_code){
			$queryString .= " OR  user_verification_code = '".$hash_code."' ";
		}
		$queryString .=" LIMIT 0, 1";

		$user = $this->performQuery(array(
			'queryString' => $queryString,
			'queryParams' => array(':userId' => filter_var($user_id, FILTER_SANITIZE_STRING, PDO::PARAM_STR))
		));
	//	var_dump($user_id);

		if($user){
			if(!$registerEmail = $this->sendemail(array(
				'email' => $user['user_email'],
				'hashUrl' => $this->config['this_admin_url'].'activate/'.$user['user_verification_code'],
				'action' => 'access',
				'subject' => "Puckermob Registration Email",
				'username' => $user['user_name']
			))) return $registerEmail;
			$r = $this->helpers->returnStatus(200);
			$r['message'] = "<h2 class=\"uppercase\">To Complete your Registration: </h2><p>Please check your email  and click  the link  provided to complete your registration.</p><p>Didn't get an e-mail from us? Check your spam folder or <a href=\"".$this->config['this_admin_url'].'activate/resend'."\">Click Here</a> to resend.";
			return $r;
		}else $this->helpers->returnStatus(500);
	}
	/* End Registration Functions */


// --------------------------------------------------------
// --------------- SMF ROUTINES ---------------------------
// --------------------------------------------------------

	public function smf_setContributorEarningsPaid($data){

// Currently does not work - as of 2017-03-21 - GB		
		$contributor_id = filter_var($data['contributor_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$paid = $data['paid'];

		$month = filter_var($data['month'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = filter_var($data['year'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		//Check if record exists
		$recordExist = $this->performQuery(array(
			'queryString' => 'SELECT * FROM contributor_earnings WHERE contributor_id = :contributor_id AND month = :month AND year = :year ',
			'queryParams' => array(':contributor_id' => $contributor_id, ':month' => $month, ':year' => $year )
		));

			// --------------------------- testing -------------------------------
			// --------------------------- testing -------------------------------
				// $payday_date = date('Y-m-d H:i:s', time());
				// $sql = "UPDATE contributor_earnings SET paid = :paid, payday_date = ':payday_date' 
				// WHERE contributor_id = :contributor_id
				// AND payday_date = 0 
				// AND DATE(updated_date) <= LAST_DAY(CONCAT(:year,'-',:month,'-','15')) ";

				// $s = array(':contributor_id' ,':month', ':year', ':paid', ':payday_date'  );
				// $p = array( $contributor_id, $month, $year, $paid,  $payday_date  );
				// var_dump("Debug S: ") ;
				// var_dump($s) ;
				// var_dump("Debug P: ") ;
				// var_dump($p) ;
				// $sql = str_replace($s,$p,$sql);
				// var_dump("Debug SQL: ".$sql) ;

			// --------------------------- testing -------------------------------
			// --------------------------- testing -------------------------------


		if($recordExist){
			$payday_date = date('Y-m-d H:i:s', time());
			$payment_record =  $this->performUpdate(array(
				'updateString' => "UPDATE `contributor_earnings` SET `paid` =  $paid, `payday_date` = '$payday_date' 
									WHERE `contributor_id` = $contributor_id
									AND `payday_date` = 0 
									AND DATE(`updated_date`) <= LAST_DAY(CONCAT($year,'-',$month,'-','15')) ",
				'updateParams' => array()
			));
		}//end if

		return $payment_record ;




	}//end function




}//end class
?>