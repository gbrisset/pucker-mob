<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../assets/php/config.php');
	// require_once ('z_TestAndFixes.php');
	
	$z_TestAndFix = new z_TestAndFix($config);
	

error_reporting(E_ALL);
ini_set('display_errors', '1');

$stepFive = $z_TestAndFix->fix_earnings_fix_paid();
$ddd = new debug('Step Five - fix_earnings_fix_paid - done',0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


?>