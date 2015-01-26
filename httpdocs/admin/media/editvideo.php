<?php
	$admin = true;
	
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$videoInfo = $mpVideoShows->getVideoInfo(['videoSeoName' => $uri[2]]);

	if(empty($videoInfo)) $mpShared->get404();

	$adminController->user->data = $adminController->user->getUserInfo();

	$videoInfo = $videoInfo [0];
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['syn_video_title-s']):
					$updateStatus = $adminController->UpdateVideoMediaInfo($_POST);
					$updateStatus['arrayId'] = 'video-edit-form';
					if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
					break;
				
				case isset($_POST['visible_on_article-s']):
					$updateStatus = $mpArticleAdmin->updateVideoArticleInfo($_POST);
					$updateStatus['arrayId'] = 'video-add-edit-article';
					if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
					break;
				
				case isset($_POST['video_id']):
					$updateStatus =  $mpArticleAdmin->deleteVideoMediaInfo($_POST);
					$updateStatus['arrayId'] = 'video-delete-form';
					if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
					break;
				}
		}else $adminController->redirectTo('logout/');
	}
	

	$imageExtension = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$videoInfo["syn_video_id"].'-video-wide');
	$wideImageUrl = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$videoInfo["syn_video_id"].'-video-wide.'.$imageExtension;	
	$pathToWideImage = $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$videoInfo["syn_video_id"].'-video-wide.'.$imageExtension;
	
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
		
		<div id="content">
			<section id="video-info">
				<header class="section-bar">
					<h2>Edit Video Info</h2>
				</header>
			</section>
			<form  class="ajax-submit-form" id="video-edit-form" name="video-edit-form" action="<?php echo $config['this_admin_url']; ?>video/new/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="text" class="hidden" id="v_i" name="v_i" value="<?php echo $videoInfo['syn_video_id']; ?>" >

					<fieldset>
						<label for="syn_video_title-s">Video Title<span>*</span> :</label>
						<input type="text" name="syn_video_title-s" id="syn_video_title-s" placeholder="Please enter the video's title here." 
							value="<?php if(isset($videoInfo['syn_video_title'])) echo $videoInfo['syn_video_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_title') echo 'autofocus'; ?> />
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the video's title that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="syn_video_desc-s">Video Description<span>*</span> :</label>
						<input type="text" name="syn_video_desc-s" id="syn_video_desc-s" placeholder="Please enter the video's description here." value="<?php if(isset($videoInfo['syn_video_desc'])) echo $videoInfo['syn_video_desc']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is a shorter description of the video that will appear throughout the site as a summy of the article.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="syn_video_tags-s">Video Keywords :</label>
						<input type="text" name="syn_video_tags-s" id="syn_video_tags-s" placeholder="Please enter the video's tags here." value="<?php if(isset($videoInfo['syn_video_tags'])) echo $videoInfo['syn_video_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that will show up in search engines, social networks, etc for this video.  They should be separated with a comma.  Keywords are limited to 1500 characters.</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<label for="syn_video_filename-s">Video FileName<span>*</span> :</label>
						<input type="text" name="syn_video_filename-s" id="syn_video_filename-s" placeholder="Please enter the video's filename here." value="<?php if(isset($videoInfo['syn_video_filename'])) echo $videoInfo['syn_video_filename']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_filename') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the video name</p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-add-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-add-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
					</form>
				</section>
				
				<section id="video-article">
					<header class="section-bar">
						<h2>Add article to Video</h2>
					</header>
					<form  class="ajax-submit-form" id="video-add-edit-article" name="video-add-edit-article" action="<?php echo $config['this_admin_url']; ?>video/new/" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="syn_video_id" name="syn_video_id-s" value="<?php echo $videoInfo['syn_video_id']; ?>" >
						<?php
							$videoArticle = $mpVideoShows->getArticleInfoPerVideo($videoInfo['syn_video_id']);
							$allArticles = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM articles  WHERE article_status = 1 ORDER BY article_title ASC'));
							if($allArticles && count($allArticles)){
						?>
						<fieldset>
							<label for="article_video">Related Article:</label>

							<select name="article_id-s" id="article_video">
								<option value="-1">None</option>
								<?php
									foreach($allArticles as $articleInfo){
										$option = '<option value="'.$articleInfo['article_id'].'"';
										if($articleInfo['article_id'] == $videoArticle[0]['article_id']) $option .= ' selected="selected"';
										$option .= '>'.$articleInfo['article_title'].'</option>';
										echo $option;
									}
								?>
							</select>
						</fieldset>
						<fieldset>
							<label class="radio-button-label-parent">Visible On Article Page :</label>

							<input type="radio" name="visible_on_article-s" id="visible_on_article_yes" value="1" <?php if(isset($videoArticle[0]['visible_on_article']) && $videoArticle[0]['visible_on_article'] == 1) echo "checked"; ?> checked/>
							<label for="article_page_live_live" class="radio-label">Yes</label>
							
							<input type="radio" name="visible_on_article-s" id="visible_on_article_no" value="0" <?php if(isset($videoArticle[0]['visible_on_article']) && $videoArticle[0]['visible_on_article'] == 0) echo "checked"; ?> />
							<label for="article_page_live_maint" class="radio-label">No</label>
						</fieldset>
						<fieldset>
							<div class="btn-wrapper">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-add-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-add-form') echo $updateStatus['message']; ?>
								</p>

								<button type="submit" id="submit" name="submit">Submit</button>
							</div>
						</fieldset>
						<?php } ?>
					</form>
				</section>
				
				<section id="video-images">
				<header class="section-bar">
					<h2>Video Image</h2>
				</header>

				<div id="video-wide-image-upload" class="image-uploader">
					<div class="image-upload-zone drop-zone">
						<p>Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>
						
						<form id="video-wide-image-upload-form" enctype="multipart/form-data" name="video-wide-image-upload-form" action="<?php echo $config['this_admin_url']; ?>media/edit/<?php echo $uri[2]; ?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

							<input type="hidden" id="video_id" name="video_id" value="<?php echo $videoInfo['syn_video_id']; ?>" />
							<input type="hidden" id="currentImage" name="currentImage" value="<?php echo $videoInfo['syn_video_id']; ?>-video-wide.jpg" />

							<fieldset>
								<label for="video_wide_img">"Wide" Image<span>*</span> :</label>
								<input type="file" id="video_wide_img" name="video_wide_img" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>Photo Preview :</p>
							
						<div class="image-bg">
							<img class="<?php if(!file_exists($pathToWideImage)) echo 'hidden'; ?>" src="<?php echo file_exists($pathToWideImage) ? $wideImageUrl : '' ?>" alt="<?php echo $videoInfo['syn_video_title']; ?> Video Image" />

							<?php if(!file_exists($pathToWideImage)){ ?>
								<p class="no-img">This article doesn't have an wide image yet!</p>
							<?php } ?>
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-wide-image-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>

			</section>

			<section id="video-delete">
				<header class="section-bar">
					<h2>Delete this Video</h2>
				</header>
				<form class="ajax-submit-form" id="video-delete-form" name="video-delete-form" action="<?php echo $config['this_admin_url']; ?>media/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="v_i" name="v_i" value="<?php echo $videoInfo['syn_video_id']; ?>" />
					<input type="hidden" id="video_i" name="video_i" value="<?php echo $videoInfo['syn_video_id']; ?>" />
					
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-delete-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'video-delete-form') echo $updateStatus['message']; ?>
							</p>
							<button type="submit" id="submit" name="submit">Delete Video</button>
						</div>
					</fieldset>
				</form>
			</section>
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