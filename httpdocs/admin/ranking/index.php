<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	$ManageDashboard = new ManageAdminDashboard( $config );
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="ranking">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>Ranking & Incentives</h1>
			</div>
			<input type="hidden" value="<?php echo $rate['rate']; ?>" id="current-user-rate" />

			<?php include_once($config['include_path_admin'].'view_ranking.php');?>

			
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding" >
				<?php include_once($config['include_path_admin'].'incentives.php'); ?>
			</div>


		</div>

	</main>

	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
