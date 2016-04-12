<head>
	<meta charset="utf-8" />
	<?php if ( !$detect->isMobile() ) { ?>
		<!--<meta http-equiv="x-dns-prefetch-control" content="on" />-->
	<?php }
	
	$promotedArticle = false; $tag = 'smarties'; $has_sponsored = true;
	if(isset($isArticle) && $isArticle && isset($articleInfoObj)){ ?>
		<link rel="canonical" href="<?php echo 'http://www.puckermob.com/'.$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title']; ?>" />
	<?php } ?>

	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob";} ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

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
	<meta name="author" content="Sequel Media International">
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
	
	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="@PuckerMob" />
	<meta name="twitter:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob: We're All Part of It.";} ?>" />
	<meta name="twitter:image" content="<?php if(isset($articleInfo) && $articleInfo ){echo $config['image_url'].'articlesites/puckermob/large/'.$articleInfo['article_id'].'_tall.jpg';}else{echo 'http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png';}?>" />
	<meta name="twitter:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />


	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-6839498-81', 'auto');
  ga('send', 'pageview');
</script>

<!-- IF ARTICLE PAGE -->
<?php if(!$detect->isMobile()){ ?>
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

 	<!-- TABOOLA -->
 	<script type="text/javascript">
	  window._taboola = window._taboola || [];
	  _taboola.push({article:'auto'});
	  !function (e, f, u) {
	    e.async = 1;
	    e.src = u;
	    f.parentNode.insertBefore(e, f);
	  }(document.createElement('script'),
	  document.getElementsByTagName('script')[0],
	  '//cdn.taboola.com/libtrc/puckermob/loader.js');
	</script>

	<!-- Totally Her GPT -->
	<script src="http://tags.evolvemediallc.com/websites/evolve_tags/13623"></script> 

<?php }else{ ?>

	<script type='text/javascript'>
  (function() {
    var useSSL = 'https:' == document.location.protocol;
    var src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
    document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
  })();
</script>

<script type='text/javascript'>
  googletag.cmd.push(function() {
    googletag.defineSlot('/73970039/test_unit', [300, 250], 'div-gpt-ad-1460408034474-0').setTargeting('top', []).addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.pubads().enableSyncRendering();
    googletag.enableServices();
  });
</script>

	<!-- SHARETHROUNG
     <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>-->

	<?php if(isset($article_id) && $article_id == 13305 ){?>
		<!-- Totally Her GPT -->
		<script src="http://tags.evolvemediallc.com/websites/evolve_tags/13623"></script> 
	<?php } ?>

		<!-- Go to www.addthis.com/dashboard to customize your tools 
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" async></script>
		<script type="text/javascript">
			if(document.readyState === "complete") {
				addthis.init();
			}else {
			  //Add onload or DOMContentLoaded event listeners here: for example,
			  window.addEventListener("onload", function () { addthis.init(); }, false);
			}
		</script>-->

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