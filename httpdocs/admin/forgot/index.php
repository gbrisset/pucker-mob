<?php
	$admin = true;
	require_once('../../assets/php/config.php');

	if(isset($_POST['submit'])) $emailStatus = $adminController->user->initializePasswordReset($_POST);
		require_once('../fb/fbfunctions.php');
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="forgot">
	<main>
		<section id="slide-1" class="homeSlide">
			<div class="bcg">
		       	<div class="hsContainer">
		        	<h1>PUCKERMOB</h1>
				    <hr>
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    
			    	<h2>Earn money by writing</h2>
			    	
			    	<div class="hsContent dark-bg margin-top">
						<form id="forgot-password-form" name="forgot-password-form" action="<?php echo $config['this_admin_url']; ?>forgot/" method="POST">
				    		<?php if(isset($emailStatus) && $emailStatus['hasError'] == true){ ?>
							<p class="<?php echo ($emailStatus['hasError'] == true) ? 'error' : 'success'; ?>">
								<?php echo $emailStatus['message']; ?>
							</p>
							<?php } ?>
							
							<input type="email" id="user_email-e" name="user_email-e" value="<?php if(isset($_POST['user_email-e'])) echo $_POST['user_email-e']; ?>" placeholder="email" required  <?php if(isset($emailStatus) && isset($emailStatus['field']) && $emailStatus['field'] == 'user_email') echo 'autofocus'; ?> />
					   		<div class="">
							    <div class="">
									<?php if(isset($emailStatus)){ ?><p class="<?php echo ($emailStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $emailStatus['message']; ?></p><?php } ?>
									<button type="submit" id="submit" name="submit" class="button left small-12">Send Email</button>
								</div>
								<div class="">
									<span class="or">or</span>
								</div>
								<div class="hsContentLink">
									<a href="http://www.puckermob.com/admin/login">CLICK HERE TO LOGIN</a>
								</div>
							</div>
						</form>
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
	</main>
		<!--<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<fieldset class="admin-box mobile-12 small-6 auto-margin"> 
			<legend>
				<h1>Forgot your password?</h1>
			</legend>
   	
			<div class="admin-form-cont" id="forgot-password-form-cont">

				<form id="forgot-password-form" name="forgot-password-form" action="<?php echo $config['this_admin_url']; ?>forgot/" method="POST">
					<?php if(isset($emailStatus)){ ?>
						<p class="<?php echo ($emailStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $emailStatus['message']; ?></p>
					<?php } else { ?>
						<p>Enter the email address associated with this account, below.</p>
					<?php } ?>
					<div class="row">
						<div class="large-12 columns">
						    <label>Email 
								<input type="email" id="user_email-e" name="user_email-e" value="<?php if(isset($_POST['user_email-e'])) echo $_POST['user_email-e']; ?>" placeholder="Your Email" required <?php if(isset($emailStatus) && isset($emailStatus['field']) && $emailStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						    </label>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 columns">
							<?php //if(!isset($emailStatus) || $emailStatus['hasError'] == true){ ?>
								<button type="submit" id="submit" name="submit" class="expand button">Send Email</button>
							<?php //} ?>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<p id="bottom-link">
								<a href="<?php echo $config['this_admin_url']; ?>login/">Or log in here!</a>
							</p>
						</div>
					</div>
				</form>
			</div>
		</fieldset>
	</main>-->
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>