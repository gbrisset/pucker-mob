<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_category')) $adminController->redirectTo('noaccess/');
	
	$categoryInfo = null;

	foreach($MPNavigation->categories as $category){
		if( isset($category['cat_dir_name'])&& isset($uri[2]) && ($category['cat_dir_name'] == $uri[2])  ){
			$categoryInfo = $category;
			break;
		}
	}

	if(is_null($categoryInfo)) $mpShared->get404();

	$categoryInfo = $mpArticleAdmin->getFullCategoryInfo($categoryInfo);

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['category_page_name-s']):
					$updateStatus = array_merge($mpArticleAdmin->updateCategoryInfo($_POST), ['arrayId' => 'category-info-form']);
					$categoryInfo = $mpArticleAdmin->getFullCategoryInfo($categoryInfo);
					break;
				case isset($_POST['article_category_page_featured_article']):
					$updateStatus = array_merge($mpArticleAdmin->updateCategoryFeautedArticle($_POST), ['arrayId' => 'category-featured-article-form']);
					break;
				case isset($_POST['category-featured-article-form']): //DropDown Featured Article
					$updateStatus = array_merge($mpArticleAdmin->updateCategoryFeautedArticle($_POST['formData']));
					break;
				case isset($_POST['category-slideshow-article-form']): //SlideShow Articles
					$updateStatus = array_merge($mpArticleAdmin->insertCategorySlideshowArticles($_POST['formData']));
					break;
				case isset($_POST['category-slideshow-delete']): //Delete Article Slideshow Functionality
					$updateStatus = array_merge($mpArticleAdmin->deleteCatgorySlideshowArticles($_POST['formData']));	
					break;
			}
		}else $adminController->redirectTo('logout/');
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

	<div id="main-cont" class="edit-category">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class = 'categories'>
			<section id="category-info">
				<header class="section-bar">
					<h2>Category Information</h2>
				</header>

				<form class="ajax-submit-form" id="category-info-form" name="category-info-form" action="<?php echo $config['this_admin_url']; ?>categories/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $categoryInfo['cat_id']; ?>" />
					
					<fieldset>
						<label for="cat_name-s">Category Name<span>*</span> :</label>
						<input type="text" name="cat_name-s" id="cat_name-s" placeholder="Please enter the full category name here." value="<?php if(isset($categoryInfo['cat_name'])) echo $categoryInfo['cat_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'cat_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the category name that will show up in search engines, page titles, etc.  It can be longer and more descriptive than the 'visible category name'.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="cat_tags-s">Category Keywords :</label>
						<input type="text" name="cat_tags-s" id="cat_tags-s" placeholder="Please enter the category's tags here." value="<?php if(isset($categoryInfo['cat_tags'])) echo $categoryInfo['cat_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'cat_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that will show up in search engines, social networks, etc.  They should be separated with a comma.  Keywords are limited to 1500 characters.</p>
							</div>
						</div>
					</fieldset>


					<fieldset>
						<label for="category_header_slider_title-s">Category SlideShow Title :</label>
						<input type="text" name="category_header_slider_title-s" id="category_header_slider_title-s" placeholder="Please enter the category's slideshow header title" value="<?php if(isset($categoryInfo['category_header_slider_title'])) echo $categoryInfo['category_header_slider_title']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'category_header_slider_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These is the title that will show at the top of the slideshow.  This should be limit to no more than 50 characters.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">SlideShow Status :</label>

						<input type="radio" name="category_slider_live-s" id="slideshow_live_live" value="1" <?php if(isset($categoryInfo['category_slider_live']) && $categoryInfo['category_slider_live'] == 1) echo "checked"; ?> />
						<label for="slideshow_live_live" class="radio-label">Live</label>
								
						<input type="radio" name="category_slider_live-s" id="slideshow_live_maint" value="0" <?php if(isset($categoryInfo['category_slider_live']) && $categoryInfo['category_slider_live'] == 0) echo "checked"; ?> />
						<label for="slideshow_live_maint" class="radio-label">Maintenance</label>
					</fieldset>

					<fieldset>
						<label for="category_favorite_articles_title-s">Category Articles Title :</label>
						<input type="text" name="category_favorite_articles_title-s" id="category_favorite_articles_title-s" placeholder="Please enter the category's favorite articles section title" value="<?php if(isset($categoryInfo['category_favorite_articles_title'])) echo $categoryInfo['category_favorite_articles_title']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'category_favorite_articles_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the title that will be showed at the top of the list of the articles per categories.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="cat_desc-s">Category Description :</label>
						<textarea  class="elm-wysiwyg" name="cat_desc-s" id="cat_desc-s" rows="10" placeholder="Please enter a description of the category here." <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'cat_desc') echo 'autofocus'; ?> ><?php if(isset($categoryInfo['cat_desc'])) echo $categoryInfo['cat_desc']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the description text that will appear in search engines, social networks, etc for the category.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-info-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>

			<?php
			
			if($categoryInfo["has_children"]){
				$availableArticles = $mpArticle->getArticles(['count' => -1, 'sortType' => 4]);
				if($availableArticles && isset($availableArticles['articles'])){
			?>
				<section id="featured-article">
					<header class="section-bar">
						<h2>Featured Dropdown Article</h2>
					</header>

					<form class="ajax-submit-form" id="category-featured-article-form" name="category-featured-article-form" action="<?php echo $config['this_admin_url']; ?>categories/edit/<?php echo $categoryInfo['cat_dir_name']; ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $categoryInfo['cat_id']; ?>" />
						
						<fieldset>
							<label for="article_category_page_featured_article">Articles<span>*</span> :</label>
							<select class="featured-select" id="article_category_page_featured_article" name="article_category_page_featured_article">
								<?php
									foreach($availableArticles['articles'] as $article){

										$previewString = '<div style="display: block;" class="submenu-wrapper">';
											$previewString .= '<div class="right">';
												$previewString .='<h2>Featured Recipe</h2>';
												$previewString .='<div class="article-info">';
													$previewString .= '<div id="image-recipe">';
														$previewString .= '<a href="#">';
															$previewString .= '<img src="';
																$previewString .= ($local) ? $config['image_url'] : $mpHelpers->stripUrls($article['article_page_full_url'], 'images');
															$previewString .= 'articlesites/puckermob/preview/'.$article['article_preview_img'].'" alt="'.$article['article_title'].' Preview Image" />';
														$previewString .= '</a>';
													$previewString .= '</div>';

													$previewString .= '<div id="info-recipe">';
														$previewString .= '<h2>';
															$previewString .= '<a href="#">'.$article['article_title'].'</a>';
														$previewString .= '</h2>';
														
														$previewString .= '<label class="get-recipe">';
															$previewString .= '<a href="#">GET RECIPE</a>';
														$previewString .= '</label>';
													$previewString .= '</div>';
												$previewString .= '</div>';
											$previewString .= '</div>';
											
										$option = '<option data-preview="'.preg_replace('/"/', '&quot;', preg_replace('/[\n\r\t]/', '', $previewString)).'" value="'.$article['article_id'].'" id="'.$article['article_id'].'" name="'.preg_replace('/"/', '&quot;', $article['article_title']).'"';
										if($article['article_id'] == $categoryInfo["article_id"]) $option .= ' selected';
										$option .= '>'.$article['article_title'].'</option>';
										echo $option;
									}
								?>
							</select>

							<div class="preview">Preview</div>
						</fieldset>
						
						<fieldset>
							<div class="btn-wrapper">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-featured-article-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-featured-article-form') echo $updateStatus['message']; ?>
								</p>

								<button type="submit" id="submit" name="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>
			<?php } 
		}?>

		<?php 
		/*if(!$categoryInfo["has_children"]){
			$sliderArticles = $mpArticle->getFeatured(['count' => -1,'featureType' => 3, 'pageId' => $categoryInfo['cat_id']]);
			$availableArticles = $mpArticle->getArticles(['count' => -1, 'sortType' => 4, 'pageId' => $categoryInfo['cat_id']]);
			if($availableArticles && isset($availableArticles['articles'])){
		*/
		?>
			<!--	<section id="slideshow-articles" class="">
					<header class="section-bar">
						<h2>Slideshow Articles</h2>
					</header>
					
						<fieldset class="slideshow">
							<h1><?php echo $categoryInfo['category_header_slider_title']?></h1>
							<section>
								<ul>
								<?php foreach($sliderArticles["articles"] as $slideshowArticle){
									if ($slideshowArticle['parent_dir_name'] != $slideshowArticle['cat_dir_name']){ 
										$link = $config['this_url'].$slideshowArticle['parent_dir_name'].'/'.$slideshowArticle['cat_dir_name'].'/'.$slideshowArticle['article_seo_title'];
									} else {
										$link = $config['this_url'].$slideshowArticle['cat_dir_name'].'/'.$slideshowArticle['article_seo_title'];
									}
								?>
									<li id="<?php echo $slideshowArticle['article_id'];?>">
										<div class="article-content">
											<div class="article-img">
												<?php 
													echo '<a target="_blank" href="'.$link.'" >';
														echo '<img src="'.$config['image_url'].'articlesites/puckermob/wide/'.$slideshowArticle['article_id'].'_wide.jpg" alt="'.$slideshowArticle['article_title'].' Preview Image" />';
													echo '</a>';
												?>
											</div>
											<div class="article-info">
												<h2><a target="_blank" href="<?php echo $link; ?>" ><?php echo $slideshowArticle['article_title']; ?></a></h2>
												<form class="ajax-submit-form" id="category-slideshow-delete" name="category-slideshow-delete" action="<?php echo $config['this_admin_url']; ?>categories/edit/<?php echo $categoryInfo['cat_dir_name']; ?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
													<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $categoryInfo['cat_id']; ?>" />
													<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $slideshowArticle['article_id']; ?>" />
													<div class="btn-wrapper delete">
														<button name="submit" id="submit" type="submit" data-info="<?php echo $slideshowArticle['article_id']; ?>">Delete</button>
														<a href="<?php echo $config['this_admin_url'].'articles/edit/'.$slideshowArticle['article_seo_title']; ?>"><button name="edit" id="edit" type="button">Edit</button></a>
													</div>
												</form>
											</div>
										</div>
									</li>
								<?php }?>
								</ul>
							</section>
						</fieldset>
						
						<form class="ajax-submit-form" id="category-slideshow-article-form" name="category-slideshow-article-form" action="<?php echo $config['this_admin_url']; ?>categories/edit/<?php echo $categoryInfo['cat_dir_name']; ?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $categoryInfo['cat_id']; ?>" />
							
						<fieldset class="ss-dd-articles">
							
							<label for="article_category_page_featured_article">Select the Articles to add:</label>
							<select class="featured-select" id="article_category_page_featured_article" name="article_category_page_featured_article">
								<?php
									foreach($availableArticles['articles'] as $article){
										if ($article['parent_dir_name'] != $article['cat_dir_name']){ 
											$link = $config['this_url'].$article['parent_dir_name'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title'];
										} else {
											$link = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
										}

										$articleData = '<div class="article-content">';
											$articleData .= '<div class="article-img">';
												$articleData .= '<a href="'.$link.'" target="_blank">';
													$articleData .= '<img src="';
														$articleData .= ($local) ? $config['image_url'] : $mpHelpers->stripUrls($article['article_page_full_url'], 'images');
														$articleData .= 'articlesites/puckermob/wide/'.$article['article_id'].'_wide.jpg" alt="'.$article['article_title'].' Preview Image" />';
												$articleData .= '</a>';
											$articleData .= '</div>';
											$articleData .= '<div class="article-info">';
												$articleData .= '<h2>';
													$articleData .= '<a href="'.$link.'" target="_blank">'.$article['article_title'].'</a>';
												$articleData .= '</h2>';
												$articleData .= '<form class="ajax-submit-form" id="category-slideshow-delete" name="category-slideshow-delete" action="'.$config['this_admin_url'].'categories/edit/'.$categoryInfo['cat_dir_name'].'" method="POST">';
													$articleData .= '<input type="text" class="hidden" id="c_t" name="c_t" value="'.$_SESSION['csrf'].'" >';
													$articleData .= '<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="'.$categoryInfo['cat_id'].'" />';
													$articleData .= '<input type="text" class="hidden" id="article_id" name="article_id" value="'.$article['article_id'].'" />';
													$articleData .= '<div class="btn-wrapper delete">';
														$articleData .= '<button class="b-delete" data-info="'.$article['article_id'].'" type="button" id="submit" name="submit">Delete</button>';
														$articleData .= '<a href="'.$config['this_admin_url'].'articles/edit/'.$article['article_seo_title'].'"><button type="button" id="edit" name="edit">Edit</button></a>';
													$articleData .= '</div>';
												$articleData .= '</form>';
											$articleData .= '</div>';
										$articleData .= '</div>';

										$previewString = '<div style="display: block;" class="submenu-wrapper">';
											$previewString .= '<div class="right">';
												$previewString .='<h2>Featured Recipe</h2>';
												$previewString .='<div class="article-info">';
													$previewString .= '<div id="image-recipe">';
														$previewString .= '<a href="#">';
															$previewString .= '<img src="';
																$previewString .= ($local) ? $config['image_url'] : $mpHelpers->stripUrls($article['article_page_full_url'], 'images');
															$previewString .= 'articlesites/puckermob/wide/'.$article['article_id'].'_wide.jpg" alt="'.$article['article_title'].' Preview Image" />';
														$previewString .= '</a>';
													$previewString .= '</div>';

													$previewString .= '<div id="info-recipe">';
														$previewString .= '<h2>';
															$previewString .= '<a href="#">'.$article['article_title'].'</a>';
														$previewString .= '</h2>';
														
														$previewString .= '<label class="get-recipe">';
															$previewString .= '<a href="#">GET RECIPE</a>';
														$previewString .= '</label>';
													$previewString .= '</div>';
												$previewString .= '</div>';
											$previewString .= '</div>';
											
										$option = '<option data-list="'.preg_replace('/"/', '&quot;', preg_replace('/[\n\r\t]/', '', $articleData)).'" data-preview="'.preg_replace('/"/', '&quot;', preg_replace('/[\n\r\t]/', '', $previewString)).'" value="'.$article['article_id'].'" id="'.$article['article_id'].'" name="'.preg_replace('/"/', '&quot;', $article['article_title']).'"';
										$option .= '>'.$article['article_title'].'</option>';
										echo $option;
									}
								?>
							</select>

							<div class="preview">Preview</div>
						</fieldset>
						
						<fieldset>
							<div class="btn-wrapper">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-featured-article-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'category-featured-article-form') echo $updateStatus['message']; ?>
								</p>

								<button type="submit" id="submit" name="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>-->
		<?php 
			//}
		//}
		?>
		</div>
	</div>

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