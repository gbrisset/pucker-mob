<?php

class User extends DatabaseObject{

	

	protected static $table_name = "users";

	// Database Fields
	public $user_id;
	public $user_name;
	public $user_type;
	public $contributor;
	public $user_email;

	//	Object Vars
	// public static $list_count;

	protected static $db_fields = array('user_id', 'user_name', 'user_email', 'user_type');

	public function __construct( $email = null){ 
		$this->setUser($email);
	}

	public static function setUser($user_email){
		//	Set the params to be bound
		$params_to_bind = [':user_email' => $user_email];
		
		$user = static::find_by_sql("SELECT * FROM users WHERE user_email = :user_email;", $params_to_bind);
		
		var_dump($user->user_id);
		//return $data_set;
	}

	public function getUserName(){
		return $this->user_name;
	}

	public function setUserName($user_name){
		$this->user_name = $user_name;
	}
	
	public function setUserType( $type = 3 ){
		$this->user_type = $type;
	}

	public function getUserType(){
		return $this->user_type;
	}
}
?>