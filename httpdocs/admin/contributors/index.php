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
		

		if(isset($_POST['searchcontributorinput']) && !empty($_POST['searchcontributorinput'])){
			$articleContributors = $mpArticleAdmin->getAllContributors(['sortType' => $sortId, 'limit' => 1000000, 'offset' => $offset, 'condition'=>" contributor_name like '%".$_POST['searchcontributorinput']."%'"]);
		
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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">CONTRIBUTORS</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
			<h1 class="left">Contributors</h1>
			
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="contributors-list">
				<section class="">
					<form class=" small-12" id="header-search" action="<?php echo $config['this_admin_url'].'contributors/';?>" method="POST">
							<div id="search-fieldset" class="mobile-12 small-12">
								<input type="text" value="" style="width: 82%;" class="small-8 left" placeholder="Search all" id="searchemailinput" name="searchcontributorinput">
								<button type="submit" id="searchsubmit" name="searchcontributor" class="small-2"  >SEARCH<i class="icon-search"></i></button>
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
					<label class="contributor-image contributor-table-label columns small-3" >Writer Name</label>
					<label class="contributor-info contributor-table-label columns small-3">Email</label>
					<label class="contributor-info contributor-table-label columns small-2">Level</label>
					<label class="contributor-info contributor-table-label columns small-4"></label>
				</div>
				
				<?php
					foreach($articleContributors as $contributorInfo){
						$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image']);
						$pathToImage = $config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo["contributor_id"].'_contributor.'.$ext;

						if(file_exists($pathToImage)){
							$imageUrl = 'http://images.puckermob.com/articlesites/contributors_redesign/'.$contributorInfo['contributor_id'].'_contributor.jpg';
							//http://images.puckermob.com/articlesites/contributors_redesign/2431_contributor.jpg
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
						if($contributor_type) $contributor_type = $contributor_type ["user_type"];
						?>
											
						<div class="admin-contributor row clear padding-bottom">
							<div class="contributor-image columns small-1">
								<a href="<?php echo $config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name']?>" >
									<img src="<?php echo $imageUrl; ?>" alt="<?php echo $contributorInfo['contributor_name']; ?>" />
								</a>
							</div>
							<div class="contributor-info columns small-2">
								<h2 class="left">
									<a href="<?php echo $config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name']; ?>">
										<?php echo $contributorInfo['contributor_name'];?>
									</a>
								</h2>
							</div>
							<div class="contributor-info columns small-3">
								<p><?php echo $contributorInfo['contributor_email_address'] ?></p>
							</div>
							<div class="contributor-info columns small-2 align-center">
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
								}
								?>
								<input <?php echo $disabled; ?> class="mob-level" type="button" value ="<?php echo $label_level; ?>" data-info-level= "<?php echo $contributor_type; ?>"/>
							</div>

							<div class="contributor-links right small-4" >
								<a class="manage-links" href="<?php echo $config['this_admin_url'].'contributors/edit/'.$contributorInfo['contributor_seo_name']; ?>" id="edit"><i class="fa fa-pencil-square-o"></i>Edit</a>
								<a class="manage-links" href="<?php echo $config['this_admin_url'].'dashboard/contributor/'.$contributorInfo['contributor_seo_name'];?>" ><i class="fa fa-bar-chart"></i> Earnings</a>
							</div>

						</div><hr style="margin: 0.2rem 0 0.6rem 0;">
					<?php } ?>
			</section>

			<?php  include_once($config['include_path_admin'].'pages.php');?>
		</div>
	</main>
		
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>

</body>
</html>