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
		$per_page = 15;
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
			<section id="articles-list">
				<form class="search-form-admin" id="header-search" action="<?php echo $config['this_url'];?>search/" method="POST">
						<fieldset id="search-fieldset">
							<input type="text" value="" placeholder="Search all" id="searchemailinput" name="searchemailinput">
							<button type="submit" id="searchsubmit" name="searchsubmit">SEARCH<i class="icon-search"></i></button>
						</fieldset>
				</form>

				<header class="section-bar">
					<h2 class="left">SEARCH RESULTS</h2>
					<div class="right">
						<p id="search-total">
							<?php 
								echo (isset($searchString) && $searchString) ?  '<span>'.$total_count.'</span> results' : $mpArticle->data['article_page_visible_name'].' Search ';
							?>
						</p>
					</div>
				</header>
				
 				<?php
					if( isset($articles) && $articles){
						foreach($articles['articles'] as $articleInfo){

							$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/'.$articleInfo["article_id"].'_tall');
							$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo['article_seo_title'];
							$pathToImage = $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/'.$articleInfo["article_id"].'_tall.'.$ext;
							
							if(file_exists($pathToImage)){
								$imageUrl = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/'.$articleInfo["article_id"].'_tall.'.$ext;
							} else {
								$imageUrl = $config['image_url'].'/articlesites/sharedimages/recipe_default_image.jpg';
							}

							$article = '<div class="admin-article" id="'.$articleInfo["article_id"].'">';
								$article .= '<div class="article-image">';
									$article .= '<a href="'.$articleUrl.'">';
										$article .= '<img src="'.$imageUrl.'" alt="'.$articleInfo['article_title'].' Preview Image" />';
									$article .= '</a>';
								$article .= '</div>';
								
								$article .= '<div class="article-info">';
									$article .= '<h2><a href="'.$articleUrl.'">'.$articleInfo['article_title'].'</a></h2>';
									$articleSnippet = utf8_encode(trim(strip_tags($articleInfo['article_desc'])));
									$articleSnippet = (strlen($articleSnippet) > 500) ? substr($articleSnippet, 0, 100).'...' : $articleSnippet;
									$article .= '<p>'.$articleSnippet.'</p>';
								
								$article .='<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="'.$config['this_admin_url'].'articles/index.php" method="POST">';
									$article .='<input type="text" class="hidden" id="c_t" name="c_t" value="'.$_SESSION['csrf'].'" >';
									$article .='<input type="text" class="hidden" id="article_id" name="article_id" value="'.$articleInfo['article_id'].'" />';
									$article .='<a href="'.$articleUrl.'" name="edit" id="edit"><i class="icon-edit"></i> Edit</a>';
									$article .='<a href="'.$articleUrl.'" class="b-delete" name="submit" id="submit"><i class="icon-remove"></i> Delete</a>';
								$article .='</form>';

							$article .= '</div>';

							$article .= '</div>';
							
							echo $article;
				?>
				<?php
						}
					}else echo "<p>Sorry, no articles were found!</p>";
				?>
					
			</section>

			<?php include_once($config['include_path_admin'].'pages.php'); ?>
		</div>
	</main>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>