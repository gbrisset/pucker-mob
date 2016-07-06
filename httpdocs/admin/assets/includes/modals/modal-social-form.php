<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
?>
<div id="social-page">

	<div class="small-12 columns main-social-box">
		<div class="small-3 columns social-img"></div>
		<div class="small-8 columns social-copy">
			<h2>Please Join the PuckerMob Blogger Group Page</h2>
			<p>This is our closed group, where you can ask us questions, get expert tips on marketing and topic ideas, brainstorm with other bloggers, and keep up-to-date with PuckerMob announcements.
			</p>
			<p>Please note that all communication with us must happen through this page - we cannot reply to e-mails. </p>
		</div>
		<div class="small-1 columns social-button"></div>

	</div>
</div>