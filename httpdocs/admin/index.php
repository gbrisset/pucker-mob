<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
		$somevar = 0;
	} else {
		$adminController->user->data = $adminController->user->getUserInfo();

		if($adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
			$adminController->redirectTo('articles/');
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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="welcome-msg">
				<h2>Welcome to Pucker Mob!</h2>
				<p>Thank you for registering at puckermob.com. Let's get started!</p>
				
				<section id="welcome-page">
				</section>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
