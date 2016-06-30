<?php
	$userInfo = $adminController->user->data;
	$userObj = new User($userInfo['user_email']);
	$contributorInfo = $userObj->contributor->data;
	
	$image = (isset($contributorInfo->contributor_image) && !empty($contributorInfo->contributor_image)) ? $contributorInfo->contributor_image : 'pm_avatars_1.png';

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

	
?>
<div id="edit-my-profile">

	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	<div id="content" class="columns small-9 large-11">
		<div class="small-12 columns radius header-style">
			<h2>STEP 1: ADD A PICTURE</h2>
		</div>

		<!-- IMAGE SECTION -->
		<div class="small-12 columns margin-bottom margin-top no-padding">
			<div class="small-12 image-profile-box radius">
				<div class="small-12 large-3 xlarge-2 columns align-center no-padding-left">
					<img id="img-profile" src="<?php echo $contImageUrl; ?>" alt="User Image" />
				</div>
				<div class="small-12 large-9 xlarge-10 columns no-padding-left">
					<div class="div-file-upload">
						<a href="#" class="b-upload small-12 upload-photo radius" name="image-file-link" id="image-file-link">Click Here to Upload Photo</a>
						 <div class="file-upload-container hidden">
				    	<input type="file" name="contributor_wide_img" id="contributor_wide_img" class="upload-img-file account-file-input" />
					</div>  
						<input type="file" class="hidden" id="upload_form" name="upload_form" />
						<div class="photo-instructions">
							<p>Size: 140x143 px <i class="fa fa-circle"></i> 1 MB Max <i class="fa fa-circle"></i> .jpg, .jpeg, .gif, .png filetype </p>
						</div>
					</div>
					<div class="small-12 columns div-images no-padding show-for-large-up">
						<input type="hidden" id="cont_i" name="cont_i" value="<?php echo $contributorInfo->contributor_id; ?>" />
						<div class="small-3 large-3 columns no-padding">
							<label>OR CHOOSE AN AVATAR:</label>
						</div>
						<div class=" small-9 large-9 columns avatars">
							<?php for($i = 1; $i<= 18; $i++){?>
								<span class="avatar-span" id="avatar-image-<?php echo $i;?>" data-info="pm_avatars_<?php echo $i;?>.png">
									<img src="http://images.puckermob.com/articlesites/contributors_redesign/<?php echo 'pm_avatars_'.$i.'.png'; ?>" class="avatar-img" id="pm_avatars_<?php echo $i;?>" />
								</span> 
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<p id="error-img" class="error-img"></p>
		</div>

		<div class="small-12 columns radius header-style">
			<h2>STEP 2: Tell readers about you</h2>
		</div>
		<!-- PROFILE SETTINGS -->
		<form class="ajax-submit-form clear" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/user/	<?php echo $uri[2]; ?>" method="POST">
				<div class="small-12 columns margin-bottom margin-top no-padding">

					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo->contributor_id; ?>" />
					<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset( $contributorInfo->contributor_email_address)) echo  $contributorInfo->contributor_email_address; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />

					<div class="columns small-12 large-6 no-padding">
						<div class="columns small-12 margin-top">
							<input type="text" name="user_first_name-s" id="user_first_name-s" placeholder="Your Name" value="<?php if(isset($contributorInfo->contributor_name)) echo $contributorInfo->contributor_name; ?>" required  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_name') echo 'autofocus'; ?> />
						</div>
						<div class="columns small-12 margin-top">
							<input type="email" name="user_email-e" id="user_email-e" placeholder="YOUR E-MAIL ADDRESS" value="<?php if(isset($contributorInfo->contributor_email_address)) echo $contributorInfo->contributor_email_address; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />
						</div>
						<div class="columns small-12 margin-top">
							<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="YOUR LOCATION" value="<?php if(isset($contributorInfo->contributor_location)) echo $contributorInfo->contributor_location; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="columns small-12 large-6  no-padding">
						<div class="columns small-12 no-padding-right">
							<textarea class="mceEditor" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Tell us something about yourself! Start writing Bio here." ><?php if(isset($contributorInfo->contributor_bio)) echo $contributorInfo->contributor_bio; ?></textarea>
						</div>
					</div>
				</div>

				<div class="small-12 columns margin-bottom margin-top no-padding">
						<div class="columns small-12 large-6">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
							
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
							</p>
						</div>
						<div class="columns mobile-12 small-12 large-6 align-right no-padding">
							<button class="columns small-6 radius wide-button elm"><a href="http://www.puckermob.com/contributors/<?php echo $contributorInfo->contributor_seo_name; ?>" target="_blank">PROFILE</a></button>
							<button class="columns small-6  radius wide-button" style="margin-right: -5px;" type="submit" id="submit" name="submit">SAVE</button>
						</div>
				</div>

		</form>
	</div>
</div>

<div class="lightbox-shown" id="lightbox-cont2" style="display:none;">
	<div class="overlay"></div>
	<div id="lightbox-content" style="width:50% !important; top:1rem !important; position:absolute !important; " class="article-lightbox article-lightbox-img-uploader">
		
		<?php include_once($config['include_path_admin'].'cropimageprofile.php'); ?>
	</div>
</div>

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
      	  toolbarSticky: false,
      	  height: 140,
      	  placeholderText: 'WRITE A SHORT BIO',
	      toolbarButtons:   ['bold', 'italic', 'align', 'formatUL', 'insertHR', 'insertLink'],
      });
  });
	</script> 

  	