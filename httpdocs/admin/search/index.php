<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	$searchString = (isset($_GET['search-menu']) && strlen($_GET['search-menu'])) ? $_GET['search-menu'] : false;

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
		$per_page = 10000;
		$limit=10000;
		$post_date = 'all';
		$articleStatus = '1,2,3';
		$userArticlesFilter = $userData['user_email'];
		$order = '';

		// Sorting information
		$article_sort_by = "mr";
		if (isset($_GET['sort'])) {
			$sortingMethod = $mpArticleAdmin->getSortOrder($_GET['sort']);
			$articleStatus = $sortingMethod['articleStatus'];
			//$filterLabel = $sortingMethod['filterLabel'];
			$order = $sortingMethod['order'];
			$article_sort_by = $_GET['sort'];
		}


		if ($userData['user_permission_show_other_user_articles'] == 1){
			$userArticlesFilter = 'all';
		}	

		// 3. total record count ($total_count)	
		$total_count = ($search->count_article_filtered($order, $articleStatus, $userArticlesFilter, $searchString));
		$pagination = new Pagination($page, $per_page, $total_count);
		
		$offset = $pagination->offset();
		$articles = $search->get_article_filtered($limit, $order, $articleStatus, $userArticlesFilter, $offset, $searchString);
		//GET ALL ARTICLES BASE ON THE FILTER BY STATUS, USERTYPE, ETC...
	$arr_ids = [];
	foreach($articles['articles'] as $article){
		$arr_ids[] = $article['article_id'];	
	}


	//IMPLODE ALL THE IDS FOR EACH ARTICLE ON THE CURRENT INDEX PAGE.
	$comma_separated = implode(",", $arr_ids);

	//GET USA PAGEVIEWS FOR EACH ARTICLE ON THE LIST
	$usa_pageview_list = $mpArticle->getTotalUsPageviews( $comma_separated );
	$pageviews_list = [];
	foreach($usa_pageview_list as $key=>$value){

		$total_pv = isset($value['total_usa_pv']) ? $value['total_usa_pv'] : 0;
		if(isset($value['article_id']))  $pageviews_list[$value['article_id']] = $total_pv;

	}


	}

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="search-results">
	<!--<script>function change(){ document.getElementById("month-form").submit(); }</script>-->
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>Search Results for: <?php echo $searchString; ?></h1>
			</div>
			
			<section id="edit-articles">
				<!-- ARTICLES RESUME INFO --> 
				<?php include_once($config['include_path_admin'].'view_articles_resume.php'); ?>
				
				<?php 
		     		$userType_URL = $config['this_admin_url'].'search/?search-menu='.$searchString;

		     		if($page > 1){
		     			$userType_URL .= '&page='.$page;
		     		}else $userType_URL .= '&page=1';

		     		$order='';
		     		if (!isset($sortingMethod['order']) || strlen($sortingMethod['order']) == 0){
						if (isset($sortingMethod)) $order = $sortingMethod['articleStatus'];
					}
			 	?>

				<div class="small-12 xxlarge-9 columns no-padding">
					<section id="articles-list" class="columns margin-top no-padding">
						<?php if(isset($articles) && $articles ){

								// $ddd = new debug($articles,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
 ?>
						<table class="columns small-12 no-padding">
								<thead>
								    <tr>
								       <th width="400" class="align-left">Title</th>
								       <th width="90" class="show-for-large-up">Added</th>
								       <th width="90"  class="show-for-large-up">status</th>
								       <th width="90" class="show-for-xlarge-up">U.S. Traffic</th>
								       <th width="30" class="show-for-xlarge-up">Track</th>
								       <th  width="50" class="show-for-large-up"></th>
								    </tr>
								</thead>
								
								<tbody>
								 <?php foreach($articles['articles'] as $articleInfo){
									$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo['article_seo_title'];
									$articleUrlLive = $config['this_url'].'/'.$articleInfo['cat_dir_name'].'/'.$articleInfo['article_seo_title'];
									$article_id = $articleInfo["article_id"];
									$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/tall/'.$articleInfo["article_id"].'_tall');
									$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
									$article_title = $articleInfo['article_title'];
									$article_status = (isset($articleInfo["article_status"])) ? MPArticleAdmin::displayArticleStatus($articleInfo["article_status"]) : '';
									$article_date_created =  date_format(date_create($articleInfo['creation_date']), 'm/d/y');
									$article_us_traffic = 0;
									$contributor_name = $articleInfo['contributor_name'];
									$contributor_seo_name = $articleInfo['contributor_seo_name'];

									$edits = $articleInfo['article_agree_edits'];
									// $article_locked = ( $edits == 1 && $articleInfo['article_status'] == 1); // Old definition - October 19, 2017 - GB
									
									// New definition - October 19, 2017 - GB
									$article_locked = true;
									if ($articleInfo['article_status'] ==1 && $edits ==0) $article_locked = false;
									if ($articleInfo['article_status'] ==3) $article_locked = false;
									if ($admin_user) $article_locked = false;

									$revenue_track = ( $edits == 1 );// Additional definition - October 19, 2017 - GB



									if(isset($pageviews_list[$article_id]) && !is_null($pageviews_list[$article_id])){
								    	$article_us_traffic = $pageviews_list[$article_id];
									}

									if(file_exists($pathToImage)){
										$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
									} else {
										$imageUrl = 'http://images.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg';
									}

									?>
									<tr id="<?php echo 'article-'.$article_id; ?>">
									  	<td class="border-right">
									  		<div class=" large-4 columns no-padding-left show-for-large-up">
												<a href="<?php echo $articleUrl; ?>">
													<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
												</a>
											</div>
											<div class="large-7  columns no-padding" style="display: table-caption">
												<h2 class="small-12 columns no-padding">
													<i class="fa fa-caret-right hide-for-large-up small-1  columns"></i>
													<a href="<?php echo $articleUrl; ?>">
														<?php echo $mpHelpers->truncate(trim(strip_tags($article_title)), 45); ?>
													</a>
													<?php if($admin){?>
														<span class="show-for-large-up"><a href="<?php echo $config['this_admin_url']; ?>profile/user/<?php echo $contributor_seo_name; ?>"><?php echo $contributor_name?></a></span>
													<?php }?>
												</h2>
												
											</div>
											<div class="large-1 columns no-padding show-for-large-up">
												<?php if($articleInfo["article_status"] == 1 ) { ?>	
													<a href="<?php echo $articleUrlLive; ?>" target="_blank" style="position: relative; top: 1.5rem;"><i class="fa fa-external-link"></i></a> 
												<?php }?>
											</div>
									  	</td>

									  	<td class="show-for-large-up  border-right"><label><?php echo $article_date_created; ?></label></td>
									  	<td class="show-for-large-up  border-right"><label><?php echo $article_status ?></label></td>	
										<!-- REMOVE ARTICLE -->
										<td class="show-for-xlarge-up  border-right" ><label><?php echo $article_us_traffic; ?></label></td>

										<td  class="show-for-xlarge-up  border-right">
											<?php if( $revenue_track ){ ?>
												<i class="fa fa-money" style="color: #23ab23; font-size: 150%;" aria-hidden="true"></i>
											<?php }else{?>
												<i class="fa fa-file-text-o " style="color:red; font-size: 150%;" aria-hidden="true"></i>
											<?php }?>
										</td>

										<td class="show-for-large-up no-border-right valign-middle">
											<?php if($admin_user || $blogger ){?>
												<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="<?php echo $config['this_admin_url'].'articles/index.php';?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf'];?>" >
													<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $article_id;?>" />
													<a class="manage-links" href="<?php echo $articleUrl;?>" class="b-delete" name="submit" id="submit"><i class="fa fa-times"></i></a>
												</form>
											<?php }else{?>
												<?php if($articleInfo["article_status"] != 1 ){?>
												<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="<?php echo $config['this_admin_url'].'articles/index.php';?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf'];?>" >
													<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $article_id;?>" />
													<a class="manage-links" href="<?php echo $articleUrl;?>" class="b-delete" name="submit" id="submit"><i class="fa fa-times"></i></a>
												</form>
												<?php }else{ ?>
													<!-- REQUEST TO DELETE THIS ARTICLE -->
													<a class="manage-links has-tooltip b-delete" title="If you want to delete this article please contact mpinedo@sequelmediainternational.com." href="<?php echo $articleUrl;?>" name="submit" id="submit"><i class="fa fa-times b-disable"></i></a>
												<?php } ?>
											<?php }?>
										</td>	

									</tr>
								<?php }?>
							    </tbody>
						</table>
										
						<?php }else{ ?>
							<p class="not-found">
								Sorry, no articles were found!
							</p>
						<?php }?>
					</section>
					
					<?php include_once($config['include_path_admin'].'pages.php'); ?>
				</div>
				<div class="small-12 xxlarge-3 right padding" >
					<?php include_once($config['include_path_admin'].'statuses.php'); ?>
					<?php include_once($config['include_path_admin'].'filter_by_usertype.php'); ?>

					<div class="small-12 columns show-for-large-up margin-top no-padding">
						<?php include_once($config['include_path_admin'].'hottopics.php'); ?>
					</div>
				</div>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>