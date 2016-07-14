<?php
/**
   * Notification
   * Manage Notifiation Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class Notification extends DatabaseObject{

	protected static $table_name = "notifications";

	// Database Fields
	public $notification_id;
	public $type;
	public $user_id;
	public $message;
	public $date;

	//	Object Vars
	protected static $db_fields = array('notification_id', 'user_id', 'type', 'date', 'message');

	//Get all notifications per user
	public static function all( $user_id = null ){
		if( $user_id ){
			$params_to_bind = [':user_id' => $user_id];
			$notification = static::find_by_sql("SELECT * FROM notifications WHERE user_id = 0 OR user_id IN( 0, :user_id ) ORDER BY date DESC", $params_to_bind);
		}else{
			$notification = static::find_by_sql("SELECT * FROM notifications  WHERE type = 1  ORDER BY date DESC");
		}
		
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

	public function getByType( $type = 0, $user_id = 0 ){
		$notification = static::find_by_sql("SELECT * FROM notifications WHERE type = $type and user_id = $user_id");
		
		return $notification;
	}

	//Get all notifications by UserID
	public static function getNotificationByUser( $user_id ){
		//	Set the params to be bound
		$params_to_bind = [':user_id' => $user_id ];
		
		$notification = static::find_by_sql(
			"SELECT * 
			 FROM notifications 
			WHERE user_id = :user_id and type = 1 ORDER BY id DESC", $params_to_bind
		);

		return  $notification;
	}

	public static function getGeneralNotifiactions(){
		//	Set the params to be bound
		
		$notification = static::find_by_sql(
			"SELECT * 
			 FROM  notifications
			 WHERE user_id = 0 and type = 1 order by id DESC"
		);

		return  $notification;
	}
} ?>