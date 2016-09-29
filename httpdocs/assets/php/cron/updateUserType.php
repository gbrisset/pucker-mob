<?php
	
	$admin = true;
	require '../config.php';

	$userObj = new User();
	$notification_obj = new Notification(); 

	//Get all blogger Basic and Pro
	$user_list = $userObj->all("3, 8");
	$current_month =  date('n') -1;
	$prev_month = date('n') -2 ;
	$current_year = date('Y');
	foreach($user_list as $user){
		//Initialize Contributor Information
		$contributor = $user->getContributorInfo();
		
		$user_id = $user->user_id;
		$user_name = $user->user_name;
		$user_type = $user->user_type;
		$current_pageviews = $prev_pageviews = 0;
		$contributor_earnings = null;
		$limit = 25000;

	
		if($contributor){
			//$contributor_earnings = $contributor->getContributorEarnings( $user->getContributorInfo(), 2 );
var_dump("CONT_ID : $contributor->contributor_id : $prev_month, $current_month : $current_year ");

			$contributor_earnings = $contributor->getContributorEarningsPerMonth( $contributor, "$prev_month, $current_month", "$current_year" );
			$current_month_obj = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;
			$prev_month_obj = isset($contributor_earnings[1]) ? $contributor_earnings[1] : false;

			if(isset($current_month_obj) && $current_month_obj) $current_pageviews = $current_month_obj->total_us_pageviews;
			if(isset($prev_month_obj) && $prev_month_obj) $prev_pageviews = $prev_month_obj->total_us_pageviews;
			
var_dump(" PREV: $prev_pageviews, CURRENT: $current_pageviews"); 

			// Verify if Prev & Current are above the minimum pageviews per month.
			//Upgrade to PRO BLOGGER [8]
			if( $prev_pageviews >= $limit && $current_pageviews >=  $limit ){
				//UPGRADE

				if( $user_type == 3 ){
var_dump("UPGRADE TO PRO: ", $user_name, $user_id,  "--------------------------------------");
				
					$data = [ "user_id" => $user_id, "user_type" => 8 ];
					$not  = [ "user_id" => $user_id, "message" => "Upgrade to PRO BLOGGER", "type" => 2 , "date" => date( 'Y-m-d H:s:i', strtotime('now'))];

					//Update User Type value
					//$user->updateObj( $data );
					
					//Add a  Notification for this user
					//$already_notified = $notification_obj->getByType(2, $user_id);
					//if( count($already_notified) > 0 ){
					//	$not['notification_id'] = $already_notified[0]->notification_id;
						//$notification_obj->updateObj( $not );
				//	}else{
						//$notification_obj->saveObj( $not );
					//}
				}
				
			}elseif( $prev_pageviews < $limit && $current_pageviews < $limit ){
				if( $user_type == 8 ||  $user_type == 9 ){
var_dump("DOWNGRADE TO BASIC: ", $user_name, $user_id,  "--------------------------------------");
				
					// Verify if Prev & Current are below the minimum pageviews per month
					//Downgrade from PRO to BLOGGER [3]
					$data = [ "user_id" => $user_id, "user_type" => 3 ];
					$not  = [ "user_id" => $user_id, "message" => "Downgrade from PRO to BLOGGER", "type" => 2, "date" => date( 'Y-m-d H:s:i', strtotime('now')) ];

					//Update User Type value
					//$user->updateObj( $data );
					
					///Add a  Notification for this user
				//	$already_notified = $notification_obj->getByType(2, $user_id);
				//	if( count($already_notified) > 0 ){
				//		$not['notification_id'] = $already_notified[0]->notification_id;
					//	$notification_obj->updateObj( $not );
				//	}else{
					//	$notification_obj->saveObj( $not );
				//	}
				}
			}

			if($prev_pageviews >= $limit && $current_pageviews < $limit ){
				//WARNING
				if( $user_type == 8 ||  $user_type == 9 ){
var_dump("WARNING: ", $user_name, $user_id,  "--------------------------------------");
				
				//	$not  = [ "user_id" => $user_id, "message" => "Warnings", "type" => 2 , "date" => date( 'Y-m-d H:s:i', strtotime('now'))];
				//	$notification_obj->saveObj( $not );
				}

			}

		}

	}

	die;
	

?>
