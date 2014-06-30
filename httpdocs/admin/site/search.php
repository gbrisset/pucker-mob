<?php
	if(!$adminController->user->checkPermission('user_permission_show_search_settings')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->updateSiteSearch($_POST);
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
		
		<div id="content" class ='site-settings'>
			<section id="search-engine-settings">
				<header class="section-bar">
					<h2>Search Engine Settings</h2>
				</header>

				<form class="ajax-submit-form" id="search-engine-settings-form" name="search-engine-settings-form" action="<?php echo $config['this_admin_url']; ?>site/search" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<fieldset>
						<label for="google_cxid-s">Search Custom Key<span>*</span> :</label>
						<input type="text" name="google_cxid-s" id="google_cxid-s" placeholder="Please enter the search engine's custom key here." value="<?php if(isset($mpArticle->data['google_cxid'])) echo $mpArticle->data['google_cxid']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'google_cxid') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the API key provided by Google's Custom Search Engine for the site search.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="google_csoutput-s">Search Output Format<span>*</span> :</label>
						<input type="text" name="google_csoutput-s" id="google_csoutput-s" placeholder="Please enter the search engine's output format here." value="<?php if(isset($mpArticle->data['google_csoutput'])) echo $mpArticle->data['google_csoutput']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'google_csoutput') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the output format for results returned from Google's Custom Search Engine</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="google_csclient-s">Search Client Code<span>*</span> :</label>
						<input type="text" name="google_csclient-s" id="google_csclient-s" placeholder="Please enter the search engine's client code here." value="<?php if(isset($mpArticle->data['google_csclient'])) echo $mpArticle->data['google_csclient']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'google_csclient') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the client code for Google's Custom Search Engine.  It must be "google-csbe".</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="google_csnum-s">Search Results Number<span>*</span> :</label>
						<input type="text" name="google_csnum-s" id="google_csnum-s" placeholder="Please enter the number of results you'd like returned here." value="<?php if(isset($mpArticle->data['google_csnum'])) echo $mpArticle->data['google_csnum']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'google_csnum') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the number of search results to be returned from Google's Custom Search Engine.</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'search-engine-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'search-engine-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>