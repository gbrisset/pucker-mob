<?php
/**
   * Incentives
   * Manage Incentives Object - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class OrderAds extends DatabaseObject{

	protected static $table_name = "orders_ad_matching";

	// Database Fields
	public $id;
	public $date;
	public $contributor_id;
	public $month_relation;
	public $year_relation;
	public $total_earnings;
	public $amount_commit;
	public $amount_match;
	public $total_commit;
	public $agree;
	public $bonus_id;
	public $bonus_pct;
	public $bonus_match;

	//	Object Vars
	protected static $db_fields = array('id', 'date', 'contributor_id', 'month_relation', 'year_relation', 'total_earnings', 'amount_commit', 'amount_match', 'total_commit', 'agree',  'bonus_id', 'bonus_id', 'bonus_pct', 'bonus_match_pct', 'bonus_match');

	//Get Values
	public function all(){
		$result = static::find_by_sql("SELECT * FROM orders_ad_matching ");
		
		return  $result;
	}

	//Get Values
	public function where( $where = '1' ){
		$result = static::find_by_sql("SELECT * FROM orders_ad_matching WHERE $where ");
		
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