<?php 
	$notification_obj = new Notification(); 
	$userObj = new User();

	var_dump($userObj->all());
?>

<div class="small-12 xxlarge-5 columns manage-alerts no-margin-bottom margin-top radius no-padding">
	<div class="small-12">
		<h3 class="small-12 columns margin-top uppercase">Set Alerts</h3>
	</div>
	<div class="small-12 columns alerts-div">
	 	<form name="form-alert" id="form-alert" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 		<input type="text" name="alert-input" id="alert-input" />
	 		<button type="button" id="save-alert" name="save-alert" >ALERT</button>
	 	</form>
	 	<label class="sucess" id="show-msg-alerts"></label>
	</div>
</div>