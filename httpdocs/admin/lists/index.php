<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_lists')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				//	Edit List
				case isset($_POST['article-delete-form']): //Delete Article
					$updateStatus = array_merge($adminController->deleteArticleById($_POST['formData']));	
					break;

				//	Add List
				case isset($_POST['page_list_title']):
					$_POST['page_list_seo_title'] = PageList::generate_name($_POST['page_list_seo_title'], 'seoname');
					$page_list = new PageList;
					$updateStatus = $page_list->create($_POST);
					break;
			}
		}else $adminController->redirectTo('logout/');
	}
// for the new Pagination class - we only need 3 bits of info...
// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
// // 2. records per page ($per_page)
	$per_page = 15;
	$limit=15;
	$post_date = 'all';
	$articleStatus = '1,2,3';
	$userArticlesFilter = $userData['user_email'];
	$order = '';
	$filterLabel = 'Most Recent';
// Sorting information
	if (isset($_GET['sort'])) {
		$sortingMethod = $mpArticleAdmin->getSortOrder($_GET['sort']);

		$articleStatus = $sortingMethod['articleStatus'];
		$filterLabel = $sortingMethod['filterLabel'];
		$order = $sortingMethod['order'];
	}
	// if (isset($_GET['category'])) {$category = $_GET['category'];}
	if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
	if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}
	if ($userData['user_permission_show_other_user_articles'] == 1){
		$userArticlesFilter = 'all';
	}
// 3. total record count ($total_count)	
	$total_count = PageList::count_all();
	$pagination = new Pagination($page, $per_page, $total_count);
	$offset = $pagination->offset();
	$page_lists = PageList::get_filtered($limit, $order, $offset);
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
			<section id="articles-list">
				<header class="section-bar">
					<h2 class="left">Lists</h2>

				</header>

				<div id="admin-add-new-list" class="admin-add-new">
					<div>
						<div class="btn-wrapper list-button" style="text-align: left;">
							<button id="add-new-toggle-button" class="toggle-link">Add New List</button>
						</div>
					</div>
					<div id="add-list-form" class="" style="display: none;">
						<form  class="non-ajax-submit-form" id="page-list-data-form" name="page-list-data-form" action="<?php echo $config['this_admin_url']; ?>lists/index.php" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

							<fieldset>
								<label for="page-list-title">List Title<span>*</span> :</label>
								<input type="text" name="page_list_title" id="page_list_title" placeholder="Please enter the lists's title here." value="" required />

								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>This is the lists's title that will be visible throughout the network.</p>
									</div>
								</div>
							</fieldset>

							<fieldset>
								<label for="page_list_seo_title">List SEO Title<span>*</span> :</label>
								<input type="text" name="page_list_seo_title" id="page_list_seo_title" placeholder="Please enter the article's seo-formatted title here." value="" required />

								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>This is the lists's seo title that will be used in URLs.</p>
									</div>
								</div>
							</fieldset>

							<fieldset>
								<label for="page_list_desc">List Description<span>*</span> :</label>
								<textarea name="page_list_desc" id="page_list_desc" rows="4" required placeholder="Please enter the list's description here." ></textarea>
								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>This is the list's description.</p>
									</div>
								</div>
							</fieldset>

							<fieldset>
								<div class="btn-wrapper list-button">
									<p class="result <?php if(isset($updateStatus['arrayId']) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
										<?php if(isset($updateStatus['arrayId']) && $updateStatus['arrayId'] == 'article-info-form') echo $updateStatus['message']; ?>
									</p>
									
									<button type="submit" id="submit" name="submit">Add List</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>

 				<?php
					if(isset($page_lists) && $page_lists){
						foreach($page_lists as $page_list){
							if(isset($page_list) && $page_list){
								$listUrl = $config['this_admin_url'].'lists/edit/'.$page_list->page_list_seo_title;
								$list = '<div class="admin-article" id="'.$page_list->page_list_id.'">';
									$list_items = PageListItem::get_all_by_page_list_id($page_list->page_list_id);
										$list .= '<div>';
											$list .= '<h2><a href="'.$listUrl.'" class="orange-link" name="Add List Items" title="Add List Items">'.$page_list->page_list_title.'</a></h2>';
											$list .= '<ul class="page-list-inline">';
											if(isset($list_items) && !empty($list_items)){
												foreach($list_items as $list_item){
													if (!empty($list_item->page_list_item_image)){
														$imageUrl = $config['image_url'].'articlesites/puckermob/list/'.$list_item->page_list_item_image;
													} else {
														$imageUrl = $config['image_url'].'articlesites/puckermob/list/placeholder.png';
													}
													
													$list .= '<li>';
														$list .= '<img src="'.$imageUrl.'" alt="'.$list_item->page_list_item_title.' Preview Image" />';
														$list .= '<p>'.$mpHelpers->truncate($list_item->page_list_item_title, 20).'</p>';
													$list .= '</li>';
												}
											} else {
												//	The list has no items yet
												$list .= '<p class="page-list-none">';
												$list .= 'This has no list items yet.  <a href="'.$listUrl.'" class="orange-link" name="Add List Items" title="Add List Items">CLICK HERE</a> to add items to this list!';
												$list .= '</p>';
											}
											$list .= '</ul>';
										$list .= '</div>';
										if(isset($page_list->page_list_item_image)){
											$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/list/'.$page_list->page_list_item_image;
										}
								echo $list;
							}
				?>
 							<form class="list-delete-form" id="list-delete-form" name="list-delete-form" action="<?php echo $config['this_admin_url']; ?>lists/index.php" method="POST">
								<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
								<input type="text" class="hidden" id="page_list_id" name="page_list_id" value="<?php echo $page_list->page_list_id; ?>" />
								<div class="btn-wrapper delete list-button">
									<a href="<?php echo $listUrl; ?>" class="list-button"><button name="edit" id="edit" type="button">Edit</button></a>
									<button class="b-delete" name="submit" id="submit" type="submit" data-info="<?php echo $page_list->page_list_id; ?>">Delete</button>
								</div>
							</form>
						</div>

<?php
						} // end foreach

					//	No lists have been created...	
					} else { echo "<p>Sorry, no lists were found!</p>"; } 
?>



			</section>

			<?php include_once($config['include_path_admin'].'pages.php'); ?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>