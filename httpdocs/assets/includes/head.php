<head>
	<meta charset="utf-8" />
	<?php if ( !$detect->isMobile() ) { ?>
		<meta http-equiv="x-dns-prefetch-control" content="on" />
	<?php }
	
	$promotedArticle = false; $tag = 'smarties';
	if(isset($isArticle) && $isArticle && $articleInfoObj){ ?>
		<link rel="canonical" href="<?php echo 'http://puckermob.com/'.$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title']; ?>" />
	<?php 
		if($articleInfoObj['article_id'] == 4349 || $articleInfoObj['article_id'] == 4399 || $articleInfoObj['article_id'] == 4396){ $promotedArticle = true; }
	} ?>

	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob";} ?></title>
    <meta content='width=device-width, initial-scale=1' name='viewport'/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<?php 
		$headDesc = '';
		if(isset($articleInfo) && strlen($articleInfo['article_desc'])) $headDesc = $articleInfo['article_desc'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_desc'])) $headDesc = $categoryInfo['cat_desc'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_desc'])) $headDesc = $mpArticle->data['article_page_desc'];

		$headTags = '';
		if(isset($articleInfo) && strlen($articleInfo['article_tags'])) $headTags = $articleInfo['article_tags'];
		else if(isset($categoryInfo) && strlen($categoryInfo['cat_tags'])) $headTags = $categoryInfo['cat_tags'];
		else if(isset($mpArticle->data) && strlen($mpArticle->data['article_page_tags'])) $headTags = $mpArticle->data['article_page_tags'];
	?>
	<meta name="description" content="<?php if(isset($headDesc) && strlen($headDesc)) echo $headDesc; ?>">
	<meta name ="keywords" content="<?php if(isset($headTags) && strlen($headTags)) echo strtolower($headTags); ?>">
	<meta name="author" content="Sequel Media Group">
	<meta property="og:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob: We're All Part of It.";} ?>" />
	<meta property="og:description" content="<?php echo $headDesc; ?>" />
	<meta property="og:type" content="<?php if(isset($articleInfo) && $articleInfo){echo 'article';}else{echo 'website';} ?>" />
	<meta property="og:site_name" content="<?php echo $mpArticle->data['article_page_name']; ?>" />
	<meta property="og:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />
	<meta property="og:image" content="<?php if(isset($articleInfo) && $articleInfo ){echo $config['image_url'].'articlesites/puckermob/large/'.$articleInfo['article_id'].'_tall.jpg';}else{echo 'http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png';}?>" />
	<?php if(isset($articleInfo) && $articleInfo){ ?>
	<meta property="article:published_time" content="<?php if (isset($articleInfo)) echo date('Y-m-d\TH:i', strtotime($articleInfo['creation_date'])); ?>" />
	<meta property="article:section" content="<?php if (isset($categoryInfo)) echo $categoryInfo['cat_name']; ?>" />
	<meta property="article:tag" content="<?php echo $headTags; ?>" />
	<?php } ?>
	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	
	<style>	body {background: #fcf4de;} </style>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/newchangestoadd.css" />
	
	<style>.ad320{ height: auto !important; }</style>
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
	<?php if (!$local){
    	if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
    	else echo $mpArticle->data['article_page_analytics'];
	} ?>

<!-- IF ARTICLE PAGE -->
<?php if(!$detect->isMobile()){
 	if(isset($isHomepage) && $isHomepage && $has_sponsored){?>
    	<!-- puckermob.com/home -->
		<script type="text/javascript">
		  var ord = window.ord || Math.floor(Math.random() * 1e16);
		  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=1000x1000;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
		</script>
		<noscript>
			<a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=1000x1000;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
			<img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=1000x1000;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="1000" height="1000" />
			</a>
		</noscript>

 	<?php } ?>
<?php }else{?>

<?php } ?>

<?php if (!$local){?>
<!-- COMSCORE -->
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "18667744" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=18667744&cv=2.0&cj=1" />
</noscript>
<!-- End COMSCORE Tag -->

<!-- Quantcast Tag -->
<script type="text/javascript">
  var _qevents = _qevents || [];

  (function() {
  var elem = document.createElement('script');
  elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
  elem.async = true;
  elem.type = "text/javascript";
  var scpt = document.getElementsByTagName('script')[0];
  scpt.parentNode.insertBefore(elem, scpt);
  })();

  _qevents.push({
  qacct:"p-B2Jsd5NDNU3Qq"
  });
</script>

<noscript>
  <div style="display:none;">
    <img src="//pixel.quantserve.com/pixel/p-B2Jsd5NDNU3Qq.gif" border="0" height="1" width="1" alt="Quantcast"/>
  </div>
</noscript>
<?php }?>
 	
</head>
 <?php flush(); ?>