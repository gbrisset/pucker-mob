<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	//if($adminController->user->getLoginStatus()) $adminController->redirectTo('');

	if(!isset($_GET['c'])){
		$adminController->redirectTo('login/');
	}

	//	If POST...
	if(isset($_POST['submit'])){
			if (isset($_POST['user_password1-s'])){
				$attemptReset = $adminController->user->resetPassword($_POST);
				if(isset($attemptReset['hasError']) && $attemptReset['hasError'] == true) {
					//	Failure
					//	$adminController->user->invalidateAllTokens();
				} else {
					//	Success
					//	Perform the redirect....  
					?>
					<script>setTimeout(function(){window.location = "<?php echo $config['this_admin_url']; ?>"}, 4000);</script>
				<?php }
			}
	}
	//	If the GET is set, but POST isn't, run verify method...
	if(isset($_GET['c']) && !isset($_POST['submit']) ){
			$resetVerified = $adminController->user->verifyPasswordReset($_GET['c']);
	} 

	//	If get isset, but the hash is wrong...
	if(isset($_GET['c']) && isset($resetVerified) && $resetVerified['hasError'] == true){
		//$adminController->redirectTo('login/');
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<div class="admin-box" id="login-cont">
		<header>
			<img src="<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_logo']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name']; ?> Logo">
		</header>
		<div class="admin-form-cont" id="reset-cont">
			<?php if( isset($resetVerified['hasError']) && !$resetVerified['hasError'] || ( isset($attemptReset) && $attemptReset['hasError'] == true) ){ 
				//	If the attempt is verified, but the user has not yet reset the password, show the form....
			?>
			<h1>Password Reset</h1>
			<p class="<?php echo (isset($attemptReset['hasError']) && $attemptReset['hasError'] == true) ? "error" : "success"; ?>"><?php if (isset($attemptReset)) echo $attemptReset['message']; ?></p>
			<form id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>reset_password/<?php echo $_GET['c']; ?>" method="POST">	
				<input type="text" class="hidden" id="code" name="code" value="<?php echo $_GET['c']; ?>" >
				<input type="text" class="hidden" id="user_email-e" name="user_email-e" value="<?php echo (isset($attemptReset['email'])) ? $attemptReset['email'] : $resetVerified['email'] ?>" >
				<fieldset>
					<label for="user_password-s">New Password :</label>
					<input type="password" name="user_password1-s" id="user_password1-s" placeholder="Enter your new password here." value="" <?php if(isset($resetVerified) && isset($resetVerified['field']) && $resetVerified['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
				</fieldset>

				<fieldset>
					<label for="user_password-s">Retype New Password :</label>
					<input type="password" name="user_password2-s" id="user_password2-s" placeholder="Retype your new password" value="" <?php if(isset($resetVerified) && isset($resetVerified['field']) && $resetVerified['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
				</fieldset>
				<fieldset>
					<div class="btn-wrapper">
						<p class="<?php if(isset($resetVerified)) echo ($resetVerified['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
							<?php if(isset($resetVerified) ) echo $resetVerified['message']; ?>
						</p>

						<button type="submit" id="submit" name="submit">Update Account Information</button>
					</div>
				</fieldset>
				<input type="text" class="hidden" id="pwd_change" name="pwd_change" value="true" >
			</form>
			<?php } elseif( isset($attemptReset['hasError']) && $attemptReset['hasError'] == false ) { ?>
				<p class="<?php echo ($attemptReset['hasError'] == true) ? "error" : "success"; ?>"><?php echo $attemptReset['message']; ?></p>
			<?php } else { ?>
				<p class="<?php echo ($resetVerified['hasError'] == true) ? "error" : "success"; ?>"><?php echo $resetVerified['message']; ?></p>
			<?php } ?>

		</div>
	</div>
			
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>