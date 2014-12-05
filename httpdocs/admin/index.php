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
	
		//Get Top 5 Shared Moblogs
		$top_shares_articles = $ManageDashboard->getTopSharedMoblogs(); 

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
			<div id="warning-box" class="warning-box  mobile-12 small-12 margin-top ">
				<div class="mobile-2 small-2 left">
					<i class="fa fa-5x fa-exclamation-triangle"></i>
				</div>
				<div class="mobile-10 small-10 inline p-cont">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
						sed do eiusmod tempor incididunt ut labore et dolore 
						magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
						ullamco laboris nisi.
					</p>
				</div>
			</div>
			
			<div class="buttons-container dashboard mobile-12 small-12">
				<?php if($articles_by_cont){?>
				<select class="small-5" id="recent-articles" name="recent-articles">
					<option value = "0">my recent articles</option>
					<?php foreach( $articles_by_cont as $art ){
						echo '<option value = "'.$art['article_id'].'">'.$art['article_title'].'</option>';
					}?>
					
				</select>
				<?php }?>
				<a href="<?php echo $config['this_url'].'admin/articles/';?>" id="viewall" name="viewall" class="a-buttons">VIEW ALL</a>
				<a href="<?php echo $config['this_url'].'admin/articles/newarticle/';?>" id="addnew" name="addnew" class="a-buttons">ADD NEW</a>			
			</div>
			<div class="mobile-12 small-12">
				<?php if(isset($top_shares_articles) && $top_shares_articles){?>
				<section id="top-shares" class="top-shares small-6 left">
					<h2>Top 5 Shared Moblogs</h2>
					<div class="top-shared-articles">
						<ol>
						<?php foreach( $top_shares_articles as $article ){ //var_dump($article);

							$link_to_article = $config['this_url'].$article['category'].'/'.$article['article_seo_title'];
							$date_created = date_create($article['creation_date']);
							$date_created = $date_created->format('m/d/Y');
							$article_id = $article['article_id'];
							$url = "http://www.puckermob.com/".$article['category']."/".$article['article_seo_title'];
							$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";
							$json = file_get_contents("http://free.sharedcount.com/?url=" . rawurlencode($url) . "&apikey=" . $apikey);
			
							$counts = json_decode($json, true);

							$article['shares'] = $counts["StumbleUpon"] +  $counts["Facebook"]["share_count"] +  $counts["GooglePlusOne"] + $counts["Twitter"] +  $counts["Pinterest"] +  $counts["LinkedIn"] + $counts["Delicious"] ;
							$totalShares = $ManageDashboard->bd_nice_number($article['shares']);

						?>
						<li>
							<article id="article-id-<?php echo $article['article_id'];?>" class="top-shared-cont">
								<p>
									<span class="shares"><?php echo  $totalShares; ?> Shares</span> |
									<img src="http://images.puckermob.com/articlesites/contributors_redesign/<?php echo $article['contributor_image'];?>" alt="<?php echo $article['contributor_name'];?>" />
									<a href="http://www.puckermob.com/contributors/<?php echo $article['contributor_seo_name'];?>" taget="_blank"><?php echo $article['contributor_name'];?></a>
								</p>
								<p class="article-link">
									<a href="<?php echo $link_to_article; ?>" target=""><?php echo $mpHelpers->truncate($article['article_title'], 60);?></a>
									<span class="date-created right"><?php echo $date_created ;?></spam>
								</p>		
							</article>
						</li>
						<?php }?>
						</ol>
					</div>
				</section>
				<?php }?>

				<section id="announcements" class="announcements small-5 left">
						<div class="sub-announcements">
							<h2>ANNOUNCEMENTS</h2>
							<div class="box">
								<p>
									<span>FROM THE EDITOR:</span>
									Lorem ipsum dolor sit amet, consectetur 
									adipiscing elit, sed do eiusmod tempor 
									incididunt ut labore et dolore magna aliqua. 
									Ut enim ad minim veniam, quis nostrud exercitation 
									ullamco laboris nisi ut aliquip ex ea commodo consequat.
									Duis aute irure dolor in reprehenderit in voluptate 
									velit esse cillum dolore eu fugiat nulla pariatur. 

									Excepteur sint occaecat cupidatat non proident, sunt 
									in culpa qui officia deserunt mollit anim id est laborum
								</p>
							</div>
						</div>
						<div class="sub-announcements">
							<h2>TRENDING TOPICS</h2>
							<div class="box no-padding">
								<ul>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
									</li>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
									</li>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
									</li>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
									</li>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
									</li>
									<li>
										<p><span>Hot Topics:</span>
											Lorem ipsum dolor sit amet, 
											consectetur adipiscing elit, 
											sed do eiusmod tempor aliquip.
										</p> 
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
