<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	
	$ManageDashboard = new ManageAdminDashboard( $config );
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	//GET RANK POSITION FOR CURRENT USER.
	$limit = 40;
	if($detect->isMobile()){
		$limit = 30;
	}
	 $rank_list = $ManageDashboard->getTopShareWritesRank( date('n'), $limit);
	 $rank = '9999';
	
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

			
			<div class="small-12 large-10 xxlarge-8 columns no-padding-right">
				<p class="small-12 columns no-padding hide-for-large-up">
					View your rank compared to other bloggers in our community, and check to see our latest incentive plan.
				</p>
				<div class="small-12 columns no-padding hide-for-large-up radius mobile-ranking-div margin-bottom" >
					<h2 class="bold">TOP BLOGGERS (THIS MONTH)</h2>
				</div>
				<?php include_once($config['include_path_admin'].'rank_authors_list.php'); ?>

				<!--<div class="small-12 columns no-padding hide-for-large-up radius mobile-ranking-div margin-bottom" >
					<h2 class="bold uppercase"><?php //echo date('F'); ?> INCENTIVE PLAN</h2>
				</div>
				<div class="small-12 columns no-padding hide-for-large-up margin-bottom" >
					<label class="main-color font-1-5x">$100 TOP 10 BONUS</label>
					<p>It's really simple: finish among the Top 10 for the month, and we'll add $100 to your earning total for the month!</p>
				</div>-->

			</div>
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding  show-for-large-up" >
				<?php include_once($config['include_path_admin'].'incentives.php'); ?>
			</div>

		</div>

	</main>

	<!-- INFO BADGE 
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php //include($config['include_path_admin'].'info-badge.php');?>
	</div>-->
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
