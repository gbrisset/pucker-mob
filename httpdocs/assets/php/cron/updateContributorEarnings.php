<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	// require_once ('../class.CronSocialMediaUpdate.php');

	// //$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	
	

$results = $dashboard->pageviewsReport_merit( $month, $year );// after 2017-07-01 - earnings based on end of month performance
// $results = $dashboard->pageviewsReport( $month, $year );// before 2017-07-01 - earnings based on blogers level at the beginning of the month


	echo "DONE! - " . date("h:i:s");$skin = $month%3;
	$ddd = new debug("Done",$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

?>