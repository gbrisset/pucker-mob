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
</div>
<?php }?>