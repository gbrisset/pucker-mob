<?php
	$admin = true;
	
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$seriesInfoObj = $mpVideoShows->getSerieShow($uri[2]);

	if(empty($seriesInfoObj)) $mpShared->get404();

	$adminController->user->data = $adminController->user->getUserInfo();

	$seriesInfo = $seriesInfoObj["serie_info"];
	$playlist =  $seriesInfoObj["playlist"];
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article_page_series_title-s']):
					$updateStatus = $adminController->updateSeriesMediaInfo($_POST);
					$updateStatus['arrayId'] = 'series-edit-form';
					if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
					break;

				case isset($_POST['series-add-edit-video']):
					$updateStatus = $adminController->updateSeriesPlaylist($_POST);
					$updateStatus['arrayId'] = 'series-add-edit-video';
					if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
					break;

				case isset($_POST['series-video-delete']): //Delete Article Slideshow Functionality
					$updateStatus = array_merge($mpArticleAdmin->deleteSeriesVideo($_POST['formData']));	
					break;
			}
		}else $adminController->redirectTo('logout/');
	}
	

	$imageExtension = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$seriesInfo["article_page_series_image"]);
	$wideImageUrl = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$seriesInfo["article_page_series_image"];	
	$pathToWideImage = $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$seriesInfo["article_page_series_image"];

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
			<section id="series-info">
				<header class="section-bar">
					<h2>Edit Series Info</h2>
				</header>
			</section>
			<form  class="ajax-submit-form" id="series-edit-form" name="series-edit-form" action="<?php echo $config['this_admin_url']; ?>media/editseries/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="text" class="hidden" id="s_i" name="s_i" value="<?php echo $seriesInfo['article_page_series_id']; ?>" >

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
						<label class="radio-button-label-parent">Active :</label>

						<input type="radio" name="article_page_series_active-s" id="article_page_series_active_yes" value="1" <?php if(isset($seriesInfo['article_page_series_active']) && $seriesInfo['article_page_series_active'] == 1) echo "checked"; ?> />
						<label for="article_page_live_live" class="radio-label">Yes</label>
						
						<input type="radio" name="article_page_series_active-s" id="article_page_series_active_no" value="0" <?php if(isset($seriesInfo['article_page_series_active']) && $seriesInfo['article_page_series_active'] == 0) echo "checked"; ?> />
						<label for="article_page_live_maint" class="radio-label">No</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Visible On HomePage :</label>

						<input type="radio" name="article_page_series_visible_hp-s" id="article_page_series_visible_hp_yes" value="1" <?php if(isset($seriesInfo['article_page_series_visible_hp']) && $seriesInfo['article_page_series_visible_hp'] == 1) echo "checked"; ?> />
						<label for="article_page_live_live" class="radio-label">Yes</label>
						
						<input type="radio" name="article_page_series_visible_hp-s" id="article_page_series_visible_hp_no" value="0" <?php if(isset($seriesInfo['article_page_series_visible_hp']) && $seriesInfo['article_page_series_visible_hp'] == 0) echo "checked"; ?> />
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
					</form>
				</section>
				
				<section id="series-images">
				<header class="section-bar">
					<h2>Series Image</h2>
				</header>

				<div id="series-wide-image-upload" class="image-uploader">
					<div class="image-upload-zone drop-zone">
						<p>Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>
						
						<form id="series-wide-image-upload-form" enctype="multipart/form-data" name="series-wide-image-upload-form" action="<?php echo $config['this_admin_url']; ?>media/editseries/<?php echo $uri[2]; ?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

							<input type="hidden" id="series_id" name="series_id" value="<?php echo $seriesInfo['article_page_series_id']; ?>" />
							<input type="hidden" id="currentImage" name="currentImage" value="<?php echo $seriesInfo['article_page_series_image'];?>" />

							<fieldset>
								<label for="series_wide_img">"Series" Image<span>*</span> :</label>
								<input type="file" id="series_wide_img" name="series_wide_img" required />
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
							<img class="<?php if(!file_exists($pathToWideImage)) echo 'hidden'; ?>" src="<?php echo file_exists($pathToWideImage) ? $wideImageUrl : '' ?>" alt="<?php echo $seriesInfo['article_page_series_title']; ?> Video Image" />
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

			<section id="video-article">
					<header class="section-bar">
						<h2>Manage Series Playlist</h2>
					</header>
					
					<fieldset class="series-playlist">
						<section>
							<ul>
								<?php
								if(isset($playlist) && $playlist){
								  foreach($playlist as $video_pl){
									//var_dump($video_pl);
								?>
									<li id="<?php echo $video_pl['syn_video_id'];?>">
										<div class="playlist-content">
											<div class="video-info">
												<i class="icon-play"></i>
												<h2><a href="<?php echo $config['this_admin_url'].'media/edit/'.$video_pl['syn_video_filename']?>" ><?php echo $video_pl['syn_video_title']; ?></a></h2>
												<form class="ajax-submit-form series-video-add-remove-slideshow" id="series-video-add-remove-slideshow" name="series-video-add-slideshow" action="<?php echo $config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo']; ?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
													<input type="text" class="hidden" id="v_s_i" name="v_i" value="<?php echo $video_pl['syn_video_id']; ?>" />
													<input type="text" class="hidden" id="s_i" name="s_i" value="<?php echo $seriesInfo['article_page_series_id']; ?>" />
												</form>

												<form class="ajax-submit-form series-video-add-remove-slideshow" id="series-video-add-remove-slideshow" name="series-video-add-slideshow" action="<?php echo $config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo']; ?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
													<input type="text" class="hidden" id="v_s_i" name="v_i" value="<?php echo $video_pl['syn_video_id']; ?>" />
													<input type="text" class="hidden" id="s_i" name="s_i" value="<?php echo $seriesInfo['article_page_series_id']; ?>" />
												
													<?php 
													if(isset($video_pl["article_page_series_featured_video"]) && $video_pl["article_page_series_featured_video"] == 0){?>
														<a id="series-video-add-slideshow-link" name="series-video-add-slideshow-link" href = "<?php echo $config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo'] ?>">
															<i class="icon-plus-sign"></i>Add to slideshow
														</a>
														<input type="text" class="hidden" id="action" name="action" value="series-video-add-slideshow-link" />
													<?php }
													else 
														if(isset($video_pl["article_page_series_featured_video"]) && $video_pl["article_page_series_featured_video"] == 2){?>
														<a id="series-video-remove-slideshow-link" name="series-video-remove-slideshow-link" href = "<?php echo $config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo'] ?>">
															<i class="icon-minus-sign"></i>Remove from slideshow
														</a>
														<input type="text" class="hidden" id="action" name="action" value="series-video-remove-slideshow-link" />
													<?php }?>
													
													<button name="submit" id="submit" type="submit" data-info="<?php echo $video_pl['syn_video_id']; ?>" style="display:none;"></button>
											
												</form>
												<form class="ajax-submit-form" id="series-video-delete" name="series-video-delete" action="<?php echo $config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo']; ?>" method="POST">
													<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
													<input type="text" class="hidden" id="v_i" name="v_i" value="<?php echo $video_pl['syn_video_id']; ?>" />
													<input type="text" class="hidden" id="s_i" name="s_i" value="<?php echo $seriesInfo['article_page_series_id']; ?>" />
												
													<div class="btn-wrapper delete">
														<button name="submit" id="submit" type="submit" data-info="<?php echo $video_pl['syn_video_id']; ?>" <?php if($video_pl["article_page_series_featured_video"] == 1) echo 'disabled'?> >Delete</button>
														<a href="<?php echo $config['this_admin_url'].'media/edit/'.$video_pl['syn_video_filename']; ?>"><button name="edit" id="edit" type="button">Edit</button></a>
													</div>
												</form>
											</div>
										</div>
									</li>
								<?php }
							}?>
								</ul>
							</section>
						</fieldset>
					<form  class="ajax-submit-form" id="series-add-edit-video" name="series-add-edit-video" action="<?php echo $config['this_admin_url']; ?>series/editseries/<?php echo $seriesInfo['article_page_series_seo'] ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="series_id" name="series_id-s" value="<?php echo $seriesInfo['article_page_series_id']; ?>" >
						<?php
							$allVideos = $mpVideoShows->getAllVideos([]);
							if($allVideos && count($allVideos)){
						?>
						<fieldset>
							<label for="article_video">All Videos:</label>

							<select name="series_video" id="series_video">
								<option value="-1">None</option>
								<?php
									foreach($allVideos as $video){
										$articleData = '<div class="playlist-content">';
											$articleData .= '<div class="video-info">';
												$articleData .= '<i class="icon-play"></i>';
												$articleData .= '<h2>';
													$articleData .= '<a href="'.$config['this_admin_url'].'media/edit/'.$video['syn_video_filename'].'">';
														$articleData .=$video['syn_video_title'];
													$articleData .= '</a>';
												$articleData .= '</h2>';

												$articleData .= '<form method="POST" action="'.$config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo'].'" name="series-video-delete" id="series-video-add-remove-slideshow" class="ajax-submit-form series-video-add-remove-slideshow">';
													$articleData .= '<input type="text" value="'.$_SESSION['csrf'].'" name="c_t" id="c_t" class="hidden">';
													$articleData .= '<input type="text" value="'.$video['syn_video_id'].'" name="v_i" id="v_i" class="hidden">';
													$articleData .= '<input type="text" class="hidden" id="s_i" name="s_i" value="'.$seriesInfo['article_page_series_id'].'" />';
												
													$articleData .= '<a id="series-video-add-slideshow-link" name="series-video-add-slideshow-link" href = "'.$config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo'].'">';
															$articleData .= '<i class="icon-plus-sign"></i>Add to slideshow';
														$articleData .= '</a>';
														$articleData .= '<input type="text" class="hidden" id="action" name="action" value="series-video-add-slideshow-link" />';
													$articleData .= '</form>';

												$articleData .= '<form method="POST" action="'.$config['this_admin_url'].'media/editseries/'.$seriesInfo['article_page_series_seo'].'" name="series-video-delete" id="series-video-delete" class="ajax-submit-form">';
													$articleData .= '<input type="text" value="'.$_SESSION['csrf'].'" name="c_t" id="c_t" class="hidden">';
													$articleData .= '<input type="text" value="'.$video['syn_video_id'].'" name="v_i" id="v_i" class="hidden">';
													$articleData .= '<input type="text" class="hidden" id="s_i" name="s_i" value="'.$seriesInfo['article_page_series_id'].'" />';
												
													$articleData .= '<div class="btn-wrapper delete">';
												$articleData .= '<button data-info="'.$video['syn_video_id'].'" type="submit" id="submit" name="submit">Delete</button>';
														$articleData .= '<a href="'.$config['this_admin_url'].'media/edit/'.$video['syn_video_filename'].'">';
															$articleData .= '<button type="button" id="edit" name="edit">Edit</button>';
														$articleData .= '</a>';
													$articleData .= '</div>';
												$articleData .= '</form>';
											$articleData .= '</div>';
										$articleData .= '</div>';	
										
										$option = '<option data-list="'.preg_replace('/"/', '&quot;', preg_replace('/[\n\r\t]/', '', $articleData)).'" value="'.$video['syn_video_id'].'"';
										$option .= '>'.$video['syn_video_title'].'</option>';
										echo $option;
									}
								?>
							</select>
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