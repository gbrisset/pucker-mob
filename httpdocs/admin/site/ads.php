<?php
	if(!$adminController->user->checkPermission('user_permission_show_ad_settings')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['300_atf-nf']):
					$updateStatus = $adminController->updateAdCodes($_POST);
					$updateStatus['arrayId'] = 'ad-code-settings-form';
					break;
				case isset($_POST['ads_rotate']):
					$updateStatus = $adminController->updateAdTiming($_POST);
					$updateStatus['arrayId'] = 'ad-timing-settings-form';
					break;

				case isset($_POST['ad-sponsor-settings-form']):
					$updateStatus = array_merge($mpArticleAdmin->updateSponsoredBy($_POST), ['arrayId' => 'ad-sponsor-settings-form']);
					break;

				case isset($_FILES['sponsored_by_img']):
					$updateStatus = $adminController->updateImageRecord($_FILES, array(
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'currentImage' => $article['sponsored_by_img'],
						'table' => 'article_images',
						'column' => 'sponsored_by_img',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/',
						'whereClause' => 'article_page_id = '.$mpArticle->data['article_page_id'],
						'successMessage' => 'Sposored Logo Image updated successfully!'
					));
					$updateStatus['arrayId'] = 'sponsored-by-image-upload-form';
					break;					

				case isset($_FILES['sponsored_super_banner']):
					$updateStatus = $adminController->updateImageRecord($_FILES, array(
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'currentImage' => $article['sponsored_super_banner'],
						'table' => 'article_images',
						'column' => 'sponsored_super_banner',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/',
						'whereClause' => 'article_page_id = '.$mpArticle->data['article_page_id'],
						'successMessage' => 'Super Banner image updated successfully!'
					));
					$updateStatus['arrayId'] = 'article-preview-image-upload-form';
					break;	


			}
			$mpArticle->reloadSiteData();
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
		
		<div id="content" class="site-settings">
			<section id="ad-code-settings">













				<header class="section-bar">
					<h2>Ad Placement Settings</h2>
				</header>

				<form class="ajax-submit-form" id="ad-code-settings-form" name="ad-code-settings-form" action="<?php echo $config['this_admin_url']; ?>site/ads" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label for="300_atf-nf">300x250 ATF Ad Code<span>*</span> :</label>
						<textarea name="300_atf-nf" id="300_atf-nf" rows="10" placeholder="Please enter the ad code for the 300x250 ATF placement here." required ><?php if(isset($mpArticle->data['300_atf'])) echo $mpArticle->data['300_atf']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the 300x250 above the fold placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="300_btf1-nf">300x250 BTF 1 Ad Code<span>*</span> :</label>
						<textarea name="300_btf1-nf" id="300_btf1-nf" rows="10" placeholder="Please enter the ad code for the 300x250 BTF 1 placement here." required ><?php if(isset($mpArticle->data['300_btf1'])) echo $mpArticle->data['300_btf1']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the first 300x250 below the fold placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="300_btf2-nf">300x250 BTF 2 Ad Code<span>*</span> :</label>
						<textarea name="300_btf2-nf" id="300_btf2-nf" rows="10" placeholder="Please enter the ad code for the 300x250 BTF 2 placement here." required ><?php if(isset($mpArticle->data['300_btf2'])) echo $mpArticle->data['300_btf2']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the second 300x250 below the fold placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="300_mobile-nf">300x250 Mobile Ad Code<span>*</span> :</label>
						<textarea name="300_mobile-nf" id="300_mobile-nf" rows="10" placeholder="Please enter the ad code for the 300x250 Mobile placement here." required ><?php if(isset($mpArticle->data['300_mobile'])) echo $mpArticle->data['300_mobile']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the 300x250 mobile placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="728_atf-nf">728x90 ATF Ad Code<span>*</span> :</label>
						<textarea name="728_atf-nf" id="728_atf-nf" rows="10" placeholder="Please enter the ad code for the 728x90 ATF placement here." required ><?php if(isset($mpArticle->data['728_atf'])) echo $mpArticle->data['728_atf']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the 728x90 above the fold placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="728_btf-nf">728x90 BTF Ad Code<span>*</span> :</label>
						<textarea name="728_btf-nf" id="728_btf-nf" rows="10" placeholder="Please enter the ad code for the 728x90 BTF placement here." required ><?php if(isset($mpArticle->data['728_btf'])) echo $mpArticle->data['728_btf']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown in the 728x90 below the fold placement.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="sponsored_placement-nf">Sponsored Placement Code<span>*</span> :</label>
						<textarea name="sponsored_placement-nf" id="sponsored_placement-nf" rows="10" placeholder="Please enter the ad code for the Sponsored Placement here." required ><?php if(isset($mpArticle->data['sponsored_placement'])) echo $mpArticle->data['sponsored_placement']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad code that will be shown on article pages (Taboola, Ad Excite, etc).</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-code-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-code-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>

			<section id="ad-timing-settings">
				<header class="section-bar">
					<h2>Ad Timing Settings</h2>
				</header>

				<form class="ajax-submit-form" id="ad-timing-settings-form" name="ad-timing-settings-form" action="<?php echo $config['this_admin_url']; ?>site/ads" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label class="radio-button-label-parent">Ad Rotation :</label>

						<input type="radio" name="ads_rotate" id="ads_rotate_enabled" value="ads_rotate_enabled" <?php if(isset($mpArticle->data['ads_rotate']) && $mpArticle->data['ads_rotate'] == 1) echo "checked"; ?> />
						<label for="ads_rotate_enabled" class="radio-label">Enabled</label>
						
						<input type="radio" name="ads_rotate" id="ads_rotate_disabled" value="ads_rotate_disabled" <?php if(isset($mpArticle->data['ads_rotate']) && $mpArticle->data['ads_rotate'] == 0) echo "checked"; ?> />
						<label for="ads_rotate_disabled" class="radio-label">Disabled</label>
					</fieldset>

					<fieldset>
						<label for="ad_rotation_time-n">Ad Rotation Interval<span>*</span> :</label>
						<input type="number" name="ad_rotation_time-n" id="ad_rotation_time-n" placeholder="Please enter the interval you wish ads to rotate at." step="10" value="<?php if(isset($mpArticle->data['ad_rotation_time'])) echo $mpArticle->data['ad_rotation_time']; ?>" required />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the interval at which ads will rotate if rotation is enabled.  It will have no effect if rotation is disabled, however.  Values are in seconds.  Ex: 240 = rotate ads every 4 minutes.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-timing-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-timing-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>


			


			<section id="ad-sponsor-settings">
				<header class="section-bar">
					<h2>Sponser Settings</h2>
				</header>

				<form class="ajax-submit-form" id="ad-sponsor-settings-form" name="ad-sponsor-settings-form" action="<?php echo $config['this_admin_url']; ?>site/ads" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $mpArticle->data['article_page_id'] ?>" >
					<fieldset>
						<label class="radio-button-label-parent">Site Sponser :</label>

						<input type="radio" name="has_sponsored_by-s" id="sponsored_enabled" value="1" <?php if(isset($mpArticle->data['has_sponsored_by']) && $mpArticle->data['has_sponsored_by'] == 1) echo "checked"; ?> />
						<label for="sponsored_enabled" class="radio-label">Enabled</label>
						
						<input type="radio" name="has_sponsored_by-s" id="sponsored_disabled" value="0" <?php if(isset($mpArticle->data['has_sponsored_by']) && $mpArticle->data['has_sponsored_by'] == 0) echo "checked"; ?> />
						<label for="sponsored_disabled" class="radio-label">Disabled</label>
					</fieldset>

					<fieldset>
						<label for="sponsored_by_url-s">Sponsored By URL <span>*</span> :</label>
						<input type="text" name="sponsored_by_url-s" id="sponsored_by_url-s" placeholder="Please enter the name of the directory where the site's assets can be found." value="<?php if(isset($mpArticle->data['sponsored_by_url'])) echo $mpArticle->data['sponsored_by_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'sponsored_by_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the link to the sponsor's website and will by placed on their logo image that appears to the right of our main navigation.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="sponsored_super_banner_url-s">Super Banner URL <span>*</span> :</label>
						<input type="text" name="sponsored_super_banner_url-s" id="sponsored_super_banner_url-s" placeholder="Please enter the name of the directory where the site's assets can be found." value="<?php if(isset($mpArticle->data['sponsored_super_banner_url'])) echo $mpArticle->data['sponsored_super_banner_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'sponsored_super_banner_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the link to the sponsor's website - or a secondary link (facebook fan page) and will by placed on their 'super banner'</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-sponsor-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'ad-sponsor-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>

				<div id="sponsored-by-image-upload" class="image-uploader">
					<div class="image-upload-zone">
						<p>Drop Sponsor's LOGO image here</p>
						<!--<p>Drop LOGO IMAGE here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>-->						
						<form id="sponsored-by-image-upload-form" enctype="multipart/form-data" name="sponsored-by-image-upload-form" action="<?php echo $config['this_admin_url']; ?>site/ads" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $mpArticle->data['article_page_id']; ?>" >
							<input type="hidden" id="currentImage" name="currentImage" value="<?php echo (isset($mpArticle->data['sponsored_by_img'])) ? $mpArticle->data['sponsored_by_img'] : 'unset'; ?>" />

							<fieldset>
								<label for="sponsored-by_img">Sponsor Logo Image<span>*</span> :</label>
								<input type="file" id="sponsored-by_img" name="sponsored_by_img" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>This is the sponsor's LOGO image.  It is shown on the right hand side of the site's main navigation.</p>
						<div class="image-bg">
							<img class="<?php if(empty($mpArticle->data['sponsored_by_img'])) echo 'hidden'; ?>" src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/'.$mpArticle->data['sponsored_by_img']; ?>" alt="Sponsor Logo Image" />
							<?php if(empty($mpArticle->data['sponsored_by_img'])){ ?>
								<p class="no-img">This sponsor doesn't have a logo image yet!</p>
							<?php } ?>
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sponsored-by-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sponsored-by-image-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>


				<div id="sponsored-super-banner-upload" class="image-uploader">
					<div class="image-upload-zone">
						<p>Drop Sponsor's Super Banner image here</p>
						<!--<p>Drop LOGO IMAGE here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>-->						
						<form id="sponsored-super-banner-upload-form" enctype="multipart/form-data" name="sponsored-super-banner-upload-form" action="<?php echo $config['this_admin_url']; ?>site/ads" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="text" class="hidden" id="c_p_i" name="c_p_i" value="<?php echo $mpArticle->data['article_page_id']; ?>" >
							<input type="hidden" id="currentImage" name="currentImage" value="<?php echo (isset($mpArticle->data['sponsored_super_banner'])) ? $mpArticle->data['sponsored_super_banner'] : 'unset'; ?>" />

							<fieldset>
								<label for="sponsored-by_img">Sponsor Super Banner Image<span>*</span> :</label>
									<input type="file" id="sponsored-super-banner" name="sponsored_super_banner" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>This is the sponsor's Super Banner image.  It is shown wherever the superbanenr is displayed</p>
						<div class="image-bg">
							<img class="<?php if(empty($mpArticle->data['sponsored_super_banner'])) echo 'hidden'; ?>" src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/'.$mpArticle->data['sponsored_super_banner']; ?>" alt="Sponsor Super Banner Image" />
							<?php if(empty($mpArticle->data['sponsored_super_banner'])){ ?>
								<p class="no-img">This sponsor doesn't have a Super Banner image yet!</p>
							<?php } ?>
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sponsored-super-banner-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'sponsored-super-banner-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>

			</section>



















		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>