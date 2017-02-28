<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../assets/php/config.php');
	require_once ('../assets/php/z_TestAndFixes.php');
	
	$z_TestAndFix = new z_TestAndFix($config);
	

error_reporting(E_ALL);
ini_set('display_errors', '1');

// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------

$results = $z_TestAndFix->fix_earnings_step_1();

$current_contributor_id = 0;
$payday_date = "0000-00-00 00:00:00";
foreach ($results as $key => $row) {

		/*
		$results[contributor_id] => 1570
		$results[month] => 1
		$results[year] => 2017
		$results[total_us_pageviews] => 4460
		$results[total_earnings] => 3.345
		$results[paid] => 0
		$results[to_be_pay] => 73.8395
		$results[updated_date] => 2017-01-31 10:01:35
		$results[payday_date] => 0000-00-00 00:00:00

		*/

		$contributor_id = $row['contributor_id'];
		$month = $row['month'];
		$year = $row['year'];
		$total_us_pageviews = $row['total_us_pageviews'];
		$total_earnings = $row['total_earnings'];
		$paid = $row['paid'];
		$to_be_pay = $row['to_be_pay'];
		$updated_date = $row['updated_date'];
		$payday_date = $row['payday_date'];

		if($contributor_id != $current_contributor_id){
			$current_contributor_id = $contributor_id;
			$payday_date = "0000-00-00 00:00:00";;
			$ddd = new debug($contributor_id . " - " . $payday_date,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
	 	}//end if
		if($paid == 1){
			$payday_date =   date( "Y-m-d H:i:s" ,mktime(0,0,0,2+date("n", strtotime($updated_date)), 22, date("Y", strtotime($updated_date)) )) ;
	 	}//end if

			$ddd = new debug($updated_date . " - " . $total_earnings . " - " . $paid . " - " . $payday_date,2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


}//end foreach ($results


 // $ddd = new debug($new_paydate,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


 // $ddd = new debug($results,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

?>