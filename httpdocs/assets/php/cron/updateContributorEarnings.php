<?php
	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	//$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	//1- Get All Articles Status = Live.
	
	$month = 1;//date('n');
	$year = 2015;//date('Y');
	//$month = 11;
	
	$dashboard->updateContributorsEarnings( $month, $year );

?>