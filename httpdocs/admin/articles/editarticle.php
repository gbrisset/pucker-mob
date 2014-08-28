<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');
	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];
	// If the article exists and has an id, check to see if this user has permissions to edit this article...
	if (isset($article['article_id']) ){
		if ( !($adminController->user->checkUserCanEditOthers('article', $article['article_id'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}
	require_once('../assets/php/notify-user-form.php');

	$articleCategories = $articleResultSet['categories'];
	$isRecipe = false;
	$tallExtension = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall');

	if(!$tallExtension) $tallExtension = 'jpg';

	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	
	$pathToTallImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;

	//Verify if user is a content provider...
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;

		$contributor_email = $adminController->user->data['user_email'];
		$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'][0];
	}
	//Verify if Article Image file exists.
	$artImageDir =  $config['image_upload_dir'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';
	$artImageExists = false;

	if(isset($artImageDir) && !empty($artImageDir) && !is_null($artImageDir)){
		$artImageExists = file_exists($artImageDir);
	}

	$articleImages = $mpArticle->getArticlesImages($article['article_id']);	
	if(empty($article)) $mpShared->get404();

	// SUMMIT FORM
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article_title-s']):
			
					$updateStatus = $adminController->updateArticleInfo($_POST);
					$updateStatus['arrayId'] = 'article-info-form';
					break;
				case isset($_FILES['article_post_tall_img']):
					$updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'article',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
						'articleId' => $article['article_id'],
						'imgData' => $_POST,
						'whereClause' => 'article_id = '.$article['article_id'],
						'desWidth' => 405,
						'desHeight' => 415
					]), ['arrayId' => 'article-tall-image-upload-form']);
				
					break;

			}
			$article = $adminController->getSingleArticle(array('seoTitle' => $uri[2]));
		}else $adminController->redirectTo('logout/');
	}

	$article_status = 'Pending Review';
	if(isset($article) && $article['article_status']){
		switch ($article['article_status']){
			case 1: 
				$article_status = "Live";
				break;

			case 2:
				$article_status = "Pending Review";
				break;

			case 3:
				$article_status = "Draft";
				break;

			default:
				$article_status = "Pending Review";
		}
	}

	//Preview Article Content
	//include_once($config['include_path_admin'].'preview.php');
	
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
			<!-- Image Sections -->
			<section id="article-inline-settings">
					<header class="section-bar">
						<h2 class="left">Article Image</h2>
						<div class="right">
							<p><span>Status: </span><?php echo $article_status; ?></p>
						</div>
					</header>
					
					<fieldset id="add-an-image-fs">
							<div class="image-steps image-sec">
								<div id="image-container">
							<?php if(file_exists($pathToTallImage)){?>
							<?php 	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	?>
									<img src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
									<span><a id="change-art-image" href=""><i class="icon-picture"></i>Change Photo</a></span>
								<?php } else{ ?>
									<img src="http://images.puckermob.com/articlesites/sharedimages/recipe_default_image.jpg" alt="Default Image" />
									<span><a id="change-art-image" href=""><i class="icon-picture"></i>Change Photo</a></span>
								<?php } ?>
								</div>
							</div>
							
							<div class="image-steps">
								<header class="section-bar">
									<h2>Add an Image to your article</h2>
								</header>
								<fieldset>
							    	<div class="file-upload-container">
								        <span>
								        	<button name="image-file-link" id="image-file-link" type="button"><i class="icon-plus-sign"></i>Add Image</i></button>
								        </span>
								    </div>
							        <div id="rules">
							        	<span>Make sure the image selected:</span>
							        	<ul>
							        	<li>Must be: .jpg, .jpeg, .gif, or .png type.</li>
		    							<li>Do not exceed a maximum size: 1 MB.</li>
		    							<!--<li>Has a minimun dimensions of  405 x 415</li>-->
							        </div>
						        </fieldset>
						         <p id="error-img" class="error-img"></p>
						    </div>
					</fieldset>
					<div class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error-img show-err' : 'success-img'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo $updateStatus['message']; ?>
					</div>
			</section>

			<section id="article-info">
				<header class="section-bar">
					<h2>Article Information</h2>
				</header>

				<form  id="article-info-form" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />

					<fieldset>
						<label for="article_title-s">Article Title<span>*</span> :</label>
						<input type="text" name="article_title-s" id="article_title-s" placeholder="ex: Chicken with Spinach and Zucchini Skillet" <?php echo ($content_provider) ? 'maxlength="40"' : ''; ?> value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please provide a title for your article, 50 characters maximum</p>
							</div>
						</div>
					</fieldset>

					<fieldset style="<?php if($content_provider) echo 'display:none;'?>">
						<label for="article_seo_title-s">Article SEO Title<span>*</span> :</label>
						<input type="text"  name="article_seo_title-s" id="article_seo_title-s" placeholder="Please enter the article's seo-formatted title here." value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the article's title that will be used in URLs throughout the network.</p>
							</div>
						</div>
					</fieldset>
				
					<fieldset>
						<label for="article_desc-s">Article Description<span>*</span> :</label>
						<input type="text" name="article_desc-s" id="article_desc-s" placeholder="ex: In cold weather, there’s no better way to warm up than with a comforting bowl of soup. This hearty soup is loaded with ..." maxlegth="150" value="<?php if(isset($article['article_desc'])) echo $article['article_desc']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please provide a short description introducing your article, 150 characters maximum. This description will appear underneath the title of your article on the search results page.</p>
							</div>
						</div>
					</fieldset>

					<?php //if(!$content_provider){?>
					<fieldset>
						<label for="article_tags-s">Article Keywords :</label>
						<input type="text" name="article_tags-s" id="article_tags-s" placeholder="ex: Meatless, Gluten-free, Detox, Antioxidant, All-Natural, One Pot, Chicken" value="<?php if(isset($article['article_tags'])) echo $article['article_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please enter keywords that will help people search for your article. Keywords should include terms that are relevant to your article like ingredients, categories and descriptive nouns.</p>
							</div>
						</div>
					</fieldset>
					<?php //}?>

					<fieldset>
						<label for="article_body-nf">Article Body:</label>
						<textarea class="mceEditor" name="article_body-nf" id="article_body-nf" rows="45" placeholder="Please enter the article's body here." ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
						<!--<div class="tooltip">
							<img src="<?php // echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the main content of the article, formatted in HTML.</p>
							</div>
						</div>-->
					</fieldset>
				
					<!-- PAGE LIST -->				
					<fieldset>
						<label for="page_list">Page List: </label>
						<select name="page_list_id-nf" id="page_list_id-nf">
							<option value="0">None</option>
							<?php			
								$page_lists = PageList::get();
								foreach($page_lists as $page_list){
									echo "<option value='".$page_list->page_list_id."' ".(($page_list->page_list_id == $article['page_list_id']) ? 'selected=selected ': '') ."  >";
										echo $page_list->page_list_title;
									echo "</option>";
								}
							?>
						</select>
					</fieldset>				

					<!-- Article Status and Preview Section -->
					<?php
						$allStatuses = $adminController->getSiteObjectAll(array('table' => 'article_statuses'));
						if($allStatuses && count($allStatuses)){
							include_once($config['include_path_admin'].'previewarticle.php'); 
						} 
					?>
					<fieldset class="<?php if($content_provider) echo 'hide'; ?>">
						<label for="article_status">Article Status<span>*</span> :</label>
						<select name="article_status" id="article_status" class = "status-select">
						<?php
							if(!$content_provider){ 
								foreach($allStatuses as $statusInfo){
									$option = '<option data-preview="'.preg_replace('/"/', '&quot;', $preview_article).'" value="'.$statusInfo['status_id'].'"';
									
									if($statusInfo['status_id'] == $article['article_status']) $option .= ' selected="selected"';
									
									$option .= '>'.$statusInfo['status_label'].'</option>';
									echo $option;
								}
							}else{
									$option = '<option value="3"';
									$option .= '>Draft</option>';
									echo $option;
							}
						?>
						</select>
						<!-- <div class="preview">Preview</div> -->

						<?php include_once($config['include_path_admin'].'preview_email.php');  ?>
						<?php 
						echo '<div>';
							$preview = '<div data-preview="'.$preview_profile.'" class="notify-preview-container">';
							$preview .= '</div>';
							echo $preview; 
						echo '</div>';
						if($adminController->user->data['user_type'] < 3){
							echo '<div class="notify">Notify Contributor</div>';
						}
						?>

					</fieldset>

					<!-- Show Contributor List -->
					<?php
					if(!$content_provider){
						$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
						if($allContributors && count($allContributors)){

					?>
						<fieldset>
							<label for="article_contributor">Article Contributor<span>*</span> :</label>
							<select name="article_contributor" id="article_contributor">
								<option value="-1">None</option>
								<?php
									foreach($allContributors as $contributorsInfo){

										$option = '<option value="'.$contributorsInfo['contributor_id'].'"';
										if( $article['contributor_id']  && $contributorsInfo['contributor_id'] == $article['contributor_id'] ) $option .= ' selected="selected"';
										else if($article['contributor']['contributor_id'] && $contributorsInfo['contributor_id'] == $article['contributor']['contributor_id'])  $option .= ' selected="selected"';
										$option .= '>'.$contributorsInfo['contributor_name'].'</option>';
										echo $option;
									}
								?>
							</select>
						</fieldset>

					<?php }
					}else{ ?>
					<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
					<?php } ?>

					<!-- Show All Categories -->
					<?php
						$allCategories = $MPNavigation->getAllCategoriesWithArticles();
						if($allCategories && count($allCategories)){
					?>
						<fieldset>
							<label class="checkbox-group-label-parent">Article Categories<span>*</span> :</label>
							<p class="p-message">Categorize your article choosing up to 5 categories. </p>
							<section class="checkbox-group-content">
							<?php
								foreach($allCategories as $arr){
									$checkbox = '<div class="checkbox-group">';
										$checkbox .= '<input type="checkbox" value="'.$arr['cat_id'].'" id="category-'.$arr['cat_id'].'" name="article_categories[category-'.$arr['cat_id'].']"';
										if($articleResultSet['categories']){
											foreach($articleResultSet['categories'] as $catArr){
												if($arr['cat_id'] == $catArr['cat_id']){
													$checkbox .= ' checked="checked"';
													break;
												}
											}
										}
										$checkbox .= ' />';
										$checkbox .= '<label class="checkbox-label" for="category-'.$arr['cat_id'].'">'.$arr['cat_name'].'</label>';
									$checkbox .= '</div>';
									echo $checkbox;
								}
							?>
							</section>
						</fieldset>
					<?php } ?>
					
					<!-- Featured Article -->
					<?php if(!$content_provider){ 
						$featuredArticle = $mpArticle->getFeaturedArticle( 1 );
					?>
					<fieldset>
						<label>Feature this article: </label>
						<?php 
						$y_checked = ''; $n_checked = 'checked';

						if( $featuredArticle && $featuredArticle['article_id'] == $article['article_id']) { $y_checked = 'checked'; $n_checked = ''; } ?>
						<input type="radio" name="feature_article" data-info="yes"  value="1" <?php echo $y_checked; ?> />
						<label for="" class="radio-label">Yes</label>
								
						<input type="radio" name="feature_article" id="no" value="0"  <?php echo $n_checked; ?> />
						<label for="" class="radio-label">No</label>
					</fieldset>
					<?php }?>

					<!-- Poll Script -->
					<?php if(!$content_provider){ 
					?>

					<fieldset>
						<label>Article Poll ID: </label>
						<input type="text" name="article_poll_id-s" id="article_poll_id-s" value="<?php if(isset($article['article_poll_id'])) echo $article['article_poll_id']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_poll_id') echo 'autofocus'; ?> />
					</fieldset>
					<?php }?>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo $updateStatus['message']; ?>
							</p>
							
							<button type="submit" id="submit" name="submit">Save</button>
						</div>
					</fieldset>
				</form>
			</section>

			<!--<section>
				<fieldset class="multiple-forms">
					<div>
						<div data-preview='<?php echo  $preview_article; ?>' class="preview-art-container" ></div>
					</div>

					<form class="ajax-submit-form" id="article-review-form" name="article-review-form" action="<?php echo $config['this_admin_url'].'articles/edit/'.$uri[2]; ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				        <input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']?>"/>
				        <input type="hidden" id="article_status" name="article_status" value="2"/>
				        
					<div class="main-buttons edit-recipe">
						<button type="submit" id="submit" name="submit" class="review">Submit for Review</button>
						<button class="article-prev" name="preview-art" id="preview-art" type="button">Preview Article</button>
					</div>
				</form>
				</fieldset>
			</section>-->
			
		</div>
	</div>
	<div class="lightbox-shown" id="lightbox-cont2" style="display:none;">
		<div class="overlay"></div>
		<div id="lightbox-content" class="article-lightbox article-lightbox-img-uploader">
			
			<div id="lightbox-preview-cont">
				<?php 
					include_once($config['include_path_admin'].'preview_image.php'); 
					echo $image_prev;
				?>
			</div>
		</div>
	</div>
	<?php include_once($config['include_path'].'footer.php');?>
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content" class="article-lightbox">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>