<?php
/**
   * Incentives
   * Manage Incentives Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class AdMatching extends DatabaseObject{

	protected static $table_name = "ad_matching_program";

	// Database Fields
	public $bonus_id;
	public $bonus_label;
	public $bonus_month;
	public $bonus_year;
	public $bonus_user_pct;
	public $bonus_match_pct;
	public $user_type;


	//	Object Vars
	protected static $db_fields = array('bonus_id', 'bonus_label', 'bonus_month', 'bonus_year', 'bonus_user_pct', 'bonus_match_pct', 'user_type');

	//Get Values
	public function all(){
		$result = static::find_by_sql("SELECT * FROM ad_matching_program ");
		
		return  $result;
	}

	//Get Values
	public function where( $where = '1' ){
		$result = static::find_by_sql("SELECT * FROM ad_matching_program WHERE $where ");
		
		return  $result;
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