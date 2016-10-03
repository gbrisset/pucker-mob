<?php
	
	$admin = true;
	require '../config.php';
	//	error_reporting(E_ALL);
	//	ini_set('display_errors', '1');
	$userObj = new User();
	$notification_obj = new Notification(); 
	
	$user_list = $userObj->all("30"); //Get all blogger Basic and Pro

var_dump("TOTAL: ".count($user_list) );


	//IF CURRENT MONTH & YEAR 
	$current_month =  date('n');
	$current_year = date('Y');
	
	//For each User
	foreach($user_list as $user){
		
		//Initialize Contributor Information
		$contributor = $user->getContributorInfo();
		
		$user_id = $user->user_id;
		$user_name = $user->user_name;
		$user_type = $user->user_type;
		$current_pageviews = $prev_pageviews = 0;
		$contributor_earnings = null;
		$limit = 5000;

	
		if($contributor && isset($contributor->contributor_id) ) {
var_dump("CONT_ID : $contributor->contributor_id :  $current_month : $current_year ");
		
			$contributor_earnings = $contributor->getContributorEarningsPerMonth( $contributor, "$current_month", "$current_year" );
			$current_month_obj = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;

			if(isset($current_month_obj) && $current_month_obj) $current_pageviews = $current_month_obj->total_us_pageviews;
			
var_dump("CURRENT: $current_pageviews"); 

			// Verify if Prev & Current are above the minimum pageviews per month.
			//Upgrade to PRO BLOGGER [8]
			if( $prev_pageviews >= $limit ){
				if( $user_type == 30 ){
var_dump("UPGRADE TO BASIC: ", $user_name, $user_id,  "--------------------------------------");
				
					$data = [ "user_id" => $user_id, "user_type" => 3 ];
					$not  = [ "user_id" => $user_id, "message" => "Congratulations, you have been promote to Basic.", "type" => 2 , "date" => date( 'Y-m-d H:s:i', strtotime('now'))];

					//Update User Type value
					//$user->updateObj( $data );
					
					//Add a  Notification for this user
					$already_notified = $notification_obj->getByType(2, $user_id);
					if( count($already_notified) > 0 ){
						$not['notification_id'] = $already_notified[0]->notification_id;
					//	$notification_obj->updateObj( $not );
					}else{
					//	$notification_obj->saveObj( $not );
					}
				}
				
			}

			

		}

	}

	die;
	

?>
