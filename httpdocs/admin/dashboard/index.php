<?php
	
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	//if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$date_updated = '';
// 2. records per page ($per_page)
	$per_page = 30;
	$limit=30;
	$post_date = 'all';

	$articleStatus = '1, 2, 3';

	$userArticlesFilter = $userData['user_email'];
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
	//if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
		//$userArticlesFilter = 'all';
	//}
// 3. total record count ($total_count)	
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter));
	$pagination = new Pagination($page, $per_page, $total_count);
	$offset = $pagination->offset();
	$current_month = date('n');
	$current_year = date('Y');
	
	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
	$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);

	$contributor_name = $userData["contributor_name"];
	$contributor_id = $userData["contributor_id"];
	$contributor_email = $userData["user_email"]; 

	$contributor_type = $mpArticle->getContributorUserType($contributor_email);

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
			
			<section id="articles">
			<!-- MONTHLY SHARE RATE -->
				<div id="share-rate-box" class="mobile-12 small-12">
					<div class="share-rate-txt left">
						<p>Feb 2015 Social share rate: $0.03</p>
					</div>
					<div class="find-more-link right">
						<p><a href="#" id="find-more-info">Find out how to make money with  moblogs</a></p>
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
				<div id="earnings-info" class="earnings-info mobile-12 small-12 margin-bottom">
					<header>EARNINGS AT A GLANCE</header>
					<div class="total-earnings left">
						<h3>Month to Date</h3>
						<p class="earnings-value"><?php echo '$'.$this_month_earnigs; ?></p>
					</div>
					<div class="last-month-earnings left">
						<h3>Last Month</h3>
						<p class="earnings-value"><?php echo '$'.$last_month_earnings; ?></p>
					</div>
					<div class="total-earnings left">
						<h3>Total to Date</h3>
						<p class="earnings-value"><?php echo '$'.$total_earnings_to_date; ?></p>
					</div>
				</div>
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
					
					</form> </label>
					</div>
				</header>
				<?php if(isset($articles) && $articles ){?>
				<table>
				  <thead>
				    <tr>
				      <th>Article Title</th>
				      <th>Date Added</th>
				      <?php if(!$blogger){?>
				     	<th>Article Rate</th>
				      <?php }?>
				      <th>Shares</th>
				      <th>Share Rate</th>
				      <th>Share Rev</th>
				      <!--<th>% U.S. Traffic</th>-->
				      <th class="bold">Total Rev</th>
				    </tr>
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
				  		//var_dump($articles);
				  		$date_updated = date_format(date_create($dateupdated[0]['date_updated']), 'l, F jS Y \a\t h:i:s A');

				  		foreach( $articles as $article ){ 

				  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
				  		$month_created = date_format(date_create($article['creation_date']), 'n');
				  		$cat = $article['category'];
				  		$prevMonthData = $dashboard->get_dashboardArticlesPrevMonth($article['article_id'], $last_month, $cat, $last_year);

				  		/*Display just those articles when the shares has changed.*/
				  		if( $prevMonthData ){
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

				  		//var_dump($month_created, $current_month, $month);
				  		if( $month_created == $month && $article['rate_by_article'] != 0){
				  			if( $contributor_type > 2) $rate_by_article = $article['rate_by_article'] / $count;
				  			else $rate_by_article = 0;
				  		}

				  		$rate_by_share  = $article['rate_by_share'];
				  		
				  		//TOTAL SHARES
				  		$total_shares_this_month = $facebook_shares + $twitter_shares + $pinterest_shares + $googleplus_shares +
				  								   $linkedin_shares + $delicious_shares + $stumbleupon_shares;


				  		//if($year != 2014 ) $total_shares_this_month = $total_shares_this_month + $facebook_likes + $facebook_comments;
				  		if($year == 2015 && $month == 1) $total_shares_this_month = $total_shares_this_month + $facebook_likes + $facebook_comments;

				  		//SHARE RATE  TOTAL SHARES * RATE BY ARTICLE (0.04)			   
				  		$share_rate = $total_shares_this_month * $rate_by_share;

				  		//SHARE REVENU = SHARE RATE + RATE BY ARTICLE ( $10 or $5 or $0)
				  		$share_rev = $share_rate + $rate_by_article;
				  		$total_shares += $total_shares_this_month;
				  		$total_share_rate += $share_rate;
				  		$total_article_rate += $rate_by_article;
				  		$total += $share_rev;

				  		$link_to_article = 'http://puckermob.com/'.$article["category"].'/'.$article["article_seo_title"];

				  		if($month_created != $month && $share_rev == 0) continue; 

				  	?>
				    <tr id="article-<?php echo $article['article_id']; ?>">
				      <td class="article"><a href='<?php echo $link_to_article; ?>' target='blank'><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 20); ?></a></td>
				      <td><?php echo $creation_date;?></td>
				      <?php if(!$blogger){?>
				      	<td><?php echo '$'.$rate_by_article;?></td>
				      <?php }?>
				      <td><?php echo $total_shares_this_month; ?></td>
				      <td><?php echo $rate_by_share; ?></td>
				      <td><?php echo '$'.$share_rate; ?></td>
				      <!--<td></td>-->
				      <td class="bold"><?php echo '$'.$share_rev; ?></td>
				    </tr>

				    <?php }?>
				    <tr class="total">
				    	<td class="bold">TOTAL</td>
				    	<td></td>
				    	<?php if(!$blogger){?>
				    		<td class="bold"><?php echo '$'.$total_article_rate; ?></td>
				    	<?php }?>
				    	<td class="bold"><?php echo $total_shares; ?></td>
				    	<td></td>
				    	<td class="bold"><?php echo '$'.$total_share_rate; ?></td>
				    	<!--<td></td>-->
				    	<td class="bold"><?php echo '$'.$total; ?></td>
				    </tr>
				  </tbody>
				</table>

				<?php }else{ ?>

					<section class="columns">
						<p class="notes bold">No Records Found!</p>
					</section>
				<?php } ?>
			</section>

			<section>
				<p class="notes">
					Please note: In cases where your article shows a lower flat rate than what was originally quoted, 
				your article has been placed in multiple categories, and the flat rate payment fee has simply 
				been divided among them.
				</p>
			</section>
			<section>
				<p class="notes">All payments will be made via PayPal the 15th of the month.</p>
			</section>
			<section>
				<p class="time">Last time updated: <span class="bold"><?php echo $date_updated; ?></span></p>
			</section>
		</div>
		<?php 	include_once($config['include_path_admin'].'findouthowpopup.php');

		?>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
