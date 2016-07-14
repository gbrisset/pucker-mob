<?php
/**
   * Notification
   * Manage Notifiation Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class Notification extends DatabaseObject{

	protected static $table_name = "notify_users";

	// Database Fields
	public $id;
	public $notification_id;
	public $user_id;
	public $status;
	public $notification_msg;
	public $notification_date;

	//	Object Vars
	protected static $db_fields = array('id', 'user_id', 'notification_id', 'status', 'notification_date');

	//Get all notifications per user
	public static function all(){
		
		$notification = static::find_by_sql("SELECT * FROM notify_users");
		
		return  $notification;
	}

	//Update
	public function updateObj( $data ){

		$update = static::update($data);
		
		return $update;

	}

	//Insert into notify_users table
	public function saveObj( $data ){

		$save = static::create($data);
		
		return $save;

	}

	//Get all notifications by UserID
	public static function getNotificationByUser( $user_id ){
		//	Set the params to be bound
		$params_to_bind = [':user_id' => $user_id ];
		
		$notification = static::find_by_sql(
			"SELECT * 
			 FROM notify_users 
			INNER JOIN (notification_center) 
				ON notify_users.notification_id = notification_center.notification_id 
			WHERE user_id = :user_id and status = 1 GROUP BY notification_type ORDER BY notify_users.notification_id DESC", $params_to_bind
		);

		return  $notification;
	}

	public static function getGeneralNotifiactions(){
		//	Set the params to be bound
		
		$notification = static::find_by_sql(
			"SELECT * 
			 FROM notification_center 
			 WHERE notification_type = 99 order by notification_id DESC"
		);

		return  $notification;
	}
} ?>