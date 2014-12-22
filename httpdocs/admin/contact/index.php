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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Contact Us</h1>
	</div>

	<!-- WELCOME MESSAGE -->
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up hide">
			<h1 class="left">Contact Us</h1>
	</section>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
				
			<section id="articles" class="padding-bottom">
				<h2 class="">Need help?</h2>
				<p>For site support, please contact us using the form below or email us at <a href="mailto:info@sequelmediagroup.com">info@sequelmediagroup.com</a>.</p>	
				<form id="adv-contact-form" name="adv-contact-form" action="" method="POST">
					 <div class="row">
					    <div class="columns">
							<label for="name"> NAME:</label>
							<input class="small-9" type="text" id="name" name="name" value="" placeholder="Enter your name here" required />						
						</div>
					</div>
					 <div class="row">
						<div class="columns">
							<label for="email" class="small-2">E-MAIL:</label>
							<input class="small-9" type="email" id="email" name="email" value="" placeholder="Enter your email address here" required />
							
						</div>
						</div>
					 <div class="row">
						<div class="columns">
							<label class="message-label" for="message">MESSAGE</label>
							<textarea name="message" id="message" rows="10" placeholder="Enter your message here" required ></textarea>
						</div>
						</div>
					 <div class="row">
						<div class="columns">
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>
							<button type="submit" id="submit" name="contactsubmit">SEND</button>
							<div id="div-result">
								<p id="result" <?php if(isset($formStatus)) echo ($formStatus) ? 'class="success"' : 'class="error"'; ?>><?php if(isset($formStatusMsg)) echo $formStatusMsg; ?></p>
							</div>
						</div>
						</div>
					</div>
				</form>

				<section class="contact-info">
					<div>
						<h3>Info About Advertising Partnerships: </h3>
						<p>Please email us at <a href="mailto:info@sequelmediagroup.com">info@sequelmediagroup.com</a> or visit our advertising page at: <a href="http://www.puckermob.com/advertise.php" target="_blank">Advertise with Us!</a></p>
					</div>
					<div>
						<h3>Our Brands: </h3>
						<p>You can find more information about Sequel Media Group and our brands at: <a href="http://www.sequelmediagroup.com" target="_blank">Sequelmediagroup.com</a>.</p>
					</div>
					<div>
						<h3>Our Terms of Use: </h3>
						<p>Read our the full End User Liscense Agreement: <a href="http://www.puckermob.com/policy.php" target="_blank">Terms of Use</a></p>
					</div>
					<div>
						<h3>Our Privacy Policy: </h3>
						<p>Read our Privacy Policy: <a href="http://www.puckermob.com/policy.php#privacy" target="_blank">Privacy Policy</a>.</p>
					</div>
				</section>
			
			</section>
			

		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>