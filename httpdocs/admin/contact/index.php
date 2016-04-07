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
<body id="cotact-us">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="small-12 columns padding-bottom margin-bottom">
				<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
					<h1>Contact Us</h1>
				</div>
				<div class="small-12 xxlarge-8 columns">	
	
					<div id="articles" class="margin-bottom">
						<p>For site support, please contact us using the form below or email us at <a href="mailto:info@sequelmediainternational.com">info@sequelmediainternational.com</a>.</p>	
						<form id="adv-contact-form" name="adv-contact-form" action="" method="POST">
							 <div class="row">
							    <div class="columns">
									<input class="small-9" type="text" id="name" name="name" value="" placeholder="Enter your name here" required />						
								</div>
							 </div>
							 <div class="row">
								<div class="columns">
									<input class="small-9" type="email" id="email" name="email" value="" placeholder="Enter your email address here" required />
									
								</div>
							</div>
							 <div class="row">
								<div class="columns">
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

						<div class="contact-info small-12 columns">
							<div>
								<h3>Info About Advertising Partnerships: </h3>
								<p>Please email us at <a href="mailto:info@sequelmediainternational.com">info@sequelmediainternational.com</a> or visit our advertising page at: <a href="http://www.puckermob.com/advertise.php" target="_blank">Advertise with Us!</a></p>
							</div>
							<div>
								<h3>Our Brands: </h3>
								<p>You can find more information about Sequel Media International and our brands at: <a href="http://www.sequelmediainternational.com" target="_blank">sequelmediainternational.com</a>.</p>
							</div>
							<div>
								<h3>Our Terms of Use: </h3>
								<p>Read our the full End User Liscense Agreement: <a href="http://www.puckermob.com/policy.php" target="_blank">Terms of Use</a></p>
							</div>
							<div>
								<h3>Our Privacy Policy: </h3>
								<p>Read our Privacy Policy: <a href="http://www.puckermob.com/policy.php#privacy" target="_blank">Privacy Policy</a>.</p>
							</div>
						</div>
					
					</div>
				</div>
				<!-- Right Side -->
				<div class="small-12 xxlarge-4 right padding rightside-padding show-for-large-up" >
					<?php include_once($config['include_path_admin'].'hottopics.php'); ?>
				</div>
			</div>
		</div>
	</main>

  	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>