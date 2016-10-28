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

	public function generateForm( $contributor_id, $balance ){
		
		$form = "";
		$form .= "<div>";
		$form .= "<form action='' method='POST' id='form-transaction'>";
		$form .= "<input type='hidden' value='".$contributor_id."'  name='contributor_id' id='contributor_id' />";
		$form .= "<input type='hidden' value='".$balance."'  name='balance' id='balance-transaccion' />";
		$form .= "<table class='columns small-12'>";
		$form .= "<tr>";
		$form .= "<td width=\"200\"><div><input type='checkbox' name='receipt' id='receipt-transaction' /></div></td>";
		$form .= "<td width=\"200\"><div><input type='number' placeholder='0.00' name='spent' id='spent-transaction' /></div></td>";
		$form .= "<td width=\"200\"><div><input type='date' name='date'  id='date-transaction' value='".date("m/d/Y")."'' /></div></td>";
		$form .= "<td width=\"200\"><div><label>---</label></div></td>";
		$form .= "<td width=\"200\"><div><input type='button' name='save-transaction' id='save-transaction' value='SAVE' class='button' /></div></td>";
		$form .= "</tr>";
		$form .= "</table>";
		$form .= "</form>";
		$form .= "</div>";
		
		return $form;
	}
	
} ?>