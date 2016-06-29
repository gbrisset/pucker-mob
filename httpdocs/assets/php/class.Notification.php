<?php

class Notification extends DatabaseObject{

	protected static $table_name = "notify_users";

	// Database Fields
	public $id;
	public $notification_id;
	public $user_id;
	public $status;

	//	Object Vars
	protected static $db_fields = array('id', 'user_id', 'notification_id', 'status');

	public function __construct(){ 

	}

	public static function all(){
		
		$notification = static::find_by_sql("SELECT * FROM notify_users");
		
		return  $notification;
	}

	public static function getNotificationByUser($user_id){
		//	Set the params to be bound
		$params_to_bind = [':user_id' => $user_id];
		
		$notification = static::find_by_sql("SELECT * FROM notify_users WHERE user_id = :user_id", $params_to_bind);
var_dump( $notification);
		if(!is_null($notification)){
			$this->status = $notification->status;
		}
		return  $notification;
	}

	public function getNotificationStatus(){
		return $this->status;
	}



	
}
?>