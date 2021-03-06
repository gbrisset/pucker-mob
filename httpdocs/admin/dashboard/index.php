<?php 
	$admin = true;
	require_once('../../assets/php/config.php');


//***************** TEST ************************************************************
//***********************************************************************************
// error_reporting(E_ALL);	ini_set('display_errors', 'on');
//***************** TEST ************************************************************
//***********************************************************************************

	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$userObj = new User( $userData['user_email'] ); 

	$ManageDashboard = new ManageAdminDashboard( $config );
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$date_updated = '';
	$rate = 0;
	
	// 2. records per page ($per_page)
	$per_page = 30;
	$limit=30;
	$post_date = 'all';
	$articleStatus = '1, 2, 3';
	$order = '';
	$filterLabel = 'Most Recent';
	$userArticlesFilter = $userData['user_email'];
		
	if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
	if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}

// 3. total record count ($total_count)	
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter));
	$pagination = new Pagination($page, $per_page, $total_count);
	$offset = $pagination->offset();
	$current_month = date('m');
	$current_year = date('Y');
	
	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$contributor_name = $userData["contributor_name"];
	$contributor_id = $userData["contributor_id"];
	$contributor_email = $userData["user_email"]; 
	$contributor_type = $mpArticle->getContributorUserType($contributor_email);

	$newCalc = true;
	if( $year < 2015 || ( $year == 2015 && $month <= 2)){
		$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$newCalc = false;
	}else{
		if( $year == 2015 && $month <= 6){
			$articles = $dashboard->get_articlesbypageviews_new($contributor_id, $month, $year);
		}else{
			$start_date = date_format(date_create($year.'-'.$month.'-01'), 'Y-m-d');
			$end_date =   date_format(date_create($year.'-'.$month.'-31'), 'Y-m-d');
			$data = ['contributor_id' => $contributor_id, 'start_date' => $start_date, 'end_date' => $end_date];
			$articles = $adminController->user->getContributorEarningChartArticleData($data);
			$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);

		}
	}
	$user_type = $userData['user_type'];
	$user_rate = $dashboard->smf_get_user_rate($user_type, $current_month, $current_year );
	if($user_rate) $current_user_rate = $user_rate['user_rate'];
	 // $ddd = new debug($user_rate,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


	$total = 0;
	
	$last_month = $current_month-1;
	$last_year = $current_year;
	if($current_month == 1){
		 $last_month = 12;
		 $last_year = $current_year - 1;
	}
	$show_art_rate = false;
	if($year == 2014 || $year == 2015 && $month < 2) $show_art_rate = true;

	$user_type = $userData["user_type"];
	$earnings = $ManageDashboard->smf_getContributorEarningsInfo( $contributor_id );
	$current_earnings = isset($earnings['total_earnings']) ? $earnings['total_earnings'] : 0;

?>
<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="earnings">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>MY DASHBOARD</h1>
			</div>

			<!--<div class="mobile-12 small-12 columns padding-bottom">
				<a href="http://www.puckermob.com/admin/admatching/" >
					<img style="width: 100%;" src="http://www.puckermob.com/admin/assets/img/Ad_Matching_ad.jpg" />
				</a>
			</div>-->
			
			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>
			
			<input type="hidden" value="<?php echo $current_user_rate; ?>" id="current-user-rate" />

			<!-- CHARTS --> 
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">
				<?php  include_once($config['include_path_admin'].'charts.php'); ?>
				
				<div class="small-12 columns margin-top">
					<p style="color: #777; font-family:OsloBold; font-size:16px;">Please Note: Earnings shown are estimates only. Actual earnings may be more or less, based on traffic measured via Google Anaytics, and not finalized until after the end of each month.</p>
				</div>
				<?php // include_once($config['include_path_admin'].'notifications_temp.php'); ?>

				<?php include_once($config['include_path_admin'].'incentive_plan_winners.php'); ?>

				<?php include_once($config['include_path_admin'].'alerts.php'); ?>
				<?php //include_once($config['include_path_admin'].'social_dashboard_links.php'); ?>
			</div>

			<div class="small-12 columns no-padding margin-top hide-for-large-up">
				<div class="month-to-date radius">
					<label>$<?php echo $current_earnings; ?></label>
					<span class="uppercase">Month to Date</span>
				</div>
			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding" style="padding: 0 15px !important;" >
			<!-- MERIT RATES -->
				<div class="small-12  columns half-margin-bottom no-padding">


				<div class="small-12 columns radius right-side-box no-margin-top margin-bottom">
					<div class="small-12 radius experttips">

						<h2>GET MORE TRAFFIC</h2>
						<h2 style="color: #008000; ">MAKE MORE MONEY</h2>
						<div style="margin-bottom: .5rem; ">
						As your articles get more traffic, you&#39;ll move up to higher pay levels. The higher your level at the end of the month, the more money you&#39;ll earn!
						</div>
						<h3 style="color: #008000;     text-transform: uppercase; "><?php echo date("F"); ?>&nbsp;RATES</h3>

						<?php 
						//include_once($config['include_path_admin'].'have_question_box.php');

						$merit_rates = $dashboard->smf_get_merit_rate_table( $current_month, $current_year);	

						// // ****************************************************************************************************************************************************************************************
						// $ddd = new debug($merit_rates,0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	*******************************************************************************************************
						// $ddd = new debug("So far so good ... ",1); $ddd->show(); exit();// ************************************************************************************************************************
						// // ****************************************************************************************************************************************************************************************

					echo "
						<table class=\"small-12 columns no-padding\" id=\"\">
							<thead>
								<tr>
									<td style=\" color: #333;\" class=\"align-center\">LEVEL</td>
									<td style=\" color: #333;\" class=\"align-left\">MIN US TRAFFIC</td>
									<td style=\" color: #333;\" class=\"align-left\">EARN</td>
								</tr>
							</thead>
							<tbody>

						";

					foreach ($merit_rates as $key => $merit_rate) {
						$level = $merit_rate['level'];
						$threshold = $merit_rate['threshold'];
						$flat_rate_threshold = $merit_rate['flat_rate_threshold'];
						
						echo "
								<tr>
									<td style=\" color: #333;\" class=\"align-center\">$level</td>
									<td style=\" color: #333;\" class=\"align-left\">" . number_format($threshold,0) ."</td>
									<td style=\" color: #333;\" class=\"align-left\">$" . number_format($flat_rate_threshold,0) ."</td>
								</tr>

						";
						

					}//end foreach ($merit_rates as $key => $value) 


					echo "
							</tbody>
							</table>
					";	



						 ?>

				 </div><!-- <div class="small-12 radius experttips"> -->
			</div> <!-- <div class="small-12 columns radius right-side-box no-margin-top margin-bottom"> --> </div>
			

					<!-- HOT TOPICS --> 
	<!-- 				<div class="small-12  columns half-margin-bottom no-padding">
						<?php // include_once($config['include_path_admin'].'hottopics.php'); ?>
					</div>
					<div class="small-12  columns half-margin-bottom no-padding">
						<?php //include_once($config['include_path_admin'].'top_bloggers.php'); ?>
					</div>
					<div class="small-12 columns radius right-side-box no-margin-top margin-bottom">
						<?php include_once($config['include_path_admin'].'expert_tips.php'); ?>
					</div>

	 -->				
					<!-- WELCOME MODAL -->
					<?php 
						if(	$userData['user_login_count'] == 0  && !isset($_SESSION['show_welcome_modal']) ){
							include_once($config['include_path_admin'].'welcome_modal.php'); 
						}
					?>


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
