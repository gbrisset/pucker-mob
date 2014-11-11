<?php

class MPAdminUserController extends MPArticleAdminController{
	protected $config;
	protected $con;
	protected $mpArticle;
	public $helpers;
	
	public $data;

	private $salt;

	public function __construct($opts){
		$this->config = $opts['config'];
		$this->con = new Connector($this->config);
		$this->mpArticle = $opts['mpArticle'];

		$this->data = false;

		$this->helpers = new AdminControllerHelpers(array('config' => $this->config));
		
		$this->salt = 'w?LO4?}1l!EZLFBri,5KGek>41t<q|wH_1D`DWA<f~K-]GIo$.2yR:Y9a&k|4-RQ';
	}


/**
 * 	Redirects the user, after logging in
 *	Depending on the user_type 
 */
	public function redirectAfterLogin(){
		//	getUserInfo() doesn't require any arg - uses $_SESSION
		$user = $this->getUserInfo();
		
		$config = $this->config;
		if($user['user_type'] > 2){
			//	Check if 1st login...
			if($user['user_login_count'] <= 1){
				//	Redirect to admin/ (first login)
				return "<script>setTimeout(function(){window.location = \"".$config['this_admin_url']."\"}, 10);</script>";
			} else {
				//	Redirect to admin/articles/ (user_type: 3, 4)
				return "<script>setTimeout(function(){window.location = \"".$config['this_admin_url']."\"}, 10);</script>";
				//return "<script>setTimeout(function(){window.location = \"".$config['this_admin_url']."articles/\"}, 1000);</script>";
			}
		} else {
			//	Redirect to admin/	(user_type: 1, 2)
			return "<script>setTimeout(function(){window.location = \"".$config['this_admin_url']."\"}, 10);</script>";
		}
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
							WHERE user_name != :userName 
							AND 
							(	user_email = :email 
								OR (
	     								( LOWER(user_first_name) = LOWER(:first) AND LOWER(user_last_name) = LOWER(:last) )
									)
							)
							LIMIT 0, 1",
			'queryParams' => [
				':userName' => filter_var(trim($post['user_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				':email' => filter_var(trim($post['user_email-e']), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				':first' => filter_var(trim($post['user_first_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR),
				':last' => filter_var(trim($post['user_last_name-s']), FILTER_SANITIZE_STRING, PDO::PARAM_STR)
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
		
			// if(!$this->helpers->compareTimes(time(), strtotime($q['user_login_creation_date']), 15)) return array(
			// 	'hasError' => true, 
			// 	'message' => "Sorry, your session has expired.  Please try again <a href=\"".$this->config['this_admin_url'].'login/'."\">here</a>."
			// );
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
				'message' => "Thanks!  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\">here</a>" 
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
			'message' => "Sorry, we couldn't find any users that matched your user name.  Please try again."
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
			'queryString' => "SELECT * FROM users WHERE (user_name = :username OR  user_email = :username) AND user_hashed_password = :password LIMIT 0, 1",
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

		//	Based on the post data, formulate the hashed password.
		$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);	

		$hashed_password = crypt($post['user_password-s'], '$2a$12$' . $salt);
		//	Unset the password in the past variable, so as not to save it to the db and compile it  in compilePairs()
		
		unset($post['user_password-s']);

		//	Make sure the email addresses match
		if($post['user_email_1-e'] == "" || $post['user_email_2-e'] == ""){
			return array('hasError' => true, 'message' => "Oops!  You must fill out both email fields.");
		}
		if($post['user_email_1-e'] != $post['user_email_2-e']){
			return array('hasError' => true, 'message' => "Oops!  Your email addresses do not match.");
		}

		//	Set the email post variable correctly
		$post['user_email-e'] = $post['user_email_2-e'];
		unset($post['user_email_1-e']);
		unset($post['user_email_2-e']);

		$pairs = $this->helpers->compilePairs($post, true);
		$params = $this->helpers->compileParams($post);
		$unrequired = array('user_last_name');
		
		$username = $post['user_name-s'];

		if ($this->usernameExists($username)){
			return array('hasError' => true, 'message' => "Oops!  Looks like that username is already taken.  Did you mean to login instead?  If so, you can do that <a href=\"".$this->config['this_admin_url'].'login/'."\"><u>here</u></a>.");
		}	

		$user = $this->userAlreadyExists($post);
		if ($user['user_email'] == $post['user_email-e']){
			return array('hasError' => true, 'message' => "Oops!  Looks like that email address is already in use.  Did you mean to login instead?  If so, you can do that <a href=\"".$this->config['this_admin_url'].'login/'."\"><u>here</u></a>.");
		}

		if (strtolower($user['user_first_name']) == strtolower($post['user_first_name-s']) && strtolower($user['user_last_name']) == strtolower($post['user_last_name-s'])){
			return array('hasError' => true, 'message' => "That first and last name combination is taken, please choose another first and/or last name.");
		}

		if (!isset($post['tos_agreed-s']) || $post['tos_agreed-s'] != 1){
			return array('hasError' => true, 'message' => 'You must agree to our terms of service.');
		}

		$valid = $this->helpers->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$verificationHash = $this->generateHash();

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
		
		$s = "INSERT INTO users (".join(', ', $keys).") VALUES (".join(', ', $values).")";
		$result = $this->performUpdate(array(
			'updateString' => "INSERT INTO users (".join(', ', $keys).") VALUES (".join(', ', $values).")",
			'updateParams' => $params
		));

		if($result){
			//Add Contributor Info
			$contributor_name = $post['user_first_name-s'].' '.$post['user_last_name-s'];
			$email = $post['user_first_name-s'].' '.$post['user_email-e'];
			$contributor_seo_name  = $this->helpers->generateName(array('input' => $contributor_name ));
			
			if(isset($contributor_seo_name)) $contributor_seo_name = join(explode(' ', strtolower(preg_replace('/[^A-Za-z0-9- ]/', '', $contributor_seo_name))), '-');

			$dupCheck = $this->mpArticle->getContributors(['contributorSEOName' => $contributor_seo_name] );
			$dupCheckEmail = $this->mpArticle->getContributors(['contributorEmail' => $post['user_email-e'] ] );


			if(count($dupCheck['contributors']) <= 0 && count($dupCheckEmail['contributors']) <= 0){
				$contributor_id = $this->performUpdate(array(
					'updateString' => "INSERT INTO article_contributors ( contributor_name, contributor_seo_name, contributor_email_address ) VALUES ('".$contributor_name ."', '".$contributor_seo_name."', '".$post['user_email-e']."')",
					'updateParams' => $params
				));
			}
			//End Adding Contributor Info

			//	Send Email
			if(!$registerEmail = $this->send_email(array(
				'email' => $params[':user_email'],
				'hashUrl' => $this->config['this_admin_url'].'activate/'.$verificationHash,
				'action' => 'access',
				'subject' => $this->mpArticle->data['article_page_visible_name']." Registration Email",
				'username' => $params[':user_name']
			))) return $registerEmail;
			$r = $this->helpers->returnStatus(200);
			$r['message'] = "Thanks for registering.  You'll receive an email to confirm your account shortly.";
			return $r;
		}else return $this->helpers->returnStatus(500);
	}	


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
		$mail->AltBody = 'Thank you for registering with puckermob.com!  Go to '.$options['hashUrl'].' to complete the registration process.';

		if(!$mail->send()) {
		   //return 'Message could not be sent.';
		   //return 'Mailer Error: ' . $mail->ErrorInfo;
		   return array_merge($this->helpers->returnStatus(500), array('hasError' => true));

		   exit;
		}

		//	return 'Message has been sent';
		return true;

	}


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
			'queryString' => 'SELECT * FROM users WHERE user_verification_code = :user_verification_code LIMIT 0, 1',
			'queryParams' => array(':user_verification_code' => filter_var($hash, FILTER_SANITIZE_STRING, PDO::PARAM_STR)),
			'returnRowAsSingleArray' => true,
			'bypassCache' => true
		));

		if($user){
			if($user['user_verified'] == 1){
				$r = $this->helpers->returnStatus(200);
				$r['message'] = "Thanks for verifying.  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\">here</a>.";
				return $r;
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
				$r['message'] = "Thanks for verifying.  You'll be redirected momentarily to your account.  If not, click <a href=\"".$this->config['this_admin_url']."\">here</a>.";
				return $r;
			}else return $this->helpers->returnStatus(500);
		}else return $this->helpers->returnStatus(500);
	}

	public function resendUserVerify(){
		if(!isset($_SESSION['user_id'])) $this->helpers->returnStatus(500);

		$user = $this->performQuery(array(
			'queryString' => "SELECT * FROM users WHERE user_id = :userId LIMIT 0, 1",
			'queryParams' => array(':userId' => filter_var($_SESSION['user_id'], FILTER_SANITIZE_STRING, PDO::PARAM_STR))
		));

		if($user){
			if(!$registerEmail = $this->sendEmail(array(
				'email' => $user['user_email'],
				'hashUrl' => $this->config['this_admin_url'].'activate/'.$user['user_verification_code'],
				'action' => 'access',
				'subject' => $this->mpArticle->data['article_page_visible_name']." Registration Email",
				'username' => $user['user_name']
			))) return $registerEmail;
			$r = $this->helpers->returnStatus(200);
			$r['message'] = "Thanks for registering.  We've resent your verification email to the email address on file.";
			return $r;
		}else $this->helpers->returnStatus(500);
	}
	/* End Registration Functions */
}
?>