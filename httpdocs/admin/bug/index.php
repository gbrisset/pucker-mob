<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userInfo = $adminController->user->data = $adminController->user->getUserInfo();

	if(isset($_POST['submit'])){
		// The form has been submitted
		$bug = new Bug;
		$response = $bug->save($_POST);
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
		
		<div id="content">
			<section id="bug-cont">
				<section>
					<header class="section-bar">
						<h2 class="floated">Report a Bug</h2>
						<div class="btn-wrapper" style="margin: 0;">
							<button type="submit" onclick="window.location.href='<?php echo $config['this_admin_url'].'bug/reporting/'; ?>'">View Reports</button>
						</div>
					</header>
				</section>

				<h3>See something wrong?</h3>
				<p>If you have spotted a bug, please use the form below to report it to our technical department.</p>
				<p>A 'bug' can be considered anything that doesn't work as you expect it to work.  This can range from some minor typo or asthetic glitch you may find to some functionality being really broken or not working at all.</p>
				<h3></h3>

				<p>When reporting a bug, please try to be as descriptive as possible and use these guidelines:</p>
				<ul id="bug-instructions-cont">
			    	<li class="bug-instructions">
				        	<p>Limit your bug report to 1 issue.</p>
				        	<p class="italic-grey">Don't combine more than one bug into one bug report.</p>
				    </li>			        
			    	<li class="bug-instructions">
				        	<p>What were you doing when the bug happened?</p>
				        	<p class="italic-grey">Carefully explain what you were doing when the bug occured.  Try to be as descriptive as possible.  Ex. "I was trying to upload an image, when I got a message that said, 'Sorry, something went wrong.'"</p>
				    </li>         
				</ul>
				<form id="bug-form" class="ajax-submit-form" name="adv-bug-form" action="" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="bug_date" name="bug_date" value="<?php echo date('Y-m-d H:i:s'); ?>" />					
					<input type="hidden" id="bug_user_email" name="bug_user_email" value="<?php echo $userInfo['user_email']; ?>" />					
					<input type="hidden" id="bug_browser" name="bug_browser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />					
					<fieldset>
						<label for="bug_description"><span></span>What were you doing<br />when the bug occured?</label>
						<textarea name="bug_description" id="bug_description" rows="5" placeholder="ex. I was trying to upload an image on the add recipe page." required ></textarea>
					</fieldset>
					<fieldset>
						<label for="bug_error_message"><span></span>What error message (if any)<br />appeared when the bug occured?</label>
						<textarea name="bug_error_message" id="bug_error_message" rows="5" placeholder="ex. 'Sorry, something has gone wrong.  The upload has failed.'" required ></textarea>
					</fieldset>					

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>
							<button type="submit" id="submit" name="submit">Send</button>

						</div>
					</fieldset>
				</form>
			</section>	
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>