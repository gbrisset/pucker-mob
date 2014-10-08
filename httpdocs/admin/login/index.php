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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<fieldset class="admin-box mobile-12 small-6 auto-margin"> 
			<legend>
				<h1>Pucker Mob Login</h1>
			</legend>
   
		  	<section id="login-cont">

				<div class="admin-form-cont" id="login-form-cont">
					<form id="login-form" class="login-form" name="login-form" action="<?php echo $config['this_admin_url']; ?>login/" method="POST">
						<div class="row">
						    <div class="large-12 columns">
						      <label>Email or User Name
						        <input type="text" id="user_login_input" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>" placeholder="Username or email address" required autofocus/>
						      </label>
						    </div>
						</div>
						<div class="row">
						    <div class="large-12 columns">
						      <label>Password
								<input type="password" id="user_login_password_input" name="user_login_password_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_password_input']; ?>" placeholder="Password" required autofocus/>
						      </label>
						    </div>
						</div>
						

						<div class="row">
						    <div class="large-12 columns">
								<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
								
								<button type="submit" id="submit" name="submit" class="button expand">Sign In</button>
							</div>
						</div>
						<div class="row">
						    <div class="large-12 columns">
								<p id="bottom-link">
									<a href="<?php echo $config['this_admin_url']; ?>register/" class="left">Create an Account</a>
									<a href="<?php echo $config['this_admin_url']; ?>forgot/" class="right">Forgot Password?</a>
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