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
<?php include_once($config['include_path'].'head.php');?>
<body id="logout">
	<?php include_once($config['include_path'].'header.php');?>

	<main id="main-cont" class="row" role="main">
		<section id="verify-cont" class="admin-logout-content small-12 columns">
			
				
			<div class="row margin-top">
				<h1 class="margin-bottom margin-top uppercase">You've been successfully logged out.</h1>
				<p>  You'll be redirected momentarily to the main site.  
					If not, click <a href="<?php echo $config['this_url']; ?>">Here</a></p>
				<p>Or you can  <a href="http://www.puckermob.com/login/">Log in to existing account here!</a></p>

			</div>
		</div>
	</section>
	</main>

	<script>setTimeout(function(){window.location = "http://www.puckermob.com"}, 2000);</script>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>