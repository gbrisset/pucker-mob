<div class="small-12 xxlarge-8 left padding margin-bottom no-padding dropbox-image-edit" style="background:#888;">
	<form  id="image-drop" class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
				
		<div class="dropzone-previews dz-message small-12" data-dz-message>
			<div class=" small-4 large-4 columns valign-middle">
				<div id="img-container" class="columns" style="height:270px;" >
			   		<label class="padding-top uppercase main-color  show-for-large-up font-125-pct" style="margin-top: 5%;     font-size: 1.2rem !important;">
			   			Change Image
			   		</label>
					<p class=" hide-small"><a>Click to choose</a> your own image</p>				
					<p class=" hide-small small-12 columns no-padding">OR</p>
			   		<p class="hide-small"> Choose from our  <span class="photo-library underline" id="search-lib">Photo Library!</span></p>
			   	</div>
		   	</div>
			<div class=" small-8 large-8 columns no-padding" id="image-content">
				<div class="dz-preview dz-file-preview small-12">
					<div id="main-image" class="">
						<div class="dz-details columns no-padding">	
							<img id="main-image-src" class="data-dz-thumbnail" style="width:100%; height:270px;" src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</form>
</div>

<script>
	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
		Dropzone.options.imageDrop = {
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

			   if($('#template_copy').length > 0 ){
			  		$('#template_copy').remove();
			  }

			   file.previewElement = Dropzone.createElement(this.options.previewTemplate);
			   $('#image-content').html('');
			   $('#image-content').html(file.previewElement );			
			  
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