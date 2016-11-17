<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');

	if( $detect->isMobile() )  $adminController->redirectTo('dashboard/');

	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$email = isset($userData['contributor_email_address']) ? $userData['contributor_email_address'] : 'none';
	
	$contributor_id = $userData['contributor_id'];
	$user_id = $userData['user_id'];
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$contributorObj = new Contributor( $email );
	$ContributorEarnings = new ContributorEarnings( $contributorObj );
	$adMatching = new AdMatching(); //AD Matching Object
	$OrderObj = new OrderAds(); //ORDER OBJECT

	$rank = '9999';

	//GET ALL FOR CURRENT MONTH
	$month = date('n');
	$year = date('Y');

	//BONUS
	$bonuses = $adMatching->where(" bonus_month = $month AND bonus_year = $year AND user_type = 0 ");

	//GET EARNINGS SPECIFIC MONTH
	$month_relation = date('n')-2;
	$year_relation = date('Y');

	//CHECK IF ORDER EXIST THIS MONTH
	$orderExist = $OrderObj->where(" contributor_id = $contributor_id AND month_relation = $month_relation AND year_relation = $year_relation ");

	$exist_bonus_id = 0;
	if($orderExist){
		$exist_bonus_id = $orderExist[0]->bonus_id;
	}

	//EARNINS INFORMATION
	$earnings_info = $ContributorEarnings->getEarningsPerMonthYear($month_relation, $year_relation);	
	$earnings_info = isset($earnings_info[0]) ? $earnings_info[0] : $earnings_info;

	$to_be_pay = ( isset($earnings_info) && $earnings_info ) ? $earnings_info->to_be_pay : 0;
	
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

			
			<div class="small-12 xxlarge-8 columns no-padding-right padding-top">

				<h2 class="small-12 columns uppercase no-padding-left padding-top">More reach, more traffic, more money!</h2>
				<p class="small-12 columns no-padding payment-balance-copy">For your next payment, you are scheduled to receive: <span class="bold"><?php echo '$'.number_format( $to_be_pay, 2); ?></span></p>
				
				<?php if( isset($bonuses) && $bonuses){?>
				<div class="row clear" data-equalizer data-equalizer-mq="large-up" id="bonus-wrapper">
				   <?php 
				   	$index = 1;
				   	foreach($bonuses as $bonus_plan){
						$bonus_id =  $bonus_plan->bonus_id;
						$bonus_label = $bonus_plan->bonus_label;
						$bonus_user_pct = $bonus_plan->bonus_user_pct;
						$bonus_match_pct = $bonus_plan->bonus_match_pct;

						$user_pct = $match_pct = $amount_user_commit = 0;
						if( $bonus_user_pct > 0 )  $user_pct = ( $bonus_user_pct / 100 );
						if( $bonus_match_pct > 0 )  $match_pct = ( $bonus_match_pct / 100 );
						
						$amount_user_commit = $to_be_pay * $user_pct;
						$amount_to_match = $amount_user_commit * $match_pct;
						$total_to_commit = $amount_to_match + $amount_user_commit;

						
						?>
						<div id="bonus-box-<?php echo $index; ?>" class="small-12 xxlarge-4 columns margin-bottom" data-equalizer-watch>
							<div data-equalizer-watch class="small-12 columns radius box-bonus no-padding">
								<input type="hidden" value="<?php echo $year_relation?>" id="year_relation" />
								<input type="hidden" value="<?php echo $month_relation?>" id="month_relation" />
								<div data-equalizer-watch class="small-12 columns heading-div">
									<h2  class="uppercase" style= "<?php if($index === 2 ) echo 'opacity: 0.8'; elseif($index === 3) echo 
									'opacity: 0.9'; ?>"><?php echo $bonus_label; ?></h2>
								</div>
								<div class="small-12 columns bonus-info padding-top">
									<div class="small-12 columns no-padding">
										<label class="small-8 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>You commit <?php echo $bonus_user_pct.'%'; ?>:
											<p>of your past earnings</p>
										</label>
										<span class="right small-4 columns no-padding align-right" id="user_commit" data-amount = "<?php echo $amount_user_commit; ?>">
											<?php echo '$'.number_format( $amount_user_commit, 2); ?>
										</span>
									</div>
									<div class="small-12 columns padding-top no-padding">
										<label class="small-8 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>We'll add another:
											<p>of our own money</p>
										</label>
										<span class="right small-4 columns no-padding align-right" id="match_commit" data-amount = "<?php echo $amount_to_match; ?>">
											<?php echo '$'.number_format( $amount_to_match, 2); ?>
										</span>
									</div>
									<div class="small-12 columns padding-top no-padding">
										<label class="small-8 columns no-padding">
											<i class="fa fa-caret-right" aria-hidden="true"></i>And spend a total:
											<p>boosting you articles</p>
										</label>
										<span class="right small-4 columns no-padding align-right" id="total_commit" data-amount = "<?php echo $total_to_commit; ?>">
											<?php echo '$'.number_format( $total_to_commit, 2); ?>
										</span>
									</div>
								</div>
								<div class="small-1 columns small-12 columns ad-match-me">
									<?php if( $exist_bonus_id == $bonus_id ){ ?>
										<input id="ad-match-me-<?php echo $index; ?>" name="ad-match-me" data-bonus="<?php echo $bonus_user_pct; ?>" data-bonus-id = "<?php echo $bonus_id; ?>"  data-bonus-match="<?php echo $bonus_match_pct; ?>" type="checkbox" checked="checked" >
									     <label class="ad-match-me-element small-1 columns"><i class="fa fa-check checkd-label" aria-hidden="true"></i></label>
									<?php }else {?>
								     <input id="ad-match-me-<?php echo $index; ?>" name="ad-match-me" data-bonus="<?php echo $bonus_user_pct; ?>" data-bonus-id = "<?php echo $bonus_id; ?>"  data-bonus-match="<?php echo $bonus_match_pct; ?>" type="checkbox"  >
								     <label class="ad-match-me-element small-1 columns"></label>
								     <?php } ?>
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

				<!-- HOW AD MATCHING WORKS BOX -->
				<?php include_once($config['include_path_admin'].'add-screen-shots.php'); ?>

			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding" >
				<!-- HOW AD MATCHING WORKS BOX -->
				<?php include_once($config['include_path_admin'].'how-admatching-works.php'); ?>
			
				<!-- ORDER INFORMATION AND EXECUTION -->
				<?php include_once($config['include_path_admin'].'order-info.php'); ?>
			</div>

		</div>

	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>



