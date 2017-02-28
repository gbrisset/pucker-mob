<?php

 // $ddd = new debug($config,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	require_once('../assets/php/config.php');
	require_once ('../assets/php/z_TestAndFixes.php');
	
	$z_TestAndFix = new z_TestAndFix($config);
	

error_reporting(E_ALL);
ini_set('display_errors', '1');

// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------


$updated_date = "2017-01-31";
$new_paydate =   date( "Y-m-d G:i:s" ,mktime(0,0,0, date("n", strtotime($updated_date)), 22, date("Y", strtotime($updated_date)) )) ;



 $ddd = new debug($new_paydate,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


 // $ddd = new debug($results,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

?>