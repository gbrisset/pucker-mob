<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="60">
</head>
<body>

<?php



	require_once('../assets/php/config.php');

// Classes ---------------------------------------------------------------------
// Classes ---------------------------------------------------------------------


 require_once '../assets/php/Connector.php';



class zx_TestAndFix{
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
			
		//	if($options['returnRowAsSingleArray'] === true && $r && count($r) == 1) $r = $r[0];
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
		$x = " %d, 99 "; 	$y = $segment*100 ;
		$limit = sprintf($x,$y);

		$s = " 
				SELECT DISTINCT(contributor_id) FROM contributor_earnings  
				ORDER by contributor_id
				LIMIT $limit;
		";

		// var_dump($s);exit;
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_get_contributors_ids
	

	// Generic -- Fetch contributors from temp id table -----------------------------------------------------------------------------------------
	public function fix_earnings_get_contributors_ids_from_temp_table(){
		
		$s = "SELECT max(cid) AS id FROM _temp_cid WHERE fixed = 0;	";

		// var_dump($s);exit;
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_get_contributors_ids
	
	// Generic -- Update contributors in temp id table -----------------------------------------------------------------------------------------
	public function update_contributors_id_in_temp_table($cid){
		
		$s = " UPDATE  _temp_cid SET fixed =1 WHERE cid = " . $cid;

		// var_dump($s); exit;
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;

	}// end 	public function ...
	



	// Step Four -----------------------------------------------------------------------------------------
	public function fix_earnings_fix_payday_date($contributor_id){

			$results = $this->fix_earnings_get_contributors($contributor_id);
			$counter = 0;//used for testing only
			$payday_date = "0000-00-00 00:00:00";


			foreach ($results as $key => $row) {
					$contributor_id = $row['contributor_id'];
					$paid = $row['paid'];
					$updated_date = $row['updated_date'];

					if($paid == 1){
						$payday_date =   date( "Y-m-d H:i:s" ,mktime(0,0,0,2+date("n", strtotime($updated_date)), 22, date("Y", strtotime($updated_date)) )) ;
						$counter++;//used for testing only
				 	}//end if
						

					$s = "  
					UPDATE contributor_earnings 
					SET payday_date = '$payday_date'

					WHERE contributor_id = $contributor_id
					AND updated_date = '$updated_date'	";

					$queryParams = [ ];			
					$q = $this->performQuery(['queryString' => $s]);


			}//end foreach ($contributor ...	
return true;
	}// end 	public function ...

	
}//end class



// End of Classes ---------------------------------------------------------------------
// End of Classes ---------------------------------------------------------------------


	$zx_TestAndFix = new zx_TestAndFix($config);
	

error_reporting(E_ALL);
ini_set('display_errors', '1');

 // $segment = $_GET['s'];


	// $results = $zx_TestAndFix->fix_earnings_get_contributors_ids($segment);

	//  $ddd = new debug("	Step Four - $segment ",1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
	//  $ddd = new debug(count($results),3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
	//  // exit();
	// 	foreach ($results as $contributor) {
	// 		$contributor_id = $contributor['contributor_id'];
	// 		$stepFour = $zx_TestAndFix->fix_earnings_fix_payday_date($contributor_id);
	// }//end foreach ($results as $contributor) 



for($zzz=0; $zzz<1; $zzz++){

	$temp_cid = $zx_TestAndFix->fix_earnings_get_contributors_ids_from_temp_table();
	 // $ddd = new debug($temp_cid,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	
	$cid = $temp_cid[0]['id'];
	$stepFour = $zx_TestAndFix->fix_earnings_fix_payday_date($cid);
	if ($stepFour) {
		$update_cid = $zx_TestAndFix->update_contributors_id_in_temp_table($cid);
		$msg = "OK";
	}else{
		$msg = "VOID";
	}//end if

$skin = $cid%4;//used for testing only
$ddd = new debug("Step Four - fix_earnings_fix_payday_date - cid $cid $msg",$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

}//end for($zzz=0; ...

$skin = $cid%4;//used for testing only
$ddd = new debug("Step Four - DONE ",$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



// $stepFour = $zx_TestAndFix->fix_earnings_fix_payday_date(8821);




?>

</body>
</html>