<?php 
	$admin = true;
	require_once('../../assets/php/config.php');

	$userInfo = $adminController->user->data;
	$userObj = new User( $userInfo['user_email'] ); 
	
	$ManageDashboard = new ManageAdminDashboard( $config );
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
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

	$rate = $dashboard->get_current_rate( $month, $contributor_type );
	if(isset($rate['rate'])) $rate = $rate['rate'];


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
	$earnings = $ManageDashboard->getContributorEarningsInfo(  1103 );
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
			
			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>
			
			<input type="hidden" value="<?php echo $rate; ?>" id="current-user-rate" />

			<!-- CHARTS --> 
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">
				<?php include_once($config['include_path_admin'].'charts.php'); ?>

				<?php include_once($config['include_path_admin'].'notifications_temp.php'); ?>

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
			<!-- HAVE A QUESTION -->
				<div class="small-12  columns half-margin-bottom no-padding">
					<?php include_once($config['include_path_admin'].'have_question_box.php'); ?>
				</div>
				<!-- HOT TOPICS --> 
				<div class="small-12  columns half-margin-bottom no-padding">
					<?php include_once($config['include_path_admin'].'hottopics.php'); ?>
				</div>
				<div class="small-12  columns half-margin-bottom no-padding">
					<?php include_once($config['include_path_admin'].'top_bloggers.php'); ?>
				</div>

				<div class="small-12 columns radius right-side-box no-margin-top margin-bottom">
					<?php include_once($config['include_path_admin'].'expert_tips.php'); ?>
				</div>
				
				<!-- WELCOME MODAL -->
				<?php 
					if(	$userData['user_login_count'] == 0  && !isset($_SESSION['show_welcome_modal']) ){
						include_once($config['include_path_admin'].'welcome_modal.php'); 
					}
				?>

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
