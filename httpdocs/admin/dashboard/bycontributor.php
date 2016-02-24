<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2] ])['contributors'];

	if(empty($contributorInfo)) $mpShared->get404();
	$contributorInfo = $contributorInfo[0];
	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($contributorInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $contributorInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}

	//Verify if is a content provider user
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}
	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	// 2. records per page ($per_page)
	$per_page = 30;
	$limit=30;
	$post_date = 'all';
	$articleStatus = '1, 2, 3';
	$order = '';
	$filterLabel = 'Most Recent';
	$userArticlesFilter = $contributorInfo['contributor_email_address'];
	
	// Sorting information
	$article_sort_by = "mr";
	if (isset($_GET['sort'])) {
		$sortingMethod = $mpArticleAdmin->getSortOrder($_GET['sort']);
		$articleStatus = $sortingMethod['articleStatus'];
		$filterLabel = $sortingMethod['filterLabel'];
		$order = $sortingMethod['order'];
		$article_sort_by = $_GET['sort'];
	}
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

	//if(!$_POST['month'] && isset($_GET['month'])){
	//	$month = $_GET['month'];
	//	$year = $_GET['year'];
	//}
	
	$contributor_name = $contributorInfo["contributor_name"];
	$contributor_id = $contributorInfo["contributor_id"];
	$contributor_email = $contributorInfo["contributor_email_address"]; 
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
		}
	}
	$rate = $dashboard->get_current_rate( $month, $contributor_type, $year );
	$total = 0;
	$ManageDashboard = new ManageAdminDashboard( $config );

	//WARNINGS
	$warnings = $ManageDashboard->getWarningsMessages(); 

	//LAST MONTH EARNINGS
	$last_month = $current_month-1;
	$last_year = $current_year;
	if($current_month == 1){
		 $last_month = 12;
		 $last_year = $current_year - 1;
	}
	$show_art_rate = false;
	if($year == 2014 || $year == 2015 && $month < 2) $show_art_rate = true;

	$user_type = $contributor_type;

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
			
			<div id="following-header" class="  mobile-12 small-12 columns padding-bottom ">
				<h2><?php echo $contributor_name.'\'s '; ?>Dashboard</h2>
			</div>

			<div class="small-12 xxlarge-8 left padding margin-top">
				<?php if( $contributor_type != 1 && $contributor_type != 6 && $contributor_type != 7 ){?>
				
				<section id="articles" class="small-12 columns box-border no-margin-vaxis">
					
					<section class="margin-top">
					    <div id="bar_chart" style=""></div>
					</section>
				</section>

				<?php }?>


				<div id="dashboard" class="small-12 columns">
					<header >EARNINGS PER ARTICLE</header>
					<?php include_once($config['include_path_admin'].'dashboard_list_articles.php'); ?>

				</div>

				
			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding" id="right-new-article">
				<!--MOB LEVEL -->
				<?php include_once($config['include_path_admin'].'showuserplan.php');?>

				<!-- MONTHLY SHARE RATE -->
				<div id="share-rate-box" class="small-12 columns right box-it-up">
					<div class="share-rate-txt padding-bottom padding-top">
						<input type="hidden" value="<?php echo $rate['rate']; ?>" id="current-user-rate" />
						<label class="uppercase main-color"><?php echo "CPM (".$moblevel.") : $".number_format($rate['rate'], 2, '.', ',');?></label>
					</div>
				</div>
				<div id="total-earned-range" class="small-12 columns right box-it-up">
					<div class="share-rate-txt">
						<label class="uppercase">Total Earned for selected range: <span class="main-color"><?php echo "$".number_format($total, 2, '.', ',');?></span></label>
					</div>
				</div>
				<div id="calendar-section" class="small-12 columns right box-it-up">
					<div id="reportrange">
						<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						<input type="text" name="daterange" value="01/01/2015 - 01/31/2015" />
					</div>
				</div>
				<div id="mob-rank" class="small-12 columns right box-it-up">
					<?php  include_once($config['include_path'].'your_rank.php'); ?>
					<div class="share-rate-txt">
						<label class="uppercase">Mob Rank: <span><?php echo "#".$your_rank;?></span></label>
					</div>
				</div>

			</div>

			<?php include_once($config['include_path_admin'].'earnings_information.php'); ?>

		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>