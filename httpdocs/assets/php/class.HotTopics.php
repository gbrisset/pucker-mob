<?php
/**
   * Notification
   * Manage Notifiation Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class HotTopics extends DatabaseObject{

	protected static $table_name = "hottopics";

	// Database Fields
	public $hot_topics_id;
	public $hot_topics_message;


	//	Object Vars
	protected static $db_fields = array('hot_topics_id', 'hot_topics_message');

	//Get Values
	public function all(){
		$hottopics = static::find_by_sql("SELECT * FROM hottopics LIMIT 1");
		
		return  $hottopics;
	}
	//Update
	public function updateObj( $data ){

		$update = static::update($data);

		return $update;

	}


	public function saveObj( $data ){

		$save = static::create($data);
		
		return $save;

	}
	
} ?>