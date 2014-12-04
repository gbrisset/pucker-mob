<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
		$somevar = 0;
	} else{

		$userData = $adminController->user->data = $adminController->user->getUserInfo();


		if($adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		//	$adminController->redirectTo('articles/');
		}else{
			$username = $adminController->user->data['user_name'];
			$userLoginCount = $adminController->user->data['user_login_count'];
			$contributor_email = $adminController->user->data['user_email'];
			$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'];
			//$adminController->redirectTo('contributors/edit/'.$contributorInfo[0]['contributor_seo_name']);
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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Welcome</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up padding-bottom">
			<h1 class="left"></h1>
			<div class="right">
			<p class="">Welcome, <?php echo $adminController->user->data['user_email']; ?>
				<img src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'. $adminController->user->data['contributor_image'];?>" >
				<a href="<?php echo $config['this_admin_url']; ?>/logout/">Sign Out</a>
			</p>
		</div>
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="articles">
			<section id="welcome-msg" class="left  mobile-12 small-12 padding-top">
				<h2>Welcome to Sequel Media Group!</h2>
				<p>Thank you for registering with Sequel Media Group!</p>
				<p> We're excited to have you as a contributing writing for our publications. 
					To view your earnings for the previous month, just click the Dashboard button on the left. </p>
				<p>Please remember: The dashboard has just been launched, and will not calculate your social shares 
					or earnings on those shares for the month of October.  Calculations of social shares and earnings 
					on shares will begin on November 1, and will be updated weekly. </p>
				
				<section id="welcome-page">
				</section>
			</section>
				</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
