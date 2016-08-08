<?php
	$admin = true;
	require_once('../assets/php/config.php');
	
	//Admin Class To handle login
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	//Verify Registration
	if(isset($_POST['submit'])) {
		$registrationStatus = $adminController->user->doRegistration($_POST);
	}

	//FACEBOOK SETTINGS
	require_once('../admin/fb/fbfunctions.php');
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- Head -->
<?php include_once($config['include_path'].'head.php');?>

<!-- BODY -->
<body id="registration">
	
	<!-- HEADER [ Navigation ]-->
	<?php include_once($config['include_path'].'header.php'); ?>

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel" role="main">
		<div id="header-ad"></div>
		<div class="columns small-12">
		       	
		       	<h1 class="main-color font-3x center margin-bottom">Love to write? Make money while building an audience on PuckerMob</h1>
			   <!-- REGISTRATION STATUS -->
			    <?php if(isset($registrationStatus) && $registrationStatus['hasError'] == false){ ?>
					<h2>Almost Done!</h2>
					<div class="hsContent dark-bg">
						<div id="register-form-cont-new" class="admin-form-cont success-msg">
							<div class="row">
								<p class="">
									<?php 
										$url = $config['this_admin_url'].'dashboard/';
										//echo $url;
										echo $registrationStatus['message']; 
									?>
								</p>
								<script>setTimeout(function(){window.location = "<?php echo $url; ?>"}, 1000);</script>

							</div>
						</div>
					</div>
				<?php }else{ ?>
			    	
			    	<div class="columns small-6 hsContent margin-top">
				    	<div>
				    		<h2 class="uppercase">REGISTER</h2>
				    		<p class="small-registration-text">By registering, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy">Terms of Service.</a></p>
				    	</div>
			    		<div>
							<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
					    		<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == true){ ?>
								<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>">
									<?php echo $registrationStatus['message']; ?>
								</p>
								<?php } ?>
								<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="email" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
								<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
					   			<!--<input type="text" id="user_name-s" name="user_name-s" value="<?php if(isset($_POST['user_name-s'])) echo $_POST['user_name-s']; ?>" placeholder="username" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_name') echo 'autofocus'; ?> />-->
								<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="your name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
								
								<div class="g-recaptcha" style="margin-left:-7px; " data-sitekey="<?php echo RECAPTCHAPUBLICKEY; ?>"></div>
						        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
					   			
					   			<p class="registration-akn">By registering, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy" style=" text-transform: capitalize; text-decoration:underline;">Terms of Service.</a></p>
						   		<div class="">
								    <div class="">
										<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
										<button type="submit" id="submit" name="submit" class="button left small-12">Register</button>
									</div>
									<div class="">
										<span class="or">or</span>
									</div>
									<div>
										<div class="fb-login-button">
											<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="" />
										</div>
										<div class="margin-top facebook-txt">
											<p style="margin-bottom:0;">We'll never post anything to Facebook
											without your permission.</p>
										</div>
									</div>
								</div>
							</form>
						</div>
			    	</div>

			    	<div class="columns small-6 hsContent">
						<form id="login-form" name="login-form" action="http://www.puckermob.com/login/" method="POST">
				    		<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == true){ ?>
							<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>">
								<?php echo $registrationStatus['message']; ?>
							</p>
							<?php } ?>
							
							<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="email" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
							<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />

						
				   			<p class="registration-akn">By registering, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy" style=" text-transform: capitalize; text-decoration:underline;">Terms of Service.</a></p>
					   		<div class="">
							    <div class="">
									<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
									<button type="submit" id="submit" name="submit" class="button left small-12">Register</button>
								</div>
								<div class="">
									<span class="or">or</span>
								</div>
								<div>
									<div class="fb-login-button">
										<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="" />
									</div>
									<div class="margin-top facebook-txt">
										<p style="margin-bottom:0;">We'll never post anything to Facebook
										without your permission.</p>
									</div>
								</div>
							</div>
						</form>
			    	</div>
			    	
			    	<?php }?>
		        	

		        
		</div>
		
	</main>
	
	<?php 
		include_once($config['include_path'].'bottomscripts.php'); 
	?>


</body>
</html>
