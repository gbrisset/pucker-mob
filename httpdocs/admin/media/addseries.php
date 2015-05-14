<?php
	$admin = true;
	
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->addSeries($_POST);
			$updateStatus['arrayId'] = 'series-add-form';
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
					<h2>Add New Series</h2>
				</header>
			</section>
			<form  class="ajax-submit-form" id="series-add-form" name="series-add-form" action="<?php echo $config['this_admin_url']; ?>media/editseries/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<fieldset>
						<label for="article_page_series_title-s">Series Title<span>*</span> :</label>
						<input type="text" name="article_page_series_title-s" id="article_page_series_title-s" placeholder="Please enter the series title here." 
							value="<?php if(isset($seriesInfo['article_page_series_title'])) echo $seriesInfo['article_page_series_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_series_title') echo 'autofocus'; ?> />
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the series title that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_series_seo-s">Series SEO Title<span>*</span> :</label>
						<input type="text" name="article_page_series_seo-s" id="article_page_series_seo-s" placeholder="Please enter the series seo title here." 
							value="<?php if(isset($seriesInfo['article_page_series_seo'])) echo $seriesInfo['article_page_series_seo']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_series_seo') echo 'autofocus'; ?> />
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the article's title that will be used in URLs throughout the network.</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<label for="article_page_series_desc-s">Series Description<span>*</span> :</label>
						<textarea  class="elm-wysiwyg" name="article_page_series_desc-s" id="article_page_series_desc-s" rows="10" placeholder="Please enter the series description here." <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_series_desc-s') echo 'autofocus'; ?> ><?php if(isset($seriesInfo['article_page_series_desc'])) echo $seriesInfo['article_page_series_desc']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the description text that will appear in search engines, social networks, etc for the series.</p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<label for="article_page_series_prev_desc-s">Series Prev. Description<span>*</span> :</label>
						<input type="text" name="article_page_series_prev_desc-s" id="article_page_series_prev_desc-s"  value="<?php if(isset($seriesInfo['article_page_series_prev_desc'])) echo $seriesInfo['article_page_series_prev_desc']; ?>" placeholder="Please enter an small description of series description here." required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_series_prev_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is a shorter description of the series that will appear throughout the site.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_series_tags-s">Series Tags:</label>
						<input type="text" name="article_page_series_tags-s" id="article_page_series_tags-s"  value="<?php if(isset($seriesInfo['article_page_series_tags'])) echo $seriesInfo['article_page_series_tags']; ?>" placeholder="Please tags here." <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_series_prev_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Here add the tags of the series.</p>
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