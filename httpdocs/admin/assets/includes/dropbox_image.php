
<!-- Load widget code -->
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>

<?php if(!$detect->isMobile()){?>
<div class="radius small-12 xxlarge-8 columns no-padding"  >
	<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
 		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
 		<input type="hidden" id="a_i" name="a_i" class="a_i" value="0" />

 		<div class="dz-message inline-flex dropzone-previews" data-dz-message >
 			<div class="dz-preview dz-file-preview small-12 large-7" id="template">  <!-- template for images -->
	            <div class="dz-details dztemplate">
	              <div class="dz-filename" style="display:none;"><span data-dz-name></span></div>
	              <div class="dz-size"  style="display:none;" data-dz-size></div>
	              <img data-dz-thumbnail style="display:inline;" id="main-image-src" src=""/>
	            </div>
	            <div class="dz-progress" style="display:none;"><span class="dz-upload" data-dz-uploadprogress></span></div>
	            <div class="dz-success-mark" style="display:none;"><span>✔</span></div>
	            <div class="dz-error-mark" style="display:none;"><span>✘</span></div>
	            <div class="dz-error-message large-8 center"><span data-dz-errormessage></span></div>
          	</div>
 			<div id="img-container" class="small-12 large-5" >
 				<div class="hide-for-large-up">
 					<div class="image-icon small-3 columns "><i class="fa fa-file-image-o font-4x"></i></div>
 			   		<label class="small-9 columns hide">  <span class="photo-library" id="search-lib">Choose An image from our Photo Library!</span> </label>
 			   		<label class="mini-fonts mini-fonts small-12 columns">(If you'd like to upload your own photo please login from a desktop computer)</label>
 		   		</div>
 		   		<div class="show-for-large-up" style="margin:25% 10px">
 			   		<label class="large-10 columns uppercase bold no-padding main-label">ADD An Image</label>
 			   		<label style="color: #ccc;" class="large-10 columns no-padding margin-bottom">Drag Image Here or <a>Click to Upload</a> (784x431) </label>
			   		<label class="large-10 columns uppercase bold no-padding font-1x margin-bottom second-label hide">Don't have your own image? Don't worry!</label>
 			   		<label class="large-10 columns no-padding left hide" style="color: #ccc;" >  Pick An image from our free <a href="#" class="photo-library" id="search-lib">Photo Library!</a> </label>
 		   		</div>
 		   	</div>
 		</div>
 	</form>
 	<!-- original line of HTML here: -->
<img id="editableimage1" src=""/>
<br>
<a href="#" onclick="return launchEditor('main-image-src', $('#main-image-src').attr('src') );" style="">Edit!</a>

</div>

<script>

	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
	  var previewNode = document.querySelector("#template");
	  previewNode.id = "";
	  var previewTemplate = previewNode.parentNode.innerHTML;
	  previewNode.parentNode.removeChild(previewNode);


	    var featherEditor = new Aviary.Feather({
	        apiKey: '1234567',
	        tools: ['crop', 'resize'],
	        onSave: function(imageID, newURL) {
	            var img = document.getElementById(imageID);
	            img.src = newURL;

	               $.ajax({
	                type: 'POST',
	                dataType: 'json',
	                data: { task: 'get_edited_image', articleId: 3, url:newURL, dirDest:'temp' },
	                url: "http://www.puckermob.com/getImage.php",
	                success: function(msg) {
	                    var status = 'success';
	                    if(msg['hasError']) status = 'error';

	                    $('#msg').html(msg['message']).addClass(status);
	                },
	                error: function(){
	                    var status = 'error';
	                    var msg = 'Ouch! something happend!';

	                    $('#msg').show();
	                }
	            });

	            featherEditor.close();

	        }
	    });

	    function launchEditor(id, src) {
	    	console.log('launchEditor', id, src);
	        featherEditor.launch({
	            image: id,
	            url: src
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

			  $('#main-image-src').click();
			 // console.log(file);
			  if($('#template_copy').length > 0 ){
			  	$('#template_copy').remove();
			  }

			  currentWidth = 0;
	          currentHeight = 0;

	         // var img_url = 'http://images.puckermob.com/articlesites/puckermob/large/19552_tall.jpg';
	        //  return launchEditor('main-image-src',  img_url );

			});

			// Will send the filesize along with the file as POST data.
			this.on("sending", function(file, xhr, formData) {
	  			formData.append("filesize", file.size); 
			});

			this.on("thumbnail", function(file) {
                if (file.width != maxImageWidth || file.height != maxImageHeight) {
                  file.rejectDimensions()
                }
                else {
                  file.acceptDimensions();
                }
              });

		 },
		 accept: function(file, done) {
              file.acceptDimensions = done;
              file.rejectDimensions = function() { done("Invalid dimension. Must be 784x431PX"); };
          }
		};
	</script>
<?php }else{?>

<div class="radius small-12 xxlarge-8 columns no-padding"  >
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
</div>
<?php } ?>   