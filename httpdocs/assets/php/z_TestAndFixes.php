<?php
require_once dirname(__FILE__).'/Connector.php';

class z_TestAndFix{
	protected $config;
	protected $con;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	}



	// Generic -- Execute Query -----------------------------------------------------------------------------------------
	protected function performQuery($opts){
		$options = array_merge(array(
			'queryString' => '',
			'queryParams' => array(),
			'returnRowAsSingleArray' => true,
			'bypassCache' => false,
			'returnCount' => false  //	true: performQuery will only return a count of rows
			), $opts);
		$cachedData = false;
		if($cachedData === false || $options['bypassCache'] === true){
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($options['queryString']);
			$q->execute($options['queryParams']);
			if($q && $q->rowCount()){
				$r = array();
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					$r[] = $row;
				}
			}else $r = false;
			if($options['returnRowAsSingleArray'] === true && $r && count($r) == 1) $r = $r[0];
			$this->con->closeCon();

			if($options['returnCount'] === true){
					//	Return a count of the rows returned by the query
				return $q->rowCount();
			}

			return $r;
		}else return $cachedData;
	}



	// Generic -- Fetch contributors -----------------------------------------------------------------------------------------
	public function fix_earnings_get_contributors($contributor_id=""){
		if($contributor_id=="") $where = ""; else $where = "WHERE contributor_id IN(  $contributor_id)"; 
		$s = " 

				SELECT contributor_id, paid, updated_date FROM contributor_earnings  $where
				ORDER by contributor_id, year DESC, month DESC;

		";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_get_contributors
	
	// Generic -- Fetch contributors ids -----------------------------------------------------------------------------------------
	public function fix_earnings_get_contributors_ids($segment){
		$x = " %d, 999 "; 	$y = $segment*1000 ;
		$limit = sprintf($x,$y);

		$s = " 
				SELECT DISTINCT(contributor_id) FROM contributor_earnings  
				ORDER by contributor_id, year DESC, month DESC
				LIMIT $limit;
		";

		// var_dump($s);exit;
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_get_contributors_ids
	

	// Step One -- is manual on DB---------------------------------------------------------------------------------------
	// Step Two -- is manual on DB---------------------------------------------------------------------------------------
	
	// Step Three -----------------------------------------------------------------------------------------
	public function fix_earnings_fix_updated_date($contributor_id=""){
				if($contributor_id=="") $where = ""; else $where = " contributor_id IN(  $contributor_id) AND "; 
			$s = " 
			UPDATE contributor_earnings 
			SET updated_date = last_day(concat_ws('-',year, month,'01'))

			WHERE $where concat (year, month) <> concat(YEAR(updated_date), MONTH(updated_date));

		";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function ...



	// Step Four -----------------------------------------------------------------------------------------
	public function fix_earnings_fix_payday_date($contributor_id){

			$results = $this->fix_earnings_get_contributors($contributor_id);
			// $current_contributor_id = 0;
			$counter = 0;//used for testing only
			$payday_date = "0000-00-00 00:00:00";
			foreach ($results as $key => $row) {

					$contributor_id = $row['contributor_id'];
					// $month = $row['month'];
					// $year = $row['year'];
					// $total_us_pageviews = $row['total_us_pageviews'];
					// $total_earnings = $row['total_earnings'];
					$paid = $row['paid'];
					// $to_be_pay = $row['to_be_pay'];
					$updated_date = $row['updated_date'];
				
					// if($contributor_id != $current_contributor_id){
					// 	$current_contributor_id = $contributor_id;
					// 	$payday_date = "0000-00-00 00:00:00";;
					// 		// $ddd = new debug($contributor_id ,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
				 // 	}//end if

					if($paid == 1){
						$payday_date =   date( "Y-m-d H:i:s" ,mktime(0,0,0,2+date("n", strtotime($updated_date)), 22, date("Y", strtotime($updated_date)) )) ;
						$counter++;//used for testing only
				 	}//end if
					// $skin = $counter%4;//used for testing only
					// $ddd = new debug($updated_date . " - " . $total_earnings . " - " . $paid . " - " . $payday_date,$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
						

					$s = "  
					UPDATE contributor_earnings 
					SET payday_date = '$payday_date'

					WHERE contributor_id = $contributor_id
					AND updated_date = '$updated_date'	";

					$queryParams = [ ];			
					$q = $this->performQuery(['queryString' => $s]);


			}//end foreach ($contributor ...	

	}// end 	public function ...

	

	// Step Five -----------------------------------------------------------------------------------------
	public function fix_earnings_fix_paid($contributor_id=""){
		if($contributor_id=="") $where = ""; else $where = "WHERE contributor_id IN(  $contributor_id) AND "; 

		$s = " 
			UPDATE contributor_earnings 
			SET paid = 1 
			WHERE $where payday_date > '0000-00-00 00:00:00'
		";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function ...



	//-------------------------------------------------------------------
	//------------------ DRAFTS AND SANDBOX ---------------------------
	//-------------------------------------------------------------------


	public function fix_earnings_XXXXXXXXX($contributor_id){



	}// end 	public function ...


	

}//end class


?>