<div class="radius small-12 xxlarge-8 columns no-padding"  >
	<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
 		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
 		
 		<div class="dz-message inline-flex dropzone-previews" data-dz-message >
 			<div class="dz-preview dz-file-preview small-12 large-8" id="template">  <!-- template for images -->
	            <div class="dz-details dztemplate">
	              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
	              <div class="dz-size"  style="display:none;" data-dz-size></div>
	              <img data-dz-thumbnail style="display:inline;" src=""/>
	            </div>
	            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
	            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
	            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
	            <div class="dz-error-message large-8 center"><span data-dz-errormessage></span></div>
          	</div>
 			<div id="img-container" class="small-12 large-4" >
 				<div class="hide-for-large-up">
 					<div class="image-icon small-3 columns "><i class="fa fa-file-image-o font-4x"></i></div>
 			   		<label class="small-9 columns">  <span class="photo-library" id="search-lib">Choose An image from our Photo Library!</span> </label>
 			   		<label class="mini-fonts mini-fonts small-12 columns">(If you'd like to upload your own photo please login from a desktop computer</label>
 		   		</div>
 		   		<div class="show-for-large-up">
 			   		<label class="large-10 columns uppercase bold no-padding main-label">ADD An Image</label>
 			   		<label style="color: #ccc;" class="large-10 columns no-padding margin-bottom-2x">Drag Image Here or <a>Click to Upload</a> (784x431) </label>
			   		<label class="large-10 columns uppercase bold no-padding font-1x margin-bottom second-label">Don't have your own image? Don't worry!</label>
 			   		<label class="large-10 columns no-padding left" style="color: #ccc;" >  Pick An image from our free <a href="#" class="photo-library" id="search-lib">Photo Library!</a> </label>
 		   		</div>
 		   	</div>
 		</div>
 	</form>
</div>

<script>
	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
	  var previewNode = document.querySelector("#template");
	  previewNode.id = "";
	  var previewTemplate = previewNode.parentNode.innerHTML;
	  previewNode.parentNode.removeChild(previewNode);
		
		Dropzone.options.imageDrop = {
		  previewTemplate : previewTemplate,
		  paramName: "file", // The name that will be used to transfer the file
		  maxFiles: '1',
		  acceptedFiles: '.jpg, .gif, .png, .jpeg',       // allowed image types don't use image/*
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
	           //currentWidth = file.width;
	           //currentHeight = file.height;
	           console.log('thumbnail');
		    });
			
			this.on("complete", function(file) {
			 // console.log(file);
			

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