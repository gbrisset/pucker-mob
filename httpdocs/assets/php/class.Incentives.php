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
	public $bonus;
	public $month;
	public $year;
	public $limit;
	public $start;
	public $end;


	//	Object Vars
	protected static $db_fields = array('incentives_id', 'bonus', 'month', 'year', 'limit', 'start', 'end');

	//Get Values
	public function all(){
		$incentives = static::find_by_sql("SELECT * FROM incentives");
		
		return  $incentives;
	}

	//Get Values
	public function where( $where = '1' ){
		$incentives = static::find_by_sql("SELECT * FROM incentives WHERE $where ");
		
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