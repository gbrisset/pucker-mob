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
	$per_page = 40;
	$limit=40;
	$post_date = 'all';

	$articleStatus = '1';
	if($adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 8  || $adminController->user->data['user_type'] == 9  || $adminController->user->data['user_type'] == 2 || $adminController->user->data['user_type'] == 30){
		$articleStatus = '1, 2, 3';
	}
	

	$artType = '';
	$allCurrent = 'current';
	$writersCurrent = $bloggersCurrent = '';
	
	if(  isset($_GET['artype']) && $_GET['artype']){
		$allCurrent = '';
		$artType = $_GET["artype"];
		if($artType === "bloggers") $bloggersCurrent = 'current';
		elseif($artType === "writers")  $writersCurrent = 'current';
	}

	$sortType = '';
	$allSort = 'current';
	$liveCurrent = $draftCurrent = $pendingCurrent= '';
	
	if(  isset($_GET['sort']) && $_GET['sort']){
		$allSort = '';
		$sortType = $_GET["sort"];
		if($sortType === "3") $draftCurrent = 'current';
		elseif($sortType === "1")  $liveCurrent = 'current';
		elseif($sortType === "2")  $pendingCurrent = 'current';

	}

	$userArticlesFilter = $userData['user_email'];
	$order = '';
	// Sorting information
	$article_sort_by = "mr";
	if (isset($_GET['sort'])) {
		$sortingMethod = $mpArticleAdmin->getSortOrder($_GET['sort']);
		$articleStatus = $sortingMethod['articleStatus'];
		$order = $sortingMethod['order'];
		$article_sort_by = $_GET['sort'];
	}


	if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
	if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}
	if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
		$userArticlesFilter = 'all';
	}
// 3. total record count ($total_count)	
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter, $artType));
	$pagination = new Pagination($page, $per_page, $total_count);	
	$offset = $pagination->offset();


	//GET ALL ARTICLES BASE ON THE FILTER BY STATUS, USERTYPE, ETC...
	$articles = $mpArticle->get_filtered($limit, $order, $articleStatus, $userArticlesFilter, $offset, $artType);
	$arr_ids = [];
	foreach($articles as $article){
		$arr_ids[] = $article['article_id'];
	}

	//IMPLODE ALL THE IDS FOR EACH ARTICLE ON THE CURRENT INDEX PAGE.
	$comma_separated = implode(",", $arr_ids);

	//GET USA PAGEVIEWS FOR EACH ARTICLE ON THE LIST
	$usa_pageview_list = $mpArticle->getTotalUsPageviews( $comma_separated );
	$pageviews_list = [];
	if($usa_pageview_list){
		foreach($usa_pageview_list as $key=>$value){
			$pageviews_list[$value['article_id']] =$value['total_usa_pv'];
		}
	}
	$promoteArticles = new PromoteArticles();
	$fb_pages = $promoteArticles->getAllFacebookPages();
	//var_dump($fb_pages); die;

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body>
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>View & Edit Articles</h1>
			</div>
			
			<section id="edit-articles">
				<!-- ARTICLES RESUME INFO --> 
				<?php include_once($config['include_path_admin'].'view_articles_resume.php'); ?>
				
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
					
				<div class="small-12 xxlarge-9 columns no-padding">
						<section id="articles-list" class="columns margin-top no-padding">
						<div class="" id="view-articles-legend">
							<label><i class="fa fa-lock" aria-hidden="true"></i>: Article Locked. Click to request access</label>
							<label><i class="fa fa-external-link" aria-hidden="true"></i>: View article.</label>
						</div>
						
						<?php
							if(isset( $articles) && $articles ){ ?>

							<?php include_once($config['include_path_admin'].'statuses-mobile.php'); ?>

							<table class="columns small-12 no-padding">
								<thead>
								    <tr>
								       <th width="400" class="align-left">Title</th>
								       <th width="100" class="show-for-large-up">Added</th>
								       <?php if($admin_user){?>
								       		<th width="100" class="show-for-large-up">Promotion</th>
									   <?php }?>
								       <th width="100"  class="show-for-large-up">status</th>
								       <th width="70" class="show-for-xlarge-up">U.S. Traffic</th>
								       <th width="30" class="show-for-xlarge-up">EDIT?</th>
								       <th  width="50" class="show-for-large-up"></th>
								    </tr>
								</thead>
								
								<tbody>
								 <?php foreach($articles as $articleInfo){
								 	$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo['article_seo_title'];

									$articleExternalUrl = $config['this_url'].$articleInfo['cat_dir_name'].'/'.$articleInfo['article_seo_title'];
									$article_id = $articleInfo["article_id"];
									$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/tall/'.$articleInfo["article_id"].'_tall');
									$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
									$article_title = $articleInfo['article_title'];
									$article_status = (isset($articleInfo["article_status"])) ? MPArticleAdmin::displayArticleStatus($articleInfo["article_status"]) : '';
									$article_date_created =  date_format(date_create($articleInfo['creation_date']), 'm/d/y');
									$article_us_traffic = 0;
									$contributor_name = $articleInfo['contributor_name'];
									$contributor_seo_name = $articleInfo['contributor_seo_name'];
									$user_id = $articleInfo['user_id'];
									$edits = $articleInfo['article_agree_edits'];
									$article_locked = ( $edits == 1 && $articleInfo['article_status'] == 1);

									if(isset($pageviews_list[$article_id])){
								    	$article_us_traffic = $pageviews_list[$article_id];
									}

									if(file_exists($pathToImage)){
										$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo["article_id"].'_tall.jpg';
									} else {
										$imageUrl = 'http://cdn.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg';
									}
									?>
									<tr id="<?php echo 'article-'.$article_id; ?>">
									  	<td class="border-right">
									  		<div class=" large-2 columns no-padding-left show-for-large-up">
									  			
												<a href="<?php echo $articleUrl; ?>">
													<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
												</a>
										
											</div>
											<div class="large-7 columns no-padding" style="display: table-caption">
												
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
											<div class="small-3 columns align-right" id="article-list-table-legend">
												<?php if( $article_locked ){ ?>
												<label class="inline">
													<a  id="unlock-article" data-status-lock="<?php echo $edits; ?>">
														<i class="fa fa-lock" aria-hidden="true"></i>
													</a>
												</label>
												<?php }?>
												
												<?php if($articleInfo["article_status"] == 1 ){?>
												<label class="inline"><a href="<?php echo $articleExternalUrl; ?>" target="_blank" class="main-color" id="view-article-link"><i class="fa fa-external-link" aria-hidden="true"></i></a></label>
												<?php } ?>
											</div>
									  	</td>
									  	<!-- DATE ADDED -->
									  	<td class="show-for-large-up  border-right">
									  		<label><?php echo $article_date_created; ?></label>
									  	</td>
									  	
									  	<!-- PROMOTE PAGE LIST -->
									  	<?php if( $admin_user ){ ?>
									  	<td class="show-for-large-up  border-right">
									  		<label data-info="<?php echo $article_id; ?>" data-user-id="<?php echo $user_id; ?>" data-title="<?php echo $article_title; ?>" >
									  			<select class="facebook-sites">
									  				<option value = '0' >NONE</option>
									  				<?php foreach( $fb_pages as $page ){
									  					$isPromotedObj = $promoteArticles->promotedInfo($article_id);
									  					$facebook_page_id_promoted = isset($isPromotedObj[0]) ? $isPromotedObj[0]->facebook_page_id : 0;
									  					?>
									  						<option value = "<?php echo $page->facebook_page_id; ?>" <?php if($facebook_page_id_promoted == $page->facebook_page_id) echo ' selected '; ?> >
										  						<?php echo $page->facebook_page_name; ?>
										  					</option>
									  				<?php }?>
									  			</select>
									  		</label>
									  	</td>
									  	<?php } ?>
									  	
									  	<!-- ARTICLE STATUS -->
									  	<td class="show-for-large-up  border-right"><label><?php echo $article_status ?></label></td>	
										
										<!-- ARTICLE TRAFFIC -->
										<td class="show-for-xlarge-up  border-right" ><label><?php echo $article_us_traffic; ?></label></td>

										<!-- ARTICLE EDITS ALLOW ?-->
										<td  class="show-for-xlarge-up  border-right">
											<?php if( $article_locked ){ ?>
												<i class="fa fa-circle" style="color: #23ab23; font-size: 150%;" aria-hidden="true"></i>
											<?php }else{?>
												<i class="fa fa-circle " style="color:red; font-size: 150%;" aria-hidden="true"></i>
											<?php }?>
										</td>
										
										<!-- DELETE ARTICLE FORM -->
										<td class="show-for-large-up no-border-right valign-middle">
											<?php if( $admin_user || ( $blogger && !$article_locked ) ){?>
												<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="<?php echo $config['this_admin_url'].'articles/index.php';?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf'];?>" >
													<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $article_id;?>" />
													<a class="manage-links" href="<?php echo $articleUrl;?>" class="b-delete" name="submit" id="submit"><i class="fa fa-times"></i></a>
												</form>
											<?php }else{?>
												<?php //if($articleInfo["article_status"] != 1 ){?>
												<!--<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="<?php echo $config['this_admin_url'].'articles/index.php';?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf'];?>" >
													<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $article_id;?>" />
													<a class="manage-links" href="<?php echo $articleUrl;?>" class="b-delete" name="submit" id="submit"><i class="fa fa-times"></i></a>
												</form>-->
												<?php //}else{ ?>
													<!-- REQUEST TO DELETE THIS ARTICLE -->
													<a class="manage-links has-tooltip b-delete" title="If you want to delete this article please contact mpinedo@sequelmediainternational.com." href="<?php echo $articleUrl;?>" name="submit" id="submit"><i class="fa fa-times b-disable"></i></a>
												<?php //} ?>
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
				</div>
					
				<div class="small-12 xxlarge-3 right padding" >
					<?php include_once($config['include_path_admin'].'statuses.php'); ?>
					<?php include_once($config['include_path_admin'].'filter_by_usertype.php'); ?>

					<div class="small-12 columns show-for-large-up half-margin-top no-padding">
						<?php include_once($config['include_path_admin'].'hottopics.php'); ?>
					</div>
				</div>
		</section>

		</div>
	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>