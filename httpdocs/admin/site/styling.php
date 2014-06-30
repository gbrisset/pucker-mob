<?php
	if(!$adminController->user->checkPermission('user_permission_show_styling_settings')) $adminController->redirectTo('noaccess/');

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['article_page_bg_color-s']):
					$updateStatus = $adminController->updateStylingSettings($_POST);
					$updateStatus['arrayId'] = 'styling-settings-form';
					break;
				case isset($_POST['featured_img_link-u']):
					$updateStatus = $adminController->updateFeautredImageLink($_POST);
					$updateStatus['arrayId'] = 'featured-image-link-form';
					break;
				case isset($_FILES['article_page_player_logo']):
					$updateStatus = array_merge(
						$mpArticleAdmin->uploadSiteImage($_FILES, [
							'allowedExtensions' => 'png,jpg,jpeg,gif',
							'imgType' => 'playerlogo',
							'currentImage' => $mpArticle->data['article_page_player_logo']
						]), ['arrayId' => 'player-logo-image-upload-form']);
					break;
				case isset($_FILES['article_page_logo']):
					$updateStatus = array_merge(
						$mpArticleAdmin->uploadSiteImage($_FILES, [
							'allowedExtensions' => 'png,jpg,jpeg,gif',
							'imgType' => 'headerlogo',
							'currentImage' => $mpArticle->data['article_page_logo']
						]), ['arrayId' => 'header-image-upload-form']);
					break;
				case isset($_FILES['article_page_footer_logo']):
					$updateStatus = array_merge(
						$mpArticleAdmin->uploadSiteImage($_FILES, [
							'allowedExtensions' => 'png,jpg,jpeg,gif',
							'imgType' => 'footerlogo',
							'currentImage' => $mpArticle->data['article_page_footer_logo']
						]), ['arrayId' => 'footer-image-upload-form']);
					break;			
			}
			$mpArticle->reloadSiteData();
		}else  $adminController->redirectTo('logout/');
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
			<section id="styling-settings">
				<header class="section-bar">
					<h2>Styling Settings</h2>
				</header>

				<form class="ajax-submit-form" id="styling-settings-form" name="styling-settings-form" action="<?php echo $config['this_admin_url']; ?>site/styling" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label for="article_page_bg_color-s">Background Color<span>*</span> :</label>
						<input type="text" name="article_page_bg_color-s" id="article_page_bg_color-s" placeholder="Please enter a color for the site's background here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_bg_color'])) echo $mpArticle->data['article_page_bg_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_bg_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the color for the site's background.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_player_accent_color-s">Player Accent Color<span>*</span> :</label>
						<input type="text" name="article_page_player_accent_color-s" id="article_page_player_accent_color-s" placeholder="Please enter a color for the site's player accent color here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_player_accent_color'])) echo $mpArticle->data['article_page_player_accent_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_player_accent_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the accent color for the site's player.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_bar_color-s">Site Accent Color<span>*</span> :</label>
						<input type="text" name="article_page_bar_color-s" id="article_page_bar_color-s" placeholder="Please enter a color for the site's accent color here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_bar_color'])) echo $mpArticle->data['article_page_bar_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_bar_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>

						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the main accent color for the site.  It's used throughout the design and will effect all pages.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_header_bg_color-s">Header Background Color<span>*</span> :</label>
						<input type="text" name="article_page_header_bg_color-s" id="article_page_header_bg_color-s" placeholder="Please enter a color for the site's header background here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_header_bg_color'])) echo $mpArticle->data['article_page_header_bg_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_header_bg_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the color for the site's header background.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_header_link_color-s">Header Link Color<span>*</span> :</label>
						<input type="text" name="article_page_header_link_color-s" id="article_page_header_link_color-s" placeholder="Please enter a color for the site's header links here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_header_link_color'])) echo $mpArticle->data['article_page_header_link_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_header_link_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the color for the site's header links.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_header_link_hover_color-s">Header Link Hover Color<span>*</span> :</label>
						<input type="text" name="article_page_header_link_hover_color-s" id="article_page_header_link_hover_color-s" placeholder="Please enter a color for the site's header links when hovered here." class="picker-input" value="<?php if(isset($mpArticle->data['article_page_header_link_hover_color'])) echo $mpArticle->data['article_page_header_link_hover_color']; ?>" pattern="^#?(([a-fA-F0-9]){3}){1,2}$" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_header_link_hover_color') echo 'autofocus'; ?> />

						<div class="picker-element"></div>
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the color for the site's header links when hovered over by a mouse.  A hex (starting with a hash sign #) value is accepted. Ex: #fff, #e36c0a.</p>
							</div>
						</div>

						<div class="colorpicker-parent">
							<div class="colorpicker"></div>						
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'styling-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'styling-settings-form') echo $updateStatus['message']; ?>
							</p>
							
							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>

			<section id="logo-settings">
				<header class="section-bar">
					<h2>Update Header Logo</h2>
				</header>

				<div id="header-logo-image-upload" class="image-uploader">
					<div class="image-upload-zone">
						<p>Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>
						
						<form id="header-logo-image-upload-form" enctype="multipart/form-data" name="header-logo-image-upload-form" action="<?php echo $config['this_admin_url']; ?>site/styling" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<fieldset>
								<label for="article_page_logo">Logo Image<span>*</span> :</label>
								<input type="file" id="article_page_logo" name="article_page_logo" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>Preview :</p>

						<div class="image-bg">
							<img src="<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_logo']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name']; ?> Logo" />
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'header-logo-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'header-logo-image-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>
			</section>

			<section id="logo-settings">
				<header class="section-bar">
					<h2>Update Footer Logo</h2>
				</header>

				<div id="footer-logo-image-upload" class="image-uploader">
					<div class="image-upload-zone">
						<p>Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>
						
						<form id="footer-logo-image-upload-form" enctype="multipart/form-data" name="logo-image-upload-form" action="<?php echo $config['this_admin_url']; ?>site/styling" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<fieldset>
								<label for="article_page_footer_logo">Logo Image<span>*</span> :</label>
								<input type="file" id="article_page_footer_logo" name="article_page_footer_logo" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>Preview :</p>

						<div class="image-bg">
							<img src="<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_footer_logo']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name']; ?> Logo" />
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'footer-logo-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'footer-logo-image-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>
			</section>

			<section id="player-logo-settings">
				<header class="section-bar">
					<h2>Update Player Logo</h2>
				</header>

				<div id="player-logo-image-upload" class="image-uploader">
					<div class="image-upload-zone">
						<p>Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.</p>
						
						<form id="player-logo-image-upload-form" enctype="multipart/form-data" name="player-logo-image-upload-form" action="<?php echo $config['this_admin_url']; ?>site/styling" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<fieldset>
								<label for="article_page_player_logo">Player Logo Image<span>*</span> :</label>
								<input type="file" id="article_page_player_logo" name="article_page_player_logo" required />
							</fieldset>

							<fieldset>
								<div class="btn-wrapper">
									<button type="submit" id="submit" name="submit">Submit</button>
								</div>
							</fieldset>
						</form>
					</div>

					<div class="image-preview">
						<p>Preview :</p>

						<div class="image-bg">
							<img src="<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name']; ?> Player Logo" />
						</div>
					</div>

					<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'player-logo-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'player-logo-image-upload-form') echo $updateStatus['message']; ?>
					</p>
				</div>
			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>