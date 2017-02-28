<?php
/**
   * Incentives
   * Manage Incentives Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class Incentives extends DatabaseObject{

	protected static $table_name = "incentives";

	// Database Fields
	public $incentives_id;
	public $month;
	public $year;
	public $threshold;
	public $slice;
	public $tier;
	public $bonus_threshold;
	public $bonus_slice;
	public $bonus_tier;
	public $user_type;
	public $bonus_txt;



	//	Object Vars
	protected static $db_fields = array('incentives_id', 'month', 'year', 'threshold', 'slice', 'tier', 'bonus_threshold', 'bonus_slice', 'bonus_tier', 'user_type', 'bonus_txt');

	//Get Values
	public function all(){
		$incentives = static::find_by_sql("SELECT * FROM incentives ORDER BY year ASC, month ASC, user_type DESC");
		
		return  $incentives;
	}

	//Get Values
	public function where( $where = '1' ){
		$incentives = static::find_by_sql("SELECT * FROM incentives WHERE $where  ORDER BY year ASC, month ASC, user_type DESC");
		
		return  $incentives;
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