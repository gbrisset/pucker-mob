<?php
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
		}
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

	<div id="main-cont" class="main-cont-min">
	<header>
		<h1>Welcome to <span>Pucker Mob</span> Login!</h1>
	</header>

	<div class="admin-box" id="login-cont">

		<div class="admin-form-cont" id="login-form-cont">
			

			<form id="login-form" class="login-form" name="login-form" action="<?php echo $config['this_admin_url']; ?>login/" method="POST">
				<fieldset>
					<label for="user_name_input">Email or User Name</label>
					<input type="text" id="user_login_input" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>" placeholder="Username or email address" required autofocus/>
				</fieldset>
				<fieldset>
					<label for="user_login_password_input">Password</label>
					<input type="password" id="user_login_password_input" name="user_login_password_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_password_input']; ?>" placeholder="Password" required autofocus/>
				</fieldset>

				<fieldset>
					<div class="btn-wrapper">
						<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>

						<button type="submit" id="submit" name="submit">Sign In</button>
					</div>
				</fieldset>
				<fieldset>
					<p id="bottom-link">
						<a href="<?php echo $config['this_admin_url']; ?>register/">Create an Account</a>
						<a href="<?php echo $config['this_admin_url']; ?>forgot/">Forgot Password?</a>
					</p>
				</fieldset>
			</form>

		</div>
			
	</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>