<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');
	
	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];
	$category = $articleResultSet['categories'];

	if(empty($article)) $mpShared->get404();

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
	$article_ads = $mpArticleAdmin->getArticleAds($article);
	if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];

	//Image Info
	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;	
	$pathToTallImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$article["article_id"].'_tall.jpg';//.$tallExtension;
	$pathToSecondImage = $config['image_upload_dir'].'articlesites/puckermob/second_image/second_mob_img_'.$article["article_id"].'.jpg';
	$secondImageUrl = $config['image_url'].'articlesites/puckermob/second_image/second_mob_img_'.$article["article_id"].'.jpg?'.rand(1, 100000000000);	
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
	$allarticles = $mpArticle->getAllLiveArticles();

	//Relate Articles
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
			
			$article = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
			$article = $article['articles'];
			$related_to_this_article = $mpArticle->getRelatedToArticle( $article['article_id'] );
			$category = $article['categories'];


			//Article ADs
			$article_ads = $mpArticleAdmin->getArticleAds($article);
			if($article_ads && isset($article_ads[0])) $article_ads = $article_ads[0];
			
		}else $adminController->redirectTo('logout/');
	}
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="editarticle">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12">
				<h1>VIEW & EDIT ARTICLE 
				<?php if( $article['article_status'] == 1 )  { ?> 
					<!--<a href="http://www.puckermob.com/<?php echo $article['cat_dir_name'].'/'.$article['article_seo_title']; ?>" class="see-article-link right" target="_blank" >
						<i class="fa fa-external-link"></i>
						SEE ARTICLE
					</a>-->
				<?php }?>
				</h1>
			</div>

			<section id="article-info" class="small-12 columns">

			<?php if(file_exists($pathToTallImage)){
				$tallImageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg';
				include_once($config['include_path_admin'].'dropbox_image_edit.php');	
			?>

			<?php }else{  ?>
				<?php include_once($config['include_path_admin'].'dropbox_image.php'); ?>	
			<?php } ?>
				
				<form id="article-info-form" class="margin-top" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
					<input type="hidden" id="creation_date" name="creation_date" value="<?php echo $article['creation_date']; ?>" />

					<div class="small-12 xxlarge-8 columns margin-top">
					<!-- ARTICLE TITLE -->
					<div class="row ">
						<div>
							<input type="text" name="article_title-s" id="article_title-s" placeholder="WRITE YOUR TITLE" value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
						</div>
					</div>

					<input type="hidden"  name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required />
					
					
					<!-- BODY -->
					<div class="row margin-bottom margin-top" >
						<div>
							<textarea class="editor" name="article_body-nf" id="article_editor" required  ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
						</div>
					</div>

	 
				  	<!-- RELATED ARTICLES -->
					<?php include_once($config['include_path_admin'].'related_edit_articles.php'); ?>

					
					<?php if($pro_admin){ ?>
						<!-- ADVERTISING OVERRIDE (IN-STREAM) -->
						<?php include_once($config['include_path_admin'].'ads_override.php'); ?>
					<?php } ?>
				
					</div>
					
					<div class="small-12 xxlarge-4 right padding " id="right-new-article">		
						<div class="row label-wrapper show-for-xxlarge-up ">
							<div class="small-12 large-4 column no-padding"><button type="button" id="preview" name="preview" class="show-for-large-up">PREVIEW</button></div>
							<div class="small-12 large-4 column"><button type="submit" id="submit" class="columns small-6 radius wide-button elm" name="submit" >SAVE</button></div>
							<?php if( $admin_user || $blogger || $externalWriter ){
							$label = "PUBLISH";
							$val = 1;
							if( ($blogger  || $pro_blogger)  && $article['article_status'] == 1 ){ $label = "DRAFT"; $val = 3;}
							if( ($admin_user  || $pro_blogger ) && $article['article_status'] == 1 ){ $label = "RE-PUB"; $val = 1;} ?>
								<div class="small-12 large-4 column  left no-padding"><button type="button" data-info = "<?php echo $val; ?>" id="publish" name="publish"  class="columns small-6 radius wide-button elm show-for-large-up"><?php echo $label; ?></button></div>
							<?php }?>
						</div>		

						<!-- KEYWORDS -->
						<div class="row">
						    <div>
						    	<textarea  class="" name="article_tags-s" id="article_tags-s"  placeholder="Enter tags"  required ><?php if(isset($article['article_tags'])) echo $article['article_tags']; ?></textarea>
							</div>
						</div>	
						
						<!-- DESCRIPTION -->
						<div class="row">
						    <div>
								<textarea  name="article_desc-s" id="article_desc-s"  required placeholder="Enter description"  maxlength="150"><?php if(isset($article['article_desc'])) echo $article['article_desc']; ?></textarea>
							</div>
						</div>	
						
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
										foreach($allCategories as $category){ 
											$selected = '';

											if( $category['cat_id'] == 9 && !$admin_user) continue; 
											if(isset($category['cat_id']) && $category['cat_id'] == $category['cat_id']) $selected = 'selected';
										?>
											<option id="<?php echo 'category-'.$category['cat_id']; ?>" value="<?php echo $category['cat_id']; ?>" <?php echo $selected; ?>><?php echo $category['cat_name']; ?></option>
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
							
						</div>

						<?php }
						}else{ 	?>
							<input type="hidden" value="<?php echo $contributorInfo['contributor_name']; ?>" id="contributor-name" />
							<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
						<?php } ?>

						<!-- Article Status -->
						<?php if($admin_user  || $externalWriter){?>
						<?php
							$allStatuses = $adminController->getSiteObjectAll(array('table' => 'article_statuses'));
						?>
						<div class="row <?php if(isset($content_provider) && $content_provider ) echo 'hide'; ?>">
						    <div>
						    		<label for="article_status" class="small-label">Status:</label>
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
							</div>
						
						</div>
						<?php }?>
						
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

						<div class="row label-wrapper show-for-large-up hide-for-xxlarge-up">
							<div class="small-12 large-4 column no-padding"><button type="button" id="preview" name="preview" class="show-for-large-up">PREVIEW</button></div>
							<div class="small-12 large-4 column"><button type="submit" id="submit" name="submit" style="background-color: #016201;" >SAVE</button></div>
							<?php if( $admin_user || $blogger || $externalWriter ){
							$label = "PUBLISH";
							$val = 1;
							if( ($blogger  || $pro_blogger)  && $article['article_status'] == 1 ){ $label = "DRAFT"; $val = 3;}
							if( ($admin_user  || $pro_blogger ) && $article['article_status'] == 1 ){ $label = "RE-PUB"; $val = 1;} ?>
								<div class="small-12 large-4 column  left no-padding"><button type="button" data-info = "<?php echo $val; ?>" id="publish" name="publish"  class="show-for-large-up" style="background: #622000; "><?php echo $label; ?></button></div>
							<?php }?>
						</div>
					
						<div class="row label-wrapper hide-for-large-up ">
							<div class="small-12 large-4 column no-padding hide-for-large-up">
								<button class="small-12 large-5 columns radius" type="submit" id="submit" name="submit" style="background-color: #016201;" >SAVE</button>
							</div>
							
						</div>	
					
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

	<!-- ARTICLE PREV TEMPLATE -->
	<?php include_once($config['include_path_admin'].'article_prev_template.php'); ?>
	
	<!-- BOTTOMSCRIPTS -->
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
	<script>
		$('input[name="article_title-s"]').SeoTitleAutoComplete("article_seo_title-s");
	</script>
	
	<script>
		$('#related_article_1').filterByText($('#related_article_textbox_1'), false);
		$('#related_article_2').filterByText($('#related_article_textbox_2'), false);
		$('#related_article_3').filterByText($('#related_article_textbox_3'), false);
	</script>
</body>
</html>