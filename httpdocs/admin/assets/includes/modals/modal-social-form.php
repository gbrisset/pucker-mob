<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	

?>
<div id="social-page">

	<div class="small-12 columns main-social-box radius valign-middle">
		<div class="small-2 columns social-img align-right">
			<img src ="<?php echo $config['this_admin_url']; ?>assets/img/bloggers.jpg" alt="social-modal" style="width: 80%;"/>
		</div>
		<div class="small-8 columns social-copy">
			<h2>Please Join the PuckerMob Blogger Group Page</h2>
			<p  class="show-for-large-up">This is our closed group, where you can ask us questions, get expert tips on marketing and topic ideas, brainstorm with other bloggers, and keep up-to-date with PuckerMob announcements.
			</p>
			<br />
			<p class="show-for-large-up">Please note that all communication with us must happen through this page - we cannot reply to e-mails. </p>
		</div>
			<div class="small-4 large-2 columns social-button no-padding-right">
			<label class="small-12">
			<a href="https://www.facebook.com/groups/1678546779082833/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i> 
					Follow</a>
			</label>
		</div>
	</div>
	<div class="small-12 columns div-wrapper no-padding">
		<div class="small-12 columns valign-middle">
			<div class="small-2 columns social-img align-right">
				<img src ="<?php echo $config['this_admin_url']; ?>assets/img/puckermob.png" alt="social-modal" style="width: 80%;"/>
			</div>
			<div class="small-8 columns social-copy">
				<h2>PuckerMob (Main Fan Page)</h2>
				<p class="show-for-large-up">Our primary fan page, where we feature all of our best articles by both bloggers and in-house writers.</p>
			</div>
			<div class="small-4 large-2 columns social-button no-padding-right">
				<label class="small-12">
					<div class="fb-like" data-href="https://www.facebook.com/puckermob" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
				</label>
			</div>
		</div>
		<hr />
		<div class="small-12 columns valign-middle">
			<div class="small-2 columns social-img align-right">
				<img src ="<?php echo $config['this_admin_url']; ?>assets/img/passionmob.png" alt="social-modal" style="width: 80%;"/>
			</div>
			<div class="small-8 columns social-copy">
				<h2>PassionMob</h2>
				<p class="show-for-large-up">Articles on dating, love, sex and relationships, written by our bloggers</p>
			</div>
			<div class="small-4 large-2 columns social-button no-padding-right">
				<label class="small-12">
					<div class="fb-like" data-href="https://www.facebook.com/PassionMob" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
				</label>
			</div>
		</div>
		<hr />
		<div class="small-12 columns valign-middle">
			<div class="small-3 large-2 columns social-img align-right">
				<img src ="<?php echo $config['this_admin_url']; ?>assets/img/passionmob_logo.png" alt="social-modal" style="width: 80%;"/>
			</div>
			<div class="small-8  columns social-copy">
				<h2>PuckerMob Passion</h2>
				<p class="show-for-large-up">Another fan page focusing on dating, love, sex and relationships, written by our bloggers</p>
			</div>
			<div class="small-4 large-2 columns social-button no-padding-right">
				<label class="small-12">
					<div class="fb-like" data-href="https://www.facebook.com/PuckerMobPassion" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
				</label>
			</div>
		</div>
		<hr />
		<div class="small-12 columns valign-middle">
			<div class="small-2 columns social-img align-right">
				<img src ="<?php echo $config['this_admin_url']; ?>assets/img/pm_voices.png" alt="social-modal" style="width: 80%;"/>
			</div>
			<div class="small-8 columns social-copy">
				<h2>PuckerMob Voices</h2>
				<p class="show-for-large-up">Articles featuring social and political commentary and other opinions on news-worthy events </p>
			</div>
			<div class="small-4 large-2  columns social-button no-padding-right">
				<label class="small-12">
					<div class="fb-like" data-href="https://www.facebook.com/PuckerMobVoices" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
				</label>
			</div>
		</div>
		<hr />

		<div class="small-12 columns valign-middle">
			<div class="small-2 columns social-img align-right">
				<img src ="<?php echo $config['this_admin_url']; ?>assets/img/open_letters.png" alt="social-modal" style="width: 80%;"/>
			</div>
			<div class="small-8 columns social-copy">
				<h2>Open Letter, Open Hearts</h2>
				<p class="show-for-large-up">An unbranded page featuring articles in the popular Open Letter format, primarily from PuckerMob, but also from other viral content sites</p>
			</div>
			<div class="small-4 large-2 columns social-button no-padding-right">
				<label class="small-12">
					<div class="fb-like" data-href="https://www.facebook.com/openlettersopenhearts" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
				</label>
			</div>
		</div>
	</div>
</div>