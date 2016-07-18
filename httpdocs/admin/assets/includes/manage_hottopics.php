<?php 
	
	//GET ALL USERS
	//$users = $userObj->all();

?>

<div class="small-12 columns manage-alerts no-margin-bottom margin-top radius no-padding">
	<div class="row">
		<h3 class="small-12 columns margin-top uppercase">Hot Topics:</h3>
	</div>
	<div class="row hotopics-div">
	 	<form class="clear" name="form-hotopics" id="form-hotopics" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 		<div class="small-12 large-7 columns">
	 			<input placeholder="" type="text" name="hottopics-input" id="alert-input"  class="radius" />
	 		</div>
	 		
	 		<div class="small-12 large-2 columns">
	 			<button type="button" id="save-hotopics" name="save-hotopics" class="radius" >SAVE</button>
	 		</div>
	 		<div class="columns small-12">
	 			<label class="success" id="show-msg-hotopics"></label>
	 		</div>
	 	</form>
	 
	</div>
</div>