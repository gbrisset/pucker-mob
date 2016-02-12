<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob | We're All Part of It";} ?></title>
	<?php 
		$headDesc = $mpArticle->data['article_page_desc'];
		$headTags = $mpArticle->data['article_page_tags'];
	?>
	<meta name="description" content="<?php if(isset($headDesc) && strlen($headDesc)) echo $headDesc; ?>">
	<meta name ="keywords" content="<?php if(isset($headTags) && strlen($headTags)) echo strtolower($headTags); ?>">
	<meta name="author" content="Sequel Media Group">
	
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<link type="text/plain" rel="author" href="<?php echo $config['this_url']; ?>humans.txt" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3.3.2/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/appadmin.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/jquery.Jcrop.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/dropzone.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/tooltipster.css" />
	
	

	
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/adminstylingie78.css">
	<![endif]-->
	<!--<style type="text/css">
	/* Apply these styles only when #preview-pane has
	   been placed within the Jcrop widget */
	#preview-pane {
	  display: block;
	  position: absolute;
	  z-index: 2000;
	  top: 10px;
	  right: -280px;
	  padding: 6px;
	  background-color: white;
	  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	}
	.jcrop-preview{ width: 169px; }
	/* The Javascript code will set the aspect ratio of the crop area based on the size of the thumbnail preview, specified here */
	#preview-pane .preview-container { width: 140px; height: 143px; overflow: hidden; }
	</style>-->

	<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
	<script src="<?php echo $config['this_url']; ?>assets/js/dropzone.js"></script>
	<script>
		var minImageWidth = 784,
	    minImageHeight = 431;

		Dropzone.options.imageDrop = {
		  acceptedFiles: "image/*",
		  paramName: "file", // The name that will be used to transfer the file
		  maxFilesize: 2, // MB
		  thumbnailWidth: 784,
		  thumbnailHeight: 431,
		  previewsContainer: ".dropzone-previews",
		  init: function() {
		    this.on("addedfile", function() {
			  if (this.files[1]!=null){
			    this.removeFile(this.files[0]);
			  } 
			  $('#main-image').hide();
			});
			this.on("sending", function(file, xhr, formData) {
	  			formData.append("filesize", file.size); // Will send the filesize along with the file as POST data.
			});
			this.on("thumbnail", function(file) {

			  //if(file.size > maxFilesize ) file.rejectFileSize();
		      // Do the dimension checks you want to do
		      if (file.width < minImageWidth || file.height < minImageHeight) {
		        file.rejectDimensions()
		      }
		      else {
		        file.acceptDimensions();
		      }

		      if (file.width > (minImageWidth + 30) || file.height > ( minImageHeight+ 30) ) {
		        file.rejectDimensions()
		      }
		      else {
		        file.acceptDimensions();
		      }
		    });
		 },
		 accept: function(file, done) {
		    file.acceptDimensions = done;
		    file.rejectDimensions = function() { done("Invalid dimension. Must be 784x431 px"); };
		    file.rejectFileSize = function(){ done("Image Size must be less than 2MB");  }
	  	 }
		};
	</script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Include Editor style. -->
	<link href="<?php echo $config['this_url']; ?>assets/css/froalacss/froala_editor.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $config['this_url']; ?>assets/css/froalacss/froala_style.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/code_view.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/image_manager.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/image.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/line_breaker.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/char_counter.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/file.css">

	<!-- Include JS files. -->
	 <script src="<?php echo $config['this_url']; ?>assets/js/froalajs/froala_editor.min.js"></script>

	  <!-- Include Plugins. -->
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/align.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/char_counter.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/code_view.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/entities.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/image.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/image_manager.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/line_breaker.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/link.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/lists.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/quote.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/save.min.js"></script>
	  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/url.min.js"></script>

</head>
<?php 
	$blogger = false; $pro_blogger = false; $admin_user = false; $externalWriter = false; $pro_admin = false;
	if( $adminController->user->data['user_type'] == 3 ||  $adminController->user->data['user_type'] == 8 ||  $adminController->user->data['user_type'] == 9 ) $blogger = true;
	if( $adminController->user->data['user_type'] == 8 ) $pro_blogger = true;
	if( $adminController->user->data['user_type'] == 1 ) $pro_admin = true;
	if( $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2 || $adminController->user->data['user_type'] == 6) $admin_user = true;
	if( $adminController->user->data['user_type'] == 7 ) $externalWriter = true;
?>
