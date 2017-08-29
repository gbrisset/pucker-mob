<?php

	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	//$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

	//if($year >= 2015 && $month > 2){
	$results = $dashboard->pageviewsReport( $month, $year );
	//}else $dashboard->updateContributorsEarnings( $month, $year );

	echo "DONE!";

?>