<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	$adminController->user->invalidateAllTokens();
	$_SESSION = [];
	session_destroy();
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
		<div class="admin-box mobile-12 small-6 auto-margin" id="login-cont">
			<header>
				<h1><span>Pucker Mob</span></h1>
			</header>

			<div class="admin-form-cont" id="verify-cont">
				<p>You've been successfully logged out.  You'll be redirected momentarily to the main site.  
					If not, click <a href="<?php echo $config['this_url']; ?>">Here</a></p>
				<p>Or you can  <a href="http://www.puckermob.com/admin/login/">Log in to existing account here!</a></p>

			</div>
		</div>
	</main>

	<script>setTimeout(function(){window.location = "http://www.puckermob.com"}, 5000);</script>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>