<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');
	
	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];

	if(empty($article)) $mpShared->get404();

	// If the article exists and has an id, check to see if this user has permissions to edit this article...
	if (isset($article['article_id']) ){
		$article_id = $article['article_id'];
		if ( !($adminController->user->checkUserCanEditOthers('article', $article['article_id'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}
	
	$articleCategories = $articleResultSet['categories'];
	
	//Article ADs
	$article_ads = $mpArticleAdmin->getArticleAds($article);
	if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];

	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	
	$pathToTallImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;

	//Verify if user is a content provider...
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2  || $adminController->user->data['user_type'] == 6){
		$admin_user = true;
	}

	$externalWriter = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 7 ){
		$externalWriter = true;
	}

	$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
	$contributor_email = $adminController->user->data['user_email'];
	$contributorInfo = $contributorInfo[0];
	
	
	//Verify if Article Image file exists.
	$artImageDir =  $config['image_upload_dir'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';
	$artImageExists = false;

	if(isset($artImageDir) && !empty($artImageDir) && !is_null($artImageDir)){
		$artImageExists = file_exists($artImageDir);
	}

	//GET ALL ARTICLES 
	$allarticles = $mpArticle->getAllLiveArticles();

	$related_to_this_article = $mpArticle->getRelatedToArticle( $article['article_id'] );
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

			$related_to_this_article = $mpArticle->getRelatedToArticle( $article['article_id'] );


			//Article ADs
			$article_ads = $mpArticleAdmin->getArticleAds($article);
			if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];
			
			//$article = $adminController->getSingleArticle(array('seoTitle' => $_POST['article_seo_title-s']));

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
<body id="editarticle">
	<?php include_once($config['include_path_admin'].'header.php');?>
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Edit Article</h1>
	</div>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
				<header>Edit Article</header>
			</div>
			
			<section id="article-info" class="">
				<form  id="image-drop" class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
					<div class="dz-message" data-dz-message>
						<div id="img-container">
					   		<label class="padding-top">Drag image here</label>
					   		<label>or</label>
					   		<input type="button" name="upload" id="upload" value="Upload Files" />
					   		<input type="button" name="search-lib" id="search-lib" value="Photo Library" style="color: #fff; background-color: #000;"/>
					   		<label class="mini-fonts padding-bottom">Size: 784x431 pixels</label>
					   	</div>
					</div>
				</form>

				<div class="dropzone-previews">
					<?php if(file_exists($pathToTallImage)){?>
					<?php 	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';	?>
					<div id="main-image"class="dz-preview dz-image-preview dz-processing dz-success">
						<div class="dz-details">	
							<img class="data-dz-thumbnail" style="width:100%;" src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
						</div>
					</div>
					<?php }  ?>
				</div>
				
				<form id="article-info-form" class="margin-top" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
					<input type="hidden" id="creation_date" name="creation_date" value="<?php echo $article['creation_date']; ?>" />

					<!-- ARTICLE TITLE -->
					<div class="row">
					    <div class="columns">
							<input type="text" name="article_title-s" id="article_title-s" placeholder="Enter article title" value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
						</div>
					</div>

					<!-- ARTICLE CATEGORY -->
					<?php
					if( $blogger ){?>
						<input type="hidden"  name="article_categories" id="article_categories" value="9" />
					<?php }else{
						$allCategories = $MPNavigation->getAllCategoriesWithArticles();
						if($allCategories && count($allCategories)){
					?>
						<div class="row">
						    <div class="columns">
						    	<div class="small-styled-select left ">
								<select id="article_categories" name="article_categories" class="small-12 large-4 left" required>
									<option value="0">SELECT CATEGORY</option>
									<?php 
									foreach($allCategories as $category){ 
										$selected = '';

										if( $category['cat_id'] == 9 && !$admin_user) continue; 
										if(isset($articleResultSet['categories'][0]) && $articleResultSet['categories'][0]['cat_id'] == $category['cat_id']) $selected = 'selected';
										?>
									<option id="<?php echo 'category-'.$category['cat_id']; ?>" value="<?php echo $category['cat_id']; ?>" <?php echo $selected; ?>><?php echo $category['cat_name']; ?></option>
									<?php }?>
								</select>
								</div>
								<div id="category-description" class="small-12 large-8 label-wrapper right padding-left show-on-large-up">
									<label>Choose one category that best specifies the genre of your article.This is where your post will reside on the site.</label>
								</div>
							</div>
						</div>
						<?php }
					}?>

					<?php if($admin_user){?>
						<div class="row">
					    <div class="columns">
						<label for="article_seo_title-s" class="uppercase">SEO Title</label>
						<input type="text" disabled  name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />

					</div></div>
					<?php }?>
				
					
					<!-- BODY -->
					<div class="row margin-bottom">
					    <div class="columns">
							<textarea class="mceEditor" name="article_body-nf" id="article_body-nf" rows="15" required placeholder="Start writing article here." ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
						</div>
					</div>
				
					<!-- KEYWORDS -->
					<div class="row">
					    <div class="columns">
						<label for="article_tags-s" class="uppercase">Keywords</label>
						<input type="text" name="article_tags-s" id="article_tags-s" placeholder="Enter keywords" value="<?php if(isset($article['article_tags'])) echo $article['article_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />
					</div></div>
					
					<!-- DESCRIPTION -->
					<div class="row">
					    <div class="columns">
						<label for="article_desc-s" class="uppercase">Description </label>
							<input type="text" name="article_desc-s" id="article_desc-s" placeholder="Enter description" maxlegth="150" value="<?php if(isset($article['article_desc'])) echo $article['article_desc']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />
						
						</div>
					</div>

					<!-- TYPE -->
					<?php if($admin_user){?>
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
					<?php }else if($blogger){?>
						<input type="hidden" name="article_type-s" data-info="0" id="staff" value="0" />
					<?php }?>
					<!-- Article Status -->
					<?php if($admin_user  || $externalWriter){?>
					<?php
						$allStatuses = $adminController->getSiteObjectAll(array('table' => 'article_statuses'));
						//if($allStatuses && count($allStatuses)){
							//include_once($config['include_path_admin'].'previewarticle.php'); 
						//} 
						
					?>
					<div class="row <?php if($content_provider) echo 'hide'; ?>">
					    <div class="columns mobile-12 small-7">
					    	<div class="small-styled-select margin-top ">
							<label for="article_status" class="uppercase">Article Status</label>
							<select name="article_status" id="article_status" class = "status-select small-6">
							<?php
								if(!$content_provider){
									foreach($allStatuses as $statusInfo){
										$option = '<option data-preview="'.preg_replace('/"/', '&quot;', $preview_article).'" value="'.$statusInfo['status_id'].'"';
										if( $statusInfo['status_id'] == 2 ) continue;
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
					
					</div>
					<?php }?>

					<!-- PAGE LIST -->
					<?php if($admin_user){?>				
					<div class="row">
					    <div class="columns">
					    <div class="small-styled-select margin-top">
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
					</div>
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
					    	<div class="small-styled-select margin-top margin-bottom ">
								<label for="article_contributor" class="uppercase">Contributor</label>
								<select name="article_contributor" id="article_contributor">
									<option value="-1">None</option>
									<?php
										foreach($allContributors as $contributorsInfo){

											$option = '<option value="'.$contributorsInfo['contributor_id'].'"';
											if( $article['contributor_id']  && $contributorsInfo['contributor_id'] == $article['contributor_id'] ) $option .= ' selected="selected"';
											else if($article['contributor']['contributor_id'] && $contributorsInfo['contributor_id'] == $article['contributor']['contributor_id']){  $contributor_name = $contributorsInfo['contributor_name']; $option .= ' selected="selected"'; }
											$option .= '>'.$contributorsInfo['contributor_name'].'</option>';
											echo $option;
										}
									?>
								</select>
							</div>
							<input type="hidden" value="<?php echo $contributor_name; ?>" id="contributor-name" />
						</div>
					</div>

					<?php }
					}else{ 	?>
					<input type="hidden" value="<?php echo $contributorInfo['contributor_name']; ?>" id="contributor-name" />
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
								<input type="text" name="article_img_credits-s" id="article_img_credits-s" placeholder="Enter image credits" value="<?php if(isset($article['article_img_credits'])) echo $article['article_img_credits']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_img_credits') echo 'autofocus'; ?> />	
						</div>
					</div>
					
					<!-- NOTES -->
					<div class="row">
					    <div class="columns">
							<label class="uppercase" >Notes</label>
								<input type="text" name="article_additional_comments-s" id="article_additional_comments-s" placeholder="Enter additional comments" value="<?php if(isset($article['article_additional_comments'])) echo $article['article_additional_comments']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_additional_comments') echo 'autofocus'; ?> />
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
					
					<!-- RELATED ARTICLES -->
					<div class="row">
					    <div class="columns">
					    	<div class="margin-top margin-bottom ">
								<label for="article_contributor" class="uppercase">Related Article(s):</label>
								
								<div class="related_articles_box">
									<select name="related_article_1" id="related_article_1"  class="related_articles small-8">
										<option value="-1">Choose an article</option>
										<?php
											foreach($allarticles as $related_articles){
												$option = '<option value="'.$related_articles['article_id'].'" ';
												if( $related_to_this_article['related_article_id_1']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_1'] ) $option .= ' selected="selected"';
												$option .= '>'.$related_articles['article_title'].'</option>';
												echo $option;
											}
										?>
									</select>
									<input type="textbox" id="related_article_textbox_1" class="related_article_textbox small-3" name="related_article_textbox_1" />
									<i class="fa fa-search"></i>
								</div>
								
								<div class="related_articles_box">
								<select name="related_article_2" id="related_article_2" class="related_articles small-8">
										<option value="-1">Choose an article</option>
										<?php
											foreach($allarticles as $related_articles){
												$option = '<option value="'.$related_articles['article_id'].'"';
												if( $related_to_this_article['related_article_id_2']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_2'] ) $option .= ' selected="selected"';
												$option .= '>'.$related_articles['article_title'].'</option>';
												echo $option;
											}
										?>
									</select>
									<input type="textbox" id="related_article_textbox_2" class="related_article_textbox small-3" name="related_article_textbox_2" />
									<i class="fa fa-search"></i>
								</div>

								<div class="related_articles_box">
									<select name="related_article_3" id="related_article_3" class="related_articles small-8" >
										<option value="-1">Choose an article</option>
										<?php
											foreach($allarticles as $related_articles){
												$option = '<option value="'.$related_articles['article_id'].'" ';
												if( $related_to_this_article['related_article_id_3']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_3'] ) $option .= ' selected="selected"';
												$option .= '>'.$related_articles['article_title'].'</option>';
												echo $option;
											}
										?>
									</select>
									<input type="textbox" id="related_article_textbox_3" class="related_article_textbox small-3" name="related_article_textbox_3" />
									<i class="fa fa-search"></i>
								</div>
							</div>
						</div>
					</div>

					<?php if($adminController->user->data['user_type'] == 1){?>
					<!-- ADVERTISING OVERRIDE (IN-STREAM) -->
					<div class="row advertising-override">
						<div class="columns advertising-box small-12">
							<h3 class="uppercase">Advertising Override (in-Stream)</h3>
							<hr>
						</div>
						<div class="columns advertising-box small-6">
							
							<h3 class="uppercase h3-ads">Mobile</h3>
							
							<div class="advertising-providers">
								<label>Google</label>
								
								<select id="google-mobile-ad" name="google_mobile_ad" class="related_articles">
									<?php if(!$article_ads || $article_ads['mobile_google'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									?>
									<?php 
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if( $article_ads && $article_ads['mobile_google'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['mobile_google'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['mobile_google'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>
								</select>
							</div>
							
							<div class="advertising-providers">
								<label>Nativo</label>
								<select id="nativo-mobile-ad" name="nativo_mobile_ad" class="related_articles">
								 <?php if(!$article_ads || $article_ads['mobile_nativo'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									?>
									<?php 
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if($article_ads &&  $article_ads['mobile_nativo'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['mobile_nativo'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['mobile_nativo'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>	
								</select>
							</div>
						
							<div class="advertising-providers">
								<label>ShareThrough</label>
								<select id="sharethrough-mobile-ad" name="sharethrough_mobile_ad" class="related_articles">
									<?php if(!$article_ads || $article_ads['mobile_sharethrough'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if( $article_ads && $article_ads['mobile_sharethrough'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['mobile_sharethrough'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['mobile_sharethrough'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>	
								</select>
							</div>

							
							<div class="advertising-providers">
								<label>Branovate</label>
								<select id="branovate-mobile-ad" name="branovate_mobile_ad" class="related_articles">
								<?php if(!$article_ads || $article_ads['mobile_branovate'] == -1){
								 		echo '<option value="-1" selected >OFF</option>';
									  }else{ 
									  	echo '<option value="-1">OFF</option>';
									  }
									
									//if($i == 0){ 
									if( $article_ads && $article_ads['mobile_branovate'] == 0 )
										echo '<option value="0" selected >Top of Article</option>';
									else 
										echo '<option value="0" >Top of Article</option>';

									if( $article_ads && $article_ads['mobile_branovate'] == 999 ) 
										echo '<option value="999" selected >End of Article</option>';
									else 
										echo '<option value="999">End of Article</option>';
								
										
									?>	
								</select>
							</div>
						</div>

						<div class="columns advertising-box small-6">
							<h3 class="uppercase h3-ads">Desktop</h3>
							
							<div class="advertising-providers">
								<label>Google</label>
								<select id="google-desk-ad" name="google_desk_ad" class="related_articles">
									<?php if(!$article_ads || $article_ads['desk_google'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if( $article_ads && $article_ads['desk_google'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['desk_google'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['desk_google'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>	
								</select>
							</div>
					
							
							<div class="advertising-providers">
								<label>ShareThrough</label>
								<select id="sharethrough-desk-ad" name="sharethrough_desk_ad" class="related_articles">
									<?php if(!$article_ads || $article_ads['desk_sharethrough'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if( $article_ads && $article_ads['desk_sharethrough'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['desk_sharethrough'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['desk_sharethrough'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>
								</select>
							</div>
						
							<div class="advertising-providers">
								<label>Carambola</label>
								<select id="carambola-desk-ad" name="carambola_desk_ad" class="related_articles">
									<?php if(!$article_ads || $article_ads['desk_carambola'] == -1){
									 		echo '<option value="-1" selected >OFF</option>';
										  }else{ 
										  	echo '<option value="-1">OFF</option>';
										  }
									
										for($i = 0; $i<=26; $i++){
											if($i == 0){ 
												if($article_ads && $article_ads['desk_carambola'] == 0 )
													echo '<option value="'.$i.'" selected >Top of Article</option>';
												else 
													echo '<option value="'.$i.'" >Top of Article</option>';

											}elseif($i > 25){
												if( $article_ads && $article_ads['desk_carambola'] == 999 ) 
													echo '<option value="999" selected >End of Article</option>';
												else 
													echo '<option value="999">End of Article</option>';
											}else {
												if( $article_ads && $article_ads['desk_carambola'] == $i ) 
													echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
												else 
													echo '<option value="'.$i.'" >After Item '.$i.'</option>';
											}
										}
									?>
								</select>
							</div>
							
						</div>
					</div>
					<?php }?>
					<?php }?>

					<div class="row buttons-container">
						<button type="submit" id="submit" name="submit" class="">SAVE</button>
						<button type="button" id="preview" name="preview" class="">PREVIEW</button>
						<?php if( $admin_user || $blogger || $externalWriter ){
							$label = "PUBLISH";
							$val = 1;
							if( $blogger  && $article['article_status'] == 1 ){ $label = "DRAFT"; $val = 3;}
							if( $admin_user  && $article['article_status'] == 1 ){ $label = "RE-PUBLISH"; $val = 1;}
						?>
							<button type="button" data-info = "<?php echo $val; ?>" id="publish" name="publish" class=""><?php echo $label; ?></button>
						<?php }?>
					</div>
					
				</form>
			</section>

		</div>
		<?php include_once($config['include_path_admin'].'articlelib.php');?>
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
	<!--FOOTER-->
	
	<?php include_once($config['include_path_admin'].'footer.php'); ?>
	<!-- ARTICLE PREV TEMPLATE -->
	<?php include_once($config['include_path_admin'].'article_prev_template.php'); ?>
	<!-- BOTTOMSCRIPTS -->
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>

	<script>
		$('#related_article_1').filterByText($('#related_article_textbox_1'), false);
		$('#related_article_2').filterByText($('#related_article_textbox_2'), false);
		$('#related_article_3').filterByText($('#related_article_textbox_3'), false);
	</script>
</body>
</html>