<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	if(isset($_GET['h'])){
		$verify = $adminController->user->doVerification($_GET['h']);
		if($verify['hasError'] == true) $adminController->user->invalidateAllTokens();
		else $_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
	}else $adminController->redirectTo('login/');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<div class="admin-box" id="login-cont">
		<header>
			<img src="<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_logo']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name']; ?> Logo">
		</header>

		<div class="admin-form-cont" id="verify-cont">
			<h1><?php echo ($verify['hasError'] == true) ? "Oops!" : "Thanks!"; ?></h1>

			<p class="<?php echo ($verify['hasError'] == true) ? "error" : "success"; ?>"><?php echo $verify['message']; ?></p>
		</div>
	</div>
	<?php if(!$verify['hasError']){ /*	Perform the redirect...	*/?>
		<script>setTimeout(function(){window.location = "<?php echo $config['this_admin_url']; ?>"}, 3000);</script>
	<?php } ?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>