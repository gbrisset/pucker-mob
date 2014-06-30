<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	//if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	if(isset($_POST['submit'])) $emailStatus = $adminController->user->initializePasswordReset($_POST);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>

	<div id="main-cont" class="main-cont-min">
		<div class="admin-box" id="register-cont">
			<header>
				<h1><span>Forgot your password?</span></h1>
			</header>

			<div class="admin-form-cont" id="forgot-password-form-cont">

				<form id="forgot-password-form" name="forgot-password-form" action="<?php echo $config['this_admin_url']; ?>forgot/" method="POST">
					<?php if(isset($emailStatus)){ ?>
						<p class="<?php echo ($emailStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $emailStatus['message']; ?></p>
					<?php } else { ?>
						<p>Enter the email address associated with this account, below.</p>
					<?php } ?>
					<fieldset>
						<input type="email" id="user_email-e" name="user_email-e" value="<?php if(isset($_POST['user_email-e'])) echo $_POST['user_email-e']; ?>" placeholder="Your Email" required <?php if(isset($emailStatus) && isset($emailStatus['field']) && $emailStatus['field'] == 'user_email') echo 'autofocus'; ?> />
					</fieldset>
					<fieldset>
						<div class="btn-wrapper">
							<?php if(!isset($emailStatus) || $emailStatus['hasError'] == true){ ?>
								<button type="submit" id="submit" name="submit">Send Email</button>
							<?php } else {?>
								<!-- Erase this after testing -->
							
								<button type="submit" id="submit" name="submit">Send Email</button>
							<?php } ?>
						</div>
					</fieldset>

					<p id="bottom-link"><a href="<?php echo $config['this_admin_url']; ?>login/">Or log in here!</a></p>
				</form>
			</div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>