<?php
	$userInfo = $adminController->user->data;

	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($userInfo['contributor_image']) && $userInfo['contributor_image'] != "") ? $userInfo['contributor_image'] : 'pm_avatars_1.png';

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($userInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();
	
	//	If the name in the url string doesn't match the logged in user's username...
	if ($userInfo['user_name'] != $uri[2]){
		//	No access
		$adminController->redirectTo('noaccess/');
	}

	//	Set the paths to the image
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  'http://images.puckermob.com/articlesites/contributors_redesign/'.$image; 
	$contImageExists = false;

	$userfbid = isset($adminController->user->data['user_facebook_id']) ? $adminController->user->data['user_facebook_id'] : 0;
	$fromFB = false;
	if($userfbid && strlen($userfbid) > 0 ){
		$fromFB = true;
		$contImageUrl = $image.'?type=large'; 
	}
	
	//	Verify if the usr has ever SELECTED an image
	if(isset($image) ){
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
					$contImageUrl =  'http://images.puckermob.com/articlesites/contributors_redesign/'.$userInfo['contributor_image']; ;
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
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>My Account</h1>
			</div>
			<div id="announcements" class="announcements-box mobile-12 columns">
				<div id="announcement-icon" class="">
					<i class="fa fa-3x fa-comments"></i>
				</div>
				<div id="announcement-txt" class="p-cont">
					<p style="font-size:1rem;"><strong>Did you know:</strong> Readers like to get to know the authors behind the articles. Articles with completed user profiles, including a photograph, are nearly 4x more likely to get read and shared!</p>
				</div>
			</div>
			
			<section id="articles" class="">
			
			<div id="profile-inline-settings">
			
				<!-- IMAGE SECTION -->
				<section class="mobile-12 small-12 columns margin-bottom margin-top">
						<h2 class="small-12">Profile Photo</h2>
						<div class="small-12 image-profile-box">
							<img id="img-profile" class="left" src="<?php echo $contImageUrl; ?>" alt="User Image" />
							<div class="small-10 left image-wrapper">
								<div class="small-6 columns div-images">
									<input type="hidden" id="cont_i" name="cont_i" value="<?php echo $userInfo['contributor_id']; ?>" />
									
									<div class="small-12 avatars">
										<?php for($i = 1; $i<= 18; $i++){?>
											<span class="avatar-span" id="avatar-image-<?php echo $i;?>" data-info="pm_avatars_<?php echo $i;?>.png">
												<img src="http://images.puckermob.com/articlesites/contributors_redesign/<?php echo 'pm_avatars_'.$i.'.png'; ?>" class="avatar-img" id="pm_avatars_<?php echo $i;?>" />
											</span> 
										<?php }?>
									</div>
									<a href="#" class="b-upload select-avatar small-12" id="select-avatar">Save Avatar</a>
								</div>
								<div style="width:4.2rem;" class="left">
									<span class="and ">or</span>
								</div>
								<div class="small-6 columns div-file-upload">
									<a href="#" class="b-upload small-12 upload-photo" name="image-file-link" id="image-file-link">Upload Photo</a>
									<input type="file" class="hidden" id="upload_form" name="upload_form" />
										<div class="small-12 photo-instructions">
										<label>Image Requeriments:</label>
										<ul>
											<li>Recommended Size: 140x143 px</li>
											<li>.jpg, .jpeg, .gif, .png filetype </li>
											<li>Do not exceed max size 1 MB</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<p id="error-img" class="error-img"></p>
				</section>
					

				<!-- ACCOUNT INFORMATION -->		
				<section id="row small-12 account-settings">
					<h2 class="small-12">General Information<span style="text-align: right; float:right; color:#fff; background: #000; padding:0.2rem 1rem;"><a style="color:#fff; font-size:1rem;" href="http://www.puckermob.com/contributors/<?php echo $userInfo['contributor_seo_name']; ?>" target="_blank">VIEW PROFILE</a></span></h2>
					<form class="ajax-submit-form clear" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/user/<?php echo $uri[2]; ?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />
							<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset($userInfo['user_email'])) echo $userInfo['user_email']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />

							<div class="row">
								<div class="columns mobile-12 small-12 large-6">
									<label for="user_first_name-s">Your Name</label>
									<input type="text" name="user_first_name-s" id="user_first_name-s" placeholder="Your Name" value="<?php if(isset($adminController->user->data['user_first_name'])) echo $adminController->user->data['user_first_name']; ?>" required  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
								</div>
								<div class="columns mobile-12 small-12 large-6">
									<label for="contributor_blog_link-s">Blog or Website URL</label>
									<input type="url" name="contributor_blog_link-s" id="contributor_blog_link-s" placeholder="" value="<?php if(isset($userInfo['contributor_blog_link'])) echo $userInfo['contributor_blog_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_blog_link') echo 'autofocus'; ?> />
								</div>
							</div>

							<div class="row">
								<div class="columns mobile-12 small-12 large-6">
									<label for="user_email-e">Email Address</label>
									<input type="email" name="user_email-e" id="user_email-e" placeholder="" value="<?php if(isset($adminController->user->data['user_email'])) echo $adminController->user->data['user_email']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />
								</div>
								<div class="columns mobile-12 small-12 large-6">
									<label for="contributor_facebook_link-s">Facebook URL</label>
									<input type="url" name="contributor_facebook_link-s" id="contributor_facebook_link-s" placeholder="" value="<?php if(isset($userInfo['contributor_facebook_link'])) echo $userInfo['contributor_facebook_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_facebook_link') echo 'autofocus'; ?> />
								</div>
							</div>

							<div class="row">
								<div class="columns mobile-12 small-12 large-6">
									<label for="contributor_location-s">Location</label>
									<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="" value="<?php if(isset($userInfo['contributor_location'])) echo $userInfo['contributor_location']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />
								</div>
								<div class="columns mobile-12 small-12 large-6">
									<label for="contributor_twitter_handle-s">Twitter Handle </label>
									<input type="text" name="contributor_twitter_handle-s" id="contributor_twitter_handle-s" placeholder="ex:jhonsmith" value="<?php if(isset($userInfo['contributor_twitter_handle'])) echo $userInfo['contributor_twitter_handle']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_twitter_handle') echo 'autofocus'; ?> />
								</div>
							</div>

							
							<div class="row">
								<div class="columns mobile-12 small-12 large-12">
									<textarea class="mceEditor" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Tell us something about yourself! Start writing Bio here." ><?php if(isset($userInfo['contributor_bio'])) echo $userInfo['contributor_bio']; ?></textarea>
								</div>
							</div>
							
							<div class="row buttons-container">
								<div class="columns mobile-12 small-12 large-6">
									<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
									
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
									</p>
								</div>
								<div class="columns mobile-12 small-12 large-6">
									<span style="text-align: right; color:#fff; background: #000; padding:0.5rem 1rem;"><a style="color:#fff; font-size:1rem;" href="http://www.puckermob.com/contributors/<?php echo $userInfo['contributor_seo_name']; ?>" target="_blank">VIEW PROFILE</a></span>
									<button type="submit" id="submit" name="submit">UPDATE</button>
								</div>
							</div>
						
					</form>
				</section>

				<?php if( isset($fromFB) && !$fromFB){?>
				<!-- PASSWORD -->
				<section class="small-12 account-settings margin-top">
							<h2>Change Password</h2>
							<form class="ajax-submit-form clear" id="account-password-form" name="account-password-form" action="<?php echo $config['this_admin_url']; ?>account/user/<?php echo $uri[2]; ?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
							<input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />
							<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset($userInfo['user_email'])) echo $userInfo['user_email']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_email') echo 'autofocus'; ?> />

							<div class="row">
								<div class="columns mobile-12 small-12 large-6">
									<label for="user_password_current-s">Verify Current Password</label>
									<input type="password" name="user_password_current-s" id="user_password_current-s" placeholder="" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
								</div>
								<div class="columns mobile-12 small-12 large-6">
									<label for="user_password-s">New Password</label>
									<input type="password" name="user_password1-s" id="user_password1-s" placeholder="" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />		
								</div>
							</div>
							<div class="row">
								<div class="columns mobile-12 small-12 large-6"></div>	
								<div class="columns mobile-12 small-12 large-6">
									<label for="user_password-s">Retype New Password</label>
									<input type="password" name="user_password2-s" id="user_password2-s" placeholder="" value="" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'user_hashed_password') echo 'autofocus'; ?> />
								</div>
							</div>
							<div class="row buttons-container">
								<div class="columns mobile-12 small-12 large-10">
									<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-password-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-password-form') echo $updateStatus['message']; ?>
									</p>
								</div>
								<div class="columns mobile-12 small-12 large-2">
									<button type="submit" id="submit" name="submit">UPDATE</button>
								</div>
							</div>
							</form>
				</section>
				<?php }?>
			</div>
			</section>
		</div>
	</main>

	<div class="lightbox-shown" id="lightbox-cont2" style="display:none;">
		<div class="overlay"></div>
		<div id="lightbox-content" style="width:50% !important; top:1rem !important; position:absolute !important; " class="article-lightbox article-lightbox-img-uploader">
			
			<div id="lightbox-preview-cont">
			<section id="update-article-image">
				<div id="contributor-wide-image-upload" class="image-uploader">
					<form class="ajax-submit-image" id="contributor-wide-image-upload-form" enctype="multipart/form-data" name="contributor-wide-image-upload-form" 
							  action="<?php echo $config['this_admin_url'].'account/user/'.$uri[2]; ?>" method="POST"  onsubmit="return checkForm()">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				        <input type="hidden" id="x1" name="x1" />
				        <input type="hidden" id="y1" name="y1" />
				        <input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />

				        
				        <div class="step2">
						   	<span>
						       	<p>Please select region</p>
						    </span>
						    <span class="right preview-close">
								<a href="#close" title="Close" id="preview-close" class="close">X</a>
							</span>
					    </div>  
					    
					    <div class="image-info">  	
					        <img id="preview" alt="" src="" />
					    </div>

					    <div class="image-info">
					        <div class="info">
					        	<input type="hidden" id="filesize" name="filesize" />
								<input type="hidden" id="w" name="w" />
					            <input type="hidden" id="h" name="h" />
					            <input type="hidden" id="dimHeight" name="dimHeight" />
					            <input type="hidden" id="dimWidth" name="dimWidth" />
					        </div>
					 	</div>
					    <div class="file-upload-container hidden">
					    	<input type="file" name="contributor_wide_img" id="contributor_wide_img" class="upload-img-file account-file-input" />
						</div>   
					    <div class="save-button left margin-top">
							<div class="btn-wrapper">
								<button type="submit" id="submit" name="submit" value="Save Image" class="ajax-submit-image">Save Image</button>
							</div>
						</div>
					</form>
				</div>
			</section>
			</div>
		</div>
	</div>

	<?php include_once($config['include_path_admin'].'footer.php');?>

	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content" class="article-lightbox">
			<a href="#close" title="Close" id="preview-close" class="close">X</a>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>

	<script>
      $(function() {	
          $('#contributor_bio-nf').froalaEditor({
          	  key: 'UcbaE2hlypyospbD3ali==',
          	  height: 220,
          	  placeholderText: 'Start Writing Here.',
		      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikethrough', 'align', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsMD: ['bold', 'italic', 'underline', 'strikethrough', 'align', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsSM: ['bold', 'italic', 'underline', 'align', 'formatUL', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsXS: ['bold', 'italic', 'align', 'formatUL',  'insertHR', 'insertLink']
          });
      });
  	</script> 

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>