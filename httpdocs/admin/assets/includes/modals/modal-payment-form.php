<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$billingInfo = $adminController->getBillingInformation($userData['user_id']);
	
	$w9_live = 0;
	if( isset($billingInfo['w9_live']) && $billingInfo['w9_live']) $w9_live = $billingInfo['w9_live'];
	
	//Verify if is a content provider user
	$contributor_name = $adminController->user->data["contributor_name"];
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;	
	}
?>
<div id="billing-page">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	<div id="content" class="columns small-12 no-padding">
			<div class="small-12 columns radius header-style">
				<h2>W9 Tax Forms</h2>
			</div>

			<div class="billing-cont">
				<div class="small-12 columns billing-form-box half-margin-top">
					<!--<img class="small-1 left show-for-large-up" id="billing-img" src="http://www.puckermob.com/assets/img/Download-Form.png" alt="Upload W9 Form" />-->
					<div class="small-12 columns image-wrapper">
						<div class="small-6 columns border-right">
							<a href="http://www.puckermob.com/assets/download/fw9.pdf" class="b-upload" download><i class="fa fa-cloud-download" aria-hidden="true"></i>Download</a>
							<div class="small-12 instructions">
								<!--<label>Instructions</label>-->
								<ul>
									<li>Download form</li>
									<li>Fill out all appropriate lines</li>
									<li>Print and sign</li>
								</ul>
							</div>
						</div>
						<div class="small-1 columns">
							<!--<span class="uppercase">and</span>-->
						</div>
						<div class="small-5 columns">
							<a href="mailto:taxes@sequelmediainternational.com?subject=W9 form (<?php echo $contributor_name; ?>)&body=Please add your completed form Here." class="b-upload" id="upload_form_file"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Send</a>
							<div class="small-12 instructions">
							<!--<label>Instructions</label>-->
							<ul>
								<li>Make sure form is signed</li>
								<li>Scan</li>
								<li>Send to <a href="mailto:taxes@sequelmediainternational.com?subject=W9 form (<?php echo $contributor_name; ?>)&body=Please add your completed form Here." id="upload_form_file">taxes</a></li>
							</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="columns small-12 hide-for-large-up margin-top">
					<label class="small-7 columns"><a href="http://www.puckermob.com/assets/download/fw9.pdf" class="b-upload" download><i class="fa fa-cloud-download" aria-hidden="true"></i>Download</a></label>
					<label class="small-5 columns"><a href="mailto:taxes@sequelmediainternational.com?subject=W9 form (<?php echo $contributor_name; ?>)&body=Please add your completed form Here." class="b-upload" id="upload_form_file"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Send</a></label>
				</div>
			</div>
			
				<div class="paypal-info small-12 columns no-padding half-margin-top">
					<form  method="POST" class="ajax-submit-form  small-12 columns no-padding half-margin-top clear " id="paypal-form" name="paypal-form">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="user_id" name="user_id" value="<?php  echo $userData['user_id']; ?>" >
						
						<label class="small-12 columns no-padding">
							<input type="checkbox" name="w9_live" id="w9-live"  <?php if($w9_live && $w9_live == 1) echo 'checked'; ?> /> Yes, I have completed and uploaded my W9 form.
						</label>
						
						<div class="small-12 columns radius header-style">
							<h2>Paypal Information</h2>
						</div>
						
						<label class="small-12 large-3 columns uppercase half-margin-top no-padding" style="color: #ddd; padding-top:13px; ">Paypal Email Address:</label>
						<div class="columns small-12 large-9  no-padding">
							<div class="small-12 half-margin-top">
								<input type="email" required id="paypal-email" name="paypal-email" placeholder="example@email.com" value="<?php echo $billingInfo['paypal_email']; ?>">
							</div>
						</div>

						<div class="columns mobile-12 small-12 large-12 half-margin-top half-margin-bottom">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'paypal-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
							
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'paypal-form') echo $updateStatus['message']; ?>
							</p>
						</div>
						<div class="columns mobile-12 small-12 large-4 align-right no-padding">
							<button type="submit" id="submit" class ="columns small-12 radius wide-button elm" name="submit">Save</button>
						</div>
				

					</form>
				</div>
		

		</div>

</div>
