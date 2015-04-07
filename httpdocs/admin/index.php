<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');

	//WELCOME POPUP SESSION VALUE
	if(!isset($_SESSION['welcome-seen']) ) $_SESSION['welcome-seen'] = false;

	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
		$somevar = 0;
	} else{
		$userData = $adminController->user->data = $adminController->user->getUserInfo();

		if($adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
			$userFilter = 'all';
		}else{
			$userFilter = $adminController->user->data['user_email'];
			$username = $adminController->user->data['user_name'];
			$userLoginCount = $adminController->user->data['user_login_count'];
			$contributor_email = $adminController->user->data['user_email'];
			$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'];
		}

		$rate = $dashboard->get_current_rate();
		$ManageDashboard = new ManageAdminDashboard( $config );

		$current_month = date('n');
		$current_year = date('Y');
		$contributor_id = $userData["contributor_id"];
		
		$contributor_name = $userData["contributor_name"];
		$month =  $current_month;
		$sort_ever = '';
		$sort_month = 'underline';
		if(isset($_GET['month']) && $_GET['month']!= '0' ){
			$month = $_GET['month'];
			if($month == 'all'){ $sort_ever = 'underline'; $sort_month = '';}
			if($month != 'all' && $month > 0){ $sort_month = 'underline'; $sort_ever = '';};
		}

		//Get Top 10 Shared Moblogs
		$top_shares_articles = $ManageDashboard->getTopSharedMoblogs($month, $current_year ); 

		//WARNINGS
		$warnings = $ManageDashboard->getWarningsMessages(); 

		//ANNOUNCEMENTS
		$annoucements = $ManageDashboard->getAnnouncements(); 
 
		//LAST MONTH EARNINGS
		$last_month_earnings_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month-1, $current_year);
		$last_month_earnings = 0;
		if($last_month_earnings_info && $last_month_earnings_info['total_earnings'] && !empty($last_month_earnings_info['total_earnings']) ) $last_month_earnings = $last_month_earnings_info['total_earnings'];
		if( $last_month_earnings < 0 ) $last_month_earnings = 0;	
		
		//TOTAL EARNINGS TO DATE
		$total_earnings_to_date_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, 0, 0);
		$total_earnings_to_date = 0;
		if($total_earnings_to_date_info ){
			foreach($total_earnings_to_date_info as $value){
				if(isset($value['total_earnings'])) $earnings = $value['total_earnings'];
				else $earnings = $value;
				$total_earnings_to_date += $earnings;
			}
		} 
	
		//THIS MONTH EARNINGS
		$this_month_earnigs_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month, $current_year);
		$this_month_earnigs = 0;
		if($this_month_earnigs_info && $this_month_earnigs_info['total_earnings'] && !empty($this_month_earnigs_info['total_earnings']) ) $this_month_earnigs = $this_month_earnigs_info['total_earnings'];
		//if($this_month_earnigs_info ) $this_month_earnigs = $this_month_earnigs_info['total_earnings'];

		//Top Shared Writers
		
		$writers_arr = $ManageDashboard->getTopShareWritesRank($current_month);
		$index = 0;
		$your_cont_rank = array();
		if($writers_arr){
			$your_rank = 0;
			$your_shares = 0;
			$writers_rank = array();
			$is_in = 0;
		
			foreach( $writers_arr as $writer ){
				
				if($writer['contributor_id'] == $contributor_id ){
					$your_rank = $index;
					$your_shares = $writer['total_us_pageviews'];
					$your_id = $writer['contributor_id'];
				}
				$index ++;
			}
			$total = 0;	
			for($i= 0; $i< count($writers_arr) -1; $i++){
				$position = $i + 1;
				$class = "";
				
				if($your_rank == $i ){
					$your_cont_rank['id'] = $writers_arr[$i]['contributor_id'];
					$your_cont_rank['name'] = $writers_arr[$i]['contributor_name'];
					$your_cont_rank['total_shares'] = $writers_arr[$i]['total_us_pageviews'];//;$writers_arr[$i]['total_shares'];
					$your_cont_rank['rank'] = $your_rank;
					$class = "your-rank";
					$is_in = 1;
				}
	
				if( $total == 10) break;
				if( $writers_arr[$i]['user_type'] == 6 || $writers_arr[$i]['user_type'] == 1 ) continue;

				$contributorId =$writers_arr[$i]['contributor_id'];
				$contributorName = $writers_arr[$i]['contributor_name'];
				$shares = $writers_arr[$i]['total_us_pageviews'];//$writers_arr[$i]['total_shares'];

				$ids[] = $contributorId;
				
				$writers_rank[$i]['position'] = $position;
				$writers_rank[$i]['class'] = $class;
				$writers_rank[$i]['contributor_id'] = $contributorId;
				$writers_rank[$i]['contributor_name'] = $contributorName;
				$writers_rank[$i]['shares'] = $shares;

				if($total < 10 ) $total++;

		    }

			if( $is_in === 0 ){
				$your_cont_rank['rank'] = $your_rank;
				$your_cont_rank['id'] = $your_id;
				$your_cont_rank['name'] = $contributor_name;
				$your_cont_rank['total_shares'] = $your_shares;


			}
		}
	
	}

	$user_login_count = $adminController->user->data['user_login_count']; 
	//var_dump($user_login_count);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">My DASHBOARD</h1>
	</div>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
					<header>MY DASHBOARD</header>
			</div>
			<section id="articles">
				<!-- MONTHLY SHARE RATE -->
				<div id="share-rate-box" class="mobile-12 small-12">
					<div class="share-rate-txt left">
						<p>April CPM Rate (Based on U.S. Visitors): <?php echo '$'.number_format($rate, 2, '.', ','); ?></p>
						<p id="dd-shares-calc">Click to Learn More About CPM Rates <i class="fa 2x fa-caret-down"></i></p>
					</div>
					<div class="find-more-link right">
						<p><a href="#" id="find-more-info">Find out how to make money with  moblogs</a></p>
					</div>
				</div>
				<div id="dd-shares-content" class="mobile-12 small-12">
					<div>
						<p>CPM stands for Cost Per Thousand and is one of the standard ways that people and companies calculate revenue. 
							So the rate we're paying this month 
							is that amount you'll earn for every thousand U.S. visitors that read your content.
						</p>
					</div>
				</div>
				<!-- WARNINGS BOX -->
				<?php if(isset($warnings) && $warnings[0] && $warnings[0]['notification_live']){ ?>
				<div id="warning-box" class="warning-box  mobile-12 small-12" style="">
					<div id="warning-icon" class="">
						<i class="fa fa-3x fa-exclamation-triangle"></i>
					</div>
					<div id="warning-txt" class="p-cont">
						<p>
							<?php echo $warnings[0]['notification_msg']; ?>
						</p>
					</div>
				</div>
				<?php }?>

				<!-- ANNOUNCEMENTS BOX -->
				<?php if(isset($annoucements) && $annoucements[0] && $annoucements[0]['notification_live']){ ?>
				<div id="announcements" class="announcements-box  mobile-12 small-12" style="MARGIN-BOTTOM: 1rem;">
					<div id="announcement-icon" class="">
						<i class="fa fa-3x fa-comments"></i>
					</div>
					<div id="announcement-txt" class="p-cont">
						<p>
							<?php echo $annoucements[0]['notification_msg']; ?>
						</p>
					</div>
				</div>
				<?php }?>
				
				<!-- EARNINGS AT A GLANCE -->
				<?php if($userData['user_type'] != 6 && $userData['user_type'] != 1){?>
				<div id="earnings-info" class="earnings-info mobile-12 small-12">
					<header>EARNINGS AT A GLANCE</header>
					<div class="total-earnings left">
						<h3>Month to Date</h3>
						<p class="earnings-value"><?php echo '$'.number_format($this_month_earnigs, 2, '.', ','); ?></p>
					</div>
					<div class="last-month-earnings left">
						<h3>Last Month</h3>
						<p class="earnings-value"><?php echo '$'.number_format($last_month_earnings, 2, '.', ','); ?></p>
					</div>
					<div class="total-earnings left">
						<h3>Total to Date</h3>
						<p class="earnings-value"><?php echo '$'.number_format($total_earnings_to_date, 2, '.', ','); ?></p>
					</div>
				</div>
				<?php }?>

				<!-- TOP MOST SHARES MOBLOGS -->
				<div id="top-shares" class="top-shares mobile-12 small-12 left">
					<?php if(isset($top_shares_articles) && $top_shares_articles){?>
						<header>Top 10 Most Popular Articles
							<div class="sort-by-month right">
								<a href="<?php echo $config['this_admin_url'].'?month='.$current_month; ?>" class="<?php echo $sort_month; ?>">This month</a>
								<a href="#">  | </a> <a href="<?php echo $config['this_admin_url'].'?month=all'; ?>" class="<?php echo $sort_ever; ?>">ever</a> 
							</div>
						</header>
						
						<div class="top-shared-articles">
							<table class="left" style="margin-right:0.2rem">
								<thead><tr><td></td><td  style="width:80%;">TITLE</td><td>SHARES</td></tr></thead>
								<tbody>
							<?php 
								$index = 0; 
								foreach( $top_shares_articles as $article ){ 
								$index++;
								$link_to_article = $config['this_url'].$article['category'].'/'.$article['article_seo_title'];

								$article_id = $article['article_id'];
								$url = "http://www.puckermob.com/".$article['category']."/".$article['article_seo_title'];
								
								$totalShares = $ManageDashboard->bd_nice_number($article['total_shares']);

							?>
							<tr id="article-id-<?php echo $article['article_id'];?>" class="top-shared-cont">
								<td class="index-article"><?php echo $index;?>.</td>
								<td class="td-title">
									<p class="article-link">
										<a href="<?php echo $link_to_article; ?>"><?php echo $mpHelpers->truncate($article['article_title'], 45);?></a>
									</p>
								</td>
								<td>
									<p>
										<span class="shares"><?php echo  $totalShares; ?></span>
									</p>	
								</td>
							</tr>
							
							<?php if($index == 5){?>
								</tbody>
							</table>
							<table class="right">
								<thead><tr><td></td><td  style="width:80%;">TITLE</td><td>SHARES</td></tr></thead>
								<tbody>
							<?php }?>
							<?php }?>
							
							</tbody>
							</table>
						</div>
						
					<?php }?>
				</div>
				
				<!-- Top 10 most shared writers this month -->
				<div id="earnings-section" class="top-shares mobile-12 small-12 left">
					<header>MOST POPULAR MOBloggers</header>
					<?php if($writers_rank){?>
					<div class="top-shared-articles">
							<table class="left" style="margin-right:0.2rem">
								<thead><tr><td></td><td style="width:80%;">NAME</td><td>PAGEVIEWS</td></tr></thead>
								<tbody>
							<?php 
								$index = 0; 
								foreach ($writers_rank as $writer){  

								$index++;
								$totalShares = $ManageDashboard->bd_nice_number($article['total_shares']);

							?>
							<tr id="id="contributor-<?php echo $writer['contributor_id'] ?>"" class="top-shared-cont">
								<td class="index-article"><?php echo $index;?>.</td>
								<td class="td-title">
									<p class="writer-name article-link">
										<?php echo $writer['contributor_name']; ?>
									</p>
								</td>
								<td>
									<p>
										<span class="shares"><?php echo $ManageDashboard->bd_nice_number($writer['shares']); ?></span>
									</p>	
								</td>
							</tr>
							<?php if($index == 5){?>
								</tbody>
							</table>
							<table class="right">
								<thead><tr><td></td><td  style="width:80%;">NAME</td><td>PAGEVIEWS</td></tr></thead>
								<tbody>
							<?php }?>
							<?php }?>
							
							</tbody>
							</table>
						</div>
						<div class="your-rank-box left">
							<p><?php echo $your_cont_rank["rank"].'. '.$your_cont_rank["name"].', PAGEVIEWS: '.$ManageDashboard->bd_nice_number($your_cont_rank['total_shares']); ?></p>
						</div>

					<?php }?>
				
				</div>
			</section>
		</div>
		<?php 

	include_once($config['include_path_admin'].'findouthowpopup.php');

 	if( (isset( $user_login_count ) && $user_login_count < 1) && $_SESSION['welcome-seen'] == false){	
 		include_once($config['include_path_admin'].'welcomepopup.php');
 	}?>
	</main>

 	
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
	<script>
		function change(){ 
			document.getElementById("month-select").submit(); 
		}
	</script>

</body>
</html>
