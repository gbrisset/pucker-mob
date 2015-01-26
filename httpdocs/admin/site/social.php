<?php
	if(!$adminController->user->checkPermission('user_permission_show_social_settings')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->updateSocialSettings($_POST);
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
			<section id="social-network-settings">
				<header class="section-bar">
					<h2>Social Networking Settings</h2>
				</header>

				<form class="ajax-submit-form" id="social-network-settings-form" name="social-network-settings-form" action="<?php echo $config['this_admin_url']; ?>site/social" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<fieldset>
						<label for="article_page_contact_email-e">Contact Email Address<span>*</span> :</label>
						<input type="email" name="article_page_contact_email-e" id="article_page_contact_email-e" placeholder="Please enter the contact email address for this site here." value="<?php if(isset($mpArticle->data['article_page_contact_email'])) echo $mpArticle->data['article_page_contact_email']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_contact_email') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the email address that will be linked to the site and receive any contact emails.  A valid email address must be entered.  Ex: example@example.com</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_advertise_contact_email-e">Advertise Email Address<span>*</span> :</label>
						<input type="email" name="article_page_advertise_contact_email-e" id="article_page_advertise_contact_email-e" placeholder="Please enter the advertise contact email address for this site here." value="<?php if(isset($mpArticle->data['article_page_advertise_contact_email'])) echo $mpArticle->data['article_page_advertise_contact_email']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_advertise_contact_email') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the email address that will be linked to the site and receive any contact emails from the advertise with us form.  A valid email address must be entered.  Ex: example@example.com</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_facebook_url-u">Facebook Page URL<span>*</span> :</label>
						<input type="url" name="article_page_facebook_url-u" id="article_page_facebook_url-u" placeholder="Please enter the URL for the site's Facebook page here." value="<?php if(isset($mpArticle->data['article_page_facebook_url'])) echo $mpArticle->data['article_page_facebook_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_facebook_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the site's Facebook page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_facebook_gallery_url-u">Facebook Gallery URL<span>*</span> :</label>
						<input type="url" name="article_page_facebook_gallery_url-u" id="article_page_facebook_gallery_url-u" placeholder="Please enter the URL for the site's Facebook gallery page here." value="<?php if(isset($mpArticle->data['article_page_facebook_gallery_url'])) echo $mpArticle->data['article_page_facebook_gallery_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_facebook_gallery_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the site's Facebook gallery page.  This URL may be the same as the 'Facebook url' link.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_facebook_app_id-s">Facebook App ID<span>*</span> :</label>
						<input type="text" name="article_page_facebook_app_id-s" id="article_page_facebook_app_id-s" placeholder="Please enter the Facebook App ID for the site here." value="<?php if(isset($mpArticle->data['article_page_facebook_app_id'])) echo $mpArticle->data['article_page_facebook_app_id']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_facebook_app_id') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the Facebook App ID for the sharing button on article pages.  Each site must have a App ID in order to share articles via Facebook.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_twitter_url-u">Twitter URL<span>*</span> :</label>
						<input type="url" name="article_page_twitter_url-u" id="article_page_twitter_url-u" placeholder="Please enter the URL for the site's Twitter page here." value="<?php if(isset($mpArticle->data['article_page_twitter_url'])) echo $mpArticle->data['article_page_twitter_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_twitter_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the site's Twitter page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_pinterest_url-u">Pinterest URL<span>*</span> :</label>
						<input type="url" name="article_page_pinterest_url-u" id="article_page_pinterest_url-u" placeholder="Please enter the URL for the site's Pinterest page here." value="<?php if(isset($mpArticle->data['article_page_pinterest_url'])) echo $mpArticle->data['article_page_pinterest_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_pinterest_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the site's Pinterest page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_googleplus_url-u">Google+ URL<span>*</span> :</label>
						<input type="url" name="article_page_googleplus_url-u" id="article_page_googleplus_url-u" placeholder="Please enter the URL for the site's Google+ page here." value="<?php if(isset($mpArticle->data['article_page_googleplus_url'])) echo $mpArticle->data['article_page_googleplus_url']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_googleplus_url') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the site's Google + page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<label for="article_page_newletter_api_key-s">Newsletter API Key<span>*</span> :</label>
						<input type="text" name="article_page_newletter_api_key-s" id="article_page_newletter_api_key-s" placeholder="Please enter the API key for the newsletter service." value="<?php if(isset($mpArticle->data['article_page_newletter_api_key'])) echo $mpArticle->data['article_page_newletter_api_key']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_newletter_api_key') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the API key from the newsletter service (MailChimp).  You can get this key by logging into our MailChimp account.  An API key is needed to allow newsletter signups.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_page_newletter_list_id-s">Newsletter List ID<span>*</span> :</label>
						<input type="text" name="article_page_newletter_list_id-s" id="article_page_newletter_list_id-s" placeholder="Please enter the list ID for the newsletter service." value="<?php if(isset($mpArticle->data['article_page_newletter_list_id'])) echo $mpArticle->data['article_page_newletter_list_id']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_newletter_list_id') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ID from the newsletter service (MailChimp) that corresponds with the list designated for this site.  You can get this ID by logging into our MailChimp account.  A list ID is needed to allow newsletter signups.</p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<label for="article_page_sell_sheet">Sell Sheet Document<span>*</span> :</label>
						<input type="text" name="article_page_sell_sheet" id="article_page_sell_sheet" placeholder="Please enter the Sell Sheet document name." value="<?php if(isset($mpArticle->data['article_page_sell_sheet'])) echo $mpArticle->data['article_page_sell_sheet']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_page_sell_sheet') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the pdf document sell sheet that correspond to the site.</p>
							</div>
						</div>
					</fieldset>
					 

					<fieldset>
						<label class="checkbox-group-label-parent">Article Share Buttons :</label>
						
						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_facebook" name="articles_have_facebook" <?php if(isset($mpArticle->data['articles_have_facebook']) && $mpArticle->data['articles_have_facebook'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_facebook">Facebook</label>
						</div>

						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_twitter" name="articles_have_twitter" <?php if(isset($mpArticle->data['articles_have_twitter']) && $mpArticle->data['articles_have_twitter'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_twitter">Twitter</label>
						</div>

						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_pinterest" name="articles_have_pinterest" <?php if(isset($mpArticle->data['articles_have_pinterest']) && $mpArticle->data['articles_have_pinterest'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_pinterest">Pinterest</label>
						</div>

						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_googleplus" name="articles_have_googleplus" <?php if(isset($mpArticle->data['articles_have_googleplus']) && $mpArticle->data['articles_have_googleplus'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_googleplus">Google +</label>
						</div>

						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_linkedin" name="articles_have_linkedin" <?php if(isset($mpArticle->data['articles_have_linkedin']) && $mpArticle->data['articles_have_linkedin'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_linkedin">LinkedIn</label>
						</div>

						<div class="checkbox-group">
							<input type="checkbox" id="articles_have_ziplist" name="articles_have_ziplist" <?php if(isset($mpArticle->data['articles_have_ziplist']) && $mpArticle->data['articles_have_ziplist'] == 1) echo "checked"; ?> />
							<label class="checkbox-label" for="articles_have_ziplist">ZipList Recipe Box</label>
						</div>
					</fieldset>
					
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'social-network-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'social-network-settings-form') echo $updateStatus['message']; ?>
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