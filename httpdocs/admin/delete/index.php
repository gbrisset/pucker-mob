<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	$adminController->user->invalidateAllTokens();
	$_SESSION = [];
	session_destroy();


	//FACEBOOK SETTINGS
	require_once('../fb/fbfunctions.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body class="background-blue">
	  <main>
	<section id="slide-1" class="homeSlide">
	   <div class="bcg">
		    <div class="hsContainer">
		    <h1>PUCKERMOB</h1>
			<hr>
			<img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
					<div class="hsContent dark-bg padding-top margin-top">
						<div id="register-form-cont-new" class="admin-form-cont success-msg">
							<div class="row">
								<p class="">
									Your account has been deleted.  You'll be redirected momentarily to the main site.  
									If not, click <a href="<?php echo $config['this_url']; ?>">Here</a>
								</p>
								<script>setTimeout(function(){window.location = "<?php echo $config['this_url']; ?>"}, 3000);</script>
							</div>
						</div>
					</div>
			</div>
		</div>
	</section>
</main>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>