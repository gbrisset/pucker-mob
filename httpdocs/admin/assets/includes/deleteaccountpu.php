
<div id="deleteAccount" class="modalDialogDeleteAccount" >
	<div id="popup-content" style="min-width: 15rem;">
			<div class="modal-img" style="background: none; padding: 0;">
				<div class="small-12 columns" style=" padding:0 !important;">
					<form class="ajax-submit-form" name="user-account-delete-form" id="user-account-delete-form" method="POST" action="<?php echo $config['this_admin_url']; ?>">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
					<input type="hidden" id="c_i" name="c_i" value ="<?php echo $adminController->user->data['contributor_id']; ?>" />
					<h3 class="small-12 columns" style="font-size: 1.2rem; text-transform: uppercase; margin-top: 10px;">Are you sure you want to delete your account?</h3>
					<p class="small-12 columns">Please note that any articles you have written to date will be removed from the site, and you will no longer be eligible to earn revenue from these articles.</p>
					<div class="buttons-wrapper columns small-12">
						<button type="button" class="no-delete">No, I don't want to delete my account</button>
						<button type="submit" class="" id="submit" name="submit">Yes, please delete my account</button>
					</div>
				</form>
			</div>
			</div>
		</div>
</div>

<script>

if($('#deleteAccount')){

	$('.no-delete').click(function(e){
		$('body').removeClass('show-modal-delete-box');
	});

	$('#deleteAccount').click(function(e){
		$('body').removeClass('show-modal-delete-box');
	});

	$('#delete-account').click(function(e){
		$('body').addClass('show-modal-delete-box');
	});


}
</script>