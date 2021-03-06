<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	$ManageDashboard = new ManageAdminDashboard( $config );

//***************** TEST ************************************************************
//***********************************************************************************
// error_reporting(E_ALL);	ini_set('display_errors', 'on');
//***************** TEST ************************************************************
//***********************************************************************************

	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	$contributorInfo = $mpArticle->getContributorInfo( $uri[1] );
		 // $ddd = new debug($userData,1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
		 // $ddd = new debug($contributorInfo,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($contributorInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userData['contributor_email_address'])) && $contributorInfo['contributor_email_address'] !== $userData['contributor_email_address']  ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();

	if(empty($contributorInfo)) $mpShared->get404();
	
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
	$pagination = new Pagination(1, $per_page, $total_count);
	$offset = $pagination->offset();
	$current_month = date('m');
	$current_year = date('Y');
	
	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$contributor_name = $contributorInfo["contributor_name"];
	$contributor_id = $contributorInfo["contributor_id"];
	$contributor_email = $contributorInfo["contributor_email_address"]; 
	$contributor_type = $mpArticle->getContributorUserType($contributor_email);

	
	//if(isset($_GET['show']) && $_GET['show'] == true){
			$user_info = new User($contributor_email);
			$contributor = $user_info->contributor;
			$contributor_earnings = new ContributorEarnings( $contributor );
		//	$rate = $contributor_earnings->getRate( 6, 2016, $user_type )
			// var_dump($contributor_earnings); die;

	//}

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
	if($current_month == 1){ $last_month = 12; $last_year = $current_year - 1;}//end if
	
	$show_art_rate = false;
	//if($year == 2014 || $year == 2015 && $month < 2) $show_art_rate = true;

	$user_type = $contributor_type; 
	$earnings = $ManageDashboard->smf_getContributorEarningsInfo(  $contributor_id );
	$current_earnings = isset($earnings['total_earnings']) ? $earnings['total_earnings'] : 0;
	$best_article = $ManageDashboard->get_bestArticle($contributor_id,  date('n'), date('Y'));

	if(isset($_GET['show']) && $_GET['show'] == true){ var_dump($contributor_earnings, $user_type, $earnings, $current_earnings); }
?>
<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="earnings">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	<input type="hidden" value="<?php echo $user_type; ?>" id="user_type" />
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>Earnings &amp; Analytics</h1>
			</div>
			
			<input type="hidden" value="<?php echo $current_user_rate; ?>" id="current-user-rate" />
			<input type="hidden" value="<?php echo $user_type; ?>" id="current-user-type" />


			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>

			<!-- Calendar -->
			<?php // include_once($config['include_path_admin'].'calendar.php'); ?>

			
			<!-- CHARTS --> 
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">
				<?php // include_once($config['include_path_admin'].'charts.php'); ?>

				<div id="earnings-list" class="small-12 columns no-padding margin-top">
				<table class="small-12 columns no-padding" id="daily-earnings">
					<thead>
						<tr>
							<td class="align-left">Date</td>
							<td class="align-center">US. Traffic | 1K</td>
							<td class="align-center">CPM Rate</td>
							<td class="align-right">Earnings</td>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				</div>

				
			</div>

			<div class="small-12 columns no-padding margin-top hide-for-large-up">
				<div class="month-to-date radius">
					<label>$<?php echo $current_earnings; ?></label>
					<span class="uppercase">Month to Date</span>
				</div>
			</div>

		

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding" >
				<?php include_once($config['include_path_admin'].'earnings_info.php'); ?>
			</div>
			<div class="small-12 xxlarge-3 right padding rightside-padding" >
				<?php include_once($config['include_path_admin'].'payment_options.php'); ?>
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
