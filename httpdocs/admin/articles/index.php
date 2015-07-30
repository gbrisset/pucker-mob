<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article-delete-form']): //Delete Article
					$updateStatus = array_merge($adminController->deleteArticleById($_POST['formData']));	
					break;
			}
		}else $adminController->redirectTo('logout/');
	}
// for the new Pagination class - we only need 3 bits of info...
// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
// 2. records per page ($per_page)
	$per_page = 20;
	$limit=20;
	$post_date = 'all';

	$articleStatus = '1, 2, 3';

	$artType = '';
	$allCurrent = 'current';
	$writersCurrent = $bloggersCurrent = '';
	if(  isset($_GET['artype']) && $_GET['artype']){
		$allCurrent = '';
		$artType = $_GET["artype"];
		//var_dump($artType);
		if($artType === "bloggers") $bloggersCurrent = 'current';
		elseif($artType === "writers")  $writersCurrent = 'current';
	}

	$sts = '';
	if(isset($_GET['sts']) && $_GET['sts']){
		$sts = '?sts='.$_GET['sts'];
	}


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
	// if (isset($_GET['category'])) {$category = $_GET['category'];}
	if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
	if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}
	if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
		$userArticlesFilter = 'all';
	}
// 3. total record count ($total_count)	
	// $total_count = $mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter);
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter, $artType));
	
	$pagination = new Pagination($page, $per_page, $total_count);
	
	$offset = $pagination->offset();

	$articles = $mpArticle->get_filtered($limit, $order, $articleStatus, $userArticlesFilter, $offset, $artType);
	
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;
	}

	$inhouse_writer = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 6 ){
		$inhouse_writer = true;
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
		<h1 class="left">View Articles</h1>
	</div>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
				<header>View Articles</header>
			</div>
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
				 <?php 
					    	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
					    	$liveClass = '';
					    	$draftClass = '';
					    	$sortStatus = 1;
							if( $sort == 1){
								$sortStatus = 3; 
								$liveClass = 'current';
								$draftClass = '';
								
							} elseif( $sort == 3) {
								$sortStatus = 1;
								$liveClass = '';
								$draftClass = 'current';
								
							}
					    ?>
					<?php if($admin_user || $inhouse_writer){?>
					<section class="from-diff-users-filter clear">
					    <div class="columns left small-9">
					     <label>Show Articles From:
					     	<?php
					     		$userType_URL = $config['this_admin_url'].'articles/';

					     		if($page > 1){
					     			$userType_URL .= '?page='.$page;
					     		}else $userType_URL .= '?page=1';

					     		$order='';
					     		if (!isset($sortingMethod['order']) || strlen($sortingMethod['order']) == 0){
									if (isset($sortingMethod)) $order = $sortingMethod['articleStatus'];
								}
					     	?>
					     	<a class="<?php echo $allCurrent; ?>" href="<?php echo $userType_URL.'&sort='.$order.'&artype=' ?>">All</a> | 
						 	<a class="<?php echo $writersCurrent; ?>" href="<?php echo $userType_URL.'&sort='.$order.'&artype=writers'; ?>">Writers</a> |
						 	<a class="<?php echo $bloggersCurrent; ?>" href="<?php echo $userType_URL.'&sort='.$order.'&artype=bloggers'; ?>">Bloggers</a>
					     </label>
					    </div>
					   
					    <div class="columns left small-3 no-padding align-right">
					     <label>Status:
					     	<a class="<?php echo $liveClass; ?>" href="<?php  echo $userType_URL.'&sort=1&artype='.$artType; ?>">Live</a> | 
						 	<a class="<?php echo $draftClass; ?>" href="<?php echo $userType_URL.'&sort=3&artype='.$artType; ?>">Draft</a>
						 	<a class="<?php echo $draftClass; ?>" href="<?php echo $userType_URL.'&sort=3&artype='.$artType; ?>">Reviewed</a>
					     </label>
					    </div>
				</section>
				<?php }?>

				<section id="articles-list" class="margin-top clear">
				
 				<?php
					if($articles){ ?>
					<table class="columns small-12 no-padding">
						<thead>
						    <tr>
						      <th class="columns  mobile-12 small-12 medium-7">Article Name</th>
						      <th class="columns  small-2"><a href="<?php //echo $config['this_admin_url'].'articles/'.($page > 1) ? '?p='.$page.'&sort='.$sortDate : '?sort='.$sortDate;?>">Added</a></th>
						      <!--<th class="small-2"><a href="<?php //echo $config['this_admin_url'].'articles/'.($page > 1) ? '?p='.$page.'&sort='.$sortStatus : '?sort='.$sortStatus;?>">status</a></th>-->
						      <th  class="columns small-2">status</th>
						      <th   class="columns small-1"></th>
						    </tr>
						 </thead>
						 <tbody>
						 <?php foreach($articles as $articleInfo){

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

						//	$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/6225_tall.jpg';
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
								  	<td class="columns  small-2 padding-top-center"><?php echo $article_date_created; ?></td>
								  	<!--<td class="small-2"><?php echo $article_status; ?></td>-->
								  	<td  class="columns  small-2 padding-top-center"><?php echo $article_status ?></td>	
									<!-- REMOVE ARTICLE -->
									<td   class="columns small-1 padding-top-center">
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
											<?php }else{?>
											<!-- REQUEST TO DELETE THIS ARTICLE -->
											<a class="manage-links has-tooltip b-delete" title="If you want to delete this article please contact mpinedo@sequelmediagroup.com." href="<?php echo $articleUrl;?>" name="submit" id="submit"><i class="fa fa-times b-disable"></i></a>
											<?php }?>
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
					<p class="not-found">
						<span>Upload Articles:</span>
						Start adding your own articles to our site clicking <a href="<?php echo $config['this_admin_url']?>articles/newarticle/">HERE</a>.
					</p>
					
					<?php } ?>
			</section>

			<?php include_once($config['include_path_admin'].'pages.php'); ?>
		</section>
		</section>

		</div>
	</main>

	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>