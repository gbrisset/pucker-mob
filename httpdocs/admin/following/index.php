<?php
	$username = "";
	$admin = true;

	require_once('../../assets/php/config.php');

	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
		$somevar = 0;
	} else{
		$userData =  $follow->getReaderInfo();
		$adminController->user->data = $userData;
		if($adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
			$userFilter = 'all';
		}else{
			$userFilter = $adminController->user->data['user_email'];
			$username = $adminController->user->data['user_name'];
			$contributor_email = $adminController->user->data['user_email'];
			$userLoginCount = $adminController->user->data['user_login_count'];
			$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'];
		}

		$rate = $dashboard->get_current_rate();
		$ManageDashboard = new ManageAdminDashboard( $config );

		$current_month = date('n');
		$current_year = date('Y');
		$month =  $current_month;
	
		$reader_email = $adminController->user->data['user_email'];
	
		$sort_ever = $sort_month = '';
		if(isset($_GET['month']) && $_GET['month']!= '0' ){
			$month = $_GET['month'];
			if($month == 'all') $sort_ever = 'underline';
			if($month != 'all' && $month > 0) $sort_month = 'underline';
		}

		//GET AUTHORS FOLLOW BY THIS READER
		$authors = $follow->getFollowingAuthors( $reader_email ); 
		
		//MOST FOLLOWED CONTRIBUTOR
		$most_followed = $follow->mostFollowedWriters(5);

		//MOST POPULAR AUTHORS
		$most_popular = $ManageDashboard->getTopShareWritesRank($current_month, 5);

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
		<h1 class="left">FOLLOWING</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up padding-bottom hide margin-top">
			<h1 class="left">FOLLOWING</h1>
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="articles">
				<input type="hidden" value="<?php echo  $reader_email; ?>" id="reader_email" />
				<div id="following-header" class="following-header mobile-12 small-12">
					<header>YOU ARE FOLLOWING: </header>
				</div>
				<div id="following-content" class="following-content">
					<?php if(isset($authors) && $authors){?>
					<?php foreach( $authors as $author ){?>
					<div id="about-the-author" data-info="<?php echo $author['contributor_id']?>" class="columns">
						<div class="border-right" style="max-width: 8rem;">
							<div  style="min-width: 70px; margin-right: 1rem; text-align:center;">
								<a href="<?php echo $config['this_url'].'contributors/'.$author['contributor_seo_name']; ?>">
									<img src="<?php echo 'http://images.puckermob.com/articlesites/contributors_redesign/'.$author['contributor_image']; ?>" alt="<?php echo $author['contributor_name']?>" class="following-img"/>
								</a>
								<h1 class="following-name"><?php echo $author['contributor_name']?></h1>
							</div>
							<div class="author-links" style="margin-right:1rem;">
								<a href="http://www.puckermob.com/contributors/<?php echo $author['contributor_seo_name']; ?>">READ BIO</a>
								<a href="" id="unfollow-author">Unfollow</a>
								<input type="hidden">
							</div>
						</div>
						<div class="" id="following-author-articles">
							<h2>Recent Articles:</h2>
							<?php 
								$articles = $follow->getArticlesPerAuthor($author['contributor_id']);
							?>
							<div class="author-recent-articles">
								<?php 
								foreach($articles as $article){ 
								?>
								<div id="article-<?php echo $article['article_id']?>" class="row  article-div">
									<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article["article_id"]; ?>_tall.jpg" alt="<?php echo $article['article_title']?>" class="columns small-3 no-padding margin-right"/>
									<div class=" columns small-9">
										<a href="<?php echo 'http://www.puckermob.com/'.$article['cat_dir_name'].'/'.$article['article_seo_title']; ?>"><h1 class="vertical-align-center"><?php echo $article['article_title']; ?></h1></a>
									</div>
								</div>
								<?php }?>
							</div>
							<label class="author-read-more"><a href="http://www.puckermob.com/contributors/<?php echo $author['contributor_seo_name']; ?>">Read more</a></label>
						</div>
					</div>
					<?php }?>
					<?php }else{?>
					<p class="columns margin-top">You are not following any author!</p>
					<?php }?>
				</div>
			</section>

			<!-- MOST FOLLOWED AUTHORS -->
			<?php if($most_followed){?>
			<section id="most-followd-authors" class="columns small-6">
				<h1>Most Followed Writers:</h1>
				<ul> 
				<?php foreach($most_followed as $followed){ 
					echo '<li id="'.$followed["contributor_id"].'"><a href="http://www.puckermob.com/contributors/'.$followed['contributor_seo_name'].'" target="_blank" >'.$followed['contributor_name'].'</a></li>';
				 } ?>
				</ul>
			</section>
			<?php }?>

			<!-- MOST POPULAR AUTHORS -->
			<?php if($most_popular){?>
			<section id="most-followd-authors" class="columns small-6">
				<h1>Most Popular Writers:</h1>
				<ul> 
				<?php foreach($most_popular as $popular){ 
					echo '<li id="'.$popular["contributor_id"].'"><a href="http://www.puckermob.com/contributors/'.$popular['contributor_seo_name'].'" target="_blank" >'.$popular['contributor_name'].'</a></li>';
				 } ?>
				</ul>
			</section>
			<?php }?>
		</div>
	</main>
	
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
