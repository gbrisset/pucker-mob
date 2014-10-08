<?php
	$userInfo = $adminController->user->data;
	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($userInfo['contributor_image']) && $userInfo['contributor_image'] != "") ? $userInfo['contributor_image'] : 'default_profile_contributor.png';

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($userInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else {
		$mpShared->get404();
	}
	//	If the name in the url string doesn't match the logged in user's username...
	if ($userInfo['user_name'] != $uri[2]){
		//	No access
		$adminController->redirectTo('noaccess/');
	}

	//Verify if is a content provider user
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	//	Set the paths to the image
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  $config['image_url'].'articlesites/contributors_redesign/'.$image; 
	$contImageExists = false;

	//	Verify if the usr has ever SELECTED an image
	if(isset($image) && $image != 'default_profile_contributor.png'){
		$contImageExists = file_exists($contImageDir);
	}

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['contributor_name-s']):
					$updateStatus = array_merge($mpArticleAdmin->updateContributorInfo($_POST), ['arrayId' => 'contributor-info-form']);
					// $contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2]])['contributors'][0];
					break;
				case isset($_FILES['contributor_wide_img']):
					$updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'contributor',
						'contributorId' => $userInfo['contributor_id'], 
						'currentImage' => $userInfo['contributor_image'],
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/contributors_redesign/',
						'imgData' => $_POST,
						'desWidth' => 140,
						'desHeight' => 143,
					]), ['arrayId' => 'contributor-wide-image-upload-form']);
					$userInfo = $adminController->user->getUserInfo();
					$contImageUrl =  $config['image_url'].'articlesites/contributors_redesign/'.$userInfo['contributor_image']; ;
					break;
				case isset($_POST['user_email-e']):
                    $updateStatus = $adminController->updateUserInfo($_POST);
                    $adminController->user->data = $adminController->user->getUserInfo();
                    break;
				case isset($_POST['c_i_d']):
					$mpArticleAdmin->deleteuserInfo($_POST);
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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="profile-inline-settings">
		
			<section class="section-bar left  border-bottom mobile-12 small-12 margin-bottom">
				<h1 class="left">Profile</h1>
			</section>
			<!-- IMAGE SECTION -->
				<div id="add-an-image-fs" class="padding-top padding-bottom left small-12 border-radius">
					<div class="image-steps image-sec columns small-4 ">
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
							
					<div class="image-steps image-button-header">
						<header class="section-bar">
							<h2>Add an Image to your profile</h2>
						</header>
						<div class="file-upload-container">
							<span>
								<button name="image-file-link" id="image-file-link" type="button"><i class="icon-plus-sign"></i>Add Image</i></button>
							</span>
						</div>
					</div>
				</div>
				<div id="rules" class="left columns small-12">
					<span>Make sure the image selected:</span>
					<ul class="padding-top">
						<li>Must be: .jpg, .jpeg, .gif, or .png type.</li>
		    			<li>Do not exceed a maximum size: 1 MB.</li>
		    			<li>Has a minimun dimensions of  140 x 143</li>
		    		</ul>
				</div>
				<p id="error-img" class="error-img"></p>
				<div class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error-img show-err' : 'success-img'; ?>" id="result">
					<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo $updateStatus['message']; ?>
				</div>
			</div>

			<!-- Account Info -->		
			<section id="account-settings">
				<header class="section-bar left  border-bottom mobile-12 small-12 margin-bottom">
					<h2>My Information</h2>
				</header>

				<form class="ajax-submit-form" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/user/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />
					<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset($userInfo['user_email'])) echo $userInfo['user_email']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />



					<fieldset>
						<label for="user_name-s">User Name :</label>
						<p class="disabled-field"><?php echo $adminController->user->data['user_name']; ?></p>
					</fieldset>


					<fieldset>
						<label for="user_first_name-s">First Name<span>*</span> :</label>
						<input type="text" name="user_first_name-s" id="user_first_name-s" placeholder="Please enter your first name here." value="<?php if(isset($adminController->user->data['user_first_name'])) echo $adminController->user->data['user_first_name']; ?>" required  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's first name that will be visible throughout the Simple Dish website.</p>
							</div>
						</div>					
					</fieldset>

					<fieldset>
						<label for="user_last_name-s">Last Name :</label>
						<input type="text" name="user_last_name-s" id="user_last_name-s" placeholder="Please enter your last name here." value="<?php if(isset($adminController->user->data['user_last_name'])) echo $adminController->user->data['user_last_name']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_last_name') echo 'autofocus'; ?> />
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's last name that will be visible throughout the Simple Dish website.</p>
							</div>
						</div>	
					</fieldset>



					<fieldset>
						<label for="contributor_bio-nf">Bio :</label>
						<textarea class="" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Please enter the contributor's bio here." ><?php if(isset($userInfo['contributor_bio'])) echo $userInfo['contributor_bio']; ?></textarea>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's bio that will be used throughout the network.  HTML is accepted.</p>
							</div>
						</div>
					</fieldset>



					<fieldset>
						<label for="contributor_blog_link-s">Blog URL :</label>
						<input type="url" name="contributor_blog_link-s" id="contributor_blog_link-s" placeholder="http://yourblog.com" value="<?php if(isset($userInfo['contributor_blog_link'])) echo $userInfo['contributor_blog_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_blog_link') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the URL for the contributor's blog page.  URLs must begin with http:// and end with a trailing slash.  Ex: http://www.example.com/</p>
							</div>
						</div>
					</fieldset>


					<fieldset>
						<label for="contributor_facebook_link-s">Facebook URL:</label>
						<input type="url" name="contributor_facebook_link-s" id="contributor_facebook_link-s" placeholder="http://facebook.com/yourprofile" value="<?php if(isset($userInfo['contributor_facebook_link'])) echo $userInfo['contributor_facebook_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_facebook_link') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's facebook url that will be used throughout the network.</p>
							</div>
						</div>
					</fieldset>



					<fieldset>
						<label for="contributor_twitter_handle-s">Twitter Handle :</label>
						<input type="text" name="contributor_twitter_handle-s" id="contributor_twitter_handle-s" placeholder="@yourtwitterhandle" value="<?php if(isset($userInfo['contributor_twitter_handle'])) echo $userInfo['contributor_twitter_handle']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_twitter_handle') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's twitter handle that will be used throughout the network.  Twitter handles must have an '@' symbol in front of it.</p>
							</div>
						</div>
					</fieldset>



					<fieldset>
						<label for="contributor_location-s">Location :</label>
						<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="Please enter the contributor's location here." value="<?php if(isset($userInfo['contributor_location'])) echo $userInfo['contributor_location']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the contributor's location that will be used throughout the network.</p>
							</div>
						</div>
					</fieldset>


					<fieldset>
						<div  class="btn-wrapper" style="text-align: left;">
							<label>Password :</label>
							<button type="button" id="field-toggler">Change Password</button>
						</div>
					</fieldset>

					<div id="hidden-field-set" class="hidden">
						<fieldset>
							<label for="user_password_current-s">Current Password :</label>
							<input type="password" name="user_password_current-s" id="user_password_current-s" placeholder="Enter your current password here." value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>Please enter the current password for this account.</p>
								</div>
							</div>							

						</fieldset>

						<fieldset>
							<label for="user_password-s">New Password :</label>
							<input type="password" name="user_password1-s" id="user_password1-s" placeholder="Enter your new password here." value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>Please enter a new password.</p>
								</div>
							</div>
						</fieldset>
	
						<fieldset>
							<label for="user_password-s">Retype New Password :</label>
							<input type="password" name="user_password2-s" id="user_password2-s" placeholder="Retype your new password" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>Please re-enter your new password.</p>
								</div>
							</div>	
						</fieldset>	
					</div>

					<fieldset>
						<label for="user_email-e">Email Address<span>*</span> :</label>
						<input type="email" name="user_email-e" id="user_email-e" placeholder="Please enter your email address here." value="<?php if(isset($adminController->user->data['user_email'])) echo $adminController->user->data['user_email']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the email address associated with this account.</p>
							</div>
						</div>					
					</fieldset>

					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Save</button>
						</div>
					</fieldset>

					<input type="text" class="hidden" id="pwd_change" name="pwd_change" value="false" >
				</form>
			</section>
			<!--<section>
				<fieldset class="multiple-forms">
					<?php include_once($config['include_path_admin'].'preview_profile.php');  ?>
					<div>
						<div class="preview-container" data-preview="<?php echo $preview_profile; ?>"></div>
					</div>

					<div class="main-buttons edit-recipe">
						<button type="button" id="cont-preview" name="button" class="profile-preview">Preview Profile</button>
					</div>
				</fieldset>
			</section>-->
			<br />
		</div>
	</main>

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
				        <input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />

				        
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
					           	<!--<label>Size:</label> <p id="filesizetext" name="filesizetext"></p>
					        	<label>Type:</label><p id="filetype" name="filetype"></p>
					        	<label>Dimension:</label><p id="filedim" name="filedim"></p>-->
					        
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
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content" class="article-lightbox">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>