<?php




	// header('Location: http://www.puckermob.com/login');
	// die;

	$admin = true;
	require_once('../../assets/php/config.php');
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	if(isset($_POST['submit'])) {
		$loginStatus = $adminController->user->handleLogin($_POST);

		if($loginStatus['hasError'] == true) {
			//	Failure
			$adminController->user->invalidateAllTokens();
		} else {

			//	Success
			$_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
			$redirectString = $adminController->user->redirectAfterLogin();
			
			echo $redirectString;

			file_put_contents($file, $redirectString.PHP_EOL);
		}
	} 

	require_once('../fb/fbfunctions.php');

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="login">
	<?php //include_once($config['include_path_admin'].'header.php');?>
	<main>
       	 <?php //if( $detect->isMobile() ){?>

       <!--	<section id="slide-1" class="homeSlide">
	        <div class="bcg">
		       	<div class="hsContainer">
		        	<h1>PUCKERMOB</h1>
				    <hr>
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    	<h2>Earn money by writing</h2>
			    	
			    	<div class="hsContent dark-bg">
						<p>Welcome to The Mob by PuckerMob! We're happy that you're interested in joining the mob, and making money by writing a blog on our site. </p>

						<p>We're still working on the mobile version, which will be launched shortly. In the meantime, please register and get started writing on a desktop computer or laptop. Thanks!</p>
			    	</div>
			   
		        	<div class="next-step" style="margin-top:0.5rem; margin-bottom: 3rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	<div class="full-width dark-bg next-step active">
		        		<h2><a href="#slide-2">What is The Mob?</a></h2>
		        	</div>
		        </div>
		    </div>
		</section>-->
       	 <?php //}else{?>
       	<section id="slide-1" class="homeSlide">
	        <div class="bcg">
		       	<div class="hsContainer">
		        	<h1>PUCKERMOB</h1>
				    <hr>
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    
			    	<h2>Earn money by writing</h2>
			    	
			    	<div class="hsContent dark-bg">
						<form id="login-form" name="login-form" action="<?php echo $config['this_admin_url']; ?>login/" method="POST">
				    		
				    		<?php if(isset($loginStatus) && $loginStatus['hasError'] == true){ ?>
							<p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>">
								<?php echo $loginStatus['message']; ?>
							</p>
							<?php } ?>
							<input type="email" id="user_login_input" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>" placeholder="email" required  autofocus />
							<input type="password" id="user_login_password_input" name="user_login_password_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_password_input']; ?>" placeholder="password" required <?php if(isset($loginStatus) && isset($loginStatus['field']) && $loginStatus['field'] == 'password') echo 'autofocus'; ?> />

				   			<p class="registration-akn">By logging in, you acknowledge that you have read and agree with our <a href="http://www.puckermob.com/policy" style=" text-transform: capitalize; text-decoration:underline;">Terms of Service.</a></p>
					   		
					   		<div class="">
							    <div class="">
									<!--<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>-->
									<button type="submit" id="submit" name="submit" class="button left small-12">Log In</button>
								</div>
								<div class="">
									<span class="or">or</span>
								</div>

								<div>
									<div class="fb-login-button">
										<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="fb loggin button" />
									</div>
									<div class="margin-top facebook-txt">
										<p style="margin-bottom:0;">We'll never post anything to Facebook
										without your permission.</p>
									</div>
								</div>
								<div class="hsContentLink">
									<a href="<?php echo $config['this_admin_url']; ?>forgot/" class="align-center">Forgot Password?</a>
								</div>
								<input type="checkbox" class="remember"> <span class="remember">Remember Me</span> <br>
							</div>
						</form>
			    	</div>
			    	<div class=" hsContentLink dark-bg ">
		        		<p>NOT REGISTERED YET?</p>
		        		<a href="<?php echo $config['this_admin_url']; ?>register">CLICK HERE TO REGISTER</a>
		        	</div>
			    	<div class="next-step" style="margin-top:0.5rem; margin-bottom: 2.5rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	
		        </div>
		</section>
		    <?php //} ?>
	</main>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
	
</body>
</html>
