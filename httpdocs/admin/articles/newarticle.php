<?php
	if(!$adminController->user->checkPermission('user_permission_show_add_article')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->addArticle($_POST);
			$updateStatus['arrayId'] = 'article-add-form';
			if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="article-info">
				<section class="section-bar left  border-bottom mobile-12 small-12">
					<h1 class="left">Add New Article</h1>
				</section>
				<section class="left  mobile-12 small-12 padding-top">
				<form  id="article-add-form" name="article-add-form" action="<?php echo $config['this_admin_url']; ?>articles/newarticle/" method="POST" novalidate>
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<div class="row">
					    <div class="columns">
					      	<label>Article Title<span>*</span> :
								<input type="text" name="article_title-s" id="article_title-s" placeholder="Please enter the article's title here." <?php echo ($content_provider) ? 'maxlength="40"' : ''; ?>   value="<?php if(isset($_POST['article_title-s'])) echo $_POST['article_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
					 		</label>
					    
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">
									<div class="tooltip-info">
									<p>This is the article's title that will be visible throughout the network.</p>
								</div>
							</div>
						</div>
					</div>	

					<?php if(!$content_provider){?>
					<div class="row">
					    <div class="columns">
					      	<label>Article SEO Title<span>*</span> :
								<input type="text" name="article_seo_title-s" id="article_seo_title-s" placeholder="Please enter the article's seo-formatted title here." value="<?php if(isset($_POST['article_seo_title-s'])) echo $_POST['article_seo_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />
					 		</label>
					    
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the article's title that will be used in URLs throughout the network.</p>
								</div>
							</div>
						</div>
					</div>	
					<?php }?>
					<div class="row">
					    <div class="columns">
						<label for="article_desc-s">Article Description<span>*</span> :
						<input type="text" name="article_desc-s" id="article_desc-s" placeholder="Please enter the article's description here." maxlength="150"  value="<?php if(isset($_POST['article_desc-s'])) echo $_POST['article_desc-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />
						</label>
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is a shorter description of the article that will appear throughout the site as a summy of the article.</p>
							</div>
						</div>
						</div>
					</div>	

					<?php if(!$content_provider){?>
					<div class="row">
					    <div class="columns">
						<label for="article_tags-s">Article Keywords :
						<input type="text" name="article_tags-s" id="article_tags-s" placeholder="Please enter the article's tags here." value="<?php if(isset($_POST['article_tags-s'])) echo $_POST['article_tags-s']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />
						</label>
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that will show up in search engines, social networks, etc for this article.  They should be separated with a comma.  Keywords are limited to 1500 characters.</p>
							</div>
						</div>
					</div>
					</div>	
					<?php }?>

					<div class="row padding-bottom">
					    <div class="columns">
						<label for="article_body-nf">Article Body<span>*</span> :
						<textarea  class="mceEditor" name="article_body-nf" id="article_body-nf" rows="35" required placeholder="Please enter the article's body here." ><?php if(isset($_POST['article_body-nf'])) echo $_POST['article_body-nf']; ?></textarea>
						</label>
					</div>
					</div>

					<!-- PAGE LIST -->
					<div class="row">
					    <div class="columns">
						<label for="page_list">Page List: 
						<select name="page_list_id-nf" id="page_list_id-nf">
							<option value="0">None</option>
						<?php			
							$page_lists = PageList::get();
							foreach($page_lists as $page_list){
								echo "<option value='".$page_list->page_list_id."'  >";
									echo $page_list->page_list_title;
								echo "</option>";
							}
						?>
						</select>
						</label>
					</div>
					</div>
					

					<?php
					if(!$content_provider){
						$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
						if($allContributors && count($allContributors)){
					?>
						<div class="row">
					    <div class="columns">
							<label for="article_contributor">Article Contributor<span>*</span> :
							<select name="article_contributor" id="article_contributor">
								<option value="-1">None</option>
								<?php
									foreach($allContributors as $contributorInfo){
										$option = '<option value="'.$contributorInfo['contributor_id'].'"';
										if($contributorInfo['contributor_id'] == $_POST['article_contributor']) $option .= ' selected="selected"';
										$option .= '>'.$contributorInfo['contributor_name'].'</option>';
										echo $option;
									}
								?>
							</select>
						</label>
						</div>
					</div>
					<?php } 
				}else{ ?>
					<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
				<?php } ?>

					
					<?php
						$allCategories = $MPNavigation->getAllCategoriesWithArticles();
						if($allCategories && count($allCategories)){
					?>
						<div class="row">
					    <div class="columns">
								<label class="checkbox-group-label-parent">Categories<span>*</span> : 
								<span class="p-message">Categorize your article choosing up to 4 categories. </span>
								<section class="checkbox-group-content">
								<?php
									foreach($allCategories as $category){ 
										//if(!$category['cat_is_brand']){
										$checkbox = '<div class="checkbox-group">';
											$checkbox .= '<input type="checkbox" id="category-'.$category['cat_id'].'" name="article_categories[category-'.$category['cat_id'].']"';
											if(isset($_POST['article_categories']) && isset($_POST['article_categories']['category-'.$category['cat_id']])){
												$checkbox .= ' checked="checked"';
											}
											$checkbox .= ' />';
											$checkbox .= '<label class="checkbox-label" for="category-'.$category['cat_id'].'">'.$category['cat_name'].'</label>';
										$checkbox .= '</div>';
										
										echo $checkbox;
										//}
									}
								?>
							</section>
							</label>
						</div>
					</div>
					<?php } ?>

					
					<input type="hidden" class="hidden" id="article_template_type-s" name="article_template_type-s" value="0" />

					<div class="row">
					    <div class="columns">
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form') echo $updateStatus['message']; ?>
							</p>

							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form' && $updateStatus['hasError'] !== true){ ?>
								<script type="text/javascript">
									setTimeout(function(){
										window.location = "<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $updateStatus['articleInfo'][':article_seo_title']; ?>";
									}, 2000);
								</script>
							<?php } ?>

							<button type="submit" id="submit" name="submit" class="radius">Save</button>
						</div>
					</div></div>
				</form>
				</section>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path'].'footer.php');?>
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>