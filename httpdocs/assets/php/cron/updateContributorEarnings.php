<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	// require_once ('../class.CronSocialMediaUpdate.php');

	// //$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	
	

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if(strtotime("now")>strtotime("2017-07-02")){
	// DO NOTHING UNTIL WE RETURN ON WEDNESDAY 2017-07-04
	// $results = $dashboard->pageviewsReport_merit( $month, $year );// after 2017-07-01
}else{
	
	$results = $dashboard->pageviewsReport( $month, $year );
}//end if

 // $ddd = new debug($config,2); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	
	echo "DONE! - " . date("h:i:s");

?>