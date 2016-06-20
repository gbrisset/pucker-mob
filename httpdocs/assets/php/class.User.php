<?php

require 'config.php';

class User extends DatabaseObject{

	//
//$user = new User();
//PageList::get_by_seo_title($uri[2]);
//var_dump(User::getUser('fguzman@sequelmediagroup.com')->user_name); die;

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

	public function __construct( $email = null){ 
		$this->user_email = $email;
		$this->user = $this->getUser($email);
		$this->contributor = $this->getContributorInfo($email);
	}

	public static function getUser($user_email){
		//	Set the params to be bound
		$params_to_bind = [':user_email' => $user_email];
		
		$user = static::find_by_sql("SELECT * FROM users WHERE user_email = :user_email;", $params_to_bind);

		return  array_shift($user);
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

	public function setUserType( $data ){

		$save = static::update($data);
		
		if( $save )
			$this->user_type = $data['user_type'];

	}

	/*
	* 	GeT Contributor information that match this user.
	*  	This will return an instance of the Contributor Object. 
	*   DB Table  Affected: Article_Contributors
	*/
	public function getContributorInfo(){
		$contributor = new Contributor($this->user_email);
		return $contributor;
	}

	public function getPermission(){

	}
}
?>