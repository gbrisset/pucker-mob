<?php


$d1 = date("Y-m-d h:i:s");

	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	//$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	
	$month = date('n');
	$year = date('Y');
	
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
	$month = 2;
	$year = 2017;	
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
/// TEST /// TEST /// TEST /// TEST /// TEST /// TEST 
	

error_reporting(E_ALL);
ini_set('display_errors', '1');


	$results = $dashboard->pageviewsReport( $month, $year );

$d2 = date("Y-m-d h:i:s");

  $ddd = new debug($d1,0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
  $ddd = new debug($d2,1); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


?>