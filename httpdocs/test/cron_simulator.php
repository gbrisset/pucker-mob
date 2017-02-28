<?php 

 // $ddd = new debug($config,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


// 58 23 * * * curl http://www.puckermob.com/assets/php/cronUpdategaustraffic_daily.php > /dev/null 2>&1
/*require_once dirname(dirname(__FILE__)). '/assets/php/cronUpdategaustraffic_daily.php';*/


// 00 00 * * * curl http://www.puckermob.com/assets/php/cronUpdategaustrafficnew.php > /dev/null 2>&1
/*require_once dirname(dirname(__FILE__)). '/assets/php/cronUpdategaustrafficnew.php';*/
// calls unused functions


// 00 05 * * * curl http://www.puckermob.com/assets/php/cron/updateContributorEarnings.php > /dev/null 2&1
require_once '../assets/php/cron/updateContributorEarnings.php';
//Calls pageviewsReport



// 00 04 * * 0 curl http://www.puckermob.com/assets/php/cron/updateStarterBlogger.php > /dev/null 2&1
/*require_once dirname(dirname(__FILE__)). '/assets/php/cron/updateStarterBlogger.php';*/



// 00 06 1 * * curl http://www.puckermob.com/assets/php/cron/updateUserType.php  > /dev/null 2&1
/*require_once dirname(dirname(__FILE__)). '/assets/php/cron/updateUserType.php';*/


?>