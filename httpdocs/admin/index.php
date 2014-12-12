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
		//	$adminController->redirectTo('articles/');
		}else{
			$userFilter = $adminController->user->data['user_email'];
			$username = $adminController->user->data['user_name'];
			$userLoginCount = $adminController->user->data['user_login_count'];
			$contributor_email = $adminController->user->data['user_email'];
			$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'];
			//$adminController->redirectTo('contributors/edit/'.$contributorInfo[0]['contributor_seo_name']);
		}

		$ManageDashboard = new ManageAdminDashboard( $config );

		//ARTICLES PER CONTRIBUTOR
		$articles_by_cont = $mpArticle->get_filtered(100000, '', '', $userFilter, 0);
	
		//Get Top 10 Shared Moblogs
		$current_month = date('n');
		$current_year = date('Y');

		$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
		$top_shares_articles = $ManageDashboard->getTopSharedMoblogs($month-1, $current_year ); 

		$warnings = $ManageDashboard->getWarningsMessages(); 
		$annoucements = $ManageDashboard->getAnnouncements(); 

	}
	
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
			<?php if($warnings[0] && $warnings[0]['notification_live']){ ?>
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
			<?php if($annoucements[0] && $annoucements[0]['notification_live']){ ?>
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
						<select class="months" name="months">
							<option value="0">THIS MONTH</option>
						</select>
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
							
							$article['shares'] = 445454;
							
							$totalShares = $ManageDashboard->bd_nice_number($article['shares']);

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
						<span class="earnings-value">$87.90</span>
					</div>
					<div class="total-earnings">
						<h3>Total Earnings to Date</h3>
						<span class="earnings-value">$649.90</span>
					</div>
					<div class="most-shared-writers">
						<h3>Top 10 most shared writes this month ( + your rank )</h3>
						<div class="rank-writers margin-top">
							<ul>
								<li>

									<p class="writer-name"><span class="rank-position">1.</span>John Smith</p>
									<p class="monthly-shares right">123,455</p>
								</li>
								<li>
									<p class="writer-name"><span class="rank-position">2.</span>John Smith</p>
									<p class="monthly-shares right">123,455</p>
								</li>
								<li>
									<p class="writer-name"><span class="rank-position">3.</span>John Smith</p>
									<p class="monthly-shares right">123,455</p>
								</li>
								<li>
									<p class="writer-name"><span class="rank-position">4.</span>John Smith</p>
									<p class="monthly-shares right">123,455</p>
								</li>
								<li>
									<p class="writer-name"><span class="rank-position">5.</span>John Smith</p>
									<p class="monthly-shares right">123,455</p>
								</li>
							
								<li class="your-rank">
									<p class="writer-name"><span class="rank-position">72.</span>Flor Guzman</p>
									<p class="monthly-shares right">123,455</p>
								</li>
							</ul>
						</div>
					</div>
				</section>


			</div>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
