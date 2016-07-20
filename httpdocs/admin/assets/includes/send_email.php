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
		 			<select name="blogger_id" id="blogger_id">
		 				<option value="0">ALL</option>
			 			<?php if($users){
			 				foreach ($users as $user) {
			 					echo '<option value="'.$user->user_id.'">'.$user->user_name.'</option>';
			 				}
			 			} ?>
		 			</select>
	 			</div>
	 			<div class="small-5 columns">
					<input type="text" id="bloggers_list_search" name="bloggers_list_search" />
					<i class="fa fa-search"></i>
				</div>
			<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input type="text" class="docs-search tt-hint" data-docs-search="" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(254, 254, 254);"><input type="text" class="docs-search tt-input" data-docs-search="" placeholder="Find a page, component, variable, mixin, function..." autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Proxima Nova&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20.8px; font-style: normal; font-variant: normal; font-weight: 300; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-0"></div></div></span>
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
