<?php
/**
   * Incentives
   * Manage Incentives Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class AdMatchingTransactions extends DatabaseObject{

	protected static $table_name = "ad_matching_transactions";

	// Database Fields
	public $id;
	public $contributor_id;
	public $spent;
	public $balance;
	public $date;
	public $receipt;


	//	Object Vars
	protected static $db_fields = array('id', 'contributor_id', 'spent', 'balance', 'date', 'receipt');

	//Get Values
	public function all(){
		$result = static::find_by_sql("SELECT * FROM ad_matching_transactions ");
		
		return  $result;
	}

	//Get Values
	public function where( $where = '1' ){
		$result = static::find_by_sql("SELECT * FROM ad_matching_transactions WHERE $where ");
		
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