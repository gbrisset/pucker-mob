<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	// require_once ('../class.CronSocialMediaUpdate.php');

	// //$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	
	
# levels merit flat rate approach
// from  2017-07-01 to 2017-12-31
// Earnings based on end of month performance
// $results = $dashboard->pageviewsReport_merit( $month, $year );


# CPM - pageviews approach
// before  2017-07-01 
// and after 2017-12-31
// Earnings based on bloggers level/rank at the beginning of the month
$results = $dashboard->pageviewsReport( $month, $year );


	echo "DONE! - " . date("h:i:s");$skin = $month%3;
	$ddd = new debug("Done",$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

?>