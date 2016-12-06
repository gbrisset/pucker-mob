<?php
	/*
	*	This Script is incharge of doing an automatic upgrade for those 
	*	Starter Bloggers that are over 5k Pageviews, making them a Basic Blogger.
	*
	*	This CronJob will run weekly at 3:00 AM. 
	*
	*	Developer: fguzman@sequelmediainternational.com
	*	Date: 10/05/2016
	*
	*	Objects: class.User.php, class.Notification.php, config.php
	*/
	
	$admin = true;
	require '../config.php'; //Configuration File
	
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	
	//User Object
	$userObj = new User();

	//Notification Object
	$notification_obj = new Notification(); 
	
	//Get all Starter Bloggers
	$user_list = $userObj->all("30"); 

	//GET CURRENT MONTH & YEAR 
	$current_month =  date('n');
	$current_year = date('Y');

	//EMAIL Message
	$msg = "<html><body><div><h1>Hello...</h1><p>Listed below are the starter bloggers that hit the 5,000 views mark, so we’ve made them a Basic Level blogger.</p></div>";
	$msg .= "<div><table><thead><tr><td><strong>U_ID</strong></td><td><strong>NAME</strong></td><td><strong>EMAIL</strong></td><td><strong>US VIEWS</strong></td></tr></thead><tbody>";
	//For each User
	foreach($user_list as $user){
		
		//Initialize Contributor Information
		$contributor = $user->getContributorInfo();
		//$contributor = isset($contributor->data) ? $contributor->data : $contributor;
		
		$user_id = $user->user_id;
		$user_name = $user->user_name;
		$user_type = $user->user_type;
		$current_pageviews = $prev_pageviews = 0;
		$contributor_earnings = null;
		$limit = 5000;
		$index = 0;

		if($contributor->data && isset($contributor->data->contributor_id) ) {
			$contributor_name = $contributor->data->contributor_name;
			$contributor_email = $contributor->data->contributor_email_address;
			
			//Get Earnings for each contributor
			$contributor_earnings = $contributor->getContributorEarningsPerMonth( $contributor, $current_month, $current_year );
			$current_month_obj = isset($contributor_earnings[0]) ? $contributor_earnings[0] : false;
			
			if(isset($current_month_obj) && $current_month_obj) $current_pageviews = $current_month_obj->total_us_pageviews;
			// Verify if Prev & Current are above the minimum pageviews per month.


			if( $current_pageviews >= $limit ){
				//EMAIL MESSAGE DATA
				$msg .= "<tr><td>".$user_id." </td><td>".$contributor_name."</td><td>".$contributor_email."</td><td>".$current_pageviews."</td></tr>";

				if( $user_type == 30 ){ //IF is a Starter-Blogger
					
					$data = [ "user_id" => $user_id, "user_type" => 3 ];
					$not  = [ 
						"user_id" => $user_id, 
						"message" => "Congratulations! You’re really starting to build an audience. You’ve hit the 5,000 views mark, so we’ve made you a Basic Level blogger. Aren’t you special?", 
						"type" => 2 , 
						"date" => date( 'Y-m-d H:s:i', strtotime('now'))
					];

					//Update User Type value
					$user->updateObj( $data );
					
					//Add a  Notification for this user
					$already_notified = $notification_obj->getByType(2, $user_id);
					if( count($already_notified) > 0 ){
						$not['notification_id'] = $already_notified[0]->notification_id;
						//UPDATE NOTIFICATION
						$notification_obj->updateObj( $not );
					}else{
						//SAVE NOTIFICATION
						$notification_obj->saveObj( $not );
					}
				}
				
			}
		}
	}

	//SEND EMAIL
	$msg .= "</tbody></table></div>";

	$to="fguzman@sequelmediainternational.com, jmiletsky@sequelmediainternational.com, ahouli@sequelmediainternational.com, mpinedo@sequelmediainternational.com";
	$subject = 'Starter Blogger Upgraded to Basic';


	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: fguzman@sequelmediainternational.com' . "\r\n";

	mail($to, $subject, $msg ,$headers);

	die;
	

?>
