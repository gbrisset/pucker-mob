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

	//Verify if is a content provider user
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
		$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
		$contributorInfo = $contributorInfo[0];
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

		<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		<div id="content" class="columns small-9 large-11">
			<section id="article-info">

				<h1>List Information</h1>
			
				<div id="admin-add-new-list" class="row admin-add-new">
					<div id="add-list-form" class="">
						<form  class="non-ajax-submit-form" id="page-list-data-form" name="page-list-data-form" action="<?php echo $config['this_admin_url']; ?>lists/index.php" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

							<div class="row">
					    <div class="large-12 columns  padding-bottom">
					      <label>Title
								<input type="text" name="page_list_title" id="page_list_title" placeholder="Please enter the lists's title here." value="" required />
					      </label>
					    </div>
				  	</div>
				  	<div class="row">
					    <div class="large-12 columns  padding-bottom">
					      <label>SEO Title
								<input type="text" name="page_list_seo_title" id="page_list_seo_title" placeholder="Please enter the article's seo-formatted title here." value="" required />
					      </label>
					    </div>
				  	</div>
					<div class="row">
					    <div class="large-12 columns  padding-bottom">
					      <label>Description
								<textarea name="page_list_desc" id="page_list_desc" rows="10" placeholder="Please enter the list's description here." ></textarea>
					    </div>
				  	</div>
				  	<div class="row">
					    <div class="large-12 columns">
					     	<div class="btn-wrapper list-button right-aligned" >
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo $updateStatus['message']; ?>
								</p>
								
								<button type="submit" id="submit" name="submit">SAVE</button>
							</div>
						</div>
				  	</div>

						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>