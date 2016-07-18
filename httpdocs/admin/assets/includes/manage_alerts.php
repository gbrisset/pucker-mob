<?php 
	//NOTIFICATION OBJECT
	$notification_obj = new Notification(); 
	
	//GET ALL USERS
	$users = $userObj->all();

?>

<div class="small-12 columns manage-alerts no-margin-bottom margin-top radius no-padding">
	<div class="row">
		<h3 class="small-12 columns margin-top uppercase">Set Alert:</h3>
	</div>
	<div class="row alerts-div">
	 	<form class="clear" name="form-alert" id="form-alert" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 		<div class="small-12 large-7 columns">
	 			<input placeholder="Set Alert Here ...." type="text" name="alert-input" id="alert-input" required class="radius" />
	 		</div>
	 		<div class="small-12 large-3 columns">
		 		<select name="user-to-alert" id="user-to-alert">
		 			<option value="0">ALL</option>
		 			<?php if($users){
		 				foreach ($users as $user) {
		 					echo '<option value="'.$user->user_id.'">'.$user->user_name.'</option>';
		 				}
		 			} ?>
		 		</select>
	 		</div>
	 		<div class="small-12 large-2 columns">
	 			<button type="button" id="save-alert" name="save-alert" class="radius" >ALERT</button>
	 		</div>
	 		<div class="columns small-12">
	 			<label class="success" id="show-msg-alerts"></label>
	 		</div>
	 	</form>
	 
	</div>
</div>