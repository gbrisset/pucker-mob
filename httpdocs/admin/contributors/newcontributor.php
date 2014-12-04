<?php
	if(!$adminController->user->checkPermission('user_permission_show_add_contributor')) $adminController->redirectTo('noaccess/');

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $mpArticleAdmin->addContributor($_POST);
			$updateStatus['arrayId'] = 'contributor-add-form';
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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">New Contributor</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up">
			<h1 class="left">New Article</h1>
			
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="contributor-info">
				<section class="section-bar left  border-bottom mobile-12 small-12 margin-bottom">
					<h1 class="left">List Information</h1>
				</section>

				<form class="ajax-submit-form" id="contributor-add-form" name="contributor-add-form" action="<?php echo $config['this_admin_url']; ?>contributors/new" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<fieldset>
						<label for="contributor_name-s">Contributor Name<span>*</span> :</label>
						<input type="text" name="contributor_name-s" id="contributor_name-s" placeholder="Please enter the contributor's name here." value="<?php if(isset($_POST['contributor_name-s'])) echo $_POST['contributor_name-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's name that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_seo_name-s">Contributor SEO Name<span>*</span> :</label>
						<input type="text" name="contributor_seo_name-s" id="contributor_seo_name-s" placeholder="Please enter the contributor's seo-formatted name here." value="<?php if(isset($_POST['contributor_seo_name-s'])) echo $_POST['contributor_seo_name-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_seo_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's name that will be used in URLs throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_location-s">Contributor Location :</label>
						<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="Please enter the contributor's location here." value="<?php if(isset($_POST['contributor_location-s'])) echo $_POST['contributor_location-s']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's location that will be used throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_blog_link-s">Contributor Blog URL :</label>
						<input type="url" name="contributor_blog_link-s" id="contributor_blog_link-s" placeholder="Please enter the contributor's blog URL here." value="<?php if(isset($_POST['contributor_blog_link-s'])) echo $_POST['contributor_blog_link-s']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_blog_link') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the contributor's blog page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_email_address-e">Contributor Email Address <span>*</span>:</label>
						<input type="email" name="contributor_email_address-e" id="contributor_email_address-e" placeholder="Please enter the contact email address for this site here." value="<?php if(isset($_POST['contributor_email_address-e'])) echo $_POST['contributor_email_address-e']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's email address that will be used on the site and receive any contact emails.  A valid email address must be entered.  Ex: example@example.com</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_twitter_handle-s">Contributor Twitter Handle :</label>
						<input type="text" name="contributor_twitter_handle-s" id="contributor_twitter_handle-s" placeholder="Please enter the contributor's twitter handle here." value="<?php if(isset($_POST['contributor_twitter_handle-s'])) echo $_POST['contributor_twitter_handle-s']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_twitter_handle') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's twitter handle that will be used throughout the network.  Twitter handles must have an '@' symbol in front of it.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_facebook_link-s">Contributor Facebook URL:</label>
						<input type="url" name="contributor_facebook_link-s" id="contributor_facebook_link-s" placeholder="Please enter the contributor's facebook url here." value="<?php if(isset($contributorInfo['contributor_facebook_link'])) echo $contributorInfo['contributor_facebook_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_facebook_link') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's facebook url that will be used throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_bio-nf">Contributor Bio :</label>
						<textarea class="elm-wysiwyg" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Please enter the contributor's bio here." ><?php if(isset($_POST['contributor_bio-nf'])) echo $_POST['contributor_bio-nf']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's bio that will be used throughout the network.  HTML is accepted.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-add-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-add-form') echo $updateStatus['message']; ?>
							</p>

							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-add-form' && $updateStatus['hasError'] !== true){ ?>
								<script type="text/javascript">
									setTimeout(function(){
										window.location = "<?php echo $config['this_admin_url']; ?>contributors/edit/<?php echo $updateStatus['contributorDetails'][':contributor_seo_name']; ?>";
									}, 3000);
								</script>
							<?php } ?>

							<button type="submit" id="submit" name="submit" class="radius">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>