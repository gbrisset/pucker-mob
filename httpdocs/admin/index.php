<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');
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

		$ManageDashboard = new ManageAdminDashboard( $config );

		$current_month = date('n');
		$current_year = date('Y');
		$contributor_id = $userData["contributor_id"];
		
		$contributor_name = $userData["contributor_name"];
		$month =  $current_month;
		if(isset($_POST['month']) && $_POST['month']!= '0' ){
			$month = $_POST['month'];
		}

		//Get Top 10 Shared Moblogs
		$top_shares_articles = $ManageDashboard->getTopSharedMoblogs($month, $current_year ); 

		//WARNINGS
		$warnings = $ManageDashboard->getWarningsMessages(); 

		//ANNOUNCEMENTS
		$annoucements = $ManageDashboard->getAnnouncements(); 
 
		//LAST MONTH EARNINGS
		$last_month_earnings_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month-1);
		$last_month_earnings = 0;
		if($last_month_earnings_info ) $last_month_earnings = $last_month_earnings_info['total_earnings'];
		
		//TOTAL EARNINGS TO DATE
		$total_earnings_to_date_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month);
		$total_earnings_to_date = 0;
		if($total_earnings_to_date_info ) $total_earnings_to_date = $total_earnings_to_date_info['total_earnings'];

		//Top Shared Writers
		
		$writers_arr = $ManageDashboard->getTopShareWritesRank($current_month);
		$index = 0;
		if($writers_arr){
			$your_rank = 0;
			$your_shares = 0;
			$writers_rank = array();
			$is_in = 0;
			//$contributor_rank = array();
			foreach( $writers_arr as $writer ){
				
				if($writer['contributor_id'] == $contributor_id ){
					$your_rank = $index;
					$your_shares = $writer['total_shares'];
					$your_id = $writer['contributor_id'];
				}
				$index ++;
			}

			for($i= 0; $i<10; $i++){
				$position = $i + 1;
				$class = "";
				
				if($your_rank == $i ){
					$class = "your-rank";
					$is_in = 1;
				}

				$contributorId =$writers_arr[$i]['contributor_id'];
				$contributorName = $writers_arr[$i]['contributor_name'];
				$shares = $writers_arr[$i]['total_shares'];

				$ids[] = $contributorId;
				
				$writers_rank[$i]['position'] = $position;
				$writers_rank[$i]['class'] = $class;
				$writers_rank[$i]['contributor_id'] = $contributorId;
				$writers_rank[$i]['contributor_name'] = $contributorName;
				$writers_rank[$i]['shares'] = $shares;

/*				if($your_rank == $i ){
					$writers_rank[$your_rank]['position'] = $position;
					$writers_rank[$your_rank]['class'] = "your-rank";
					$writers_rank[$your_rank]['contributor_id'] = $your_id;
					$writers_rank[$your_rank]['shares'] = $your_shares;
				} */
		    }
		   // if (in_array($contributor_id, $ids)) {
			//    var_dump(in_array("1110", $ids), $ids);
			//}
		    //var_dump((in_array('1110', $ids)) ;
		    var_dump($is_in);
			if( $is_in === 0 ){
				$writers_rank[10]['position'] = $your_rank;
				$writers_rank[10]['class'] = "your-rank";
				$writers_rank[10]['contributor_id'] = $your_id;
				$writers_rank[10]['contributor_name'] = $contributor_name;
				$writers_rank[10]['shares'] = $your_shares;
			}
		}
	
	}
	var_dump($contributor_id);
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
		<h1 class="left">Welcome</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up padding-bottom">
			<h1 class="left">DASHBOARD</h1>
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="articles">
				<!-- WARNINGS BOX -->
			<?php if(isset($warnings) && $warnings[0] && $warnings[0]['notification_live']){ ?>
			<div id="warning-box" class="warning-box  mobile-12 small-12 margin-top " style="min-height:6.5rem;">
				<div class="mobile-2 small-2 left">
					<i class="fa fa-5x fa-exclamation-triangle"></i>
				</div>
				<div class="mobile-10 small-10 inline p-cont">
					<p>
						<?php echo $warnings[0]['notification_msg']; ?>
					</p>
				</div>
			</div>
			<?php }?>

			<!-- ANNOUNCEMENTS BOX -->
			<?php if(isset($annoucements) && $annoucements[0] && $annoucements[0]['notification_live']){ ?>
			<div id="announcements" class="announcements-box  mobile-12 small-12" style="min-height:6.5rem;">
				<div class="mobile-2 small-2 left">
					<i class="fa fa-5x fa-comments"></i>
				</div>
				<div class="mobile-10 small-10 inline p-cont">
					<p>
						<?php echo $annoucements[0]['notification_msg']; ?>
					</p>
				</div>
			</div>
			<?php }?>
			
			<div class="columns mobile-12 small-12 no-padding padding-top margin-top">
				<?php if(isset($top_shares_articles) && $top_shares_articles){?>
				<section id="top-shares" class="top-shares small-8 left">
					<h2>Top 10 MOST Shared Moblogs</h2>
					<div class="month-container">
						<form id="month-select" method="post">
					  	<select name='month' onchange = "change()">
					  		<option value='0'>Select Month</option>
						  	<?php 
						  	$index = 0;
						  	if($current_year == 2014) $index = 10; 
						  	for($m = $index; $m <= $current_month; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($month == $m) $selected  = 'selected'; else $selected = '';
						  		if($m == $current_month)  $monthName = "THIS MONTH";
						  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
							} ?>
						</select>
					</form>
					</div>
					<div class="top-shared-articles">
						<table>
							<thead><tr><td></td><td>TITLE</td><td>SHARES</td></tr></thead>
							<tbody>
						<?php 
							$index = 0; 
							foreach( $top_shares_articles as $article ){ 
							$index++;
							$link_to_article = $config['this_url'].$article['category'].'/'.$article['article_seo_title'];

							$article_id = $article['article_id'];
							$url = "http://www.puckermob.com/".$article['category']."/".$article['article_seo_title'];
							
							//$article['shares'] = 445454;
							
							$totalShares = $ManageDashboard->bd_nice_number($article['total_shares']);

						?>
						<tr id="article-id-<?php echo $article['article_id'];?>" class="top-shared-cont">
							<td class="index-article"><?php echo $index;?>.</td>
							<td class="td-title">
								<p class="article-link">
									<a href="<?php echo $link_to_article; ?>"><?php echo $mpHelpers->truncate($article['article_title'], 30);?></a>
								</p>
							</td>
							<td>
								<p>
									<span class="shares"><?php echo  $totalShares; ?></span>
								</p>	
							</td>
						</tr>
						<?php }?>
						</tbody>
						</table>
					</div>
					<div class="contact-red-box small-11">
						<ul>
							<li><a href="#question?">Question?</a></li>
							<li><a href="#commnets?">Comments?</a></li>
							<li><a href="#ContactUs">Contact Us!</a></li>
						</ul>
					</div>
				</section>
				<?php }?>

				<section id="earnings-section" class="earnings-section small-4 left">
					<div class="last-month-earnings">
						<h3>Last Month's earnings</h3>
						<span class="earnings-value"><?php echo '$'.$last_month_earnings; ?></span>
					</div>
					<div class="total-earnings">
						<h3>Total Earnings to Date</h3>
						<span class="earnings-value"><?php echo '$'.$total_earnings_to_date; ?></span>
					</div>
					<?php if($writers_rank){?>
					<div class="most-shared-writers">
						<h3>Top 10 most shared writes this month ( + your rank )</h3>
						<div class="rank-writers margin-top">
							<ul>
								<?php 
								foreach ($writers_rank as $writer){ //var_dump( $writer); ?>
								<li class="<?php echo $writer['class']; ?>" id="contributor-<?php echo $writer['contributor_id'] ?>">
									<p class="writer-name"><span class="rank-position"><?php echo $writer['position'] ?>.</span><?php echo $writer['contributor_name'] ?></p>
									<p class="monthly-shares right"><?php echo $writer['shares'] ?></p>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
					<?php }?>
				</section>


			</div>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
	<script>function change(){ document.getElementById("month-select").submit(); }</script>

</body>
</html>
