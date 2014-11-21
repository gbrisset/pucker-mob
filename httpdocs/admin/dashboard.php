<?php
	
	$admin = true;
	require_once('../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
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
	if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
		$userArticlesFilter = 'all';
	}
// 3. total record count ($total_count)	
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter));
	$pagination = new Pagination($page, $per_page, $total_count);
	$offset = $pagination->offset();
	$current_month = date('n');
	$current_year = date('Y');

	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	//$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month);
	
	$contributor_name = $userData["contributor_name"];
	$total = 0;

?>
<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<script>function change(){ document.getElementById("month-form").submit(); }</script>
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<section>
				<h2 class="left">Contributor: <?php echo $contributor_name ; ?></h2>
				<div>
					<label>Month: 
						<form id="month-form" method="post">
					  	<select name='month' onchange = "change()">
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
				  	<?php foreach( $articles as $article ){ 

				  		$creation_date = date_format(date_create($article['creation_date']), 'd/m/y');
				  		//Calculate shares / month
				  		//if month == selected 
				  		$facebook_shares = $article['facebook_shares'];
				  		$twitter_shares = $article['twitter_shares'];
				  		$pinterest_shares = $article['pinterest_shares'];
				  		$googleplus_shares = $article['google_shares'];
				  		$linkedin_shares = $article['linkedin_shares'];
				  		$delicious_shares = $article['delicious_shares'];
				  		$stumbleupon_shares = $article['stumbleupon_shares'];

				  		//RATE BY ARTICLE 
				  		$rate_by_article = $article['rate_by_article'];
				  		$rate_by_share  = $article['rate_by_share'];
				  		
				  		//TOTAL SHARES
				  		$total_shares_this_month = $facebook_shares + $twitter_shares + $pinterest_shares + $googleplus_shares +
				  								   $linkedin_shares + $delicious_shares + $stumbleupon_shares;
				  		//SHARE RATE  TOTAL SHARES * RATE BY ARTICLE (0.04)			   
				  		$share_rate = $total_shares_this_month * $rate_by_share;

				  		//SHARE REVENU = SHARE RATE + RATE BY ARTICLE ( $10 or $5 )
				  		$share_rev = $share_rate + $rate_by_article;

				  		$total += $share_rev;

				  	?>
				    <tr id="article-<?php echo $article['article_id']; ?>">
				      <td><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 50); ?></td>
				      <td><?php echo $creation_date;?></td>
				      <td><?php echo $rate_by_article;?></td>
				      <td><?php echo $total_shares_this_month; ?></td>
				      <td><?php echo $rate_by_share; ?></td>
				      <td><?php echo $share_rate; ?></td>
				      <td class="bold"><?php echo '$'.$share_rev; ?></td>
				    </tr>
				    <?php }?>
				  </tbody>
				</table>

				<div id="display_total">
					<p>TOTAL <span class="right bold"><?php echo '$'.$total; ?></span></p>
				</div>
				<?php }else{ echo "No Records Found!.";} ?>
			</section>
			<section>
				<p class="notes">*All payments will be made via PayPal within 60 days of month's end.</p>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
