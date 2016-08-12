<?php
	$admin = true;
	require_once('../assets/php/config.php');
	
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');

	//Admin Class To handle login
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	//Verify Registration
	if(isset($_POST['register'])) {
		$registrationStatus = $adminController->user->doRegistration($_POST);
	}

	//Verify Login
	if(isset($_POST['login'])) {
		$loginStatus = $adminController->user->handleLogin($_POST);

		if($loginStatus['hasError'] == true) {
			//	Failure
			$adminController->user->invalidateAllTokens();
		} else {

			//	Success
			$_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
			$redirectString = $adminController->user->redirectAfterLogin();
			
			//echo $redirectString;

			file_put_contents($file, $redirectString.PHP_EOL);
		}
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

	<div id="header-ad">
		<div style="width: 65%">
			<h1 class="center margin-bottom">Love to write? Make money while building an audience on Puckermob!</h1>
			<p>Find out how you can  start earning money by blogging with us!</p>
		</div>
	</div>


	<!-- MAIN CONTENT -->
	<main id="main" class="  panel padding-top" role="main">

		<div id="registration-wrapper" class="columns small-12 padding-top">
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
		    	<div class="columns small-12 large-6 hsContent margin-top" id="log-in-box">

					<form id="login-form" name="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			    		<div>
				    		<h2 class="uppercase margin-bottom">LOGIN</h2>
				    	</div>

				    	<div style="margin-top: 2rem;">

						<!-- EMAIL -->
							<input type="email" id="user_login_input" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>" placeholder="email" required  autofocus />
						
						<!-- PASSWORD -->
							<input type="password" id="user_login_password_input" name="user_login_password_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_password_input']; ?>" placeholder="password" required <?php if(isset($loginStatus) && isset($loginStatus['field']) && $loginStatus['field'] == 'password') echo 'autofocus'; ?> />


			   			<!-- REGISTER BUTTON & ERROR MESSAGE -->
			   			<div class="margin-top">
							<?php if(isset($loginStatus)){ ?>
								<p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p>
							<?php } ?>
							<button type="submit" id="login" name="login" class="button left small-12">Login</button>
						</div>
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
		    	
		    	<!--<div class="columns small-12 large-1 hsContent margin-top line-box" style="border-right: 1px solid #ddd;"></div>
		    	<div class="columns small-12 large-1 hsContent margin-top line-box"></div>
				-->
		    	<!-- RESGISTRATION -->
		    	<div class="columns small-12 large-6 hsContent margin-top " id="registration-box">
			    	<div>
			    		<h2 class="uppercase">REGISTER</h2>
			    		<p class="small-registration-text">By registering, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy">Terms of Service.</a></p>
			    	</div>
				<div style="margin-top: 2rem;">
						<form id="register-form" name="register-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
								<button type="submit" id="register" name="register" class="button left small-12">Register</button>
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

						<p class="small-registration-text">We'll never post anything to Facebook without your permission.</p>
						
						<p class="uppercase find-more">wait - How do I make money? <a href="#link-to-more">find out more</a></p>

					</div>

					<label class="hide-for-large-up login-label-link margin-top margin-bottom ">Already Registered? <a id="login-link">Log-In here</a></label>
		    	</div>

		    	
		    	
		   	<?php }?>
		</div>
		
	</main>
	
	<?php 
		include_once($config['include_path'].'bottomscripts.php'); 
	?>
	<script>
		if($('#fb-login')){
	$('#fb-login').on('click', function(e){
	    FB.login(function(response) {
	  	  checkLoginState();
	    }, {scope: 'public_profile,email'});
	});
}
	</script>

</body>
</html>
