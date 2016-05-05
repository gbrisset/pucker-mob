
<?php if(!$detect->isMobile()){?>
<div class="small-12 xxlarge-8 left padding margin-bottom no-padding dropbox-image-edit" style="background:#888;">
	<form  id="image-drop" class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
				
 		<div class="dz-message inline-flex dropzone-previews" data-dz-message >
				<div id="img-container" class="small-4 large-5 columns" style="height:270px; padding: 10px 4%;" >
			   		<label class="padding-top uppercase main-color  show-for-large-up font-125-pct" style="margin-top: 5%;     font-size: 1.2rem !important;">
			   			Change Image
			   		</label>
					<p class=" hide-small"><a>Click to choose</a> your own image</p>				
					<p class=" hide-small small-12 columns no-padding">OR</p>
			   		<p class="hide-small"> Choose from our  <span class="photo-library underline" id="search-lib">Photo Library!</span></p>
			   	</div>
		   	
				<?php if(isset($artImageExists) && $artImageExists ){?>
					<div class="dz-preview dz-image-preview columns no-padding small-12 large-7" id="image-preview-org">  
			            <div class="dz-details dztemplate">
			              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
			              <div class="dz-size"  style="display:none;" data-dz-size></div>
			              <img data-dz-thumbnail style="display:inline;" id="main-image-src" src="<?php echo $tallImageUrl; ?>" id="main-image-src"/>
			            </div>
			            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
			            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
			            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
			            <div class="dz-error-message large-8 center"><span data-dz-errormessage></span></div>
		          	</div>
		        <?php } ?>
		</div>
	</form>
</div>

<script>
	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
		
		Dropzone.options.imageDrop = {
		  paramName: "file", // The name that will be used to transfer the file
		  maxFiles: '1',
		  acceptedFiles: '.jpg, .gif, .png, .jpeg', // allowed image types don't use image/*
		  autoQueue: false, 
		  maxFilesize: 3, // MB
		  uploadMultiple: false,
		  thumbnailWidth: 784,
		  thumbnailHeight: 431,
		  previewsContainer: ".dropzone-previews",

		  init: function() {
		  	this.on("maxfilesexceeded", function(file) {
	            console.log('maxfilesexceeded');
		    });

			this.on("addedfile", function(file) {
			  console.log('addedfile');
			  if(this.files[1]!=null){
			    this.removeFile(this.files[0]);
			  } 

			  //REMOVE ELEMENT TO AVOID DUPLICATION OF THE .dz-preview element
			   if($('.dz-preview').length > 0 ){
			    	$('#image-preview-org').remove();
			    }

			   if($('#template_copy').length > 0 ){
			  		$('#template_copy').remove();
			  }

			  currentWidth = 0;
	          currentHeight = 0;

			});

			// Will send the filesize along with the file as POST data.
			this.on("sending", function(file, xhr, formData) {
	  			formData.append("filesize", file.size); 
	  			formData.append("filewidth", file.width); 
	  			formData.append("fileheight", file.height); 
			});

			this.on("thumbnail", function(file) {
	            console.log('thumbnail');
		    });
			
			this.on("complete", function(file) {
			});

		 },
		  accept: function(file, done) {
		  	console.log('accept'); 
		  	console.log(currentWidth, currentHeight);

		    if (file.width > maxImageWidth || file.height > maxImageHeight){
		      done("Invalid dimension. Must be 784x431 px");
		    }else if(file.width < maxImageWidth || file.height < maxImageHeight){
		      done("Invalid dimension. Must be 784x431 px");
		    }else { done(); }
		 }
		};
	</script>
<?php }else{?>

<div class="radius small-12 xxlarge-8 columns no-padding"  >
	<form id="image-drop" class="small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
 		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
 		
 		<div class="dz-message dropzone-previews" data-dz-message >
 			<div id="img-container" class="small-12 large-4 columns radius" >
 				<div class="columns small-12">
 					<div class="image-icon small-3 columns"><i class="fa fa-file-image-o font-4x"></i></div>
 			   		<label class="small-9 columns" style="line-height: 1.4; margin-top: 4px;">  <span class="photo-library" id="search-lib">Choose An image from our Photo Library!</span> </label>
 			   	</div>
 			   	<div class="columns small-12">
 			   		<label class="center" style="font-size: 14px !important; line-height: 1.2;">(If you'd like to upload your own photo please login from a desktop computer</label>
 		   		</div>
 		   		
 		   	</div>
 		   	<div class="dz-preview small-12 large-7 dz-image-preview" id="template_copy">
 		   		<div class="dz-details dztemplate">
 		   		<img data-dz-thumbnail src="<?php echo $tallImageUrl; ?>" id="main-image-src"/></div>
 		   	</div>
 		</div>
 	</form>
</div>
<?php } ?>