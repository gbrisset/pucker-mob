<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$adminController->user->data = $adminController->user->getUserInfo();

	if(!$adminController->user->checkPermission('user_permission_show_generic_settings')) $adminController->redirectTo('noaccess/');

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article_page_name-s']):
					$updateStatus = $adminController->updateSiteSettings($_POST);
					$updateStatus['arrayId'] = 'general-settings-form';
					break;
				case isset($_POST['article_page_featured_article']):
					$updateStatus = $adminController->updateSiteFeautedObject(array(
						'table' => 'articles_featured',
						'column' => 'article_id',
						'additionalWhere' => ' AND feature_type = 2',
						'post' => array_merge($_POST, array('article_id-n' => $_POST['article_page_featured_article'])),
						'successMessage' => 'Featured article updated successfully!'
					));
					$updateStatus['arrayId'] = 'featured-article-form';
					break;

				case isset($_POST['article_page_featured_articles_sidebar_1']):
					$updateStatus = array_merge($mpArticleAdmin->updateTodaysFavorites($_POST), ['arrayId' => 'sidebar-articles-form']);
					break;

				case isset($_POST['category-slideshow-article-form']): //SlideShow Articles
					$updateStatus = array_merge($mpArticleAdmin->insertCategorySlideshowArticles($_POST['formData']));
					break;
				
				case isset($_POST['category-slideshow-delete']): //Delete Article Slideshow Functionality
					$updateStatus = array_merge($mpArticleAdmin->deleteCatgorySlideshowArticles($_POST['formData']));	
					break;

				case isset($_POST['category_header_slider_title-s']): //Home Slideshow Title
					$updateStatus = array_merge($mpArticleAdmin->updateCategoryInfo($_POST), ['arrayId' => 'category-info-form']);
					$categoryInfo = $mpArticleAdmin->getFullCategoryInfo($categoryInfo);
					break;

				case isset($_POST['ask_the_chef_article']):
					$updateStatus = array_merge($mpArticleAdmin->updateAskTheChef($_POST), ['arrayId' => 'ask-the-chef-form']);
					break;

			}
			$mpArticle->reloadSiteData();
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

	<div id="main-cont">
		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="site-settings">

			<section id="general-settings">
				<header class="section-bar">
					<h2>General Settings</h2>
				</header>

				<form class="ajax-submit-form" id="general-settings-form" name="general-settings-form" action="<?php echo $config['this_admin_url']; ?>site/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label for="article_page_name-s">Site Title<span>*</span> :</label>
						<input type="text" name="article_page_name-s" id="article_page_name-s" placeholder="Please enter the full site title here." value="<?php if(isset($mpArticle->data['article_page_name'])) echo $mpArticle->data['article_page_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the site title that will show up in search engines, page titles, etc.  It can be longer and more descriptive than the 'visible site title'.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_visible_name-s">Visible Site Title<span>*</span> :</label>
						<input type="text" name="article_page_visible_name-s" id="article_page_visible_name-s" placeholder="Please enter the visible site title here." value="<?php if(isset($mpArticle->data['article_page_visible_name'])) echo $mpArticle->data['article_page_visible_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_visible_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the visible site title.  It can be shorter than the 'site title' and will be displayed on certain devices and used in situations where space is limited.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_full_url-u">Site URL<span>*</span> :</label>
						<input type="url" name="article_page_full_url-u" id="article_page_full_url-u" placeholder="Please enter the site's URL here." value="<?php if(isset($mpArticle->data['article_page_full_url'])) echo $mpArticle->data['article_page_full_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_full_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the site's full URL.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_assets_directory-s">Site Assets Directory<span>*</span> :</label>
						<input type="text" name="article_page_assets_directory-s" id="article_page_assets_directory-s" placeholder="Please enter the name of the directory where the site's assets can be found." value="<?php if(isset($mpArticle->data['article_page_assets_directory'])) echo $mpArticle->data['article_page_assets_directory']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_assets_directory') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the name of the folder on the server where the site's assets (images, media, videos, etc) can be found.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_featured_article_text-s">Featured Article Heading<span>*</span> :</label>
						<input type="" name="article_page_featured_article_text-s" id="article_page_featured_article_text-s" placeholder="Please enter the heading text that will appear in the featured article section." value="<?php if(isset($mpArticle->data['article_page_featured_article_text'])) echo $mpArticle->data['article_page_featured_article_text']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_featured_article_text') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the text that will appear as the heading for the 'featured article' section on each page.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_tags-s">Site Keywords<span>*</span> :</label>
						<input type="text" name="article_page_tags-s" id="article_page_tags-s" placeholder="Please enter the site's tags here." value="<?php if(isset($mpArticle->data['article_page_tags'])) echo $mpArticle->data['article_page_tags']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that will show up in search engines, social networks, etc.  They should be separated with a comma.  Keywords are limited to 1500 characters.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_desc-s">Site Description<span>*</span> :</label>
						<textarea  class="elm-wysiwyg" name="article_page_desc-s" id="article_page_desc-s" rows="10" placeholder="Please enter a description of the site here." required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_desc') echo 'autofocus'; ?> ><?php if(isset($mpArticle->data['article_page_desc'])) echo $mpArticle->data['article_page_desc']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the text that will appear in search engines, social networks, etc for the site.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_analytics-nf">Site Analytics Code :</label>
						<textarea name="article_page_analytics-nf" id="article_page_analytics-nf" rows="10" placeholder="Please enter the analytics code the the site here." ><?php if(isset($mpArticle->data['article_page_analytics'])) echo $mpArticle->data['article_page_analytics']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is where you can insert code from Google Analytics, Quantcast, ComScore, etc that will be included on every page.</p>
							</div>
						</div>
					</fieldset>

					<?php
					/*	$availableCategories = $mpArticleAdmin->getMainCategories();
						if($availableCategories && count($availableCategories)){
					*/?>
					<!--	<fieldset>
							<label for="cat_id">Parent Category<span>*</span> :</label>
							<select name="cat_id" id="cat_id">
								<?php
								/*	foreach($availableCategories as $category){
										if($category['visible']){
											$option = '<option id="'.$category['cat_id'].'" name="'.$category['cat_id'].'"';
											if($category['cat_id'] == $mpArticle->data['cat_id']) $option .= ' selected';
											$option .= ' value="'.$category['cat_id'].'">'.$category['cat_name'].'</option>';
											echo $option;
										}
									}*/
								?>
							</select>
						</fieldset>-->
					<?php //} ?>

					<fieldset>
						<label class="radio-button-label-parent">Status :</label>

						<input type="radio" name="article_page_live" id="article_page_live_live" value="article_page_live_live" <?php if(isset($mpArticle->data['article_page_live']) && $mpArticle->data['article_page_live'] == 1) echo "checked"; ?> />
						<label for="article_page_live_live" class="radio-label">Live</label>
						
						<input type="radio" name="article_page_live" id="article_page_live_maint" value="article_page_live_maint" <?php if(isset($mpArticle->data['article_page_live']) && $mpArticle->data['article_page_live'] == 0) echo "checked"; ?> />
						<label for="article_page_live_maint" class="radio-label">Maintenance</label>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'general-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'general-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>

			

			<?php

				$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);
				$featuredArticle = $featuredArticle ["articles"][0];
				//$availableArticles = $mpArticle->getArticles(['count' => -1, 'sortType' => 4]);
				$featuredArticleText = $mpArticle->data['article_page_featured_article_text'];
				$availableArticles = $mpArticle->getAllArticleNames();
				// if($availableArticles && isset($availableArticles['articles'])){
				if($availableArticles){

			?>
				<section id="featured-article">
					<header class="section-bar">
						<h2>Featured Article</h2>
					</header>

					<form class="ajax-submit-form" id="featured-article-form" name="featured-article-form" action="<?php echo $config['this_admin_url']; ?>site/" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

						<fieldset>
							<label for="article_page_featured_article">Articles<span>*</span> :</label>
							<select class="featured-select" id="article_page_featured_article" name="article_page_featured_article">
								<?php 	
									// foreach($availableArticles['articles'] as $article){
									foreach($availableArticles as $article){

										// if ($article['parent_category_page_directory'] != $article['category_page_directory']){ 
										// 	$link = $config['this_url'].$article['parent_category_page_directory'].'/'.$article['category_page_directory'].'/'.$article['article_seo_title'];
										// } else {
										// 	$link = $config['this_url'].$article['category_page_directory'].$article['article_seo_title'];
										// }
										$link = '#';
										$previewString = '';
										$previewString = '<section  id="featured-article" data-set="featured-article-append-around">';
											$previewString .= '<section class="featured-section" id="featured-article-cont">';
												$previewString .= '<header>';
													$previewString .= '<h2>'.$featuredArticleText.'</h2>';
												$previewString .= '</header>';

												$previewString .= '<article class="featured-article-section">';
													$previewString .= '<div class="featured-image">';
														$previewString .= '<a target="_blank" href="'.$link.'">';
															$previewString .= '<img src="'.$config['image_url'].'articlesites/'.'puckermob/tall/'.$article['article_id'].'_tall.jpg"';
															$previewString .= 'alt="'.$article['article_title'].' Preview Image" />';
														$previewString .= '</a>';
													$previewString .= '</div>';
													
													$previewString .= '<div class="featured-info">';
													$previewString .= '<h2>';
														$previewString .= '<a target="_blank" href="'. $link .'">'.$article['article_title'].'</a>';
														$previewString .= '<label class="get-recipe">';
															$previewString .= '<a target="_blank" href="'. $link .'">Get Recipe</a>';
														$previewString .='</label>';
													$previewString .= '</h2>';

												$previewString .= '</article>';
												
											$previewString .= '</section>';
										$previewString .= '</section>';
													
										$option = '<option data-preview="'.preg_replace('/"/', '&quot;', preg_replace('/[\n\r\t]/', '', $previewString)).'" value="'.$article['article_id'].'" id="'.$article['article_id'].'" name="'.preg_replace('/"/', '&quot;', $article['article_title']).'"';
										if($article['article_id'] == $featuredArticle['article_id']) $option .= ' selected';
										$option .= '>'.$article['article_title'].'</option>';
										echo $option;
									}
								?>
							</select>

							<div class="preview">Preview</div>
						</fieldset>
						
						<fieldset>
							<div class="btn-wrapper">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'featured-article-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'featured-article-form') echo $updateStatus['message']; ?>
								</p>

								<button type="submit" id="submit" name="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>
			<?php } ?>


			<?php
				$favoritesArticles = $mpArticle->getTodaysFavorites();

				if($favoritesArticles && isset($favoritesArticles)){
			?>
				<section id="sidebar-articles">
					<header class="section-bar">
						<h2>Today's Favorites</h2>
					</header>

					<form class="ajax-submit-form" id="sidebar-articles-form" name="sidebar-articles-form" action="<?php echo $config['this_admin_url']; ?>site/" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

						<?php
							$i = 0;
							foreach($favoritesArticles as $todaysfavorites){
							
								$field = '<fieldset>';
								$field .= '<label class="featured_label" for="article_page_featured_articles_sidebar_'.($i + 1).'">'.$todaysfavorites['cat_name'].'<span>*</span> :</label>';
									$field .= '<select class="featured-select" id="article_page_featured_articles_sidebar_'.($i + 1).'" name="article_page_featured_articles_sidebar_'.($i + 1).'">';
									$availableArticlesbyCat = $mpArticle->getAvailableByCategory($todaysfavorites['cat_id']);	
									$favArticleIndex = 1;	
									foreach($availableArticlesbyCat as $article){
										if (isset($article['parent_category_id'] ) && $article['parent_category_id'] != null) {
											$hasParent = true;
											$parentCategorySet = $MPNavigation->getCategoryById($article['parent_category_id']);
											$linkToArticle = $config['this_url'].$parentCategorySet['cat_dir_name']."/".$article['cat_dir_name'];
										} else {
											$linkToArticle = $config['this_url'].$article['cat_dir_name'];			
										}
										$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/wide/'.$article['article_id'].'_wide.jpg';
										
										$previewString = '<section class="favorites-dishes-videos" id="today-favorites-'.$favArticleIndex++.'">';
											$previewString .= "<h1>Today's Favorites</h1>";
											
											$previewString .= '<section class="top-articles">';
												for($j = $i; $j > 0; $j--){
													$previewString .= '<div class="single-article" id="recent-article">';
														$previewString .= '<h1><a href="#">Category</a></h1>';
														$previewString .= '<div class="article-image-prev article-no-image  article-img"></div>';
														$previewString .= '<h2><a href="#">Article Title Here</a></h2>';	
													$previewString .= '</div>';
												}

												$previewString .= '<div class="single-article" id="recent-article">';
														$previewString .= '<h1><a href="'.$linkToArticle.'">'.htmlspecialchars($article['cat_name']).'</a></h1>';
														$previewString .= '<div class="article-image-prev article-img">';
															$previewString .= '<a href= "'.$linkToArticle."/".$todaysfavorites['article_seo_title'].'" >';
																$previewString .= '<img src="'.$linkToImage.'" alt="'.$todaysfavorites['article_title'].'" />';
															$previewString .= '</a>';
														$previewString .= '</div>';
														$previewString .= '<h2>';
															$previewString .= '<a href="'.$linkToArticle."/".$todaysfavorites['article_seo_title'].'" >';
																$previewString .= $todaysfavorites['article_title'];
															$previewString .= '</a>';
														$previewString .= '</h2>';
												$previewString .= '</div>';

												for($j = $i; $j < 2; $j++){
													$previewString .= '<div class="single-article" id="recent-article">';
														$previewString .= '<h1><a href="#">Category</a></h1>';
														$previewString .= '<div class="article-image-prev article-no-image article-img"></div>';
														$previewString .= '<h2><a href="#">Article Title Here</a></h2>';	
													$previewString .= '</div>';
												}
											$previewString .= '</section>';
										$previewString .= '</section>';
										
										$field .= '<option  value="'.$article['article_id'].'" id="'.$article['article_id'].'" name="'.preg_replace('/"/', '&quot;', $article['article_title']).'"';
										if($article['article_id'] == $todaysfavorites['article_id']) $field .= ' selected';
										$field .= '>'.$article['article_title'].'</option>';
									}
									$field .= '</select>';
								$field .= '<div class="preview">Preview</div>';
								$field .= '</fieldset>';
								$i++;
								echo $field;
							}
						?>
						
						<fieldset>
							<div class="btn-wrapper">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sidebar-articles-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sidebar-articles-form') echo $updateStatus['message']; ?>
								</p>

								<button type="submit" id="submit" name="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>
			<?php } ?>


			<!--HomePage Slideshow-->
			<?php 

			$categoryInfo['cat_id'] = 1;
			$categoryInfo = $mpArticleAdmin->getFullCategoryInfo($categoryInfo);
			$sliderArticles = $mpArticle->getFeatured(['count' => -1,'featureType' => 3, 'pageId' => $categoryInfo['cat_id']]);

			//$availableArticles = isset($availableArticles) && isset($availableArticles['articles']) ? $availableArticles : $mpArticle->getArticles(['count' => -1, 'sortType' => 4]);
			if($availableArticles && isset($availableArticles)){
		
		?>
				<section id="slideshow-articles" class="">
					<header class="section-bar">
						<h2>Slideshow Articles</h2>
					</header>
					
						<form class="ajax-submit-form" id="category-info-form" name="category-info-form" action="<?php echo $config['this_admin_url']; ?>site/" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="1" />
						
							<fieldset>
								<label for="category_header_slider_title-s">SlideShow Title :</label>
								<input type="text" name="category_header_slider_title-s" id="category_header_slider_title-s" placeholder="Please enter the category's slideshow header title" value="<?php if(isset($categoryInfo['category_header_slider_title'])) echo $categoryInfo['category_header_slider_title']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'category_header_slider_title') echo 'autofocus'; ?> />

								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>These is the title that will show at the top of the slideshow.  This should be limit to no more than 50 characters.</p>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<label class="radio-button-label-parent">Status :</label>

								<input type="radio" name="category_slider_live-s" id="slideshow_live_live" value="1" <?php if(isset($categoryInfo['category_slider_live']) && $categoryInfo['category_slider_live'] == 1) echo "checked"; ?> />
								<label for="slideshow_live_live" class="radio-label">Live</label>
								
								<input type="radio" name="category_slider_live-s" id="slideshow_live_maint" value="0" <?php if(isset($categoryInfo['category_slider_live']) && $categoryInfo['category_slider_live'] == 0) echo "checked"; ?> />
								<label for="slideshow_live_maint" class="radio-label">Maintenance</label>
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
														echo '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/wide/'.$slideshowArticle['article_id'].'_wide.jpg" alt="'.$slideshowArticle['article_title'].' Preview Image" />';
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
									foreach($availableArticles as $article){
										if (isset($article['parent_dir_name']) && $article['parent_dir_name'] != $article['cat_dir_name']){ 
											$link = $config['this_url'].$article['parent_dir_name'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title'];
										} else {
											if(isset($article['cat_dir_name'])){
												$link = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
											}
										}

										$articleData = '<div class="article-content">';
											$articleData .= '<div class="article-img">';
												$articleData .= '<a href="'.$link.'" target="_blank">';
													$articleData .= '<img src="';
														$articleData .= $config['image_url'];
														$articleData .= '/articlesites/puckermob/wide/'.$article['article_id'].'_wide.jpg" alt="'.$article['article_title'].' Preview Image" />';
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
																if(isset($article['article_page_assets_directory'])){

																	$previewString .= 'articlesites/'.$article['article_page_assets_directory'].'/wide/'.$article['article_id'].'_wide.jpg" alt="'.$article['article_title'].' Preview Image" />';
																}
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
				</section>
		<?php  } ?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content" class="lightbox-featured-section">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>