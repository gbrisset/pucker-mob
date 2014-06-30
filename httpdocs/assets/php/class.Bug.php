<?php
/**
   * Bug
   * 
   * @package    DatabaseObject
   * @author     Michael Mrnak <mmrnak@sequelmediagroup.com.com>
   */

class Bug extends DatabaseObject{

	protected static $table_name = "bugs";

	// Database Fields
	public $bug_id;
	public $bug_date;
	public $bug_user_email;
	public $bug_description;
	public $bug_browser;
	public $bug_error_message;


	//	Object Vars
	public static $bug_count;

	protected static $db_fields = array('bug_id', 'bug_date', 'bug_user_email', 'bug_description', 'bug_browser', 'bug_error_message');


	public static function get_order_string($get){
		$get;
		switch ($get) {
			case 'az':
				$order = ' bug_user_email ASC ';
				break;
			
			default:
				$order = ' bug_id DESC ';
				break;
		}

	}
}
?>