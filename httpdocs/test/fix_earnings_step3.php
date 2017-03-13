<?php


	// Step One -- is manual on DB---------------------------------------------------------------------------------------
	// Step Two -- is manual on DB---------------------------------------------------------------------------------------
	
	require_once('../assets/php/config.php');
	$z_TestAndFix = new z_TestAndFix($config);

$stepThree = $z_TestAndFix->fix_earnings_fix_updated_date();

 $ddd = new debug('Step Three - fix_earnings_fix_updated_date - done',0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


?>