<?php

	require '../class.User.php';

	$userObj = new User();
	$notification_obj = new Notification(); 

	//Get all blogger Basic and Pro
	$user_list = $userObj->all("3, 8");
	foreach($user_list as $user){

		$user_id = $user->user_id;
		$user_name = $user->user_name;
		$user_type = $user->user_type;

		$current_pageviews = $prev_pageviews = 0;
		$contributor = $user->getContributorInfo();
		$contributor_earnings = null;
		$min_pv = 25000;
		$max_pv = 35000;
	
		if($contributor){
			$contributor_earnings = $contributor->getContributorEarnings( $user->getContributorInfo(), 2 );

			$current_month = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;
			$prev_month = isset($contributor_earnings[1]) ? $contributor_earnings[1] : false;

			$current_pageviews = $current_month->total_us_pageviews;
			$prev_pageviews = $prev_month->total_us_pageviews;
			
			
			// Verify if Prev & Current are above the minimum pageviews per month.
			//Upgrade to PRO BLOGGER [8]
			if( $prev_pageviews >= $min_pv && $current_pageviews >=  $min_pv ){
				//UPGRADE

				$data = [ "user_id" => $user_id, "user_type" => 8 ];
				$not  = [ "user_id" => $user_id, "message" => "Upgrade to PRO BLOGGER", "type" => 2 , "date" => date( 'Y-m-d H:s:i', strtotime('now'))];

				//Update User Type value
				$user->updateObj( $data );
				
				//Add a  Notification for this user
				$already_notified = $notification_obj->getByType(2, $user_id);
				if( count($already_notified) > 0 ){
					$not['notification_id'] = $already_notified[0]->notification_id;
					$notification_obj->updateObj( $not );
				}else{
					$notification_obj->saveObj( $not );
				}
				
			}elseif( $prev_pageviews < $max_pv && $current_pageviews < $max_pv ){

				// Verify if Prev & Current are below the minimum pageviews per month
				//Downgrade from PRO to BLOGGER [3]
				$data = [ "user_id" => $user_id, "user_type" => 3 ];
				$not  = [ "user_id" => $user_id, "message" => "Downgrade from PRO to BLOGGER", "type" => 2, "date" => date( 'Y-m-d H:s:i', strtotime('now')) ];

				//Update User Type value
				$user->updateObj( $data );
				
				///Add a  Notification for this user
				$already_notified = $notification_obj->getByType(2, $user_id);var_dump($already_notified);
				if( count($already_notified) > 0 ){
					$not['notification_id'] = $already_notified[0]->notification_id;

					$notification_obj->updateObj( $not );
				}else{
					$notification_obj->saveObj( $not );
				}

				

			}

			if($prev_pageviews < $max_pv || $current_pageviews < $max_pv ){
				//WARNING
				
				$not  = [ "user_id" => $user_id, "message" => "Warnings", "type" => 2 , "date" => date( 'Y-m-d H:s:i', strtotime('now'))];

				$notification_obj->saveObj( $not );

			}

		}

	}
	

?>
