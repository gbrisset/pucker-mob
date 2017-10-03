<?php

// **********************************************
// **********************************************
// THIS FILE IS MEANT TO BE EXECUTED MANUALLY.
// It has been created to rerun the earnings monthly update using the merit system
// (earnings based on end of month performance)
// **********************************************
// **********************************************


/*


UPDATE `contributor_earnings` SET `total_us_pageviews` = 100000, `total_earnings` = 0 WHERE `contributor_id` IN( 7062, 3612, 8821, 3173, 2409, 5916 ) AND year = 2017 AND month = 6;
SELECT * FROM `contributor_earnings` WHERE `contributor_id` IN( 7062, 3612, 8821, 3173, 2409, 5916 ) AND year = 2017 AND month = 6;
SELECT * FROM `smf_merit_rates` WHERE  year = 2017 AND month = 6;

http://www.puckermob.com/assets/php/cron/updateContributorEarnings_EARNINGS_FIXER.php

http://pucker-mob/assets/php/cron/updateContributorEarnings_EARNINGS_FIXER.php

SELECT * FROM `contributor_earnings` WHERE `contributor_id` IN( 3678	, 5109	, 4317	, 3002	, 3769	, 3620	, 3205	, 7062	, 10615	, 2651	, 18564	, 17483	, 2296	, 7517) AND year = 2017 AND month = 9;


SELECT * FROM `contributor_earnings` WHERE
`total_us_pageviews` >=5000 and  `total_earnings`=0
AND year = 2017 AND month = 9;

*/





	require_once('../config.php');
	require_once ('../class.Dashboard.php');

	$dashboard = new Dashboard($config);
	
	$month = 9; //month to fix
	$year = 2017; // year to fix


$ddd = new debug("MAKE SURE SETTINGS ARE RIGHT BEFORE USING THIS LIVE",3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
exit();
	
// **********************************************
$contributors[]['contributor_id'] =3678	;
$contributors[]['contributor_id'] =5109	;
$contributors[]['contributor_id'] =4317	;
$contributors[]['contributor_id'] =3002	;
$contributors[]['contributor_id'] =3769	;
$contributors[]['contributor_id'] =3620	;
$contributors[]['contributor_id'] =3205	;
$contributors[]['contributor_id'] =7062	;
$contributors[]['contributor_id'] =10615	;
$contributors[]['contributor_id'] =2651	;
$contributors[]['contributor_id'] =18564	;
$contributors[]['contributor_id'] =17483	;
$contributors[]['contributor_id'] =2296	;


// **********************************************

			// $contributors = $dashboard->getContributorsList(); 
			// $contributors = $dashboard->smf_getContributorsListTEST(); 
			// $ddd = new debug("So far so good ... ",3); $ddd->show(); exit();

		
			$updated_date = date('Y-m-d H:i:s', time());
			foreach($contributors as $contributor){

				$total_us_pageviews = 0;
				$total_earnings = 0;
				$user_rate = 0;

				$contributor_id = $contributor['contributor_id'];
	
				

					//retrieve contributor earnings row
					// $month = date('n', strtotime("last day of -1 month"));	
					// $year = date('Y', strtotime("last day of -1 month"));	
					$month_data = $dashboard->smf_getContributorEarnings_oneMonth($contributor_id, $month, $year);
					
				$ddd = new debug($month_data,2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
		
						// UPDATE PREVIOUS MONTH WITH $$ VALUE 
						//Gets the CPM rate accordingly to the pageviews performance. 
						// (this will need to be revised if merit changes to another mode of calculation - e.g.: slice/tiers)
						$month_pageviews = $month_data[0]['total_us_pageviews'];
						$merit_rates = $dashboard->smf_get_merit_rate($month_pageviews, $month, $year );	
				$ddd = new debug($merit_rates,1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

						if($merit_rates){
							$slice = $merit_rates['slice'];
							$cpm_rate_threshold = $merit_rates['cpm_rate_threshold'];
							// $cpm_rate_slice = $merit_rates['cpm_rate_slice'];
							// $cpm_rate_tier = $merit_rates['cpm_rate_tier'];

							$flat_rate_threshold = $merit_rates['flat_rate_threshold'];
							$flat_rate_slice = $merit_rates['flat_rate_slice'];
							// $flat_rate_tier = $merit_rates['flat_rate_tier'];

							//Calculate Total (monthly) Earnings
							if ($slice>0) 					$total_earnings += ($flat_rate_slice * floor($month_pageviews/$slice));
							if( $cpm_rate_threshold > 0 )   $total_earnings += ($month_pageviews / 1000 ) * $cpm_rate_threshold; 
							if( $flat_rate_threshold > 0 )  $total_earnings += $flat_rate_threshold;
					
						}//end if

						$sql_update_record = "UPDATE contributor_earnings 
						SET total_us_pageviews = $month_pageviews, total_earnings = $total_earnings, share_rate = $cpm_rate_threshold,
						updated_date = '$updated_date'
						WHERE contributor_id = $contributor_id AND month = $month AND year = $year ";
					
				$queryParams = [ ];			
				if($sql_update_record != "") $query_update_record = $dashboard->performQuery(['queryString' => $sql_update_record, 'queryParams' => $queryParams]);


			}//end foreach($contributors as $contributor)

// **********************************************

	echo "DONE! - " . date("h:i:s");$skin = $month%3;
	$ddd = new debug("Done",$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

?>