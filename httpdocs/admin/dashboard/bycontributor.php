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
	//$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month);
	//var_dump($articles);
	$contributor_name = $contributorInfo["contributor_name"];
	$contributor_id = $contributorInfo["contributor_id"];
	$total = 0;

?>
<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<script>function change(){ if($('#month-option').val() == 0) return; document.getElementById("month-form").submit(); }</script>
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<section>
				<h2 class="left small-8">Contributor: <?php echo $contributor_name ; ?></h2>
				<div class="small-4 dd-month">
					<label>Month: 
						<form id="month-form" method="post">
					  	<select name='month' id="month-option" onchange = "change()">
					  		<option value='0'>Select Month</option>
						  	<?php 
						  	$index = 0;
						  	if($current_year == 2014) $index = 10; 
						  	for($m = $index; $m <= $current_month; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($month == $m) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName." ".$current_year.'</option>';
							} ?>
						</select>
						</form>
					</label>
				</div>
			</section>

			<section id="dashboard" class="row">
				<?php if(isset($articles) && $articles ){?>
				<table>
				  <thead>
				    <tr>
				      <th>Article Title</th>
				      <th>Date Added</th>
				      <th>Article Rate</th>
				      <th>Shares</th>
				      <th>Share Rate</th>
				      <th>Share Rev</th>
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
				  		foreach( $articles as $article ){ 

				  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
				  		$month_created = date_format(date_create($article['creation_date']), 'n');
				  		$cat = $article['category'];
				  		$prevMonthData = $dashboard->get_dashboardArticlesPrevMonth($article['article_id'], $month - 1, $cat);

				  		/*Display just those articles when the shares has changed.*/
				  		if( $prevMonthData ){
				  			if( $article['facebook_shares'] != $prevMonthData['facebook_shares'] ||
				  				$article['twitter_shares'] != $prevMonthData['twitter_shares'] ||
				  				$article['pinterest_shares'] != $prevMonthData['pinterest_shares'] ||
				  				$article['google_shares'] != $prevMonthData['google_shares'] ||
				  				$article['linkedin_shares'] != $prevMonthData['linkedin_shares'] ||
				  				$article['delicious_shares'] != $prevMonthData['delicious_shares'] ||
				  				$article['stumbleupon_shares'] != $prevMonthData['stumbleupon_shares']
				  			){ /*Do NOTHING*/}else continue;
				  		}
				  		//Calculate shares / month
				  		//if month == selected 
				  		$facebook_shares = $article['facebook_shares'];
				  		$twitter_shares = $article['twitter_shares'];
				  		$pinterest_shares = $article['pinterest_shares'];
				  		$googleplus_shares = $article['google_shares'];
				  		$linkedin_shares = $article['linkedin_shares'];
				  		$delicious_shares = $article['delicious_shares'];
				  		$stumbleupon_shares = $article['stumbleupon_shares'];
				  		$date_updated = date_format(date_create($article['date_updated']), 'l, F jS Y \a\t h:i:s A');
				  		$article_id = $article['article_id'];
				  		
				  		//How many time the same article is listed.
						$count = $freqs[$article_id];
				  		
				  		//RATE BY ARTICLE 
				  		$rate_by_article = 0;
				  		//var_dump($month_created, $current_month, $month);
				  		if( $month_created == $month ){
				  			$rate_by_article = $article['rate_by_article'] / $count;
				  		}
				  		$rate_by_share  = $article['rate_by_share'];
				  		
				  		//TOTAL SHARES
				  		$total_shares_this_month = $facebook_shares + $twitter_shares + $pinterest_shares + $googleplus_shares +
				  								   $linkedin_shares + $delicious_shares + $stumbleupon_shares;
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
				      <td><?php echo '$'.$rate_by_article;?></td>
				      <td><?php echo $total_shares_this_month; ?></td>
				      <td><?php echo $rate_by_share; ?></td>
				      <td><?php echo '$'.$share_rate; ?></td>
				      <td class="bold"><?php echo '$'.$share_rev; ?></td>
				    </tr>

				    <?php }?>
				    <tr class="total">
				    	<td class="bold">TOTAL</td>
				    	<td></td>
				    	<td class="bold"><?php echo '$'.$total_article_rate; ?></td>
				    	<td class="bold"><?php echo $total_shares; ?></td>
				    	<td></td>
				    	<td class="bold"><?php echo '$'.$total_share_rate; ?></td>
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
					*Please note: In cases where your article shows a lower flat rate than what was originally quoted, 
				your article has been placed in multiple categories, and the flat rate payment fee has simply 
				been divided among them.
				</p>
			</section>
			<section>
				<p class="notes">*All payments will be made via PayPal the 15th of the month.</p>
			</section>
			<section>
				<p class="time">Last time updated: <span class="bold"><?php echo $date_updated; ?></span></p>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>