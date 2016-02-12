<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_article')) $adminController->redirectTo('noaccess/');
	
	$articleResultSet = $mpArticle->getByName(array('articleSEOTitle' => $uri[2]));
	$article = $articleResultSet['articles'];

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
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1 class="mobile-12 small-12  large-8 left">Edit Article
				<?php if( $article['article_status'] == 1 )  { ?> <a href="http://www.puckermob.com/<?php echo $article['cat_dir_name'].'/'.$article['article_seo_title']; ?>" class="see-article-link right" target="_blank" ><i class="fa fa-external-link"></i>
SEE ARTICLE</a><?php }?></h1>
			</div>
			
			<section id="article-info">
				<div class="small-12 xxlarge-8 left padding margin-bottom" id="image-drop" >
					<form  id="image-drop" class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
						<div class="dz-message" data-dz-message>
							<div id="img-container">
						   		<div class="image-icon"><i class="fa fa-file-image-o font-4x"></i></div>
						   		<label class="padding-top large-font-size uppercase main-color">
						   			Add an Image to your article
								</label>
						   		<label class="margin-bottom">Drag Image here or click to upload</label>
						   		<label class="margin-top">Don't have an image?</label>

						   		<label> Choose from our free <span class="photo-library" id="search-lib">Photo Library!</span></label>
						   		<label class="mini-fonts padding-bottom margin-top-2x">Size: 784x431 pixels</label>
						   	</div>
						</div>
					</form>

					<div class="dropzone-previews">
						<?php if(file_exists($pathToTallImage)){?>
						<?php 	$tallImageUrl = $config['image_url'].'articlesites/puckermob/large/'.$article_id.'_tall.jpg';	?>
						<div id="main-image"class="dz-preview dz-image-preview dz-processing dz-success">
							<div class="dz-details">	
								<img class="data-dz-thumbnail" style="width:100%;" src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
							</div>
						</div>
						<?php }  ?>
					</div>
				</div>

				<!-- SECOND IMAGE ARTICLE MOBILE -->
				<?php //if($admin_user){ ?>
				<!--<form  method="POST" lass="margin-top" name="second-article-image" id="second-article-image" class="" enctype="multipart/form-data" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php // echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php // echo $article['article_id']; ?>" />
					<input type="hidden" id="is_second_img" name="is_second_img" value="1" />
							
					<div class="row margin-top">
						<div class="columns">
							<label for="article_seo_title-s" class="uppercase">Second Image ( Mobile  Only 300x250)</label>
							<div style="height: 35px;" class="columns small-12 no-padding">
								<input id="uploadFile" placeholder="Choose File" disabled="disabled" value=""/>
								<div class="fileUpload btn btn-primary">
								    <span>Choose</span>
								    <input name="secondImage" id="secondImage" type="file" class="upload" />
								    
								</div>
								<input type="submit" name="submit" id="submit" class="btn btn-primary" value="SAVE" />
								<span id="show-image">Preview Image<i class="fa fa-chevron-down" id="arrow-img"></i></span>
							</div>
							<?php //if(file_exists($pathToSecondImage)){?>
							<div class="columns small-12 no-padding margin-top" id="second_image_div" style="display:none;">
								<img id="" src="<?php //echo $secondImageUrl; ?>" alt="Second Image Mobile" width="100"  />
							</div>
							<?php //}?>
						</div>
					</div>
				</form>-->
				<?php //} ?>
				
				<form id="article-info-form" class="margin-top" name="article-info-form" action="<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
					<input type="hidden" id="creation_date" name="creation_date" value="<?php echo $article['creation_date']; ?>" />

					<div class="small-12 xxlarge-8 left padding margin-top">
					<!-- ARTICLE TITLE -->
					<div class="row">
					    <div class="columns">
							<input type="text" name="article_title-s" id="article_title-s" placeholder="Enter article title" value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />
						</div>
					</div>

					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
							<label for="article_seo_title-s" class="small-label">SEO Title</label>
							<input type="text" disabled  name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />
						</div>
					</div>
					<?php }else{?>
					<div class="row">
					    <div class="columns">
							<label for="article_seo_title-s" class="small-label">SEO Title</label>
							<input type="text" disabled  name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />
						</div>
					</div>
					<?php }?>
				
					
					<!-- BODY -->
					<div class="row margin-bottom  margin-top">
					    <div class="columns">
							<textarea class="mceEditor" name="article_body-nf" id="article_editor" required  ><?php if(isset($article['article_body'])) echo $article['article_body']; ?></textarea>
						</div>
					</div>

					 <script>
				      $(function() {	
				          $('#article_editor').froalaEditor({
				          	  key: 'UcbaE2hlypyospbD3ali==',
				          	  height: 420,
				          	  placeholderText: 'Start Writing Here.',
						      imageUploadURL: 'upload_images.php',

						      imageUploadParams: { id: 'my_editor' },
						      imageMaxSize: 2 * 1024 * 1024,
						      imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif']
				          });
				      });
				  	</script> 


				  	<!-- RELATED ARTICLES -->
					<div class="row" id="related-articles-section">
					    <div class="columns">
					    	<div class="margin-top margin-bottom ">
								<label for="article_contributor" class="medium-label">Related Articles:</label>
								<div class="related_articles_box">
									<select name="related_article_1" id="related_article_1"  class="related_articles small-12 xlarge-7">
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
									<input type="textbox" id="related_article_textbox_1" class="related_article_textbox small-10 xlarge-3" name="related_article_textbox_1" />
									<i class="fa fa-search"></i>
								</div>
								
								<div class="related_articles_box">
									<select name="related_article_2" id="related_article_2" class="related_articles small-12 xlarge-7">
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
									<input type="textbox" id="related_article_textbox_2" class="related_article_textbox small-10 xlarge-3" name="related_article_textbox_2" />
									<i class="fa fa-search"></i>
								</div>

								<div class="related_articles_box">
									<select name="related_article_3" id="related_article_3" class="related_articles small-12 xlarge-7" >
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
									<input type="textbox" id="related_article_textbox_3" class="related_article_textbox small-10 xlarge-3" name="related_article_textbox_3" />
									<i class="fa fa-search"></i>
								</div>
							</div>
						</div>
					</div>

					

					<?php if($pro_admin){ ?>
					<!-- ADVERTISING OVERRIDE (IN-STREAM) -->
					<div class="row advertising-override">
						<div class="columns advertising-box small-12">
							<label class="medium-label">Ads Override (in-Stream)</label>
						</div>
						<div class="columns advertising-box small-6">
							<h3 class="uppercase h3-ads">Mobile</h3>
							<?php 
							foreach($mobile_ad as $ad_info){ 
								$name = $ad_info['label'];
								$id = $ad_info['id'];
								$default = $ad_info['default_position'];
								$relation_num = $ad_info['relation_num']; 
								$target = 'mobile_'.$relation_num;
							?>
							<div class="advertising-providers small-12" id="ad-info-<?php echo $relation_num;?>">
								<label><?php echo $name; ?></label>
								<select id="mobile_<?php echo $relation_num;?>" name="mobile_<?php echo $relation_num;?>" class="related_articles small-12">
								<?php 
								if( $article_ads[$target] == -1) 
									echo '<option value="-1" selected >OFF</option>';
						   		else	
						   			echo '<option value="-1">OFF</option>';
								
								for($i = 1; $i<=30; $i++){
									if( $article_ads && $article_ads[$target] == $i ) 
										echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
									else 
										echo '<option value="'.$i.'" >After Item '.$i.'</option>';
								}
								?>
								</select>
							</div>
							<?php } ?>
						</div>	
						<div class="columns advertising-box small-6">
							<h3 class="uppercase h3-ads">Desktop</h3>
							<?php
							foreach($desktop_ad as $ad_info){ 
								$name = $ad_info['label'];
								$id = $ad_info['id'];
								$default = $ad_info['default_position'];
								$relation_num = $ad_info['relation_num']; 
								$target = 'desktop_'.$relation_num;
							?>
							<div class="advertising-providers small-12" id="ad-info-<?php echo $relation_num;?>">
								<label><?php echo $name; ?></label>
								<select id="desktop_<?php echo $relation_num;?>" name="desktop_<?php echo $relation_num;?>" class="related_articles small-12">
									<?php 
									if( $article_ads[$target] == -1) 
										echo '<option value="-1" selected >OFF</option>';
							   		else	
							   			echo '<option value="-1">OFF</option>';
									
									for($i = 1; $i<=30; $i++){
										if( $article_ads && $article_ads[$target] == $i ) 
											echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
										else 
											echo '<option value="'.$i.'" >After Item '.$i.'</option>';
									} ?>
								</select>
							</div>
							<?php  }?>
						</div>
				
					</div>
					<?php } ?>
					<?php //}?>
					</div>
					<div class="small-12 xxlarge-4 right padding" id="right-new-article">
						
						<!-- KEYWORDS -->
						<div class="row">
						    <div class="columns">
						    	<?php if(strlen($article['article_tags']) > 0 ){ echo '<label class="small-label">Tags:</label>'; }?>
						    	<textarea  class="" name="article_tags-s" id="article_tags-s"  placeholder="Enter tags"  required ><?php if(isset($article['article_tags'])) echo $article['article_tags']; ?></textarea>
						    	
							</div>
						</div>	
						
						<!-- DESCRIPTION -->
						<div class="row">
						    <div class="columns">
						    	<?php if(strlen($article['article_desc']) > 0 ){ echo '<label class="small-label">Description:</label>'; }?>
								<textarea  class="" name="article_desc-s" id="article_desc-s"  required placeholder="Enter description"  maxlength="150"><?php if(isset($article['article_desc'])) echo $article['article_desc']; ?></textarea>
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
						?>
							<div class="row">
							    <div class="columns">
							    	<label for="article_categories" class="small-label">Category:</label>
									<select id="article_categories" name="article_categories" class="small-12 left" required>
										<option value="0">CATEGORY:</option>
										<?php 
										foreach($allCategories as $category){ 
											$selected = '';

											if( $category['cat_id'] == 9 && !$admin_user) continue; 
											if(isset($article['cat_id']) && $article['cat_id'] == $category['cat_id']) $selected = 'selected';
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
						    <div class="columns">
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
						    <div class="columns mobile-12 small-12">
						    	<div class="">
									<label for="article_status" class="small-label">Status:</label>
									<select name="article_status" id="article_status" class = "">
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
						
						</div>
						<?php }?>

						

						<!-- Featured Article -->
						<?php if($admin_user && ( $contributor_type == 8 || $contributor_type == 1 || $contributor_type == 2 || $contributor_type == 6 || $contributor_type == 7 ) ){ 
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
									
							<input type="radio" name="feature_article" id="no" data-info="no"  value="0"  <?php echo $n_checked; ?> />
							<label for="" class="radio-label">No</label>
						</div></div>
						<?php }?>

						<!-- Featured Article on Homepage -->
						<?php if( $admin_user && $article['cat_id'] == "9" && $contributor_type == 8 ){?>
						<div class="row">
						    <div class="columns">
							<label class="small-4 left uppercase">Show in HomePage </label>
						
							<input type="radio" name="featured_hp" id="featured_hp-yes" data-info="1"  value="1" <?php if($article['article_featured_hp'] == 1) echo "checked"; ?> />
							<label for="" class="radio-label">Yes</label>
										
							<input type="radio" name="featured_hp" data-info="0" id="featured_hp-no" value="0"  <?php if($article['article_featured_hp'] == 0) echo "checked"; ?> />
							<label for="" class="radio-label">No</label>
							</div>
						</div>
						<?php } ?>
						
						<!-- IMAGE CREDITS -->
						<div class="row">
							<div class="columns">
								<?php if(strlen($article['article_img_credits']) > 0 ){ echo '<label class="small-label">Img Credits:</label>'; }?>
								<textarea  class="" name="article_img_credits-s" id="article_img_credits-s"  required placeholder="image credits"><?php if(isset($_POST['article_img_credits-s'])) echo $_POST['article_img_credits-s']; ?></textarea>
							</div>
						</div>

						<!-- IMAGE CREDITS URL-->
						<div class="row">
							<div class="columns">
								<?php if(strlen($article['article_img_credits_url']) > 0 ){ echo '<label class="small-label">Img Credits URL:</label>'; }?>
								<textarea  class="" name="article_img_credits_url-s" id="article_img_credits_url-s"  required placeholder="image credits URL"><?php if(isset($_POST['article_img_credits_url-s'])) echo $_POST['article_img_credits_url-s']; ?></textarea>
							</div>
						</div>

						<!-- COMMENTS -->
						<div class="row">
							<div class="columns">
								<?php if(strlen($article['article_additional_comments']) > 0 ){ echo '<label class="small-label">notes:</label>'; }?>
							   	<textarea type="text" name="article_additional_comments-s" id="article_additional_comments-s" placeholder="comments" ><?php if(isset($_POST['article_additional_comments-s'])) echo $_POST['article_additional_comments-s']; ?></textarea>
							</div>
						</div>
						
						<?php if($pro_admin){?>
						<!-- Article Read More -->
						<div class="row margin-bottom">
							<div class="columns">							
							<label for="article_read_more_pct-s" class="small-label ">Read More: </label>
							<div class="input-group small-12">
  								<span class="input-group-addon" id="sizing-addon2">%</span>
  								<input type="number" name="article_read_more_pct-s" aria-describedby="sizing-addon2" id="article_read_more_pct-s" class="form-control" min="1" max="100" value="<?php if(isset($article['article_read_more_pct'])) echo $article['article_read_more_pct']; ?>"/>
							</div>
							</div>
						</div>
						<?php }?> 

						<!-- Article Disclaimer -->
						<div class="row">
						    <div class="large-12 columns">
							<label class="uppercase label-wrapper"> Disclaimer:
						
							<input type="radio" name="article_disclaimer-s" id="disclaimer-yes" data-info="1"  value="1" <?php if($article['article_disclaimer'] == 1) echo "checked"; ?> />
							<label for="" class="radio-label">Yes</label>
										
							<input type="radio" name="article_disclaimer-s" data-info="0" id="disclaimer-no" value="0"  <?php if($article['article_disclaimer'] == 0) echo "checked"; ?> />
							<label for="" class="radio-label">No</label>
							</label>
							</div>
						</div>
					
					

					<div class="buttons-container">
						<button type="submit" id="submit" name="submit" class="">SAVE</button>
						<button type="button" id="preview" name="preview" class="">PREVIEW</button>
						<?php if( $admin_user || $blogger || $externalWriter ){
							$label = "PUBLISH";
							$val = 1;
							if( ($blogger  || $pro_blogger)  && $article['article_status'] == 1 ){ $label = "DRAFT"; $val = 3;}
							if( ($admin_user  || $pro_blogger ) && $article['article_status'] == 1 ){ $label = "RE-PUBLISH"; $val = 1;}
						?>
							<button type="button" data-info = "<?php echo $val; ?>" id="publish" name="publish" class=""><?php echo $label; ?></button>
						<?php }?>
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
	<!--FOOTER-->
	
	<?php include_once($config['include_path_admin'].'footer.php'); ?>
	<!-- ARTICLE PREV TEMPLATE -->
	<?php include_once($config['include_path_admin'].'article_prev_template.php'); ?>
	<!-- BOTTOMSCRIPTS -->
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
	<script>
		$('input[name="article_title-s"]').SDSeoTitleAutoComplete("article_seo_title-s");
	</script>
	
	<script>
		$('#related_article_1').filterByText($('#related_article_textbox_1'), false);
		$('#related_article_2').filterByText($('#related_article_textbox_2'), false);
		$('#related_article_3').filterByText($('#related_article_textbox_3'), false);
	</script>
</body>
</html>