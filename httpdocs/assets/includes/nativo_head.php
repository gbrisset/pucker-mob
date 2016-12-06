<head>
	<meta charset="utf-8" />
	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob";} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <?php 
		$headDesc = '';
		if(isset($articleInfo) && isset($articleInfo['articles'][0]) && strlen($articleInfo['articles'][0]['article_desc'])) $headDesc = $articleInfo['articles'][0]['article_desc'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_desc'])) $headDesc = $categoryInfo['cat_desc'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_desc'])) $headDesc = $mpArticle->data['article_page_desc'];

		$headTags = '';
		if(isset($articleInfo) && isset($articleInfo['articles'][0]) && strlen($articleInfo['articles'][0]['article_tags'])) $headTags = $articleInfo['articles'][0]['article_tags'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_tags'])) $headTags = $categoryInfo['cat_tags'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_tags'])) $headTags = $mpArticle->data['article_page_tags'];
	?>
	<meta name="description" content="<?php if(isset($headDesc) && strlen($headDesc)) echo $headDesc; ?>">
	<meta name ="keywords" content="<?php if(isset($headTags) && strlen($headTags)) echo strtolower($headTags); ?>">
	<meta name="author" content="Sequel Media International">

	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
	<?php
		if (!$local){
	    if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
	    else echo $mpArticle->data['article_page_analytics'];
	}?>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
	
	<script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script> 
	<meta http-equiv="X-UA-Compatible" content="IE=10" /> 
	<meta name="robots" content="noindex, nofollow" />
</head>