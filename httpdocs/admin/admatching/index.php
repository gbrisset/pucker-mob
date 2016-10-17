<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$email = isset($userData['contributor_email_address']) ? $userData['contributor_email_address'] : 'none';
	$contributor_id = $userData['contributor_id'];
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$contributorObj = new Contributor( 'annabashkova@hotmail.com' );
	$ContributorEarnings = new ContributorEarnings( $contributorObj );
	$adMatching = new AdMatching(); //AD Matching Object

	//GET RANK POSITION FOR CURRENT USER.
	/*$limit = 40;
	if($detect->isMobile()){
		$limit = 30;
	}
	 $rank_list = $ManageDashboard->getTopShareWritesRank( date('n'), $limit);
	 */
	 $rank = '9999';

	//GET ALL FOR CURRENT MONTH
	$bonuses = $adMatching->where(' bonus_month = 10 AND bonus_year = 2016 AND user_type = 0 ');
	//GET EARNINGS SPECIFIC MONTH
	$earnings_info = $ContributorEarnings->getEarningsPerMonthYear('1', '2016');	
	$earnings_info = isset($earnings_info[0]) ? $earnings_info[0] : $earnings_info;

	$to_be_pay = $earnings_info->to_be_pay;

	
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="admatching">
	
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

			
			<div class="small-12 large-10 xxlarge-9 columns no-padding-right" style="margin-top: 3rem;">
				
				<h2 class="small-12 columns uppercase no-padding-left">More reach, more traffic, more money!</h2>
				<p class="small-12 columns no-padding payment-balance-copy">For your next payment, you are scheduled to receive: <?php echo '$'.number_format( $to_be_pay, 2); ?></p>
				
				<?php if( isset($bonuses) && $bonuses){?>
				<div class="row" data-equalizer data-equalizer-mq="large-up" id="bonus-wrapper">
				   <?php 
				   	$index = 1;
				   	foreach($bonuses as $bonus_plan){
						$bonus_id =  $bonus_plan->bonus_id;
						$bonus_label = $bonus_plan->bonus_label;
						$bonus_user_pct = $bonus_plan->bonus_user_pct;
						$bonus_match_pct = $bonus_plan->bonus_match_pct;
						?>
						<div id="bonus-box-<?php echo $index; ?>" class="small-12 medium-4 columns" data-equalizer-watch>
							<div class="small-12 columns radius box-bonus no-padding">
								<div class="small-12 columns heading-div">
									<h2 class="uppercase" style= "<?php if($index === 2 ) echo 'opacity: 0.8'; elseif($index === 3) echo 
									'opacity: 0.9'; ?>"><?php echo $bonus_label; ?></h2>
								</div>
								<div class="small-12 columns bonus-info padding-top">
									<div class="small-12 columns padding-top no-padding">
										<label class="small-7 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>You commit <?php echo $bonus_user_pct.'%'; ?>:
											<p>of your past earnings</p>
										</label>
										<span class="right small-5 columns no-padding align-right">$345.34</span>
									</div>
									<div class="small-12 columns padding-top no-padding">
										<label class="small-7 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>We'll add another:
											<p>of our own money</p>
										</label>
										<span class="right small-5 columns no-padding align-right">$345.34</span>
									</div>
									<div class="small-12 columns padding-top no-padding">
										<label class="small-7 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>And spend a total:
											<p>boosting you articles</p>
										</label>
										<span class="right small-5 columns no-padding align-right">$345.34</span>
									</div>
								</div>
								<div class="small-1 columns small-12 columns ad-match-me">
								     <input id="ad-match-me-<?php echo $index; ?>" type="checkbox">
								     <label class="ad-match-me-element small-1 columns"></label>
								     <label for="ad-match-me-<?php echo $index; ?>" class=" ad-match-me-label small-11 columns">Ad Match Me</label>

								</div>
				 	 		</div>
			 	 		</div>

						<?php 
						$index++;
					} ?>
				</div>
				
				<?php }else{ ?>
					<p>NO BONUS SET THIS MONTH...</p>
				<?php }?>

			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding  show-for-large-up" >
				<?php //include_once($config['include_path_admin'].'incentives.php'); ?>
			</div>

		</div>

	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>



