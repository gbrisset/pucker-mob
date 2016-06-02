<?php
$admin = true;
        require_once('../../assets/php/config.php');
        if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
        $adminController->user->data = $adminController->user->getUserInfo();

        $lib_categories = $mpArticleAdmin->getImagesCategories();

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="newarticle">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="small-12">
				<h1>Manage Library</h1>
			</div>
			
			<section id="article-info" class="small-12 columns">
				

<?php if(!$detect->isMobile()){?>
<div class="radius small-12 xxlarge-8 columns no-padding"  >
	<form id="image-drop" class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>library/upload.php">
 		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
 		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />

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
 				<div class="show-for-large-up" style="margin: 12% 0;">
 			   		<label class="large-12 columns uppercase bold no-padding main-label">Add an image to the Library</label>
 			   		<label style="color: #ccc;" class="large-12 columns no-padding margin-bottom">Drag Image Here or <a>Click to Upload</a> (784x431) </label>
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

			  currentWidth = 0;
	          currentHeight = 0;

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
<?php }?>
</section>

<section>
	<div>

		<h2>Images:</h2>
		<div class="small-12">
			<?php 
				if($lib_categories){
						foreach( $lib_categories as $img_category){ ?>
						<div class=" no-padding no-vertical-padding" data-info="<?php echo $img_category['seo_name']; ?>">
							<div class="lib_cat_desc small-5 large-8 inline-block">
								<h1><?php echo $img_category['name']; ?></h1>
							</div>
						</div>

					<?php }
				}
			?>
		</div>
	</div>
</section>
</div>
	</main>
</body>