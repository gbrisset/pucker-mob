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

		<h1 class="main-color center margin-bottom">Love to write? Make money while building an audience on PuckerMob</h1>
		<div id="registration-wrapper" class="columns small-12">
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
		    	
		    	<!-- LOGIN -->
		    	<div class="columns small-12 large-5 hsContent margin-top" id="log-in-box">
					<form id="login-form" name="login-form" action="http://www.puckermob.com/login/" method="POST">
			    		<div>
				    		<h2 class="uppercase margin-bottom">LOGIN</h2>
				    	</div>

						<!-- EMAIL -->
						<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="E-Mail" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						
						<!-- PASSWORD -->
						<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="Password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />


			   			<!-- REGISTER BUTTON & ERROR MESSAGE -->
			   			<div class="margin-top">
							<?php if(isset($loginStatus)){ ?>
								<p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p>
							<?php } ?>
							<button type="submit" id="submit" name="submit" class="button left small-12">Login</button>
						</div>

					</form>
					<!-- OR -->
					<div class="margin-bottom margin-top columns no-padding ">
						<span class="small-5 columns line"></span>
						<span class="small-2 columns or">or</span>
						<span class="small-5 columns line"></span>
					</div>

					<!-- FACEBOOK -->
		   			<div class="fb-login-button clear">
		   				<button id="fb-login" class="small-12 columns no-padding">Log-In with facebook <i class="fa fa-facebook-square" aria-hidden="true"></i></button>
					</div>

					<p class="small-registration-text">**We'll never post anything to Facebook without your permission.</p>

					<label class="hide-for-large-up login-label-link margin-top margin-bottom  ">Not Register? <a id="register-link">Sign-In</a></label>
		    	</div>
		    	
		    	<div class="columns small-12 large-1 hsContent margin-top line-box" style="border-right: 1px solid #ddd;"></div>
		    	<div class="columns small-12 large-1 hsContent margin-top line-box"></div>

		    	<!-- RESGISTRATION -->
		    	<div class="columns small-12 large-5 hsContent margin-top " id="registration-box">
			    	<div>
			    		<h2 class="uppercase">REGISTER</h2>
			    		<p class="small-registration-text">**By registering, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy">Terms of Service.</a></p>
			    	</div>
		    		<div>
						<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
				    		<!-- EMAIL -->
							<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="E-Mail" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
							
							<!-- PASSWORD -->
							<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="Password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
				   			
				   			<!-- NAME & LASTNAME -->
							<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="Your Name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
							
							<!-- RECAPTCHA -->
							<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHAPUBLICKEY; ?>"></div>
					        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
				   			
				   			<!-- REGISTER BUTTON & ERROR MESSAGE -->
				   			<div class="margin-top">
								<?php if(isset($registrationStatus)){ ?>
									<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $registrationStatus['message']; ?></p>
								<?php } ?>
								<button type="submit" id="submit" name="submit" class="button left small-12">Register</button>
							</div>
					   	</form>

					   	<!-- OR -->
						<div class="margin-bottom margin-top columns no-padding ">
							<span class="small-5 columns line"></span>
							<span class="small-2 columns or">or</span>
							<span class="small-5 columns line"></span>
						</div>
			   			
						<!-- FACEBOOK -->
			   			<div class="fb-login-button clear">
			   				<button id="fb-login" class="small-12 columns no-padding">Register with facebook <i class="fa fa-facebook-square" aria-hidden="true"></i></button>
						</div>

						<p class="small-registration-text">**We'll never post anything to Facebook without your permission.</p>
					</div>

					<label class="hide-for-large-up login-label-link margin-top margin-bottom ">Already Registered? <a id="login-link">Log-In here</a></label>
		    	</div>

		    	
		    	
		   	<?php }?>
		</div>
		
	</main>
	
	<?php 
		include_once($config['include_path'].'bottomscripts.php'); 
	?>


</body>
</html>
