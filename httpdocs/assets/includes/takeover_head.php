<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//images.simpledish.com" />
	<link rel="dns-prefetch" href="//www.google-analytics.com" />
	<link rel="dns-prefetch" href="//ad.doubleclick.net" />
	<link rel="dns-prefetch" href="//cdn.assets.craveonline.com" />
	<link rel="dns-prefetch" href="//b.scorecardresearch.com" />
	<link rel="dns-prefetch" href="//g2.gumgum.com" />
	<link rel="dns-prefetch" href="//widget.crowdignite.com" />
	<link rel="dns-prefetch" href="//ib.3lift.com" />
	<link rel="dns-prefetch" href="//contextual.media.net" />
	<link rel="dns-prefetch" href="//loadus.exelator.com" />
	<link rel="dns-prefetch" href="//adserve.postrelease.com" />
	<link rel="dns-prefetch" href="//cdn.crowdignite.com" />
	<link rel="dns-prefetch" href="//cdn1.crowdignite.com" />
	<link rel="dns-prefetch" href="//tags.bluekai.com" />
	<link rel="dns-prefetch" href="//www.bkrtx.com" />
	<link rel="dns-prefetch" href="//cdn.engine.4dsply.com" />
	<link rel="dns-prefetch" href="//engine.4dsply.com" />
	<link rel="dns-prefetch" href="//pixel.quantserve.com" />
	<link rel="dns-prefetch" href="//qsearch.media.net" />
	<link rel="dns-prefetch" href="//pagead2.googlesyndication.com" />
	<link rel="dns-prefetch" href="//ads.pubmatic.com" />
	<link rel="dns-prefetch" href="//ib.adnxs.com" />
	<link rel="dns-prefetch" href="//fei.pro-market.net" />
	<link rel="dns-prefetch" href="//mycdn.media.net" />
	<link rel="prefetch prerender" href="http://www.simpledish.com" />
	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Simple Dish | Quick, Easy & Healthy Recipes";} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<?php 
		$headDesc = '';
		if(isset($articleInfo) && isset($articleInfo['articles'][0]) && strlen($articleInfo['articles'][0]['article_desc'])) $headDesc = $articleInfo['articles'][0]['article_desc'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_desc'])) $headDesc = $categoryInfo['cat_desc'];
		else if(isset($collections_info) && strlen($collections_info['collections_desc'])) $headDesc = $collections_info['collections_desc'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_desc'])) $headDesc = $mpArticle->data['article_page_desc'];

		$headTags = '';
		if(isset($articleInfo) && isset($articleInfo['articles'][0]) && strlen($articleInfo['articles'][0]['article_tags'])) $headTags = $articleInfo['articles'][0]['article_tags'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_tags'])) $headTags = $categoryInfo['cat_tags'];
		else if(isset($collections_info) && strlen($collections_info['collections_tags'])) $headTags = $collections_info['collections_tags'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_tags'])) $headTags = $mpArticle->data['article_page_tags'];
	?>
	<meta name="description" content="<?php if(isset($headDesc) && strlen($headDesc)) echo $headDesc; ?>">
	<meta name ="keywords" content="<?php if(isset($headTags) && strlen($headTags)) echo strtolower($headTags); ?>">
	<meta name="author" content="Sequel Media Group">
	<meta property="og:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Simple Dish: Real food for real life.";} ?>" />
	<meta property="og:description" content="<?php echo $headDesc; ?>" />
	<meta property="og:type" content="<?php if(isset($articleInfo) && $articleInfo){echo 'article';}else{echo 'website';} ?>" />
	<meta property="og:site_name" content="<?php echo $mpArticle->data['article_page_name']; ?>" />
	<meta property="og:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />
	<meta property="og:image" content="<?php if(isset($articleInfo) && $articleInfo && isset($articleInfo['articles'][0])){echo $config['image_url'].'articlesites/simpledish/tall/'.$articleInfo['articles'][0]['article_id'].'_tall.jpg';}else{echo $config['image_url'].'articlesites/featured/'.$mpArticle->data['featured_img'];}?>" />
	<?php if(isset($articleInfo) && $articleInfo){ ?>
	<meta property="article:published_time" content="<?php if (isset($articleInfo['articles'][0])) echo date('Y-m-d\TH:i', strtotime($articleInfo['articles'][0]['creation_date'])); ?>" />
	<meta property="article:section" content="<?php if (isset($categoryInfo)) echo $categoryInfo['cat_name']; ?>" />
	<meta property="article:tag" content="<?php echo $headTags; ?>" />
	<?php } ?>
	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<style>
	body {background: #fcf4de;}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/iframeResizer.min.js"></script>
	<?php
	if (!$local){
    if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
    else echo $mpArticle->data['article_page_analytics'];
	}
	?>
	<script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>
	<script type="text/javascript" src="http://a.postrelease.com/serve/load.js?async=true"></script>
	<script type="text/javascript" src="http://cdn.triggertag.gorillanation.com/js/triggertag.js"></script>
	<script type="text/javascript">getTrigger('10803');</script>
</head>