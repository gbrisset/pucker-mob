<?php //if(!$detect->isMobile()){?>
<div class="small-12 xxlarge-8 columns no-padding"  >
	<h2 class="h2-img-drop radius">ADD A PICTURE</h2>
	
	<div class="small-12 columns no-padding image-drop-wrapper padding-top padding-bottom">
		
	<div class="columns small-12 large-6 padding-top" style="border-right: 1px solid #bbb">
		<h2>STEP 1: UPLOAD <span>(REQUIRED)</span></h2>
		<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
	 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
			<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
	 		<input type="hidden" id="a_i" name="a_i" class="a_i" value="0" />

	 			<div class="dz-message  dropzone-previews" >

	 			<div class="dz-preview dz-file-preview small-12 large-5 columns no-padding-left" id="template" >  <!-- template for images -->
		            <div class="dz-details dztemplate">
		              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
		              <div class="dz-size"  style="display:none;" data-dz-size></div>
		              <img data-dz-thumbnail id="main-image-src" src=""/>
		            </div>
		            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
		            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
		            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
		            <div class="dz-error-message large-11 center"><span data-dz-errormessage></span></div>
	          	</div>
	          	<div class="image-icon small-12 large-5 columns no-padding-left" id="icon-pic">
					<i class="fa fa-picture-o fa-5"  aria-hidden="true"></i>
				</div>
	 			<div id="img-container" class="small-12 large-7 columns right" >
					<div >
	 			   		<p>Every article needs a picture.</label>
	 			   		<p>Drag your image Here or <a>Click</a> to Upload </label>
				   	 </div>
	 		   	</div>
	 		</div>
	 	</form>
	 </div>

	 <div class="columns small-12 large-6">
	 	<h2>STEP 2: EDIT <span>(IF NEEDED)</span></h2>
	 	<div class="columns small-12 no-padding">
	 		<div class="small-12 large-4 columns no-padding-left
	 		">
	 			<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
	 		</div>
	 		<div id="img-container" class="small-12 large-8 columns" >
					<div >
	 			   		<p>Images need to be 784x431</label>
	 			   		<p>If your image is not this size, <a href="#" onclick="return launchEditor('main-image-src', $('#main-image-src').attr('src') );">click here </a> to resize or crop </label>
				   	 </div>
	 		   	</div>
	 	</div>
	 </div>
	</div>
</div>


<?php //}else{?>

<!--<div class="radius small-12 xxlarge-8 columns no-padding"  >
	<form id="image-drop" class="small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
 		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
 		
 		<div class="dz-message  dropzone-previews" data-dz-message >
 			<div id="img-container" class="small-12 large-4 columns radius" >
 				<div class="columns small-12 hide">
 					<div class="image-icon small-3 columns"><i class="fa fa-file-image-o font-4x"></i></div>
 			   		<label class="small-9 columns" style="line-height: 1.4; margin-top: 4px;">  <span class="photo-library" id="search-lib">Choose An image from our Photo Library!</span> </label>
 			   	</div>
 			   	<div class="columns small-12">
 			   		<label class="center" style="font-size: 14px !important; line-height: 1.2;">If you'd like to upload your own photo please login from a desktop computer</label>
 		   		</div>
 		   		
 		   	</div>
 		</div>
 	</form>
</div>-->
<?php //} ?>


<!-- Load widget code -->
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>   
<script>
	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
	  var previewNode = document.querySelector("#template");
	  previewNode.id = "";
	  var previewTemplate = previewNode.parentNode.innerHTML;
	  previewNode.parentNode.removeChild(previewNode);


	    var featherEditor = new Aviary.Feather({
	        apiKey: '1234567',
	        tools: ['resize', 'crop'],
	        cropPresets: ['784x431'],
	        displayImageSize: true,
	        fileFormat: 'jpg',

	        onSave: function(imageID, newURL) {
	            var img = document.getElementById(imageID);
	            img.src = newURL;
	            var id = $('#a_i').val();
	            var admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/assets/php/';

	            $.ajax({
	                type: 'POST',
	                dataType: 'json',
	                data: { task: 'get_edited_image', articleId: id, url:newURL, u_i: $('#u_i').val() },
	                url: admin_url+"getImage.php",
	                
	            	}).done(function(data) {
	            		console.log(data);
	            	});
	            $('.dz-error-message').css('display', 'none');
	            featherEditor.close();

	        },
	        onClose:function(isDirty){
	        	featherEditor.close();
	        }
	    });

	    function launchEditor(id, src) {
	        featherEditor.launch({
	            image: id,
	            url: src,
	            forceCropMessage: 'Please crop your photo to this size: 784x431',
	        });
	        return false;
	    }


		Dropzone.options.imageDrop = {
		  previewTemplate : previewTemplate,
		  paramName: "file", // The name that will be used to transfer the file
		  maxFiles: '1',
		  acceptedFiles: '.jpg, .gif, .png, .jpeg',       // allowed image types don't use image/*
		  //autoQueue: false, 
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

			  $('#icon-pic').hide();

			  currentWidth = 0;
	          currentHeight = 0;

	         
			});

			// Will send the filesize along with the file as POST data.
			this.on("sending", function(file, xhr, formData) {
	  			formData.append("filesize", file.size); 
			});

			this.on("thumbnail", function(file) {
                if (file.width != maxImageWidth || file.height != maxImageHeight) {
                  file.rejectDimensions();
                  
                  //$('.show-error').html($('.dz-error-message').html());
                }
                else {
                  file.acceptDimensions();
                }
              });

		 },
		 accept: function(file, done) {
              file.acceptDimensions = done;
              file.rejectDimensions = function() { done("Invalid dimension. Must be 784x431"); };
          }
		};
	</script>