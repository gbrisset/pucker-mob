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

	$userArticlesFilter = $contributorInfo['contributor_email_address'];
	$order = '';
	$filterLabel = 'Most Recent';
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
	$current_month = date('n');
	$current_year = date('Y');

	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	if(!$_POST['month'] && isset($_GET['month'])){
		$month = $_GET['month'];
		$year = $_GET['year'];
	}
	
	$contributor_name = $contributorInfo["contributor_name"];
	$contributor_id = $contributorInfo["contributor_id"];
	$contributor_email = $contributorInfo["contributor_email_address"]; 
	$contributor_type = $mpArticle->getContributorUserType($contributor_email);

	//$contributor_type = 6;
	$newCalc = true;
	if( $year < 2015 || ( $year == 2015 && $month <= 2)){
		$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$newCalc = false;
	}else{
		//IS MARCH AND UP
		$articles = $dashboard->get_articlesbypageviews_new($contributor_id, $month, $year);
	}

	if(  $month <= 5 && $year == 2015 )	$rate = $dashboard->get_current_rate($month);
	else  $rate = $dashboard->get_current_rate( $month, $contributor_type );
	
	var_dump($month, $contributor_type , $rate);

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
	$last_month_earnings_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $last_month, $last_year );
	$last_month_earnings = 0;
	if($last_month_earnings_info && $last_month_earnings_info['total_earnings'] && !empty($last_month_earnings_info['total_earnings']) ) $last_month_earnings = $last_month_earnings_info['total_earnings'];
	if( $last_month_earnings < 0 ) $last_month_earnings = 0;	
		
	//TOTAL EARNINGS TO DATE
		$total_earnings_to_date_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, 0, 0);
		$total_earnings_to_date = 0;
		if($total_earnings_to_date_info ){
			foreach($total_earnings_to_date_info as $value){
				$total_earnings_to_date += $value['total_earnings'];
			}
		} 

	//THIS MONTH EARNINGS
	$this_month_earnigs_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month, $current_year);
	$this_month_earnigs = 0;
	if($this_month_earnigs_info && $this_month_earnigs_info['total_earnings'] && !empty($this_month_earnigs_info['total_earnings']) ) $this_month_earnigs = $this_month_earnigs_info['total_earnings'];

	$show_art_rate = false;
	if($year == 2014 || $year == 2015 && $month < 2) $show_art_rate = true;
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<script>function change(){ 
		if($('#month-option').val() == 0) return; 
		var year  = $('#month option:selected').attr('data-info');  
		$('#year').val(year);
		document.getElementById("month-form").submit(); }
	</script>

	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">VIEW EARNINGS</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
		<h1 class="left">VIEW EARNINGS</h1>
	</section>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
				<header>View EARNINGS By CONTRIBUTORS</header>
			</div>
			<section id="articles">
				<!-- MONTHLY SHARE RATE -->
				<div id="share-rate-box" class="mobile-12 small-12">
					<div class="share-rate-txt left">
						<p>May CPM RATE (BASED ON U.S. VISITORS): <?php echo '$'.number_format($rate, 2, '.', ','); ?></p>
						<p id="dd-shares-calc">CLICK TO LEARN MORE ABOUT CPM RATES <i class="fa 2x fa-caret-down"></i></p>
					</div>
					<div class="find-more-link right">
						<p><a href="#" id="find-more-info">Find out how to make money with The Mob</a></p>
					</div>
				</div>
				<div id="dd-shares-content" class="mobile-12 small-12">
					<div>
						<p>CPM stands for Cost Per Thousand and is one of the standard ways that people and companies 
							generate revenue. So the rate we're paying this month is that amount you'll earn for every 
							thousand U.S. visitors that read your content.
						</p>
					</div>
				</div>
				
				<!-- WARNINGS BOX -->
				<?php if(isset($warnings) && $warnings[0] && $warnings[0]['notification_live']){ ?>
				<div id="warning-box" class="warning-box  mobile-12 small-12" style="min-height:6.5rem;">
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

				<!-- EARNINGS AT A GLANCE -->
				<?php if( $contributor_type != 6 && $contributor_type != 1 && $contributor_type != 7 ){ ?>
				<div id="earnings-info" class="earnings-info mobile-12 small-12 margin-bottom">
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
			</section>

			<section id="dashboard">
				<header style="margin-top:0.2rem;">EARNINGS PER ARTICLE
					<div class="right" style="text-align: right;">
					<label class="dd-field-month">MONTH:
					<form id="month-form" method="post" class="small-styled-select xsmall-styled-select">
						<input type="hidden" value="<?php echo $year; ?>" id="year" name="year"/>
					  	<select id="month" name='month' onchange = "change()">
					  		<option value='0'>Select Month</option>
					  		<?php if($month == 10 && $year == 2015){?>
					  			<option value='10' data-info="2014" selected>October, 2014</option>
					  		<?php }else{?>
					  			<option value='10' data-info="2014">October, 2014</option>
					  		<?php }?>

					  		<?php if($month == 11 && $year == 2014){?>
					  			<option value='11' data-info="2014" selected>November, 2014</option>
					  		<?php }else{?>
					  			<option value='11' data-info="2014">November, 2014</option>
					  		<?php }?>

					  		<?php if($month == 12 && $year == 2014){?>
					  			<option value='12' data-info="2014" selected>December, 2014</option>
					  		<?php }else{?>
					  			<option value='12' data-info="2014">December, 2014</option>
					  		<?php }?>
					  		
						  	<?php 
						  	$index = 1;
						  	for($m = $index; $m <= $current_month; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($month == $m) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$m.'" '.$selected.' data-info="'.$current_year.'" >'.$monthName.", ".$current_year.'</option>';
							} ?>
						</select>
					
					</form> 
				</label>
					</div>
				</header>
				<?php 
				$date_updated = '';
				if(isset($articles) && $articles ){?>
				<table>
				  <thead>
				  	<?php if($newCalc){?>
					  	<tr>
					      <th class="align-left">Article Title</th>
					      <th>Date Created</th>
					      <th>US Pageviews</th>
					      <th>Rate</th>
					      <th class="bold align-right">Total Rev</th>
					    </tr>
				  	<?php }else{?>
				    <tr>
				      <th class="align-left">Article Title</th>
				      <th>Date Created</th>
				       <?php if( $show_art_rate ){?>
				     	<th>Article Rate</th>
				      <?php }?>
				      <th>Shares</th>
				      <th>Share Rate</th>
				      <th>Share Rev</th>
				      <th>% U.S. Traffic</th>
				      <th class="bold align-right">Total Rev</th>
				    </tr>
				    <?php }?>
				  </thead>
				  <tbody>
				  	<?php 
				  		$date_updated = '';
				  		$ids = array();
				  		foreach( $articles as $article ){ 
				  			$id = $article['article_id'];
				  			array_push($ids, $id);
				  		}
				  		
				  		$freqs = array_count_values($ids);
				  		$date_updated = date_format(date_create($dateupdated[0]['date_updated']), 'l, F jS Y \a\t h:i:s A');

				  		if( !$newCalc ){
				  		foreach( $articles as $article ){ 

				  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
				  		$month_created = date_format(date_create($article['creation_date']), 'n');
				  		$cat = $article['category'];
				  		$prevMonthData = $dashboard->get_dashboardArticlesPrevMonth($article['article_id'], $last_month, $cat, $last_year);
				  		
				  		/*Display just those articles when the shares has changed.*/
				  		if( isset($prevMonthData) && $prevMonthData ){
				    		if( $article['facebook_shares'] != $prevMonthData['facebook_shares'] ||
				  				$article['facebook_likes'] != $prevMonthData['facebook_likes'] ||
				  				$article['facebook_comments'] != $prevMonthData['facebook_comments'] ||
				  				$article['twitter_shares'] != $prevMonthData['twitter_shares'] ||
				  				$article['pinterest_shares'] != $prevMonthData['pinterest_shares'] ||
				  				$article['google_shares'] != $prevMonthData['google_shares'] ||
				  				$article['linkedin_shares'] != $prevMonthData['linkedin_shares'] ||
				  				$article['delicious_shares'] != $prevMonthData['delicious_shares'] ||
				  				$article['stumbleupon_shares'] != $prevMonthData['stumbleupon_shares']
				  			){/*Do NOTHING*/}else continue;
				  		}
				  		//Calculate shares / month
				  		//if month == selected 
				  		$facebook_shares = $article['facebook_shares'];
				  		$facebook_likes = $article['facebook_likes'];
				  		$facebook_comments = $article['facebook_comments'];
				  		$twitter_shares = $article['twitter_shares'];
				  		$pinterest_shares = $article['pinterest_shares'];
				  		$googleplus_shares = $article['google_shares'];
				  		$linkedin_shares = $article['linkedin_shares'];
				  		$delicious_shares = $article['delicious_shares'];
				  		$stumbleupon_shares = $article['stumbleupon_shares'];
				  		$article_id = $article['article_id'];
				  		
				  		//How many time the same article is listed.
						$count = $freqs[$article_id];
				  		
				  		//RATE BY ARTICLE 
				  		$rate_by_article = 0;

				  		if( $month_created == $month && $article['rate_by_article'] != 0){
				  			if( $contributor_type > 2) $rate_by_article = $article['rate_by_article'] / $count;
				  			else $rate_by_article = 0;
				  		}

				  		$rate_by_share  = $article['rate_by_share'];
				  		
				  		//TOTAL SHARES
				  		$total_shares_this_month = $facebook_shares + $twitter_shares + $pinterest_shares + $googleplus_shares +
				  								   $linkedin_shares + $delicious_shares + $stumbleupon_shares;

				  		$us_pct_traffic = 0;
				  		$us_traffic = 0;
				  		if(!empty($article['pct_pageviews']) && $article['pct_pageviews'] != 0){
				  			$us_pct_traffic = $article['pct_pageviews']/100;	
				  			$us_traffic = 	$article['pct_pageviews'];	
				  		}	
				  		
				  		if($year == 2015 && $month <= 1 || $year < 2015 ){
				  			$us_pct_traffic = 100;
				  			$us_traffic = 100;
				  		}		   
				  		
				  		if($year == 2015 && $month == 1) $total_shares_this_month = $total_shares_this_month + $facebook_likes + $facebook_comments;
				  		
				  		//SHARE RATE  TOTAL SHARES * RATE BY ARTICLE (0.04)			   
				  		$share_rate = $total_shares_this_month * $rate_by_share;

				  		//ARTICLE RATE WILL BE SHOW ONLY ON PREVIEWS MONTH Jan and 2014 months
				  		$share_rev = 0;
				  		if( $show_art_rate ){
							$share_rev += $rate_by_article;
				  		}
				  		if($year == 2015 && $month > 1) $share_rev += ($share_rate * $us_pct_traffic);
				  		else $share_rev += ($share_rate * 1);
				  							  		
				  			
				  		$total_shares += $total_shares_this_month;
				  		$total_share_rate += $share_rate;
				  		$total_article_rate += $rate_by_article;
				  		$total += $share_rev;

				  		$link_to_article = 'http://puckermob.com/'.$article["category"].'/'.$article["article_seo_title"];

				  		if($month_created != $month && $share_rev == 0) continue; 


				  	?>
				    <tr id="article-<?php echo $article['article_id']; ?>">
				      <td class="article align-left"><a href='<?php echo $link_to_article; ?>' target='blank'><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 20); ?></a></td>
				      <td><?php echo $creation_date;?></td>
				      <?php if( $show_art_rate ){?>
				      	<td><?php echo '$'.$rate_by_article;?></td>
				      <?php }?>
				      <td class=""><?php echo number_format($total_shares_this_month, 0, '.', ','); ?></td>
				      <td><?php echo $rate_by_share; ?></td>
				      <td class=""><?php echo '$'.number_format($share_rate, 2, '.', ','); ?></td>
				      <td ><?php echo round($us_traffic, 2).'%'; ?></td>
				      <td class="bold align-right"><?php echo '$'.number_format($share_rev, 2, '.', ','); ?></td>
				    </tr>

				    <?php }?>
				    <tr class="total">
				    	<td class="bold">TOTAL</td>
				    	<td></td>
				    	<?php if($show_art_rate ){?>
				    		<td class="bold"><?php echo '$'.number_format($total_article_rate, 2, '.', ','); ?></td>
				    	<?php }?>
				    	<td class="bold"><?php echo number_format($total_shares, 0, '.', ','); ?></td>
				    	<td></td>
				    	<td class="bold"><?php echo '$'.number_format($total_share_rate, 2, '.', ','); ?></td>
				    	<td></td>
				    	<td class="bold align-right"><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
				    </tr>
				    <?php }else{
				    	
				    	$total_page_views = 0;
				  		$us_page_views = 0;
				  		$total_rev = 0;
				  		$total_us_page_views = 0;
				  		$total = 0;
				  		
				  		foreach( $articles as $article ){ 

				  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
				  		$month_created = date_format(date_create($article['creation_date']), 'n');
				  		$cat = $article['cat_dir_name'];
				  		$link_to_article = 'http://puckermob.com/'.$cat.'/'.$article["article_seo_title"];

				  		$total_page_views = $article['pageviews'];
				  		$us_page_views = $article['usa_pageviews'];
				  		$pct_pageviews = $article['pct_pageviews'];
				  
				  		if( $contributor_type == 6 || $contributor_type == 1 || $contributor_type == 7 ){
					  		if( $month > 3 && $year >= 2015 ){
					  			 $total_rev = 0;
					  		}else{
					  			if( $us_page_views > 0 ){
				  					$total_rev = ($us_page_views/1000) * $rate;
				  				}
					  		}
				  		}else{
				  			if( $us_page_views > 0 ){
				  				$total_rev = ($us_page_views/1000) * $rate;
				  			}
				  		}
				  		
				  		
				  		$total += $total_rev;
				  		$total_us_page_views += $us_page_views;
				  		
				  		?>
	
					  	 <tr id="article-<?php echo $article['article_id']; ?>">
					      <td class="article align-left"><a href='<?php echo $link_to_article; ?>' target='blank'><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 20); ?></a></td>
					      <td><?php echo $creation_date;?></td>
					      <td class=""><?php echo number_format($us_page_views, 0, '.', ','); ?></td>
					      <td class=""><?php echo '$'.number_format($rate, 2, '.', ','); ?></td>
					      <td class="bold align-right"><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></td>
					    </tr>
				  	<?php } ?>
				  		<tr class="total">
					    	<td class="bold">TOTAL</td>
					    	<td></td>
					    	<td class="bold"><?php echo number_format($total_us_page_views, 0, '.', ','); ?></td>
					    	<td class="bold"><?php echo '$'.number_format($rate, 2, '.', ','); ?></td>
					    	<td class="bold align-right"><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
				    	</tr>
				  	<?php 
				  	}?>
				  </tbody>
				</table>

				<?php }else{ ?>
					<section class="columns">
						<p class="notes bold">No Records Found!</p>
					</section>
				<?php } ?>
			</section>

			<section>
				<p class="time">Last time updated: <span class="bold"><?php echo $date_updated; ?></span></p>
			</section>

			<section>
				<p class="notes">All payments will be made approximately 45 days after the completion of the current month.</p>
			</section>
			
			<section>
				<p class="notes">Please note that earnings must meet a minimum threshold of $25 for payment to process. Earnings that have not met this threshold will be carried over to the next pay period.	
				</p>
			</section>
			
		</div>
		<?php  include_once($config['include_path_admin'].'findouthowpopup.php'); ?>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>