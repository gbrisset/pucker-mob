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

	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($contributorInfo['contributor_image']) && $contributorInfo['contributor_image'] != "") ? $contributorInfo['contributor_image'] : 'pm_avatars_1.png';

	//Verify if contributor Image file exists.
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  $config['image_url'].'articlesites/contributors_redesign/'.$image; ;
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
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Edit Contributor</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
			<h1 class="left">Edit Contributor</h1>
			
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
		<section id="articles" class="">
			<div id="profile-inline-settings">
			
		<!-- IMAGE SECTION -->
		<section class="mobile-12 small-12 margin-bottom">
				<h2>Profile Photo</h2>
				<div class="small-12 image-profile-box">
					<img id="img-profile" class="left" src="<?php echo $contImageUrl; ?>" alt="User Image" />
					<div class="small-10 left image-wrapper">
						<div class="small-6 left div-images">
							<input type="hidden" id="cont_i" name="cont_i" value="<?php echo $userInfo['contributor_id']; ?>" />
							<a href="#" class="b-upload select-avatar small-12" id="select-avatar">Save Avatar</a>
							<div class="small-12 avatars">
								<?php for($i = 1; $i<= 18; $i++){?>
									<span class="avatar-span" id="avatar-image-<?php echo $i;?>" data-info="pm_avatars_<?php echo $i;?>.png">
										<img src="http://images.puckermob.com/articlesites/contributors_redesign/<?php echo 'pm_avatars_'.$i.'.png'; ?>" class="avatar-img" id="pm_avatars_<?php echo $i;?>" />
									</span> 
								<?php }?>
							</div>
						</div>
						<div style="width:4.2rem;" class="left">
							<span class="and ">or</span>
						</div>
						<div class="small-6 left div-file-upload">
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

		<!-- CONTRIBUTOR INFORMATION -->	
		<section class="mobile-12 small-12 margin-bottom account-settings" id="contributor-info">
			<h2>Contributor Information<span style="text-align: right; float:right; color:#fff; background: #000; padding:0.5rem 1rem;"><a style="color:#fff; font-size:1rem;" href="http://www.puckermob.com/contributors/<?php echo $contributorInfo['contributor_seo_name']; ?>" target="_blank">VIEW PROFILE</a></span></h2>
		
			<form class="ajax-submit-form " id="contributor-info-form" name="contributor-info-form" action="<?php echo $config['this_admin_url']; ?>contributors/edit/<?php echo $uri[2]; ?>" method="POST">
				<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				<input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo['contributor_id']; ?>" />

				<div class="row">
				    <div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_name-s">Name<span>*</span></label>	
						<input type="text" name="contributor_name-s" id="contributor_name-s" placeholder="Writer Name" value="<?php if(isset($contributorInfo['contributor_name']))  echo $contributorInfo['contributor_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_name') echo 'autofocus'; ?> />
					</div>
					<?php if(!$content_provider){?>
				    <div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_seo_name-s">SEO Name<span>*</span> :</label>
						<input type="text" name="contributor_seo_name-s" id="contributor_seo_name-s" placeholder="Please enter the contributor's seo-formatted name here." value="<?php if(isset($contributorInfo['contributor_seo_name'])) echo $contributorInfo['contributor_seo_name']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_seo_name') echo 'autofocus'; ?> />
					</div>
					<?php }?>
				</div>

				<div class="row">
				     <div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_location-s">Location :</label>
						<input type="text" name="contributor_location-s" id="contributor_location-s" placeholder="location" value="<?php if(isset($contributorInfo['contributor_location'])) echo $contributorInfo['contributor_location']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_location') echo 'autofocus'; ?> />
					</div>
					<div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_blog_link-s">Blog URL :</label>
						<input type="url" name="contributor_blog_link-s" id="contributor_blog_link-s" placeholder="blog URL" value="<?php if(isset($contributorInfo['contributor_blog_link'])) echo $contributorInfo['contributor_blog_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_blog_link') echo 'autofocus'; ?> />
					</div>
				</div>

				<div class="row">
					<div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_facebook_link-s">Facebook URL:</label>
						<input type="url" name="contributor_facebook_link-s" id="contributor_facebook_link-s" placeholder="facebook url" value="<?php if(isset($contributorInfo['contributor_facebook_link'])) echo $contributorInfo['contributor_facebook_link']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_facebook_link') echo 'autofocus'; ?> />
					</div>
				   <div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_twitter_handle-s">Twitter Handle :</label>
						<input type="text" name="contributor_twitter_handle-s" id="contributor_twitter_handle-s" placeholder="twitter handler EX: JhonSmith" value="<?php if(isset($contributorInfo['contributor_twitter_handle'])) echo $contributorInfo['contributor_twitter_handle']; ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_twitter_handle') echo 'autofocus'; ?> />
					</div>	
				</div>
					
				<div class="row">
				     <div class="columns mobile-12 small-12 large-6">
				      	<label for="contributor_email_address-e">Email Address :</label>
						<p class="disabled-field"><?php echo $contributorInfo['contributor_email_address']; ?></p>
						<input type="hidden" name="contributor_email_address-e" id="contributor_email_address-e" value="<?php if(isset($contributorInfo['contributor_email_address'])) echo $contributorInfo['contributor_email_address']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'contributor_email_address') echo 'autofocus'; ?> />
					</div>
				</div>					

				<div class="row">
				    <div class="columns mobile-12 small-12 large-12">
				    	<textarea class="mceEditor" name="contributor_bio-nf" id="contributor_bio-nf" rows="10" placeholder="Tell us something about this writer! Start writing Bio here." ><?php if(isset($contributorInfo['contributor_bio'])) echo $contributorInfo['contributor_bio']; ?></textarea>
					</div>
				</div>

				<div class="row buttons-container">
				    <div class="columns mobile-12 small-12 large-6">
				  		<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-info-form') echo ($updateStatus['hasError'] == true) ? 'radius alert label' : 'radius success label'; ?>" id="result">
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-info-form') echo $updateStatus['message']; ?>
						</p>
					</div>
					<div class="columns mobile-12 small-12 large-6">
						<span style="text-align: right; color:#fff; background: #000; padding:0.5rem 1rem;"><a style="color:#fff; font-size:1rem;" href="http://www.puckermob.com/contributors/<?php echo $contributorInfo['contributor_seo_name']; ?>" target="_blank">VIEW PROFILE</a></span>
						<button type="submit" id="submit" name="submit">UPDATE</button>
					</div>
				</div>
				</div>
			</form>
		
		</section>
		
			<?php if(!$content_provider){?>
		<hr>
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
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-delete-form') echo ($updateStatus['hasError'] == true) ? 'radius alert label' : 'raduis success label'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'contributor-delete-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit" class="radius">Delete Contributor</button>
						</div>
					</fieldset>
				</form>
			</section>
			<?php }?>
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
				        <input type="hidden" id="c_i" name="c_i" value="<?php echo $contributorInfo['contributor_id']; ?>" />

				        
				        <div class="step2">
						   	<span>
						       	<p style="display:inline;">Please select region</p>
						    </span>
						   <span class="right preview-close">
								<a href="#close" title="Close" id="preview-close" class="close">X</a>
							</span>
					    </div>  
					    
					    <fieldset class="image-info">  	
					        <img id="preview" alt="" src="" />
					    </fieldset>

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

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>