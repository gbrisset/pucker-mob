<?php
	
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$billingInfo = $adminController->getBillingInformation($userData['user_id']);

	
	$w9_live = 0;
	if( isset($billingInfo['w9_live']) && $billingInfo['w9_live']) $w9_live = $billingInfo['w9_live'];
	

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$pp_email = "";
			if(isset($_POST['paypal-email'])) $pp_email= $_POST['paypal-email'];
			
			if(isset($_POST['w9_live']) && $_POST['w9_live'] == 'on') $_POST['w9_live'] = 1;
			else $_POST['w9_live'] = 0;

			$result = $adminController->editBillingInformation($_POST);
			$billingInfo = $adminController->getBillingInformation($userData['user_id']);
			$w9_live = $billingInfo['w9_live'];
		}else $adminController->redirectTo('logout/');
	}

	//Verify if is a content provider user
	$contributor_name = $adminController->user->data["contributor_name"];
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;	
	}

?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>

<body id="billing-page">

	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>


		<div id="content" class="columns small-9 large-11">
			<div class="small-12 columns padding-bottom ">
				<h1 class="columns small-12 no-padding" >Billing Information</h1>
			</div>
			
			<div class="small-12 xxlarge-8 columns">	
				<div class="small-12 columns margin-bottom no-padding">

					<?php if(!$billingInfo['w9_live'] ){?>
					<div class="skip-step">
						<p class="small-12">NOTE: You must complete billing information in order to be paid</p>
					</div>
					<?php }?>
					<div class="billing-cont">
						<div class="small-12 columns radius header-style">
							<h2>W9 Tax Forms</h2>
						</div>
						
						<div class="small-12 billing-form-box">

							<img class="small-2 left" id="billing-img" src="http://www.puckermob.com/assets/img/Download-Form.png" alt="Upload W9 Form" />
							<div class="small-10 left image-wrapper">
								<div class="left">
									<a href="http://www.puckermob.com/assets/download/fw9.pdf" class="b-upload" download>Download Form</a>
									<div class="small-12 instructions">
										<label>Instructions</label>
										<ul>
											<li>Download form</li>
											<li>Fill out all appropriate lines</li>
											<li>Print and sign</li>
										</ul>
									</div>
								</div>
								<div>
									<span class="and left">and</span>
								</div>
								<div class="left">
									<a href="mailto:taxes@sequelmediainternational.com?subject=W9 form (<?php echo $contributor_name; ?>)&body=Please add your completed form Here." class="b-upload" id="upload_form_file">Send Completed Form</a>
									<input type="file" class="hidden" id="upload_form" name="upload_form" />
										<div class="small-12 instructions">
										<label>Instructions</label>
										<ul>
											<li>Make sure form is signed</li>
											<li>Scan</li>
											<li>Send to taxes@sequelmediainternational.com</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="paypal-info small-12 columns no-padding">
						<form  action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="small-12 columns no-padding margin-top" id="paypal-form" name="paypal-form">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="user_id" name="user_id" value="<?php  echo $userData['user_id']; ?>" >
							
							<input type="checkbox" name="w9_live" id="w9-live" <?php if($w9_live && $w9_live == 1) echo 'checked="checked"'; ?>><label>Yes, I have completed and uploaded my W9 form.</label>
							
							<div class="small-12 columns radius header-style">
								<h2>Paypal Information</h2>
							</div>
							
							<label class="small-12 columns margin-top no-padding" style="color: #ddd; ">Paypal Email Address</label>
							<div class="columns small-12  no-padding">
								<div class="small-12 margin-top">
									<input type="email" required id="paypal-email" name="paypal-email" placeholder="example@email.com" value="<?php echo $billingInfo['paypal_email']; ?>">
								</div>
							
							</div>


							
							<div class="columns mobile-12 small-12 large-12">
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
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding show-for-large-up" >
				<?php include_once($config['include_path_admin'].'myprofile_sidebar.php'); ?>
			</div>
		</div>
	</main>

	<!-- INFO BADGE 
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php //include($config['include_path_admin'].'info-badge.php');?>
	</div>-->
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>