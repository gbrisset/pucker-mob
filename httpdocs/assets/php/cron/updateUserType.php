<?php

	require '../class.User.php';

	$user = new User('fguzman@sequelmediagroup.com');

	$user_id = $user->getUserId();
	$user_name = $user->getUserName();
	$user_type = $user->getUserType();
	$current_pageviews = $prev_pageviews = 0;
	$contributor = $user->getContributorInfo();
	$contributor_earnings = null;
	$min_pv = 25000;
	$max_pv = 50000;
	
	$post = [
		'user_id' => '960',
		'user_type' => 3
	];

	if($contributor){
		$contributor_earnings = $contributor->getContributorEarnings( $user->getContributorInfo(), 2 );

		$current_month = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;
		$prev_month = isset($contributor_earnings[1]) ? $contributor_earnings[1] : false;

		$current_pageviews = $current_month->total_us_pageviews;
		$prev_pageviews = $prev_month->total_us_pageviews;


		print_r($current_pageviews);
		print_r("/n");
		print_r($prev_pageviews);
$prev_pageviews = 4000; $current_pageviews = 4000;
		// Verify if Prev & Current are above the minimum pageviews per month.
		//Upgrade to PRO BLOGGER [8]
		if( $prev_pageviews >= $min_pv && $current_pageviews >=  $min_pv ){
			//UPGRADE
			echo "UP";
		}

		// Verify if Prev & Current are below the minimum pageviews per month
		//Downgrade from PRO to BLOGGER [3]
		if( $prev_pageviews < $min_pv && $current_pageviews < $min_pv ){
			//DOWNGRADE
			echo "DOWN";
		}

		if($prev_pageviews < $min_pv || $current_pageviews < $min_pv ){
			//NOTIFY
			echo "NOTIFY";
		}

	}
	

?>
