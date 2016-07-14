<?php 
	$notification_obj = new Notification(); 

	$notification_general = $notification_obj->getGeneralNotifiactions();
	$notification_user = $notification_obj->getNotificationByUser( $userData["user_id"] );
?>

<div class="small-12 xxlarge-5 columns alerts no-margin-bottom margin-top radius no-padding">
	<div class="small-12">
		<h3 class="small-12 columns margin-top">Alerts</h3>
	</div>
	<div class="small-12 columns alerts-div">
	 	<ul class="no-margin">
	 		<!-- INDIVIDUAL NOTIFICATIONS --> 

	 		<?php if($notification_user){
	 			foreach($notification_user as $notifications){
	 			$date = new DateTime($notifications->notification_date);
	 				echo '<li>'. $date->format('M d, Y').': '.$notifications->notification_msg.'</li>';
		 		}
		 	}?>

	 		<!-- GENERAL NOTIFICATIONS -->
	 		<?php if($notification_general){
	 			foreach($notification_general as $general){
	 				$date = new DateTime($general->notification_date);
	 				echo '<li>'. $date->format('M d, Y').': '.$general->notification_msg.'</li>';
	 			}
	 		}else{
	 			echo '<li>No Alerts</li>';
	 		} ?>
	 	
	 	</ul>
	</div>
</div>