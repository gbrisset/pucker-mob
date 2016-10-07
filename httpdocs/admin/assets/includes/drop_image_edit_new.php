<?php if(!$detect->isMobile()){?>
<div class="small-12 xxlarge-8 columns no-padding inline-flex"  >	
	
	<div class="small-12 large-8 columns image-drop-wrapper">
		
		<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
	 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
			<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
	 		<input type="hidden" id="is_mobile" value="<?php echo $detect->isMobile(); ?>" />
	 		
 			<div class="dz-message  dropzone-previews" >
	 			<div class="dz-preview dz-file-preview small-12 large-12 columns no-padding" id="template" >  <!-- template for images -->
    	            <div class="dz-details dztemplate">
		              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
		              <div class="dz-size"  style="display:none;" data-dz-size></div>
		              <img data-dz-thumbnail id="main-image-src" style="display:none;" src=""/>
		               <div class="image-overlay-content" style="display:none;">
				        <a href="#" ><i class="fa fa-camera" aria-hidden="true"></i>Change</a>
				       	<!--<a href="#" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>-->
				      </div>
		            </div>
		            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
		            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
		            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
		            <div class="dz-error-message large-11 center"><span data-dz-errormessage></span></div>
	          	</div>

	          	<?php if(isset($artImageExists) && $artImageExists ){?>
				 	 <img  id="existing-img"  src="<?php echo $tallImageUrl; ?>"/>
				 	 <div class="loading"><img src="http://dev.puckermob.com/admin/assets/img/loading.gif" /></div>
				 	 <div class="image-overlay-content" style="display:none;">
				        <a href="#" ><i class="fa fa-camera" aria-hidden="true"></i>Change</a>
				       <!--	<a href="#" id="edit-image" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>-->
				      </div>
				<?php }else{?>
		       	<div id="img-container" class="small-12 large-12 columns center padding" >
					<div class="image-drop-titles">
						<h2>UPLOAD A PICTURE</h2>
	 			   		<h3 class="show-for-large-up">Drag your image Here or Click to Upload </h3>
	 			   		<h4>Picture must be 784x431 </h4>
	 			   		<br>
						<h4 class="hide-for-large-up">You resize your images from our site</h4>
						<h4 class="show-for-large-up">You can crop and resize your images from our site</h4>				   	 
					</div>
		 		</div>
	 		   	<?php }?>
 			</div>
	 	</form>
	 </div>
	 <div id="did-u-know" class="small-12 large-4 columns show-for-large-up">
	 	<div class="small-12 columns">
	 		<h2>DID YOU KNOW…</h2>
	 		<p>Good, original images will help increase your chances of building an audience.</p>
	 		<br>
	 		<p>But pics are your responsibility - please make sure you’re not violating anybody’s copyright or privacy.</p>
	 	</div>
	 </div>
</div>
<!-- Load widget code -->
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>   
<script type="text/javascript" src="<?php echo $config['this_admin_url'].'assets/js/imagehandler.js'?>"></script>   
<?php }else{ ?>

<div class="small-12 xxlarge-8 columns no-padding inline-flex"  >	
	<div class="small-12 large-8 columns image-drop-wrapper">
		<div id="img-container" class="small-12 large-12 columns no-padding">
		<div class="image-drop-titles" id="drop-images-mobile">

		<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" style="border:none !important; background:none !important;"action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
	 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
			<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
	 		<input type="hidden" id="a_i" name="a_i" class="a_i" value="0" />
	 		<input type="hidden" id="is_mobile" value="<?php echo $detect->isMobile(); ?>" />

	 		<div id="img-container" class="small-12 large-12 columns center padding" >
					<div class="image-drop-titles">

					<h2 style="line-height: 1.4; font-size: 1.6rem; margin-bottom: 5px; color: #ddd;">PICTURE UPLOAD</h2>
 			   		<p style="color: #ddd; font-family: Oslo; font-size: 15px;">Images must be 784x431. 
 			   			<a href="#" data-reveal-id="img-modal" class="reveal-link2 "  data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal">Click here</a> 
 			   			for help cropping or resizing your image.
 			   		</p>

		 			<div class="dz-message  dropzone-previews" >
			 			<div class="dz-preview dz-file-preview small-12 large-12 columns no-padding" id="template" >  <!-- template for images -->
		    	            <div class="dz-details dztemplate">
				              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
				              <div class="dz-size"  style="display:none;" data-dz-size></div>
				              <img data-dz-thumbnail id="main-image-src" style="" src=""/>
				            </div>
				            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
				            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
				            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
				            <div class="dz-error-message large-11 center"><span data-dz-errormessage></span></div>
			          	</div>
						<?php if(isset($artImageExists) && $artImageExists ){?>
							<img  id="existing-img"  src="<?php echo $tallImageUrl; ?>"/>
						<?php }else{?>
				   	 	<div class=" div-to-hide center small-12 columns image-drop-wrapper" style="border: 3px dotted #ddd;">
				   	 		<h3 style="line-height: 1.4; color: #ddd; font-family: OsloBold; font-size: 22px;">SELECT AND UPLOAD YOUR IMAGE</h3>
				   	 	</div>
				   	 	<?php } ?>
				   	 </div>
	 		   	</div>
 			</div>
	 	</form>

		</div>
	   	</div>
 	</div>
</div>
<!-- MODAL -->
<div id="img-modal" class="reveal-modal tiny border-radius-10x" data-reveal aria-labelledby="intro-modal-title" aria-hidden="true" role="dialog" style="margin-top: 1.7rem; min-height: auto !important; ">
  <h2 style="font-family: OswaldRegular; font-size: 22px;" id="modalTitle">IMAGE CROPPING & RESIZING TOOLS</h2>
  	<p style="font-size: 15px;">If you need help cropping or resizing your images, try one of these sites or apps: </p>
	<p style="margin-bottom: 5px;">
		<i class="fa fa-caret-right" style="margin-right: 0px; font-size: 18px;" aria-hidden="true"></i>
		<a style="color: #222;" href="http://webresizer.com/" target="_blank">Web Resizer (web site)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<a style="color: #222;" href="http://imageresize.org/" target="_blank">ImageResize (web site)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-apple" aria-hidden="true"></i>
		<a style="color: #222;" href="https://appsto.re/us/BoIa5.i" target="_blank">Piczoo (iPhone app)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-android" aria-hidden="true"></i>
		<a style="color: #222;" href="https://play.google.com/store/apps/details?id=com.iudesk.android.photo.editor&hl=en" target="_blank">Photo Editor (Android app)</a>
	</p>
	<p class="">Images must be exactly 784x431</p>
</div>
<script>
	$(document).foundation().foundation();
</script>
<script type="text/javascript" src="<?php echo $config['this_admin_url'].'assets/js/imagehandler.js'?>"></script> 
<!--<div class="small-12 xxlarge-8 columns no-padding inline-flex"  >	
	<div class="small-12 large-8 columns image-drop-wrapper">
		<div id="img-container" class="small-12 large-12 columns center no-padding" style="border: 3px dotted #FFE;">
			<?php if(isset($artImageExists) && $artImageExists ){?>
				<img  id="existing-img"  src="<?php echo $tallImageUrl; ?>"/>
			<?php }else{?>
				<div class="image-drop-titles">
					<h2 style="line-height: 1.4; font-size: 1.6rem; margin-bottom: 1rem;">IMAGE UPLOAD AVAILABLE ON DESKTOP ONLY</h2>
					<h4 style="color: #ddd;" class="">MOBILE UPLOAD AND RESIZING COMING SOON</h4>
			   	 </div>
		   	 <?php }?>
	   	</div>
 	</div>
</div>-->
<?php }?>