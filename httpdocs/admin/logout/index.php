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
<body class="background-blue">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right background-blue" role="main">
		<section id="verify-cont" class="admin-logout-content admin-box mobile-12 small-12 large-4 auto-margin">
			
			<div class="admin-box mobile-12 small-12 auto-margin" id="login-cont">
				<h1>MOBlog</h1>
				
			<div class="white-box">
						<div class="row margin-top">
						<p>You've been successfully logged out.  You'll be redirected momentarily to the main site.  
					If not, click <a href="<?php echo $config['this_url']; ?>">Here</a></p>
				<p>Or you can  <a href="http://www.puckermob.com/admin/login/">Log in to existing account here!</a></p>

						</div>
						
			</div>
				
			</div>
		</div>
	</section>
	</main>

	<script>setTimeout(function(){window.location = "http://www.puckermob.com"}, 5000);</script>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>