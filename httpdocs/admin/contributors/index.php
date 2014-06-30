<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_contributors')) $adminController->redirectTo('noaccess/');

	$sortId = $mpShared->getSort(isset($_GET['sort']) ? $_GET['sort'] : '');

	$article_sort_by = "mr";
	if(isset($_GET['sort'])) $article_sort_by = $_GET['sort'];
	
	// for the new Pagination class - we only need 3 bits of info...
	// 1. the current page number ($current_page)
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		
	// 2. records per page ($per_page)
		$per_page = 10;
		$order="";
		$limit=10;
		$category = '';
		$post_date = 'all';
		$visible = '';
		if (isset($_GET['category'])) {$category = $_GET['category'];}
		if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
		if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}

	// 3. total record count ($total_count)	
		$total_count = $mpArticle->count_all_contributors();
		$pagination = new Pagination($page, $per_page, $total_count);
		$offset = $pagination->offset();
		$articleContributors = $mpArticleAdmin->getAllContributors(['sortType' => $sortId, 'limit' => $limit, 'offset' => $offset]);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>

	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content">
			<section id="contributors-list">
				<header class="section-bar">
					<h2 class="left">Contributors</h2>

					<div id="right">
						<div id="sort-by">
							<input type="hidden" value="<?php echo $article_sort_by; ?>" id="sort-by-value" />
							<label>Sort By: </label>
							<ul>
								<?php
									$dropDownOmits = [2, 3, 4, 5];
									foreach($mpArticleAdmin->dropDownInfo as $dropDownObj){
										if(in_array($dropDownObj['id'], $dropDownOmits)) continue;
										$li = '<li>';
											$li .= '<a data-info="'.$dropDownObj['shortname'].'" href="'.$config['this_admin_url'].'contributors/';
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
				</header>

				<?php
					foreach($articleContributors as $contributorInfo){
						$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image']);
						$pathToImage = $config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo["contributor_id"].'_contributor.'.$ext;

						if(file_exists($pathToImage)){
							$imageUrl = $config['image_url'].'articlesites/contributors_redesign/'.$contributorInfo["contributor_id"].'_contributor.'.$ext;
						} elseif(!empty($contributorInfo['contributor_image']) && !file_exists($pathToImage)){
							$imageUrl = '';
						} else {
							$imageUrl = $config['image_url'].'/articlesites/sharedimages/default_profile_contributor.png';
						}
						
						$contributor = '<div class="admin-contributor">';
								$contributor .= '<div class="contributor-image">';
									$contributor .= '<a href="'.$config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name'].'">';
										$contributor .= '<img src="';
										$contributor .= $imageUrl.'" alt="'.$contributorInfo['contributor_name'].' Image" />';
									$contributor .= '</a>';
								$contributor .= '</div>';
							
							$contributor .= '<div class="contributor-info">';
								$contributor .= '<h2><a href="'.$config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name'].'">'.$contributorInfo['contributor_name'].'</a></h2>';
								$bio = utf8_encode(trim(strip_tags($contributorInfo['contributor_bio'])));
								$bio = (strlen($bio) > 90) ? substr($bio, 0, 90).'...' : $bio;
								$contributor .= '<p>'.$bio.'</p>';
								$contributor .= '<a href="'.$config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name'].'" id="edit"><i class="icon-edit"></i>Edit</a>';
							$contributor .= '</div>';

						$contributor .= '</div>';
						echo $contributor;
					}
				?>
			</section>

			<?php  include_once($config['include_path_admin'].'pages.php');?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>