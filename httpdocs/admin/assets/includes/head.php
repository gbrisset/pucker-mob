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
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/adminstyling.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/jquery.Jcrop.css">

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/adminstylingie78.css">
	<![endif]-->
	<style type="text/css">

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

.jcrop-preview{
  	width: 169px;
  }

/* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
#preview-pane .preview-container {
  width: 140px;
  height: 143px;
  overflow: hidden;
}

</style>
	<script src="<?php echo  $config['this_url']; ?>assets/js/lib/modernizr-2.5.3.min.js"></script>
</head>
