<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	$searchString = (isset($_POST['search']) && strlen($_POST['search'])) ? $_POST['search'] : false;

	if(!$searchString) $searchString = (isset($_GET['q']) && strlen($_GET['q'])) ? $_GET['q'] : false;

	// Sorting information
	if (isset($_GET['sort'])) {
		$sortingMethod = $mpArticleAdmin->getSortOrder($_GET['sort']);

		$articleStatus = $sortingMethod['articleStatus'];
		$filterLabel = $sortingMethod['filterLabel'];
		$order = $sortingMethod['order'];
	}

	if( $searchString ){

		$search = new Search( $config );

		$pageName = "Search Results For: ".$searchString.' | '.$mpArticle->data['article_page_name'];
		$searchString = filter_var($searchString, FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		// 1. the current page number ($current_page)
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

		// 2. records per page ($per_page)
		$per_page = 15000;
		$limit=10;
		$post_date = 'all';
		$articleStatus = '1,2,3';
		$userArticlesFilter = $userData['user_email'];
		$order = '';
		
		if ($userData['user_permission_show_other_user_articles'] == 1){
			$userArticlesFilter = 'all';
		}	

		// 3. total record count ($total_count)	
		$total_count = ($search->count_article_filtered($order, $articleStatus, $userArticlesFilter, $searchString));
		$pagination = new Pagination($page, $per_page, $total_count);
		
		$offset = $pagination->offset();
		$articles = $search->get_article_filtered($limit, $order, $articleStatus, $userArticlesFilter, $offset, $searchString);
	}
	

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
		<section id="articles">
			<section class="left  mobile-12 small-12">
				<section class="">
					<form class="search-form-admin small-7 right margin-bottom" id="header-search" action="<?php echo $config['this_url'];?>search/" method="POST">
							<div id="search-fieldset" class="mobile-12 small-12">
								<input type="text" value="" class="small-8 left" placeholder="Search all" id="searchemailinput" name="searchemailinput">
								<button type="submit" id="searchsubmit" name="searchsubmit" class="small-4"  >SEARCH<i class="icon-search"></i></button>
							</div>
					</form>
				</section>
				
				<section id="articles-list" class="margin-top clear">
					<header class="section-bar clear">
						<h2 class="left">SEARCH RESULT</h2>
						<div class="right">
							<p id="search-total">
								<?php 
									echo (isset($searchString) && $searchString) ?  '<span>'.$total_count.'</span> results' : $mpArticle->data['article_page_visible_name'].' Search ';
								?>
							</p>
						</div>
					</header>
					<?php if($articles){ ?>
					<table class="columns small-12 no-padding">
							<thead>
							    <tr>
							      <th class="columns  mobile-12 small-12 medium-7">Article Name</th>
							     <!-- <th class="columns  small-2"><a href="">Added</a></th>-->
							      <th  class="columns small-2">U.S. VIEWS</th>
							   
							    </tr>
							 </thead>
							 <tbody>
							 <?php foreach($articles['articles'] as $articleInfo){

								$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo['article_seo_title'];
								$article_id = $articleInfo["article_id"];
								$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/tall/'.$articleInfo["article_id"].'_tall');
								$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
								$article_title = $articleInfo['article_title'];
								$article_status = (isset($articleInfo["article_status"])) ? MPArticleAdmin::displayArticleStatus($articleInfo["article_status"]) : '';
								$article_date_created =  date_format(date_create($articleInfo['creation_date']), 'm/d/y');
								$article_us_traffic = $articleInfo['us_traffic'];
							
								if(file_exists($pathToImage)){
									$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
								} else {
									$imageUrl = 'http://images.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg';
								}
								?>
									<tr id="<?php echo 'article-'.$article_id; ?>" class="columns small-12 no-padding">
									  	<td class="columns mobile-12 small-12  medium-7">
									  		<div class="article-image mobile-1 small-1">
												<a href="<?php echo $articleUrl; ?>">
													<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
												</a>
											</div>
											<h2><a href="<?php echo $articleUrl; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article_title)), 43); ?></a></h2>
									  	</td>
									 <!-- 	<td class="columns  small-2 padding-top-center"><?php //echo $article_date_created; ?></td>-->
									  	<td  class="columns  small-2 padding-top-center"><?php if(!empty($article_us_traffic)) echo $article_us_traffic; else echo '0'; ?></td>	
																	  			
									</tr>
							<?php }?>
						    </tbody>
						</table>
									
						<?php }else{ ?>
						<p class="not-found">
							Sorry, no articles were found!
						</p>
	 				<?php
							}
					?>
					
				</section>
			</section>
		</section>
		<?php //include_once($config['include_path_admin'].'pages.php'); ?>
	</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>