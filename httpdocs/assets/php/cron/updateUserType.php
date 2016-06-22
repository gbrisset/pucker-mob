<?php

	require '../class.User.php';

	$user = new User('fguzman@sequelmediagroup.com');

	$user_id = $user->getUserId();
	$user_name = $user->getUserName();
	$user_type = $user->getUserType();
	//$user_email= $user->getUserEmail();

	$current_pageviews = $prev_pageviews = 0;
	$contributor = $user->getContributorInfo();
	$contributor_earnings = null;
	$min_pv = 25000;
	$max_pv = 35000;
	$notification_obj = new Notification();
	$notification = $notification_obj->getNotificationByUser($user_id);
var_dump($notification_obj->getNotificationStatus());
	if($contributor){
		$contributor_earnings = $contributor->getContributorEarnings( $user->getContributorInfo(), 2 );

		$current_month = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;
		$prev_month = isset($contributor_earnings[1]) ? $contributor_earnings[1] : false;

		$current_pageviews = $current_month->total_us_pageviews;
		$prev_pageviews = $prev_month->total_us_pageviews;
		$current_pageviews = 5000;
		$prev_pageviews = 5000;
		
		// Verify if Prev & Current are above the minimum pageviews per month.
		//Upgrade to PRO BLOGGER [8]
		if( $prev_pageviews >= $min_pv && $current_pageviews >=  $min_pv ){
			//UPGRADE
			$data = [
				"user_id" => $user_id,
				"user_type" => 8
			];

			//Update User Type value
			$user->setUserType( $data );
			echo "UP & NOTIFY";

			//var_dump($user->getUserType());
		}

		// Verify if Prev & Current are below the minimum pageviews per month
		//Downgrade from PRO to BLOGGER [3]
		if( $prev_pageviews < $min_pv && $current_pageviews < $min_pv ){
			//DOWNGRADE
			echo "DOWN & NOTIFY";
			$data = [
				"user_id" => $user_id,
				"user_type" => 3
			];

			//Update User Type value
			$user->setUserType( $data );
			

		}elseif($prev_pageviews < $min_pv || $current_pageviews < $min_pv ){
			//NOTIFY
			echo "NOTIFY";
		}

	}
	

?>
