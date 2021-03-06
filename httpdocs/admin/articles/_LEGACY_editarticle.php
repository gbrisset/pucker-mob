<?php
	$edit_page = true;
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');

	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];
	$category = $articleResultSet['categories'];

	//If no content return 404 Not Found.
	if(empty($article)) $mpShared->get404();
	
	//Check if this user has access to this article.
	$edits = $article['article_agree_edits'];
	//$lock_status = $article['article_lock_status'];
	$admin_user = false;
	if( $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2 || $adminController->user->data['user_type'] == 6) $admin_user = true;

	//Verify if Article Is locked.
	$article_locked = ( $edits == 1 && $article['article_status'] == 1 && !$admin_user );

	// If the article exists and has an id, check to see if this user has permissions to edit this article...
	if (isset($article['article_id']) ){
		$article_id = $article['article_id'];
		if ( !($adminController->user->checkUserCanEditOthers('article', $article['article_id'])) ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();
	
	$article_id = $article['article_id'];
	
	//Article ADs
	$ads = $mpArticleAdmin->getAdsInfo();
	$mobile_ad = [];
	$desktop_ad = [];
	if( $ads ){
		foreach($ads as $ad){
			if($ad['type'] == "0" ) $mobile_ad[] = $ad;
			else $desktop_ad[] = $ad;
		}
	}
	//Article Ads Spot Setting
	$article_ads = $mpArticleAdmin->getArticleAds($article);
	if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];

	//Image Info
	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';	
	$pathToTallImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';
	$pathToSecondImage = $config['image_upload_dir'].'articlesites/puckermob/second_image/second_mob_img_'.$article["article_id"].'.jpg';
	
	//Verify if Article Image file exists.
	$artImageDir =  $config['image_upload_dir'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';
	$artImageExists = false;
	if(isset($artImageDir) && !empty($artImageDir) && !is_null($artImageDir)){
		$artImageExists = file_exists($artImageDir);
	}
	
	//Contributor Info
	$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
	$contributor_email = $adminController->user->data['user_email'];
	$contributorInfo = $contributorInfo[0];
	$contributor_id = $article['contributor_id'];
	$contributor_type = $adminController->getContributorUserType($contributor_id);
	if($contributor_type != false) $contributor_type =  $contributor_type["user_type"]; else $contributor_type = false;
	
	//GET ALL ARTICLES 
	$allarticles = $mpArticle->getAllLiveArticlesPerContributor( $contributor_id );

	//Relate Articles
	$related_to_this_article = $mpArticle->getRelatedToArticle( $article['article_id'] );
	$featured_article = $adminController->getFeaturedArticle( $article['article_id'] );

	// SUMMIT FORM
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article_title-s']):
			if( $_POST["a_i"] == 17835) {

				if($_POST['article_status'] == 1){
					if($artImageExists){
						$updateStatus = $adminController->updateArticleInfo($_POST);
					}else{
						$updateStatus["hasError"] = true;
						$updateStatus["message"] = "You need to add an image to make an article live!"; ?>
						<script>alert( "<?php echo $updateStatus["message"]; ?>" );</script>
						<?php
					}
				}else{
					$updateStatus = $adminController->updateArticleInfo($_POST);
				}
			}else{
				$updateStatus = $adminController->updateArticleInfo($_POST);
			}
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
				case isset($_POST['is_second_img']):
						if (!empty($_FILES)) { 
							$updateStatus = array_merge($mpArticleAdmin->uploadBasicImage($_FILES, [
								'allowedExtensions' => 'png,jpg,jpeg,gif',
								'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/second_image/',
								'articleId' => $_POST['a_i'],
								'imgData' => $_POST,
								'desWidth' => 300,
								'desHeight' => 250
							]), ['arrayId' => 'second-article-image']);
						}
				break;

			}
			
			$articleObj = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
			$category = $articleObj['categories'];
			$article = $articleObj['articles'];
			$related_to_this_article = $mpArticle->getRelatedToArticle( $article['article_id'] );

			$featured_article = $adminController->getFeaturedArticle($article['article_id']);

			//Article ADs
			$article_ads = $mpArticleAdmin->getArticleAds($article);
			if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];
			
		}else $adminController->redirectTo('logout/');
	}
	$field_disable = '';
	if($article_locked) $field_disable = 'disabled = "disabled"';
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="editarticle">
	<?php include_once($config['include_path_admin'].'header.php');?>
	<style>
		.dropzone .dz-error .dz-error-message, .dropzone-previews .dz-error .dz-error-message {
		    top: 0rem !important;
		    display: inline-block !important;
		}
    </style>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12">
				<h1>VIEW & EDIT ARTICLE 
				<?php if( $article['article_status'] == 1 )  { ?> 
					<a href="http://www.puckermob.com/<?php echo $category[0]['cat_dir_name'].'/'.$article['article_seo_title']; ?>" class="see-article-link right" target="_blank" >
						<i class="fa fa-external-link"></i>
						SEE ARTICLE
					</a>
				<?php }?>
				</h1>
			</div>

			<section id="article-info" class="small-12 columns">

			<?php 
				$tallImageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg';
				if( !$article_locked ){ 
					include_once($config['include_path_admin'].'drop_image_edit_new.php'); 
				}else{
					echo "<div class='small-12 xxlarge-8 columns no-padding inline-flex'><div class='small-12 large-8 columns image-drop-wrapper align-center'><img src=".$tallImageUrl." /></div><div id='did-u-know' class='small-12 large-4 columns show-for-large-up'><div class='small-12 columns'>
	 		<h2>DID YOU KNOW…</h2>
	 		<p>Good, original images will help increase your chances of building an audience.</p>
	 		<br>
	 		<p>But pics are your responsibility - please make sure you’re not violating anybody’s copyright or privacy.</p>
	 	</div></div></div>";
				}
			?>
				
				<form id="article-info-form" class="margin-top" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article_id; ?>" />
					<input type="hidden" id="creation_date" name="creation_date" value="<?php echo $article['creation_date']; ?>" />
					<input type="hidden"  name="article_seo_title-s" id="article_seo_title-s" value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required />
					<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
					<input type="hidden" id="u_type" name="u_type" value="<?php echo $adminController->user->data['user_type']; ?>" />
					<input  type="hidden" id="is_starter" name="is_starter" value ="<?php echo $starter_blogger; ?>" >
					<input  type="hidden" id="is_locked" name="is_locked" value ="<?php echo $article_locked; ?>" >

					<div class="small-12 xxlarge-8 columns margin-top">
						<!-- ARTICLE LOCKED -->
						<?php if( $article_locked ){ ?>
						<!-- ARTICLE TITLE -->
						<div class="row ">
							<div>
								<input  type="text" name="article_title-s" id="article_title-s" placeholder="WRITE YOUR TITLE" value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required disabled />
							</div>

							<!-- BODY -->
							<div class=" margin-bottom margin-top" >
								<div>

									<div id="article_editor" class="fr-element" value="<?php echo $article['article_body']; ?>" style="max-height: 350px; overflow: scroll; border: 1px solid #ddd; background-color: white; padding: 10px; "><?php if(isset($article['article_body'])) echo $article['article_body']; ?></div>
								</div>
							</div>
						</div>
						<?php }else{?>
						<!-- ARTICLE TITLE -->
						<div class="row ">
							<div>
								<input  type="text" name="article_title-s" id="article_title-s" placeholder="WRITE YOUR TITLE" value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
							</div>
						</div>

						<!-- BODY -->
						<div class="row margin-bottom margin-top" >
							<div>
								<textarea class="editor" name="article_body-nf" id="article_editor"  ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
							</div>
						</div>

						<?php }?>

						<!-- RELATED ARTICLES -->
						<?php include_once($config['include_path_admin'].'related_edit_articles.php'); ?>
						
						<?php if($pro_admin){ ?>
							<!-- ADVERTISING OVERRIDE (IN-STREAM) -->
							<?php include_once($config['include_path_admin'].'ads_override.php'); ?>
						<?php } ?>
					</div>

					<div class="small-12 xxlarge-4 right padding " id="right-new-article">		
						<div class="row label-wrapper show-for-xxlarge-up ">
							<div class="small-12 large-4 column no-padding">
								<button type="button" id="preview" name="preview" class="show-for-large-up radius wide-button preview-button" style="height: 3.3rem;">PREVIEW</button>
							</div>
							<div class="small-12 large-4 column">
								<button type="button" id="save-existing-article" class="columns small-6 radius wide-button elm save-existing-article" name="save-existing-article"  style="height: 3.3rem;" >SAVE</button>
							</div>
							
							<?php if( $admin_user || $blogger || $externalWriter ){
							$label = "PUBLISH";
							$val = 1;
							//if( ($blogger  || $starter_blogger )  && $article['article_status'] == 1 ){ $label = "DRAFT"; $val = 3;}
							if( ($admin_user  || $pro_blogger ) && $article['article_status'] == 1 ){ $label = "RE-PUBLISH"; $val = 1;} ?>
								<div class="small-12 large-4 column  left no-padding">
									<button type="button" data-info = "1" id="publish-article" name="publish-article"  class="columns small-6 radius wide-button elm show-for-large-up publish-button" style="height: 3.3rem;" >PUBLISH</button>
								</div>
							<?php }?>
						
						</div>		

						<?php if( $article_locked ){ ?>
						<!-- KEYWORDS -->
						<div class="row">
						    <div>
						    	<textarea  disabled class="" name="article_tags-nf" id="article_tags-s"  placeholder="Enter tags"   ><?php if(isset($article['article_tags'])) echo $article['article_tags']; ?></textarea>
							</div>
						</div>	
						
						<!-- DESCRIPTION -->
						<div class="row">
						    <div>
								<textarea  disabled name="article_desc-s" id="article_desc-s"  placeholder="Enter description"  maxlength="150"><?php if(isset($article['article_desc'])) echo $article['article_desc']; ?></textarea>
							</div>
						</div>
						<?php }else{?>
						<!-- KEYWORDS -->
						<div class="row">
						    <div>
						    	<textarea   class="" name="article_tags-nf" id="article_tags-s"  placeholder="Enter tags"   ><?php if(isset($article['article_tags'])) echo $article['article_tags']; ?></textarea>
							</div>
						</div>	
						
						<!-- DESCRIPTION -->
						<div class="row">
						    <div>
								<textarea name="article_desc-s" id="article_desc-s"  placeholder="Enter description"  maxlength="150"><?php if(isset($article['article_desc'])) echo $article['article_desc']; ?></textarea>
							</div>
						</div>
						<?php }?>	
						
						<?php if($admin_user){?>
							<input type="hidden" name="article_type-s" data-info="0" id="staff" value="<?php echo $article['article_type']; ?> " />
						<?php }else if($blogger){?>
							<input type="hidden" name="article_type-s" data-info="0" id="staff" value="0" />
						<?php }?>

						<!-- ARTICLE CATEGORY -->
						<?php 

						if( $blogger ){?>
							<input type="hidden"  name="article_categories" id="article_categories" value="9" />
						<?php }else{
							$allCategories = $MPNavigation->getAllCategoriesWithArticles();
							if($allCategories && count($allCategories)){
								
								if(isset($category[0]) && $category[0]){
									$category = $category[0];
								}
						?>
							<div class="row">
							    <div>
							    	<label for="article_categories" class="small-label">Category:</label>
									<select id="article_categories" name="article_categories" class="small-12 left" required>
										<option value="0">CATEGORY:</option>
										<?php 
										foreach($allCategories as $cat){ 
											$selected = '';

											if( $cat['cat_id'] == 9 && !$admin_user) continue; 
											if( $cat['cat_id'] == $category['cat_id'] ) $selected = 'selected';
										?>
											<option id="<?php echo 'category-'.$cat['cat_id']; ?>" value="<?php echo $cat['cat_id']; ?>" <?php echo $selected; ?>><?php echo $cat['cat_name']; ?></option>
									<?php }?>
									</select>									
								</div>
							</div>
							<?php }
						}?>

						<!-- Show Contributor List -->
						<?php
						if($admin_user){
							$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
							if($allContributors && count($allContributors)){
						?>
						<div class="row">
						    	<div>
									<label for="article_contributor" class="small-label">Contributor:</label>
									<select name="article_contributor" id="article_contributor">
										<option value="-1">None</option>
										<?php
											foreach($allContributors as $contributorsInfo){
												$contributor_name = $contributorsInfo['contributor_name'];
												
												$option = '<option value="'.$contributorsInfo['contributor_id'].'"';
												if( isset($article['contributor_id'])  && $contributorsInfo['contributor_id'] == $article['contributor_id'] ) $option .= ' selected="selected"';
												else if($article['contributor_id'] && $contributorsInfo['contributor_id'] == $article['contributor_id']){  $contributor_name = $contributorsInfo['contributor_name']; $option .= ' selected="selected"'; }
												$option .= '>'.$contributorsInfo['contributor_name'].'</option>';
												echo $option;
											}
										?>
									</select>
								</div>
								<input type="hidden" value="<?php echo $contributor_name; ?>" id="contributor-name" />
								<label for="article_contributor" class="small-label margin-bottom">Email: <?php echo $article['contributor_email_address']; ?></label>

						</div>

						<?php }
						}else{ 	?>
							<input type="hidden" value="<?php echo $contributorInfo['contributor_name']; ?>" id="contributor-name" />
							<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
						<?php } ?>

						<!-- Article Status -->
						<?php // if($admin_user  || $externalWriter){

							$allStatuses = $adminController->getSiteObjectAll(array('table' => 'article_statuses'));
						?>
						<div class="row <?php if(isset($content_provider) && $content_provider ) echo 'hide'; ?>">
						    <div>
						    		<label for="article_status" class="small-label padding-bottom padding-top">Status:
						    		<?php if( !$admin_user){ 
					    				switch($article['article_status']){
					    					case '1': $status = "LIVE";
					    					break;
					    					case '2': $status = "REVIEW";
					    					break;
					    					case '3': $status = "DRAFT";
					    					break;
					    					default: $status="DRAFT";
					    				}
						    		?>
						    			<span style=" color: #aaa; font-size: 1.2rem !important; margin-left: 1rem;" id="status-label">
						    				<?php echo $status?>
						    			</span>
						    		</label>
						    		<?php }else{?>
						    			</label>
										<select name="article_status" id="article_status">

									<?php
										if(!isset($content_provider)){ 
											foreach($allStatuses as $statusInfo){
												$option = '<option data-preview="" value="'.$statusInfo['status_id'].'"';
												if($statusInfo['status_id'] == $article['article_status']) $option .= ' selected="selected"';
												
												$option .= '>'.$statusInfo['status_label'].'</option>';
												echo $option; 
											}
										}else{ 
												$option = '<option value="3"';
												$option .= '>Draft</option>';
												$option .= '<option value="2"';
												$option .= '>Reviewed</option>';
												echo $option;
										}
									?>
									</select>
									<?php }?>
							</div>
						
						</div>
						<?php //}?>

						<?php if($admin_user){?>
							<!-- Article Featured -->
							<div class="row <?php if(isset($content_provider) && $content_provider ) echo 'hide'; ?>">
						    	<div>
						    		<label for="article_featured" class="small-label">Featured Article:</label>
									<select name="article_featured" id="article_featured">
										<option value="-1" >Featured Article</option>
										<option value="1" <?php if($featured_article) echo "selected"; ?> > YES </option>
										<option value="0" <?php if(!$featured_article) echo "selected"; ?> >NO </option>
									</select>
								</div>
							</div>
							
							<!-- VIDEO SCRIPT -->
							<div class="row">
								<div>
									<label for="article_featured" class="small-label">VIDEO SCRIPT:</label>
									<textarea  class="" name="article_video_script-nf" id="article_video_script-nf"  placeholder="VIDEO SCRIPT"><?php echo $article['article_video_script']; ?></textarea>
								</div>
							</div>


						<?php }?>
						<?php if( !$article_locked ){ ?>
							<!-- IMAGE CREDITS -->
							<div class="row">
								<div>
									<textarea  class="" name="article_img_credits-s" id="article_img_credits-s"  placeholder="image credits"><?php if(isset($_POST['article_img_credits-s'])) echo $_POST['article_img_credits-s']; ?></textarea>
								</div>
							</div>

							<!-- IMAGE CREDITS URL-->
							<div class="row">
								<div>
									<textarea  class="" name="article_img_credits_url-s" id="article_img_credits_url-s"  placeholder="image credits URL"><?php if(isset($_POST['article_img_credits_url-s'])) echo $_POST['article_img_credits_url-s']; ?></textarea>
								</div>
							</div>

							<!-- COMMENTS -->
							<div class="row">
								<div>
								   	<textarea type="text" name="article_additional_comments-s" id="article_additional_comments-s" placeholder="comments" ><?php if(isset($_POST['article_additional_comments-s'])) echo $_POST['article_additional_comments-s']; ?></textarea>
								</div>
							</div>
						<?php }?>
						
						<?php if($pro_admin){?>
						<!-- Article Read More -->
						<div class="row">
							<div>							
								<div class="input-group small-12">
									<div class="small-9 columns no-padding">
		  								<span class="input-group-addon small-2 columns" id="sizing-addon2">%</span>
		  								<input style="width: 83%;" type="number" name="article_read_more_pct-s" id="article_read_more_pct-s" class="small-10 columns" min="1" max="100" value="<?php if(isset($article['article_read_more_pct'])) echo $article['article_read_more_pct']; ?>"/>
		  							</div>
		  							<div class="small-3 columns no-padding">
		  								<span class="postfix">READ MORE</span>
		  							</div>
								</div>
							</div>
						</div>
						<?php }?> 

						<?php if($admin_user){?>
						<!-- Article Disclaimer -->
						<div class="row">
						    <div>
							<label class="uppercase label-wrapper"> Disclaimer:
						
							<input type="radio" name="article_disclaimer-s" id="disclaimer-yes" data-info="1"  value="1" <?php if($article['article_disclaimer'] == 1) echo "checked"; ?> />
							<label for="" class="radio-label">Yes</label>
										
							<input type="radio" name="article_disclaimer-s" data-info="0" id="disclaimer-no" value="0"  <?php if($article['article_disclaimer'] == 0) echo "checked"; ?> />
							<label for="" class="radio-label">No</label>
							</label>
							</div>
						</div>
						<?php }?> 

						<?php if( !$article_locked ){ ?>
						<div class="row label-wrapper show-for-large-up">
							<div class="small-12 large-6 column no-padding"><button type="button" id="preview" name="preview" class="show-for-large-up radius preview-button"  style="height: 3.3rem;">PREVIEW</button></div>
							<div class="small-12 large-6 column">
								<button type="button" id="save-existing-article" class="columns small-6 radius wide-button elm save-existing-article" name="save-existing-article"  style="height: 3.3rem;" >SAVE</button>
							</div>
						</div>
						
						
						<?php include_once($config['include_path_admin'].'agreement_edits.php');?>
						
						<div class="row label-wrapper hide-for-large-up ">
							<div class="small-12 large-4 column no-padding hide-for-large-up">
								<button class="small-12 large-5 columns radius" type="submit" id="submit" name="submit" style="background-color: #016201;" >SAVE</button>
							</div>
							<div class="small-12 large-4 column  left no-padding hide-for-large-up">
								<button type="button" data-info = "1" id="publish-article" name="publish-article"  class="columns small-6 radius wide-button elm publish-button" style="background-color: #016201;" >PUBLISH</button>
							</div>
						</div>	

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
	
  	

	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>

	<?php include_once($config['include_path_admin'].'showerrors_articles.php'); ?>

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