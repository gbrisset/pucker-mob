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
<body class="background-blue">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right background-blue" role="main">
			<section id="register-cont" class="admin-logout-content admin-box mobile-12 small-12 large-9 auto-margin">
				<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == false){ ?>
					<h1>Almost Done!</h1>
					<div id="register-form-cont" class="admin-form-cont success-msg">
						<div class="row margin-top">
							<p class="success">
								<?php echo $registrationStatus['message']; ?>
							</p>
						</div>
						<div class="row padding-top" style="text-align:center;">
							<a href="<?php echo $config['this_url']; ?>" class="a-green-link">Home</a>
						</div>
					</div>
				<?php }else{ ?>
				<section class="columns small-6">
					<h1 class="h1-smaller">MOBlog</h1>
					<div class="message-registration">
						<p class="right"><span class="large-registration-text light-blue">Like to Write?</span><span class="medium-registration-text light-blue">Earn money when you write for us!<span></p>
						<img class="reg-arrow" src="http://images.puckermob.com/articlesites/sharedimages/registration_arrow.jpg" alt="arrow">
						<span class="small-registration-text light-blue margin-top">Find out how</span>
						<span class="small-registration-text light-blue">and get started today!</span>
					</div>
				</section>
				
   				<section class="columns small-6">
   				<div id="register-form-cont" class="admin-form-cont">
					<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
					<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == true){ ?>
					<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>">
						<?php echo $registrationStatus['message']; ?>
					</p>
					<?php } ?>
					
					<div class="row">
						<div class="large-12 columns">
						<h3>Register Now &amp; Get Started!</h3>
						</div>
					</div>
				<div class="input-wrapper">	
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_name-s" name="user_name-s" value="<?php if(isset($_POST['user_name-s'])) echo $_POST['user_name-s']; ?>" placeholder="user name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_name') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="email address" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="email" id="user_email_2-e" name="user_email_2-e" value="<?php if(isset($_POST['user_email_2-e'])) echo $_POST['user_email_2-e']; ?>" placeholder="re-enter email address" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="password" id="user_password-s" name="user_password_2-s" value="<?php if(isset($_POST['user_password_2-s'])) echo $_POST['user_password_2-s']; ?>" placeholder="re-enter password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_last_name-s" name="user_last_name-s" value="<?php if(isset($_POST['user_last_name-s'])) echo $_POST['user_last_name-s']; ?>" placeholder="last name" <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_last_name') echo 'autofocus'; ?> />
						</div>
					</div>

					<div class="row">
						<div class="large-12 columns">
							<label class="checkbox-label"><input type="checkbox" id="tos_agreed-s" name="tos_agreed-s" value="1"  <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'tos_agreed') echo 'autofocus'; ?> />
							I have read, understand and agree to the <a href="<?php echo $config['this_url']; ?>policy.php" target="_blank"> MOBlog terms and conditions</a></label>
						</div>
					</div>
				</div>
					<div class="row">
						    <div class="large-12 columns">
								<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
								<button type="submit" id="submit" name="submit" class="button left a-green-link small-12 ">Register</button>

							</div>
						</div>
					
					</form>
					

				</div>
				<p class="login-link">Already registered?<a href="<?php echo $config['this_admin_url']; ?>login/">Click here to log in</a></p>
				</section>
				<?php }?>
			</section>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>