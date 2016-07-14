<?php 
	$notification_obj = new Notification(); 
	$notifications = $notification_obj->all( $userData["user_id"] );

?>

<div class="small-12 xxlarge-5 columns alerts no-margin-bottom margin-top radius no-padding">
	<div class="small-12">
		<h3 class="small-12 columns margin-top">Alerts</h3>
	</div>
	<div class="small-12 columns alerts-div">
	 	<ul class="no-margin">

	 		<!-- GENERAL NOTIFICATIONS -->
	 		<?php if($notifications){
	 			foreach($notifications as $not){
	 				$date = new DateTime($not->date);
	 				echo '<li>'. $date->format('M d, Y').': '.$not->message.'</li>';
	 			}
	 		}else{
	 			echo '<li>No Alerts</li>';
	 		} ?>
	 	
	 	</ul>
	</div>
</div>