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
<body id="account-info">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>

		<div id="content" class="columns small-9 large-11">
			<div class="small-12 columns padding-bottom ">
				<h1 class="columns small-12" >MY ACCOUNT</h1>
			</div>
			
			<div class="small-12 xxlarge-8 columns">
				<div class="small-12">
					<form class="ajax-submit-form" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<div class="small-12 columns radius header-style">
						<h2>CHANGE E-MAIL ADDRESS</h2>
					</div>
					<div class="columns small-12  no-padding">
						<div class="columns small-12 margin-top">
							<input type="text" name="user_email" id="user_email" placeholder="CURRENT E-MAIL" value="<?php if(isset($adminController->user->data['user_email'])) echo $adminController->user->data['user_email']; ?>" required  />
						</div>
						<div class="columns small-12 margin-top">
							<input type="email" name="user_email" id="user_email-e" placeholder="NEW E-MAIL" value="" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />
						</div>		
					</div>	

					<div class="small-12 columns radius header-style margin-top">
						<h2>CHANGE PASSWORD</h2>
					</div>

					<div class="columns small-12  no-padding">
						<div class="columns small-12 margin-top">
							<input type="password" name="user_password_current-s" id="user_password_current-s" placeholder="CURRENT PASSWORD" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
				
						</div>
						<div class="columns small-12 margin-top">
							<input type="password" name="user_password1-s" id="user_password1-s" placeholder="NEW PASSWORD" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
						</div>	
						<div class="columns small-12 margin-top">
							<input type="password" name="user_password2-s" id="user_password2-s" placeholder="RETYPE NEW PASSWORD" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
						</div>		
					</div>	

					<div class="small-12 columns radius header-style margin-top">
						<h2>CANCEL ACCOUNT</h2>
					</div>

					<div class="columns small-12 margin-top delete-account-box radius">
						<div class="main-color">
							<div class="small-3 large-2 columns">
								<a href="#" id="delete-account"><i class="fa fa-square-o"></i></a>
							</div>
							<div class="small-9 large-10 columns">
								<h3>YES I WANT TO CANCEL MY ACCOUNT</h3>
								<p>I understand this cannot be undone and i will no longer eanrn revenue from my articles.</p>
							</div>
						</div>
					</div>
					   <?php include_once($config['include_path_admin'].'deleteaccountpu.php'); ?>

				
				<input type="text" class="hidden" id="pwd_change" name="pwd_change" value="false" >

				
					<div class="small-12 columns margin-bottom margin-top no-padding">
						<div class="columns small-12 large-12">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
							
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>
						</div>
						<div class="columns small-12  align-right no-padding">
							<button class="columns small-12  radius wide-button" style="margin-right: -5px;" type="submit" id="submit" name="submit">SAVE</button>
						</div>
					</div>
				</form>
				</div>
			</div>
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding show-for-large-up" >
				<?php include_once($config['include_path_admin'].'myprofile_sidebar.php'); ?>
			</div>
		</div>
					<!--<fieldset>
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
					</fieldset>-->
					

		<!--<div id="content" class="account-settings">
			
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
		</div>-->
	</div>
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>