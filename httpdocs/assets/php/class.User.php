<?php

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

	public function getUserName(){
		return $this->user->user_name;
	}

	public function getUserId(){
		return $this->user->user_id;
	}

	public function getUserEmail(){
		return $this->user->user_email;
	}
	
	public function getUserType(){
		return $this->user->user_type;
	}

	public function getContributorInfo(){

		$contributor = new Contributor($this->user_email);

		return $contributor;
	}

	public function getPermission(){

	}
}
?>