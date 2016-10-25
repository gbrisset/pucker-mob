<?php
	$admin = true;
	$registration = true;
	require_once('../assets/php/config.php');
	
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
			$url = $config['this_admin_url'].'dashboard/';

			header( "Location: $url" ) ; 
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
	
	<!-- HEADER [ Navigation ] -->
	<?php if($detect->isMobile()){
			include_once($config['include_path'].'header.php'); 
		}else{
			include_once($config['include_path'].'new_header.php'); 
		}?>

	<!-- HEADER TITLE CONTENT -->
	<div id="header-div">
		<div class="inner-div">
			<h1 class="center margin-bottom hide-for-large-up">Make Money Blogging!</h1>

			<h1 class="center margin-bottom show-for-large-up">Love to write? Make money while building an audience on Puckermob!</h1>
			<p class="show-for-large-up">Find out how you can  start earning money by blogging with us!</p>
		</div>
	</div>

	 <!-- MOBILE TABS -->
	 	   <dl class="mobile-tabs hide-for-large-up" data-tab role="tablist">
			  <dd class="tab-title active small-6 columns login-dd" role="presentation"><a href="#login" role="tab" tabindex="0" aria-selected="true" aria-controls="login">Login</a></dd>
			  <dd class="tab-title small-6 columns register-dd" role="presentation"><a href="#register" role="tab" tabindex="0" aria-selected="false" aria-controls="register">Register</a></dd>
			</dl>
			<!-- END MOBILE TABS -->
	<!-- MAIN CONTENT -->
	<main id="main" class="  panel padding-top" role="main">

		<div id="registration-wrapper" class="columns small-12 padding-top">
	 	   
	 	   	<div class="tabs-content">
				<section role="tabpanel" aria-hidden="false" class="content active  columns small-6" id="login">
			    	<!-- LOGIN -->
			    	<div class="columns small-12 large-12 hsContent" id="log-in-box">

						<form id="login-form" name="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				    		<div>
					    		<h2 class="uppercase show-for-large-up">LOGIN</h2>
					    		<p class="small-registration-text">By logging, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy">Terms of Service.</a></p>
					    	</div>

					    	<div style="margin-top: 10px;">

							<!-- EMAIL -->
								<input type="email" id="user_login_input" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>" placeholder="email" required  autofocus />
							
							<!-- PASSWORD -->
								<input type="password" id="user_login_password_input" name="user_login_password_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_password_input']; ?>" placeholder="password" required <?php if(isset($loginStatus) && isset($loginStatus['field']) && $loginStatus['field'] == 'password') echo 'autofocus'; ?> />


				   			<!-- LOGIN BUTTON & ERROR MESSAGE -->
				   			<div class="margin-top">
								<?php if(isset($loginStatus) && $loginStatus['hasError'] ){ ?>
									<p class="new-error"><?php echo $loginStatus['message']; ?></p>
								<?php } ?>
								<button type="submit" id="login" name="login" class="button left small-12">Login</button>
							</div>
							</div>


						</form>
						<!-- OR -->
						<div class="or-box columns no-padding ">
							<span class="small-5 columns line"></span>
							<span class="small-2 columns or">or</span>
							<span class="small-5 columns line"></span>
						</div>

						<!-- FACEBOOK -->
			   			<div class="fb-login-button clear">
			   				<button id="fb-login" class="fb-login small-12 columns no-padding">Log-In with facebook <i class="fa fa-facebook-square" aria-hidden="true"></i></button>
						</div>

						<p class="small-registration-text">We'll never post to your Facebook without permission.</p>
						<div class="hsContentLink" style="margin-top: 1rem;">
							<a style="text-transform: uppercase; font-size: 14px;     font-family: OsloBold; color: #ddd;" href="<?php echo $config['this_admin_url']; ?>forgot/" class="align-center">Forgot Password? Click Here</a>
						</div>
			    	</div>
			    	<!-- END LOGIN -->
			    </section>
				
				<section role="tabpanel" aria-hidden="true" class="content columns small-6" id="register">
			    	<!-- RESGISTRATION -->
			    	<div class="columns small-12 large-12 hsContent " id="registration-box">
				    	<div>
				    		<h2 class="uppercase  show-for-large-up">REGISTER</h2>
				    		<p class="small-registration-text">I acknowledge that I agree with the  <a href="http://www.puckermob.com/policy">Terms of Service.</a></p>
				    	</div>
						<div style="margin-top: 10px;">
							<form id="register-form" name="register-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					    		<!-- EMAIL -->
								<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="E-Mail" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
								
								<!-- PASSWORD -->
								<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="Password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
					   			
					   			<!-- NAME & LASTNAME -->
								<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="Your Name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
								
								<!-- RECAPTCHA -->
								<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHAPUBLICKEY; ?>" style="padding: 0 4.5%;"></div>
						        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
					   			
					   			<!-- REGISTER BUTTON & ERROR MESSAGE -->
					   			<div class="margin-top">
									<?php if(isset($registrationStatus)){ ?>
									<div class="columns small-12 new-error margin-bottom" style="border-radius: 5px;">
										<?php echo $registrationStatus['message']; ?>
										</div>
									<?php } ?>
									<button type="submit" id="register" name="register" class="button left small-12">Register</button>
								</div>
						   	</form>
						 
						   	<!-- OR -->
							<div class="columns no-padding or-box">
								<span class="small-5 columns line"></span>
								<span class="small-2 columns or">or</span>
								<span class="small-5 columns line"></span>
							</div>
				   			
							<!-- FACEBOOK -->
				   			<div class="fb-login-button clear">
				   				<button id="fb-login" class=" fb-login small-12 columns no-padding">Register with facebook <i class="fa fa-facebook-square" aria-hidden="true"></i></button>
							</div>

							<p class="small-registration-text">We'll never post to your Facebook without permission.</p>
			
						</div>
					</div>
				    <!-- END REGISTRATION -->
			    </section>
			</div>
		</div>
	</main>
	
	<?php 
		include_once($config['include_path'].'bottomscripts.php'); 
	?>
	<!-- FACEBOOK LOGIN & REGITER API -->
	<script>
		if($('#fb-login')){
			$('.fb-login').each(function(){
				$(this).on('click', function(e){
					console.log('fb click');
				    FB.login(function(response) {
				  	  checkLoginState();
				    }, {scope: 'public_profile,email'});
				});
			});
			
		}
	</script>

<script>
   $(document).ready(function() {
      $(document).foundation();
   })
</script>

</body>
</html>
