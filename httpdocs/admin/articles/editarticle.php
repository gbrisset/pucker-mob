<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');
	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];

	// If the article exists and has an id, check to see if this user has permissions to edit this article...
	if (isset($article['article_id']) ){
		$article_id = $article['article_id'];
		if ( !($adminController->user->checkUserCanEditOthers('article', $article['article_id'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}
	//require_once('../assets/php/notify-user-form.php');

	$articleCategories = $articleResultSet['categories'];
	$tallExtension = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall');

	if(!$tallExtension) $tallExtension = 'jpg';

	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	
	$pathToTallImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;

	//Verify if user is a content provider...
	//Verify if is a content provider user
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;
		$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
		$contributor_email = $adminController->user->data['user_email'];
		$contributorInfo = $contributorInfo[0];
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
			
			$article = $adminController->getSingleArticle(array('seoTitle' => $_POST['article_seo_title-s']));

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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Edit Article</h1>
	</div>

	<!-- WELCOME MESSAGE -->
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up">
			<h1 class="left">Edit Article</h1>
			<div class="right">
			<p class="">Welcome, <?php echo $adminController->user->data['user_email']; ?>
				<img src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'. $adminController->user->data['contributor_image'];?>" >
				<a href="<?php echo $config['this_admin_url']; ?>/logout/">Sign Out</a>
			</p>
		</div>
	</section>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<!-- Image Sections -->
			<!--<section id="article-inline-settings">
					<section class="section-bar left  border-bottom mobile-12 small-12">
						<h1 class="left">Article Image</h1>
						<div class="right">
							<p><span>Status: </span><?php echo $article_status; ?></p>
						</div>
					</section>
					
					<section id="add-an-image-fs" class="padding-top left">
							<div class="image-steps image-sec">
								<div id="image-container">
							<?php if(file_exists($pathToTallImage)){?>
							<?php 	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	?>
									<img src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
									<span><a id="change-art-image" href=""><i class="fa fa-file-image-o"></i>Change Photo</a></span>
								<?php } else{ ?>
									<img src="http://images.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg" alt="Default Image" />
									<span><a id="change-art-image" href=""><i class="fa fa-file-image-o"></i>Change Photo</a></span>
								<?php } ?>
								</div>
							</div>
							
							<div class="image-steps">
								<header class="section-bar">
									<h1>Add an Image to your article</h1>
								</header>
								
								<div class="row">
					    			<div class="columns">
							    	<div class="file-upload-container">
								        <span>
								        	<button class="radius" name="image-file-link" id="image-file-link" type="button"><i class="icon-plus-sign"></i>Add Image</i></button>
								        </span>
								    </div>
							        <div id="rules">
							        	<span>Make sure the image selected:</span>
							        	<ul>
							        	<li>Must be: .jpg, .jpeg, .gif, or .png type.</li>
		    							<li>Do not exceed a maximum size: 1 MB.</li>
		    							<!--<li>Has a minimun dimensions of  405 x 415</li>-->
							     <!--   </div>
						        </div></div>
						        <span id="error-img" class="radius alert label error-img hidden"></span>
						         
						    </div>
					</section>
					<div class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error-img show-err' : 'success-img'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo $updateStatus['message']; ?>
					</div>
			</section>-->

			<section id="article-info" class="padding-top">
				
				<form  id="image-drop" class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />

					<div class="dz-message" data-dz-message><div id="img-container">
					    		<label>Drag image here</label>
					    		<label>or</label>
					    		<input type="button" name="upload" id="upload" value="Upload Files" />
					    		<label class="mini-fonts">Recommended size: 784x431 pixels</label>
					    	</div></div>

				</form>

				<div class="dropzone-previews">
					<?php if(file_exists($pathToTallImage)){?>
					<?php 	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	?>
						<div id="main-image"class="dz-preview dz-image-preview dz-processing dz-success">
						<div class="dz-details">	
						<img class="data-dz-thumbnail" src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
						</div></div>
					<?php }  ?>
				</div>
				
				<form  id="article-info-form" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />

					
					<!-- ARTICLE TITLE -->
					<div class="row">
					    <div class="columns">
							<input type="text" name="article_title-s" id="article_title-s" placeholder="ARTICLE TITLE" <?php echo (!$user_admin) ? 'maxlength="40"' : ''; ?> value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
						</div>
					</div>

					<!-- ARTICLE CATEGORY -->
					<?php
						$allCategories = $MPNavigation->getAllCategoriesWithArticles();
						if($allCategories && count($allCategories)){
					?>
					<div class="row">
					    <div class="columns">
							<select id="article_categories" name="article_categories" class="small-12 large-4 left" required>
								<option value="0">SELECT CATEGORY</option>
								<?php 
								foreach($allCategories as $category){ 
									$selected = '';
									if(isset($articleResultSet['categories'][0]) && $articleResultSet['categories'][0]['cat_id'] == $category['cat_id']) $selected = 'selected';
									?>
								<option id="<?php echo 'category-'.$category['cat_id']; ?>" value="<?php echo $category['cat_id']; ?>" <?php echo $selected; ?>><?php echo $category['cat_name']; ?></option>
								<?php }?>
							</select>
							<div class="small-12 large-8 label-wrapper right padding-left show-on-large-up">
								<label>Choose one category that best specifies the genre of your article.</label>
								<label>This is where your post will reside on the site.</label>
							</div>
						</div>
					</div>
					<?php }?>

					<?php if($admin_user){?>
						<div class="row">
					    <div class="columns">
						<label for="article_seo_title-s" class="uppercase">SEO Title</label>
						<input type="text"  name="article_seo_title-s" id="article_seo_title-s" placeholder="Please enter the article's seo-formatted title here." value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />

					</div></div>
					<?php }?>
				
					<!-- KEYWORDS -->
					<div class="row">
					    <div class="columns">
						<label for="article_tags-s" class="uppercase">Keywords</label>
						<input type="text" name="article_tags-s" id="article_tags-s" placeholder="ARTICLE KEYWORDS" value="<?php if(isset($article['article_tags'])) echo $article['article_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please enter keywords that will help people search for your article. Keywords should include terms that are relevant to your article like ingredients, categories and descriptive nouns.</p>
							</div>
						</div>
					</div></div>
					
					<!-- DESCRIPTION -->
					<div class="row">
					    <div class="columns">
						<label for="article_desc-s" class="uppercase">Description </label>
							<input type="text" name="article_desc-s" id="article_desc-s" placeholder="ex: In cold weather, there’s no better way to warm up than with a comforting bowl of soup. This hearty soup is loaded with ..." maxlegth="150" value="<?php if(isset($article['article_desc'])) echo $article['article_desc']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />
						
						</div>
					</div>

					<!-- BODY -->
					<div class="row padding-bottom">
					    <div class="columns">
						<!--<label for="article_body-nf">Article Body:-->
							<textarea class="mceEditor" name="article_body-nf" id="article_body-nf" rows="15" required placeholder="Start writing article here." ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
						<!--</label>-->
						</div>
					</div>
				
					<!-- TYPE -->
					<div class="row">
					    <div class="columns">
						<label class="small-12 large-3 left uppercase">Article Type: </label>
						
						<input type="radio" name="article_type-s" id="opinion" data-info="1"  value="1" <?php if($article['article_type'] == 1) echo "checked"; ?> />
						<label for="" class="radio-label">Opinion</label>
									
						<input type="radio" name="article_type-s" data-info="2" id="news" value="2"  <?php if($article['article_type'] == 2) echo "checked"; ?> />
						<label for="" class="radio-label">News</label>

						<input type="radio" name="article_type-s" data-info="0" id="staff" value="0"  <?php if($article['article_type'] == 0) echo "checked"; ?> />
						<label for="" class="radio-label">Staff</label>
						</div>
					</div>

					<!-- Article Status -->
					<?php if($admin_user){?>
					<?php
						$allStatuses = $adminController->getSiteObjectAll(array('table' => 'article_statuses'));
						if($allStatuses && count($allStatuses)){
							include_once($config['include_path_admin'].'previewarticle.php'); 
						} 
					?>
					<div class="row <?php if($content_provider) echo 'hide'; ?>">
					    <div class="columns mobile-12 small-7">
							<label for="article_status" class="uppercase">Article Status</label>
							<select name="article_status" id="article_status" class = "status-select small-6">
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
						</div>
					
					</div>
					<?php }?>

					<!-- PAGE LIST -->
					<?php if($admin_user){?>				
					<div class="row">
					    <div class="columns">
						<label for="page_list" class="uppercase">Page List </label>
						<select name="page_list_id-nf" id="page_list_id-nf" class="">
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
					</div></div>

					<?php }?>
					
					

					<!-- Show Contributor List -->
					<?php
					if($admin_user){
						$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
						if($allContributors && count($allContributors)){

					?>
						<div class="row">
					    <div class="columns">
							<label for="article_contributor" class="uppercase">Article Contributor</label>
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
						</div></div>

					<?php }
					}else{ ?>
					<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
					<?php } ?>

						
					<!-- Featured Article -->
					<?php if($admin_user){ 
						$featuredArticle = $mpArticle->getFeaturedArticle( 1 );
					?>
					<div class="row">
					    <div class="columns">
						<label class="small-4 left uppercase">Feature this article: </label>
						<?php 
						$y_checked = ''; $n_checked = 'checked';

						if( $featuredArticle && $featuredArticle['article_id'] == $article['article_id']) { $y_checked = 'checked'; $n_checked = ''; } ?>
						<input type="radio" name="feature_article" data-info="yes"  value="1" <?php echo $y_checked; ?> />
						<label for="" class="radio-label">Yes</label>
								
						<input type="radio" name="feature_article" id="no" value="0"  <?php echo $n_checked; ?> />
						<label for="" class="radio-label">No</label>
					</div></div>
					<?php }?>

					<!-- Poll Script -->
					<?php if($admin_user){?>

					<div class="row">
					    <div class="columns">
						<label class="uppercase">Article Poll ID</label>
						<input type="text" name="article_poll_id-s" id="article_poll_id-s" value="<?php if(isset($article['article_poll_id'])) echo $article['article_poll_id']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_poll_id') echo 'autofocus'; ?> />
					</div></div>
					

					<!-- IMAGE CREDITS -->
					<div class="row">
					    <div class="columns">
							<label  class="uppercase">Image Credits</label>
								<input type="text" name="article_img_credits-s" id="article_img_credits-s" value="<?php if(isset($article['article_img_credits'])) echo $article['article_img_credits']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_img_credits') echo 'autofocus'; ?> />	
						</div>
					</div>
					
					<!-- NOTES -->
					<div class="row">
					    <div class="columns">
							<label class="uppercase" >Notes</label>
								<input type="text" name="article_additional_comments-s" id="article_additional_comments-s" value="<?php if(isset($article['article_additional_comments'])) echo $article['article_additional_comments']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_additional_comments') echo 'autofocus'; ?> />
						</div>
					</div>

					<!-- Article Disclaimer -->
					<div class="row">
					    <div class="columns">
						<label class="small-3 left uppercase">Article Disclaimer </label>
					
						<input type="radio" name="article_disclaimer-s" id="disclaimer-yes" data-info="1"  value="1" <?php if($article['article_disclaimer'] == 1) echo "checked"; ?> />
						<label for="" class="radio-label">Yes</label>
									
						<input type="radio" name="article_disclaimer-s" data-info="0" id="disclaimer-no" value="0"  <?php if($article['article_disclaimer'] == 0) echo "checked"; ?> />
						<label for="" class="radio-label">No</label>
						</div>
					</div>
					<?php }?>


					<div class="row buttons-container">
						<button type="submit" id="submit" name="submit" class="">SAVE DRAFT</button>
						<button type="button" id="preview" name="preview" class="">PREVIEW</button>
						<?php if($admin_user){?>
							<button type="button" id="publish" name="publish" class="">PUBLISH</button>
						<?php }?>
					</div>
					
				</form>
			</section>

		</div>
	</main>
	
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
	<?php include_once($config['include_path_admin'].'footer.php');?>
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