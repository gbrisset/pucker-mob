<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	if(isset($_POST['submit'])) {
		//var_dump($_POST);
		$registrationStatus = $adminController->user->doRegistration($_POST);
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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<fieldset class="admin-box mobile-12 small-6 auto-margin"> 
			<legend>
				<h1>Join Pucker Mob</h1>
			</legend>
   
		  	<section id="register-cont">

			<div id="register-form-cont" class="admin-form-cont">
				
				<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
					<?php if(isset($registrationStatus)){ ?><p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $registrationStatus['message']; ?></p><?php } ?>
					
					<div class="row">
						<div class="large-12 columns">
							<label for="user_name-s">User Name
								<input type="text" id="user_name-s" name="user_name-s" value="<?php if(isset($_POST['user_name-s'])) echo $_POST['user_name-s']; ?>" placeholder="jane2014" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_name') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>

					<div class="row">
						<div class="large-12 columns">
							<label for="user_password-s">Password
								<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>
								
					<h2>Your Information</h2>
					<hr />
					<div class="row">
						<div class="large-12 columns">
							<label for="user_email_1-e">Email Address
								<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="jane@example.com" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<label for="user_email_2-e">Re-Enter Email Address
								<input type="email" id="user_email_2-e" name="user_email_2-e" value="<?php if(isset($_POST['user_email_2-e'])) echo $_POST['user_email_2-e']; ?>" placeholder="jane@example.com" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<label for="user_first_name-s">First Name
								<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="Jane" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<label for="user_last_name-s">Last Name (optional)
								<input type="text" id="user_last_name-s" name="user_last_name-s" value="<?php if(isset($_POST['user_last_name-s'])) echo $_POST['user_last_name-s']; ?>" placeholder="Smith" <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_last_name') echo 'autofocus'; ?> />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="checkbox" id="tos_agreed-s" name="tos_agreed-s" value="1"  <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'tos_agreed') echo 'autofocus'; ?> />
							<label class="checkbox-label">I agree to Pucker Mob <a href="<?php echo $config['this_url']; ?>policy.php" target="_blank"> Terms of Service</a></label>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
							<button type="submit" id="submit" name="submit" class="button expand">Sign Up</button>
						</div>
					</div>
					<div class="row">
					    <div class="large-12 columns">
							<p id="bottom-link">
								<a href="<?php echo $config['this_admin_url']; ?>login/">Log in to existing account here!</a>
							</p>
						</div>
					</div>
				</form>
			</div>
			</section>
		</fieldset>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>