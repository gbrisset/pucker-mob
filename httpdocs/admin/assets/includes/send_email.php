<?php
	//GET ALL USERS
	$users = $userObj->all();
?>
<div class="small-12 columns send-email no-margin-bottom margin-top radius no-padding">
	<div class="row">
		<h3 class="small-12 columns margin-top uppercase">E-MAIL</h3>
	</div>
	<div class="row send-email-div">
	 	<form class="clear" name="form-send-email" id="form-send-email" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 		<div class="small-12 large-12 columns">
	 			<div class="small-6 columns no-padding-left">
		 			<select name="blogger_email" id="blogger_email">
		 				<option  value="0">ALL</option>
			 			<?php if($users){
			 				foreach ($users as $user) {
			 					echo '<option value="'.$user->user_email.'">'.$user->user_name.'</option>';
			 				}
			 			} ?>
		 			</select>
	 			</div>
	 			<div class="small-6 columns no-padding">
					<input placeholder="Search..." type="text" id="bloggers_list_search" name="bloggers_list_search" class="small-10 columns"/>
					
				</div>
			</div>
	 		<div class="small-12 large-12 columns">
	 			<textarea placeholder="Type message here ..."  name="email_message" id="email_message"  class="radius" ></textarea>
	 		</div>
	 		<div class="columns small-12 large-10">
	 			<label class="success" id="show-msg-email"></label>
	 		</div>
	 		<div class="small-12 large-2 columns">
	 			<button type="button" id="send-email" name="send-email" class="radius columns small-12" >SEND</button>
	 		</div>
	 		
	 	</form>
	 
	</div>
</div>
