<?php
	$userInfo = $adminController->user->data;
	$userObj = new User($userInfo['user_email']);
	
	$contributorInfo = $userObj->contributor->data;
	
	$image = (isset($contributorInfo->contributor_image) && !empty($contributorInfo->contributor_image)) ? $contributorInfo->contributor_image : 'default_profile_img.png';
//$image = 'default_profile_img.png';
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
	<div id="" class="columns small-12">
		<!-- IMAGE SECTION -->
		<div class="small-12 columns half-margin-top no-padding">
			<div class="small-12 image-profile-box radius">
				<div class="small-12 large-3 columns align-center no-padding">
					<img id="img-profile" class="upload-photo" src="<?php echo $contImageUrl; ?>" alt="User Image" />
				</div>
				<div class="small-12 large-9 columns no-padding"  style="    margin-top: 8px !important;">
					<div class="div-file-upload">
						<a href="#" class="small-12 upload-photo" style="margin:0; font-family: OsloBold; font-size: 18px;" name="image-file-link" id="image-file-link">Upload Photo</a>
						 <div class="file-upload-container hidden">
				    		<input type="file" name="contributor_wide_img" id="contributor_wide_img" class="upload-img-file account-file-input" />
						</div>  
						<input type="file" class="hidden" id="upload_form" name="upload_form" />
					</div>
					<div class="small-12 columns div-images no-padding show-for-large-up center">
						<input type="hidden" id="cont_i" name="cont_i" value="<?php echo $contributorInfo->contributor_id; ?>" />
						<div class="small-12 large-12 columns no-padding">
							<label style="margin-bottom: 10px;">Don't have a pic? Choose an avatar:</label>
						</div>
						<div class=" small-12 large-12 columns avatars">
							<?php for($i = 1; $i<= 18; $i++){?>
								<span class="avatar-span" id="avatar-image-<?php echo $i;?>" data-info="pm_avatars_<?php echo $i;?>.png">
									<img src="http://images.puckermob.com/articlesites/contributors_redesign/<?php echo 'pm_avatars_'.$i.'.png'; ?>" class="avatar-img" id="pm_avatars_<?php echo $i;?>" />
								</span> 
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<p id="error-img" class="error-img" style="font-size: 12px; margin: 5px;"></p>
		</div>

		<!-- PROFILE SETTINGS -->
		<form class="ajax-submit-form clear" id="account-settings-form" name="account-settings-form" action="<?php echo $config['this_admin_url']; ?>account/user/	<?php echo $uri[2]; ?>" method="POST">
				<div class="small-12 columns half-margin-bottom half-margin-top no-padding">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo->contributor_id; ?>" />
					<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset( $contributorInfo->contributor_email_address)) echo  $contributorInfo->contributor_email_address; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />

					<div class="columns small-12 no-padding">
						<div class="columns small-12 no-padding">
							<textarea  name="contributor_bio-nf" id="contributor_bio-nf" rows="7" placeholder="Write a short bio about yourself. What you like to write about, your favorite places to travel, fun things like that..." ><?php if(isset($contributorInfo->contributor_bio)) echo $contributorInfo->contributor_bio; ?></textarea>
						</div>
					</div>
				</div>

				<div class="small-12 columns no-padding">
					<div class="columns mobile-12 small-12 large-12 center">
						<p class="hide <?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'new-success'; ?>" id="result">
						
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'account-settings-form') echo $updateStatus['message']; ?>
						</p>
					</div>
					<div class="columns mobile-12 small-12 large-12 center">
						<button class="radius wide-button" type="submit" id="submit" name="submit">SAVE</button>
					</div>
					<p class="clear center show-for-large-up">Later, you can add social networks from My Profile.</p>
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
      	  height: 80,
      	  placeholderText: 'WRITE A SHORT BIO',
	      toolbarButtons: ['insertLink']
      });
  });
	</script> 

  	