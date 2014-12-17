<?php
	
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$billingInfo = $adminController->getBillingInformation($userData['user_id']);
	
	if(isset($_POST['submit'])){
		
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			
		$pp_email = "";
		if(isset($_POST['paypal-email'])) $pp_email= $_POST['paypal-email'];

			$result = $adminController->editBillingInformation($_POST);
			$billingInfo = $adminController->getBillingInformation($userData['user_id']);
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
<body>
<?php include_once($config['include_path_admin'].'header.php');?>
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Billing INFORMATION</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up">
			<h1 class="left">Billing INFORMATION</h1>	
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<section id="articles" class="padding-top">

				<?php if(!$billingInfo['w2_live'] ){?>
				<div class="skip-step">
						<!--<p class="small-12"><a href="" class="a-buttons">SKIP THIS STEP</a>-->
						<p class="small-12">NOTE: You must complete billing information in order to be paid</p>
				</div>
				<?php }?>
				<section class="billing-cont">
					<h2>W2 Tax Forms</h2>
					<div class="small-12 billing-form-box">

						<img class="small-2 left" src="http://www.puckermob.com/assets/img/Download-Form.png" alt="Upload W2 Form" />
						<div class="small-10 left image-wrapper">
							<div>
								<a href="http://www.puckermob.com/assets/download/fw2.pdf" class="b-upload" download>Download Form</a>
								<div class="small-12 instructions">
									<label>Instructions</label>
									<ul>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
									</ul>
								</div>
							</div>
							<div>
								<span class="and">and</span>
							</div>
							<div>
								<a href="mailto:fguzman@sequelmediagroup.com?subject=W2 form (<?php echo $contributor_name; ?>)&body=Please add your completed form Here." class="b-upload" id="upload_form_file">Send Completed Form</a>
								<input type="file" class="hidden" id="upload_form" name="upload_form" />
									<div class="small-12 instructions">
									<label>Instructions</label>
									<ul>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="paypal-info">
					<h2>Paypal Information</h2>
					<div>
						<form    method="POST" class="small-7" id="paypal-form" name="paypal-form">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="user_id" name="user_id" value="<?php  echo $userData['user_id']; ?>" >

							<label>Paypal Email Address</label>
							<input type="email" required id="paypal-email" name="paypal-email" placeholder="example@email.com" value="<?php echo $billingInfo['paypal_email']; ?>">
							<div class="row buttons-container">
							<div class="columns mobile-12 small-12 large-10">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'paypal-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
								
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'paypal-form') echo $updateStatus['message']; ?>
								</p>
							</div>
							<div class="columns mobile-12 small-12 large-2">
								<button type="submit" id="submit" name="submit">Update</button>
							</div>
						</div>

						</form>
					</div>
				</section>
			</section>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>