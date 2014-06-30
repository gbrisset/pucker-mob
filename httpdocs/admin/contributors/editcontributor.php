<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_contributor')) $adminController->redirectTo('noaccess/');
	
	$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2] ])['contributors'];

	if(empty($contributorInfo)) $mpShared->get404();
	$contributorInfo = $contributorInfo[0];
	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($contributorInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $contributorInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}

	//Verify if is a content provider user
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	//Verify if contributor Image file exists.
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image'];
	$contImageUrl =  $config['image_url'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image']; ;
	$contImageExists = false;

	if(isset($contImageDir) && !empty($contImageDir) && $contributorInfo['contributor_image'] && !is_null($contImageDir)){
		$contImageExists = file_exists($contImageDir);
	}

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['contributor_name-s']):
					$updateStatus = array_merge($mpArticleAdmin->updateContributorInfo($_POST), ['arrayId' => 'contributor-info-form']);
					$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2]])['contributors'][0];
					break;
				
				case isset($_FILES['contributor_wide_img']):
					$updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'contributor',
						'contributorId' => $contributorInfo['contributor_id'], 
						'currentImage' => $contributorInfo['contributor_image'],
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/contributors_redesign/',
						'imgData' => $_POST,
						'desWidth' => 140,
						'desHeight' => 143,
					]), ['arrayId' => 'contributor-wide-image-upload-form']);
					$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2]])['contributors'][0];
					$contImageUrl =  $config['image_url'].'articlesites/contributors_redesign/'.$contributorInfo['contributor_image']; ;
					break;

				case isset($_POST['c_i_d']):
					$mpArticleAdmin->deleteContributorInfo($_POST);
					$adminController->redirectTo('contributors/');
					break;
				}
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
			<!-- Image Sections -->
			<section id="profile-inline-settings">
					<header class="section-bar">
						<h2>Profile Photo</h2>
					</header>
					
					<fieldset id="add-an-image-fs">
							<div class="image-steps image-sec">
								<div id="image-container">
								<?php 

									if($contImageExists){
										echo "<img src=\"".$contImageUrl."\" alt=\"".$userInfo['contributor_name']." Image"."\" />";
								 	} else {
										echo "<img src=\"".$config['image_url'].'articlesites/sharedimages/default_profile_contributor.png'."\" alt=\"Contributor Image\" style=\"width: 143px; height: 140px;\"/>";
									} 
									echo '<span><a id="change-art-image" href=""><i class="icon-picture"></i>Change Photo</a></span>';
								?>
								</div>
							</div>
							
							<div class="image-steps">
								<header class="section-bar">
									<h2>Add an Image to your profile</h2>
								</header>
								<fieldset>
							    	<div class="file-upload-container">
								        <span>
								        	<button name="image-file-link" id="image-file-link" type="button"><i class="icon-plus-sign"></i>Add Image</i></button>
								        </span>
								    </div>
							        <div id="rules">
							        	<span>Make sure the image selected:</span>
							        	<ul>
							        	<li>Must be: .jpg, .jpeg, .gif, or .png type.</li>
		    							<li>Do not exceed a maximum size: 1 MB.</li>
		    							<li>Has a minimun dimensions of  140 x 143</li>
							        </div>
						        </fieldset>
						        
						    </div>
					</fieldset>
					 <p id="error-img" class="error-img"></p>
					<div class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error-img show-err' : 'success-img'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo $updateStatus['message']; ?>
					</div>
			</section>


			<section id="contributor-info">
				<header class="section-bar">
					<h2>Contributor Information</h2>
				</header>

				<form class="ajax-submit-form" id="contributor-info-form" name="contributor-info-form" action="<?php echo $config['this_admin_url']; ?>contributors/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo['contributor_id']; ?>" />

					<fieldset>
						<label for="contributor_name-s">Contributor Name<span>*</span> :</label>
						<input type="text" name="contributor_name-s" id="contributor_name-s" placeholder="Please enter the contributor's name here." value="<?php if(isset($contributorInfo['contributor_name']))  echo $contributorInfo['contributor_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's name that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<?php if(!$content_provider){?>
					<fieldset>
						<label for="contributor_seo_name-s">Contributor SEO Name<span>*</span> :</label>
						<input type="text" name="contributor_seo_name-s" id="contributor_seo_name-s" placeholder="Please enter the contributor's seo-formatted name here." value="<?php if(isset($contributorInfo['contributor_seo_name'])) echo $contributorInfo['contributor_seo_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_seo_name') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's name that will be used in URLs throughout the network.</p>
							</div>
						</div>
					</fieldset>
					<?php }?>

					<fieldset>
						<label for="contributor_location-s">Contributor Location :</label>
						<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="Please enter the contributor's location here." value="<?php if(isset($contributorInfo['contributor_location'])) echo $contributorInfo['contributor_location']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's location that will be used throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_blog_link-s">Contributor Blog URL :</label>
						<input type="url" name="contributor_blog_link-s" id="contributor_blog_link-s" placeholder="Please enter the contributor's blog URL here." value="<?php if(isset($contributorInfo['contributor_blog_link'])) echo $contributorInfo['contributor_blog_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_blog_link') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the contributor's blog page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="contributor_email_address-e">Contributor Email Address :</label>
						<p class="disabled-field"><?php echo $contributorInfo['contributor_email_address']; ?></p>
						<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset($contributorInfo['contributor_email_address'])) echo $contributorInfo['contributor_email_address']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />
					</fieldset>
					
					<fieldset>
						<label for="contributor_twitter_handle-s">Contributor Twitter Handle :</label>
						<input type="text" name="contributor_twitter_handle-s" id="contributor_twitter_handle-s" placeholder="Please enter the contributor's twitter handle here." value="<?php if(isset($contributorInfo['contributor_twitter_handle'])) echo $contributorInfo['contributor_twitter_handle']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_twitter_handle') echo 'autofocus'; ?> />

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
						<textarea class="elm-wysiwyg" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Please enter the contributor's bio here." ><?php if(isset($contributorInfo['contributor_bio'])) echo $contributorInfo['contributor_bio']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's bio that will be used throughout the network.  HTML is accepted.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-info-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>
			<br />

			<?php if(!$content_provider){?>
			<section id="contributor-delete">
				<header class="section-bar">
					<h2>Delete this Contributor</h2>
				</header>
				<form class="ajax-submit-form" id="contributor-delete-form" name="contributor-delete-form" action="<?php echo $config['this_admin_url']; ?>contributors/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo['contributor_id']; ?>" />
					<input type="hidden" id="c_i_d" name="c_i_d" value="<?php echo $contributorInfo['contributor_id']; ?>" />
					
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-delete-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-delete-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Delete Contributor</button>
						</div>
					</fieldset>
				</form>
			</section>
			<?php }?>
		</div>
	</div>

		<div class="lightbox-shown" id="lightbox-cont2" style="display:none;">
		<div class="overlay"></div>
		<div id="lightbox-content" class="article-lightbox article-lightbox-img-uploader">
			
			<div id="lightbox-preview-cont">
			<section id="update-article-image">
				<div id="contributor-wide-image-upload" class="image-uploader">
					<form class="ajax-submit-image" id="contributor-wide-image-upload-form" enctype="multipart/form-data" name="contributor-wide-image-upload-form" 
							  action="<?php echo $config['this_admin_url'].'account/user/'.$uri[2]; ?>" method="POST"  onsubmit="return checkForm()">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				        <input type="hidden" id="x1" name="x1" />
				        <input type="hidden" id="y1" name="y1" />
				        <input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo['contributor_id']; ?>" />

				        
				        <fieldset class="step2">
						   	<span>
						       	<p>Please select a crop region</p>
						    </span>
						    <span class="right preview-close">
								<p>CLOSE<i class="icon-remove-sign" id="preview-close"></i></p>
							</span>
					    </fieldset>  
					    
					    <fieldset class="image-info">  	
					        <img id="preview" alt="" src="" />
					    </fieldset>

					    <fieldset class="image-info">
					        <div class="info">
					        	<h2>Image Information:</h2>

					        	<label>Name:</label> <p id="filenametext" name="filenametext"></p>
					           	<label>Size:</label> <p id="filesizetext" name="filesizetext"></p>
					        	<label>Type:</label><p id="filetype" name="filetype"></p>
					        	<label>Dimension:</label><p id="filedim" name="filedim"></p>
					        
					        	<input type="hidden" id="filesize" name="filesize" />
								<input type="hidden" id="w" name="w" />
					            <input type="hidden" id="h" name="h" />
					            <input type="hidden" id="dimHeight" name="dimHeight" />
					            <input type="hidden" id="dimWidth" name="dimWidth" />
					        </div>
					 	</fieldset>
					    <div class="file-upload-container">
					    	<input type="file" name="contributor_wide_img" id="contributor_wide_img" class="upload-img-file account-file-input" />
						</div>   
					    <fieldset class="save-button">
							<div class="btn-wrapper">
								<button type="submit" id="submit" name="submit" value="Save Image" class="ajax-submit-image">Save Image</button>
							</div>
						</fieldset>
					</form>
				</div>
			</section>
			</div>
		</div>
	</div>


	<?php include_once($config['include_path'].'footer.php');?>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>