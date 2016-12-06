<?php

	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	$dashboard = new Dashboard($config);
	
	$results = $dashboard->pageviewsReport( 10, 2016 );

	echo "DONE!";

?>