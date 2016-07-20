<?php 
	$admin = true;
	require_once('../../assets/php/config.php');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$userObj = new User( $userData['user_email'] ); 


	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="control-panel">
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>ADMIN CONTROL PANEL</h1>
			</div>
			
			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_control_panel_resume.php'); ?>
			
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">				
				<?php include_once($config['include_path_admin'].'manage_alerts.php'); ?>
			</div>

			<div class="small-12 xxlarge-9 columns chart_wrapper_div">				
				<?php include_once($config['include_path_admin'].'manage_hottopics.php'); ?>
			</div>

			<div class="small-12 xxlarge-9 columns chart_wrapper_div">				
				<?php include_once($config['include_path_admin'].'send_email.php'); ?>
			</div>

			

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding" style="padding: 0 15px !important;" >
				<div class="small-12 columns radius right-side-box no-margin-top margin-bottom">
				
					<?php include_once($config['include_path_admin'].'expert_tips.php'); ?>
				</div>
			</div>

		</div>

	</main>

	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>
	<?php //include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
