<?php
/**
   * User
   * Manage User Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class User extends DatabaseObject{

	protected static $table_name = "users";

	// Database Fields
	public $user_id;
	public $user_name;
	public $user_type;
	public $contributor;
	public $user_email;
	public $user;

	//	Object Vars
	protected static $db_fields = array('user_id', 'user_name', 'user_email', 'user_type');

	public function __construct( $email = null ){ 
		$this->user_email = $email;
		$this->user = $this->getUser($email);
		$this->contributor = $this->getContributorInfo();
	}

	public static function getUser($user_email){
		//	Set the params to be bound
		$params_to_bind = [':user_email' => $user_email];
		
		$user = static::find_by_sql("SELECT * FROM users WHERE user_email = :user_email;", $params_to_bind);

		return  array_shift($user);
	}

	/* Get All Users */
	public function all( $user_type = false ){
		if(!$user_type ){

			$users = static::find_by_sql(
					"SELECT users.*, user_logins.user_login_creation_date 
					FROM users 
					INNER JOIN user_logins 
						ON ( users.user_id = user_logins.user_id )
					WHERE user_logins.user_login_creation_date > '2016-01-01 0:0:0' 
					GROUP BY users.user_id
					ORDER BY users.user_login_count DESC 
					
				");
		}else{
			$users = static::find_by_sql(
				"SELECT users.*, user_logins.user_login_creation_date 
				FROM users 
				INNER JOIN user_logins 
					ON ( users.user_id = user_logins.user_id )
				WHERE user_logins.user_login_creation_date > '2016-01-01 0:0:0' AND user_type in ($user_type)
				GROUP BY users.user_id
				ORDER BY users.user_login_count DESC 
				
			");
		}
		return $users;
	}

	public function allTest( $user_type = false ){
		if(!$user_type ){

			$users = static::find_by_sql(
					"SELECT users.*, user_logins.user_login_creation_date 
					FROM users 
					INNER JOIN user_logins 
						ON ( users.user_id = user_logins.user_id )
					WHERE user_logins.user_login_creation_date > '2016-01-01 0:0:0' 
					GROUP BY users.user_id
					ORDER BY users.user_login_count DESC 
					
				");
		}else{
			$users = static::find_by_sql(
				"SELECT users.*, user_logins.user_login_creation_date 
				FROM users 
				INNER JOIN user_logins 
					ON ( users.user_id = user_logins.user_id )
				WHERE user_logins.user_login_creation_date > '2016-01-01 0:0:0' AND user_type in ($user_type)
				GROUP BY users.user_id
				ORDER BY users.user_login_count DESC LIMIT 2000
				
			");
		}
		return $users;
	}

	public function where($where = false){
		$query = " SELECT users.*, user_logins.user_login_creation_date 
					FROM users 
					INNER JOIN user_logins 
						ON ( users.user_id = user_logins.user_id )
				";
		
		if($where ){
			$query .= " ". $where." ";
		}

		$query .= " GROUP BY users.user_id
					ORDER BY users.user_login_count DESC  ";
		$users = static::find_by_sql($query);

		return $users;
	}

	/* GET user by ID */

	public function getObj( $id ){
		$params_to_bind = [ 'user_id' => $id ];

		$user = static::find_by_sql("SELECT * FROM users WHERE user_id = :user_id ", $params_to_bind);

		return $user;
	}

	/*
	* 	GeT  User ID Record
	*/
	public function getUserId(){
		return $this->user->user_id;
	}

	/*
	* 	GeT  and Set user Name for each User
	*   DB Table Affected: Users
	*/
	public function getUserName(){
		return $this->user->user_name;
	}

	public function setUserName( $user_name ){
		$this->user_name = $user_name;
	}

	/*
	* 	GeT  and Set User Email for each User
	* 	If User Email Change Contributor Email Address Most Change 
	*   DB Table  Affected: Users & Article_Contributors
	*/
	public function getUserEmail(){
		return $this->user->user_email;
	}

	public function setUserEmail( $user_email ){
		$this->user_email = $user_email;
	}
	
	/*
	* 	GeT  and Set User Type for each User
	* 	Values:
	*		0 => Deactivated
	* 		1 & 999 => Admin & Super Admin
	*		2 & 3 & 8 & 9 => Bloggers, Pro Bloggers & Invited Bloggers
	*		6, 7 => In-House & External Writers
	*/	
	public function getUserType(){
		return $this->user->user_type;
	}

	public function updateObj( $data ){

		$update = static::update($data);
		
		return $update;

	}

	/*
	* 	GeT Contributor information that match this user.
	*  	This will return an instance of the Contributor Object. 
	*   DB Table  Affected: Article_Contributors
	*/
	public function getContributorInfo(){ 
		$contributor = new Contributor($this->user_email); 
		$this->contributor = $contributor;
		return $contributor;
	}

}
?>