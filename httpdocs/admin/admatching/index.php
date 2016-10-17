<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$email = isset($userData['contributor_email_address']) ? $userData['contributor_email_address'] : 'none';
	$contributor_id = $userData['contributor_id'];
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$contributorObj = new Contributor( 'lexi.floom@vhhscougars.org' );
	$ContributorEarnings = new ContributorEarnings( $contributorObj );
	$earnings = $ContributorEarnings->getEarningsPerMonthYear('3', '2016');

	

	//GET RANK POSITION FOR CURRENT USER.
	$limit = 40;
	if($detect->isMobile()){
		$limit = 30;
	}
	 //$rank_list = $ManageDashboard->getTopShareWritesRank( date('n'), $limit);
	 $rank = '9999';

	//AD Matching Object
	$adMatching = new AdMatching();

	//GET ALL FOR CURRENT MONTH
	$bonuses = $adMatching->where(' bonus_month = 10 AND bonus_year = 2016 AND user_type = 0 ');
	
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="ranking">
	
	<!-- HEADER -->	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<!-- MAIN CONTENT -->
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<!-- MENU -->
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>AD Matching</h1>
			</div>

			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>

			
			<div class="small-12 large-10 xxlarge-8 columns no-padding-right">
				
				<?php if( $bonuses ){
	var_dump($earnings); 

					foreach($bonuses as $bonus_plan){
						$bonus_id =  $bonus_plan->bonus_id;
						$bonus_label = $bonus_plan->bonus_label;
						$bonus_user_pct = $bonus_plan->bonus_user_pct;
						$bonus_match_pct = $bonus_plan->bonus_match_pct;
						var_dump($bonus_label, $bonus_user_pct, $bonus_match_pct);

					}
				} 

				?>
			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding  show-for-large-up" >
				<?php //include_once($config['include_path_admin'].'incentives.php'); ?>
			</div>

		</div>

	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>



