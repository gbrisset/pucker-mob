<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_contributors')) $adminController->redirectTo('noaccess/');

	$sortId = $mpShared->getSort(isset($_GET['sort']) ? $_GET['sort'] : '');

	$byname = '';
	$bynewest = 'current';

	if(isset($_GET['sort'])){
		$bynewest = '';
		if($_GET['sort'] == 'mr') $bynewest = 'current';
		else $byname = 'current';
	}

	$article_sort_by = "mr";
	if(isset($_GET['sort'])) $article_sort_by = $_GET['sort'];
	
	// for the new Pagination class - we only need 3 bits of info...
	// 1. the current page number ($current_page)
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		
	// 2. records per page ($per_page)
		$per_page = 50;
		$order="";
		$limit=50;
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
		
		if(isset($_POST['searchcontributorinput']) && !empty($_POST['searchcontributorinput'])){
			
			$offset = 0;
			$articleContributors = $mpArticleAdmin->getAllContributors(['sortType' => $sortId, 'limit' => 1000000, 'offset' => $offset, 'condition'=>" contributor_name like '%".$_POST['searchcontributorinput']."%'"]);
			$total_count = count($articleContributors);
			$pagination = new Pagination($page, $per_page, $total_count);
			$offset = $pagination->offset();	

		}else{
			$articleContributors = $mpArticleAdmin->getAllContributors(['sortType' => $sortId, 'limit' => $limit, 'offset' => $offset]);
		}

		$ManageDashboard = new ManageAdminDashboard( $config );
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
			<section id="contributors-list">
				<section class="">
					<form class=" small-12" id="header-search" action="<?php echo $config['this_admin_url'].'contributors/';?>" method="POST">
								<div id="search-fieldset" class="small-12 large-11 columns no-padding">
							<input type="text" value="" class="small-11 columns " placeholder="Search all" id="searchemailinput" name="searchcontributorinput">
							<button type="submit" id="searchsubmit" name="searchcontributor" class="small-2 large-1 columns "  ><i class="fa fa-search"></i></button>
						</div>
					</form>
				</section>
				<section class="section-bar left mobile-12 small-12 margin-bottom">
					<div id="right">
						<div id="sort-by-contr" class="from-diff-users-filter  no-vertical-padding">
							<input type="hidden" value="<?php echo $article_sort_by; ?>" id="sort-by-value" />
							<label>Sort By:
						     	<a class="<?php echo $bynewest; ?> " href="<?php echo $config['this_admin_url'].'contributors/?sort=mr'; ?>">Newest</a> |
							 	<a class="<?php echo $byname; ?> " href="<?php echo $config['this_admin_url'].'contributors/?sort=az'; ?>">Name</a>
					     	</label>
						</div>
					</div>
				</section>

				<div class="admin-contributor left small-12 padding-bottom admin-contributor-label">
				    <label class="contributor-info columns small-1 hide-small">IMAGE</label>
					<label class="contributor-info columns small-2">NAME</label>
					<label class="contributor-info columns small-4 hide-small">EMAIL</label>
					<label class="contributor-info columns small-1 hide-small">LEVEL</label>
					<label class="contributor-info columns small-1 hide-small">DATE</label>
					<label class="contributor-info columns small-3"></label>
				</div>
				
				<?php
					foreach($articleContributors as $contributorInfo){
						$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image']);
						$pathToImage = $config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo["contributor_id"].'_contributor.'.$ext;

						if(file_exists($pathToImage)){
							$imageUrl = 'http://images.puckermob.com/articlesites/contributors_redesign/'.$contributorInfo['contributor_id'].'_contributor.jpg';
						
						} elseif(!empty($contributorInfo['contributor_image']) && !file_exists($pathToImage)){
							if(count(explode('graph.facebook.com', $contributorInfo['contributor_image'])) > 1 )
								$imageUrl = $contributorInfo['contributor_image'];
							else
								$imageUrl = 'http://images.puckermob.com/articlesites/contributors_redesign/'.$contributorInfo['contributor_image'];
						} else {
							$imageUrl = 'http://images.puckermob.com/articlesites/contributors_redesign/pm_avatars_1.png';
						} 

						$earnings = $ManageDashboard->getContributorEarningsInfo($contributorInfo['contributor_id']);
						$contributor_type = $adminController->getContributorUserType($contributorInfo['contributor_id']);
						$date_created = date_format(date_create($contributorInfo['creation_date']), 'm/d/y');
						
                         
						if($contributor_type) $contributor_type = $contributor_type ["user_type"];
						?>
											
						<div class="admin-contributor small-12 columns no-padding padding-bottom">
							<div class="contributor-image columns small-1 no-padding-left hide-small">
								<a href="<?php echo $config['this_admin_url'].'profile/user/'.$contributorInfo['contributor_seo_name']?>" >
									<img src="<?php echo $imageUrl; ?>" alt="<?php echo $contributorInfo['contributor_name']; ?>" style= "max-width: 50px;" />
								</a>
							</div>
							<div class="contributor-info columns small-2">
								<h2 class="left">
									<a href="<?php echo $config['this_admin_url'].'profile/user/'.$contributorInfo['contributor_seo_name']; ?>" style="margin-top: 5px;">
										<?php echo $contributorInfo['contributor_name'];?>
									</a>
								</h2>
							</div>
							<div class="contributor-info columns small-4 hide-small">
								<label style="margin-right:200px; margin-top: 10px;"><?php echo $contributorInfo['contributor_email_address'] ?></label>
							</div>
							<div class="contributor-info columns small-1 no-margin hide-small">
								<?php 
								$disabled = "";
								switch ($contributor_type){
									case 3:
									case 4:
									case 5: 
										$label_level  = "BASIC";
										$disabled = "";
										break;

									case 8:
										$label_level  = "PRO";
										$disabled = "";
										break;

									case 1:
									case 2: 
									case 6:
									case 7:
										$label_level  = "WRITER";
										$disabled = "disabled";
										break;
									default: 
										$label_level = "STARTER";
										break;
								}
								?>
								<input <?php echo $disabled; ?> class="mob-level mob-level-contributor no-margin" type="button" value ="<?php echo $label_level; ?>" data-info-user-email = "<?php echo $contributorInfo['contributor_email_address']; ?>"data-info-level= "<?php echo $contributor_type; ?>" />
							</div>
							<div class="contributor-links columns small-1 hide-small" style="text-align: left; padding: 0;">
								<label style="font-size:12px; margin-top: 5px;"><?php echo $date_created;?></label>
							</div>

							<div class="contributor-links columns small-5 large-3" >
								<a class="manage-links" href="<?php echo $config['this_admin_url'].'profile/edit/'.$contributorInfo['contributor_seo_name'].'/#contributor-delete-form'; ?>" id="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
								<a class="manage-links" href="<?php echo $config['this_admin_url'].'profile/edit/'.$contributorInfo['contributor_seo_name']; ?>" id="edit"><i class="fa fa-pencil-square-o"></i></a>
								<a class="manage-links" href="<?php echo $config['this_admin_url'].'earnings/'.$contributorInfo['contributor_seo_name'];?>" ><i class="fa fa-bar-chart"></i></a>
							</div>

							

						</div>
						<hr style="margin: 0.2rem 0 0.6rem 0;">
					<?php } ?>
					</div>
			</section>

			<?php  include_once($config['include_path_admin'].'pages.php');?>
		</div>
	</main>
		
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>

</body>
</html>