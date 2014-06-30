<?php
	$admin = true;
	
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->addArticle($_POST);
			$updateStatus['arrayId'] = 'video-add-form';
			if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
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
		
		<div id="content">
			<section id="video-info">
				<header class="section-bar">
					<h2>Add New Video</h2>
				</header>
			</section>
			<form  class="ajax-submit-form" id="video-add-form" name="video-add-form" action="<?php echo $config['this_admin_url']; ?>video/new/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label for="syn_video_title-s">Video Title<span>*</span> :</label>
						<input type="text" name="syn_video_title-s" id="syn_video_title-s" placeholder="Please enter the video's title here." value="<?php if(isset($_POST['syn_video_title-s'])) echo $_POST['syn_video_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the video's title that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="syn_video_desc-s">Video Description<span>*</span> :</label>
						<input type="text" name="syn_video_desc-s" id="syn_video_desc-s" placeholder="Please enter the video's description here." value="<?php if(isset($_POST['syn_video_desc-s'])) echo $_POST['syn_video_desc-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is a shorter description of the video that will appear throughout the site as a summy of the article.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="syn_video_tags-s">Video Keywords :</label>
						<input type="text" name="syn_video_tags-s" id="syn_video_tags-s" placeholder="Please enter the video's tags here." value="<?php if(isset($_POST['syn_video_tags-s'])) echo $_POST['syn_video_tags-s']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that will show up in search engines, social networks, etc for this video.  They should be separated with a comma.  Keywords are limited to 1500 characters.</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<label for="syn_video_filename-s">Video FileName<span>*</span> :</label>
						<input type="text" name="syn_video_filename-s" id="syn_video_filename-s" placeholder="Please enter the video's filename here." value="<?php if(isset($_POST['syn_video_filename-s'])) echo $_POST['syn_video_filename-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'syn_video_filename') echo 'autofocus'; ?> />

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