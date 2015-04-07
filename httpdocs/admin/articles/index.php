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

	$artType = 'all';
	$allCurrent = 'current';
	$writersCurrent = $bloggersCurrent = '';
	if($_GET['artype']){
		$allCurrent = '';
		$artType = $_GET["artype"];
		//var_dump($artType);
		if($artType === "bloggers") $bloggersCurrent = 'current';
		elseif($artType === "writers")  $writersCurrent = 'current';
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
				<?php if($admin_user){?>
					<section class="from-diff-users-filter clear">
					    <div class="columns">
					     <label>Show Articles From:
					     	<a class="<?php echo $allCurrent; ?>" href="<?php echo $config['this_admin_url'].'articles/'; ?>">All</a> | 
						 	<a class="<?php echo $writersCurrent; ?>" href="<?php echo $config['this_admin_url'].'articles/?artype=writers'; ?>">Writers</a> |
						 	<a class="<?php echo $bloggersCurrent; ?>" href="<?php echo $config['this_admin_url'].'articles/?artype=bloggers'; ?>">Bloggers</a>
					     </label>
					    </div>
				</section>
				<?php }?>

				<section id="articles-list" class="margin-top clear">
					<!--<section class="section-bar left  border-bottom mobile-12 small-12">
					
					<div id="right" class="small-9 padding-top right">
						<div id="sort-by">
							<input type="hidden" value="<?php echo $article_sort_by; ?>" id="sort-by-value" />
							<label class="left">Sort By: </label>
							<ul class="right">
								<?php
									$dropDownOmits = [6];
									foreach($mpArticleAdmin->dropDownInfo as $dropDownObj){
										if(in_array($dropDownObj['id'], $dropDownOmits)) continue;
										$li = '<li>';
											$li .= '<a data-info="'.$dropDownObj['shortname'].'" href="'.$config['this_admin_url'].'articles/';
											$li .= ($page > 1) ? '?p='.$page.'&sort='.$dropDownObj['shortname'] : '?sort='.$dropDownObj['shortname'];
											$li .= '">';
												$li .= $dropDownObj['label'];
											$li .= '</a>';
										$li .= '</li>';
										echo $li;
									}
								?>
							</ul>
						</div>
					</div>
				</section>-->
 				<?php
					if($articles){
						//if(isset($_GET['sort'])){
							$sort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
						
							if( $sort == 'az') $sortName = 'za'; else $sortName = 'az';
							$sortDate = 'mr';
							if( $sort == 2) $sortStatus = 3; else $sortStatus = 2;
						//}
						?>
					<table>
						<thead>
						    <tr>
						      <th class="mobile-12 small-12"><a href="<?php echo $config['this_admin_url'].'articles/'.($page > 1) ? '?p='.$page.'&sort='.$sortName : '?sort='.$sortName;?>">Article Name</a></th>
						      <th class="small-2"><a href="<?php echo $config['this_admin_url'].'articles/'.($page > 1) ? '?p='.$page.'&sort='.$sortDate : '?sort='.$sortDate;?>">Added</a></th>
						      <th class="small-2"><a href="<?php echo $config['this_admin_url'].'articles/'.($page > 1) ? '?p='.$page.'&sort='.$sortStatus : '?sort='.$sortStatus;?>">status</a></th>
						      <th class="small-2">COMM</th>
						      <th>SHARES</th>
						      <th></th>
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
							//$article_date_created =  $articleInfo['creation_date'];

							if(file_exists($pathToImage)){
								$imageUrl = $config['image_url'].'articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
							} else {
								$imageUrl = $config['image_url'].'/articlesites/sharedimages/puckermob-default-image.jpg';
							}

							//$imageUrl = 'http://localhost:8888/projects/pucker-mob//subdomains/images/httpdocs/articlesites/puckermob/square/3855_tall.jpg';
							?>
								<tr id="<?php echo 'article-'.$article_id; ?>">
								  	<td class="mobile-12 small-12">
								  		<div class="article-image mobile-1 small-1">
											<a href="<?php echo $articleUrl; ?>">
												<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
											</a>
										</div>
										<h2><a href="<?php echo $articleUrl; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article_title)), 40); ?></a></h2>
								  	</td>
								  	<td class="small-2"><?php echo $article_date_created; ?></td>
								  	<td class="small-2"><?php echo $article_status; ?></td>
								  	<td>--</td>
								  	<td>--</td>	
									<!-- REMOVE ARTICLE -->
									<td>
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