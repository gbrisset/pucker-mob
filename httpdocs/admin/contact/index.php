<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	$email_to = $mpArticle->data['article_page_info_contact_email'];
	require_once('../assets/php/contactform.php');

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
		
		<div id="content" class="columns small-9 large-11">
			<section id="categories-list">
				<header class="section-bar">
					<h2>Contact Us</h2>
				</header>
			</section>
			<section id="contact-us-cont">
				<p>Need help?</p>
				<p>For site support, please contact us using the form below or email us at <a href="mailto:info@simpledish.com">info@simpledish.com</a>.</p>	
				<form id="adv-contact-form" name="adv-contact-form" action="" method="POST">
					<fieldset>
						<label for="name">Your Name <span>*</span>:</label>
						<input type="text" id="name" name="name" value="" placeholder="Please enter your name here." required />
					</fieldset>
					
					<fieldset>
						<label for="name">Company Name <span></span>:</label>
						<input type="text" id="companyname" name="companyname" value="" placeholder="Please enter the company name here." />
					</fieldset>
	
					<fieldset>
						<label for="email">E-mail <span>*</span>:</label>
						<input type="email" id="email" name="email" value="" placeholder="Please enter your email address here." required />
					</fieldset>
					
					<fieldset>
						<label for="phonenumber">Phone Number <span></span>:</label>
						<input type="text" id="phonenumber" name="phonenumber" value="" placeholder="Please enter your phone number here." />
					</fieldset>
					
					<fieldset>
						<label for="message">Message <span>*</span>:</label>
						<textarea name="message" id="message" rows="10" placeholder="Please enter your message here." required ></textarea>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>
							<button type="submit" id="submit" name="contactsubmit">Send</button>
							<div id="div-result">
								<p id="result" <?php if(isset($formStatus)) echo ($formStatus) ? 'class="success"' : 'class="error"'; ?>><?php if(isset($formStatusMsg)) echo $formStatusMsg; ?></p>
							</div>
						</div>
					</fieldset>
				</form>

				<section class="contact-info">
					<div>
						<h3>Info About Advertising Partnerships: </h3>
						<p>Please email us at <a href="mailto:info@sequelmediagroup.com">info@sequelmediagroup.com</a> or visit our advertising page at: <a href="http://www.simpledish.com/advertise.php" target="_blank">Advertise with Us!</a></p>
					</div>
					<div>
						<h3>Our Brands: </h3>
						<p>You can find more information about Sequel Media Group and our brands at: <a href="http://www.sequelmediagroup.com" target="_blank">Sequelmediagroup.com</a>.</p>
					</div>
					<div>
						<h3>Our Terms of Use: </h3>
						<p>Read our the full End User Liscense Agreement: <a href="http://www.simpledish.com/policy.php" target="_blank">Terms of Use</a></p>
					</div>
					<div>
						<h3>Our Privacy Policy: </h3>
						<p>Read our Privacy Policy: <a href="http://www.simpledish.com/policy.php#privacy" target="_blank">Privacy Policy</a>.</p>
					</div>
				</section>
			</section>
			

		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>