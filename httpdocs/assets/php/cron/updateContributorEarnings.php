<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	//$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	
	
 // $ddd = new debug($config,2); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


	$results = $dashboard->pageviewsReport( $month, $year );

	echo "DONE!";

?>