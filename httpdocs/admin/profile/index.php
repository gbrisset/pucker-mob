<?php
        $admin = true;
        require_once('../../assets/php/config.php');
        if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
        $adminController->user->data = $adminController->user->getUserInfo();
        if(isset($_POST['submit'])){
                if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
                        $updateStatus = $adminController->updateUserInfo($_POST);
                        $adminController->user->data = $adminController->user->getUserInfo();
                }else $adminController->redirectTo('logout/');
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

	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="account-settings">
			<section id="account-settings">
				<header class="section-bar">
					<h2>My Account</h2>
				</header>

				<form class="ajax-submit-form" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<fieldset>
						<label for="user_name-s">User Name :</label>
						<p class="disabled-field"><?php echo $adminController->user->data['user_name']; ?></p>
					</fieldset>

					<fieldset>
						<div  class="btn-wrapper" style="text-align: left;">
							<label>Password :</label>
							<button type="button" id="field-toggler">Change Password</button>
						</div>
					</fieldset>

					<div id="hidden-field-set" class="hidden">
						<fieldset>
							<label for="user_password_current-s">Current Password :</label>
							<input type="password" name="user_password_current-s" id="user_password_current-s" placeholder="Enter your current password here." value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
						</fieldset>

						<fieldset>
							<label for="user_password-s">New Password :</label>
							<input type="password" name="user_password1-s" id="user_password1-s" placeholder="Enter your new password here." value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
						</fieldset>

						<fieldset>
							<label for="user_password-s">Retype New Password :</label>
							<input type="password" name="user_password2-s" id="user_password2-s" placeholder="Retype your new password" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
						</fieldset>	

					</div>

					<fieldset>
						<label for="user_email-e">Email Address<span>*</span> :</label>
						<input type="email" name="user_email-e" id="user_email-e" placeholder="Please enter your email address here." value="<?php if(isset($adminController->user->data['user_email'])) echo $adminController->user->data['user_email']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />
					</fieldset>

					<fieldset>
						<label for="user_first_name-s">First Name :</label>
						<input type="text" name="user_first_name-s" id="user_first_name-s" placeholder="Please enter your first name here." value="<?php if(isset($adminController->user->data['user_first_name'])) echo $adminController->user->data['user_first_name']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
					</fieldset>

					<fieldset>
						<label for="user_last_name-s">Last Name :</label>
						<input type="text" name="user_last_name-s" id="user_last_name-s" placeholder="Please enter your last name here." value="<?php if(isset($adminController->user->data['user_last_name'])) echo $adminController->user->data['user_last_name']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_last_name') echo 'autofocus'; ?> />
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
					<input type="text" class="hidden" id="pwd_change" name="pwd_change" value="false" >
				</form>
			</section>
			<section id="profile-settings">
				<header class="section-bar">
					<h2>My Profile</h2>
				</header>				
				<form class="ajax-submit-form" id="profile-settings-form" name="profile-settings-form" action="<?php echo $config['this_admin_url']; ?>account/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<fieldset>
						<label for="user_name-s">Visible Name :</label>
						<p class="disabled-field"><?php echo $adminController->user->data['user_name']; ?></p>
					</fieldset>

				
				</form>

			</section>
		</div>
	</div>

<script>



</script>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>