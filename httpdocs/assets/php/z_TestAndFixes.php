<?php
require_once dirname(__FILE__).'/Connector.php';

class z_TestAndFix{
	protected $config;
	protected $con;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	}

	//Execute Query
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





	public function fix_earnings_step_1(){
		$s = " 

SELECT *  FROM `contributor_earnings`  
 WHERE `contributor_id` IN(    
3173	
)

ORDER by contributor_id, year DESC, month DESC;


		";

// 3612, 5916, 7062, 8603, 8821, 13511, 13694, 1570, 2409, 3173, 4769, 5818, 6330, 6869, 7623, 8156, 8449, 10560, 13307, 13552 
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_step_1()

	

	public function fix_earnings_step_2(){
		$s = " UPDATE `contributor_earnings` SET `total_earnings` = '100' WHERE `contributor_earnings`.`contributor_id` = 3173;";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}// end 	public function fix_earnings_step_1()

	

}//end class


?>