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

	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>

		<div id="content">
			<section id="welcome-msg">
				<h2>Welcome to My Simple Dish!</h2>
				<p>Thank you for registering at simpledish.com. You can now build a profile and start sharing your own recipes with the Simple Dish community. Let's get started!</p>
				
				<section id="welcome-page">
					<div class="welcome-desc">
						<div id="icon-img">
							<a href="">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/icon-contributor.jpg'?>" alt"Create Profile Image">
							</a>
						</div>
						<div id="text-desc">
							<p>
								<span>Create Profile:</span> Build your <a href="<?php echo $config['this_admin_url'].'account/user/'.$username;?>">profile</a> by providing information about yourself to the Simple Dish community.
							</p>
						</div>
					</div>
					<div class="welcome-desc">
						<div id="icon-img">
							<a href="">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/icon-food.jpg'?>" alt"Upload Recipes Image">
							</a>
						</div>
						<div id="text-desc">
							<p>
								<span>Upload Recipes:</span> Start adding your own <a href="<?php echo $config['this_admin_url'].'articles/newrecipe/'?>">recipes</a> to our site and share your original creations with other users.
							</p>
						</div>
					</div>
					<div class="welcome-desc">
						<div id="icon-img">
							<a href="">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/icon-recipe.jpg'?>" alt"Simple Dish">
							</a>
						</div>
						<div id="text-desc">
							<p>
								<span>Browser Simple Dish:</span> Go back to <a href="http://simpledish.com">simpledish.com</a> to find more recipes and read articles on trending food topics.
							</p>
						</div>
					</div>
				</section>
			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
