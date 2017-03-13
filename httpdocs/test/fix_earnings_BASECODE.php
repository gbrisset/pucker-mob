<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../assets/php/config.php');
	// require_once ('z_TestAndFixes.php');
	
	$z_TestAndFix = new z_TestAndFix($config);
	

error_reporting(E_ALL);
ini_set('display_errors', '1');

// ----------------------------------------------------------------------------------------------------------------
// ---------------- FIX THE CONTRIBUTOR TABLE -------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
// '3173, 7062'
// $list_of_bloggers = $z_TestAndFix->fix_earnings_get_contributors();
// // var_dump($list_of_bloggers);

//  $ddd = new debug(count($list_of_bloggers),0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

// exit;


$stepThree = $z_TestAndFix->fix_earnings_fix_updated_date();

 $ddd = new debug('Step Three - fix_earnings_fix_updated_date - done',0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

// var_dump($contributor);exit();

$results = $z_TestAndFix->fix_earnings_get_contributors_ids();
	foreach ($results as $contributor) {
		$contributor_id = $contributor['contributor_id'];
		$stepFour = $z_TestAndFix->fix_earnings_fix_payday_date($contributor_id);
}//end foreach ($results as $contributor) 

 $ddd = new debug('Step Four - fix_earnings_fix_payday_date - done',0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

$stepFive = $z_TestAndFix->fix_earnings_fix_paid();
 $ddd = new debug('Step Five - fix_earnings_fix_paid - done',0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


 // $ddd = new debug($results,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

?>