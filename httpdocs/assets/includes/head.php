<head>

	<meta charset="utf-8" />
	<?php if ( !$detect->isMobile() ) { ?>
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//images.puckermob.com" />
	<link rel="dns-prefetch" href="//www.google-analytics.com" />
	<link rel="dns-prefetch" href="//ad.doubleclick.net" />
	<link rel="dns-prefetch" href="//cdn.assets.craveonline.com" />
	<link rel="dns-prefetch" href="//b.scorecardresearch.com" />
	<link rel="dns-prefetch" href="//s7.addthis.com" />
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
	<link rel="dns-prefetch" href="//disqus.com" />
	<link rel="dns-prefetch" href="//ib.3lift.com" />
	<link rel="dns-prefetch" href="//uac.advertising.com" />
	<link rel="dns-prefetch" href="//static.adsafeprotected.com" />
	<link rel="dns-prefetch" href="//fw.adsafeprotected.com" />
	<link rel="dns-prefetch" href="//ds.serving-sys.com" />

	<link rel="dns-prefetch" href="//adserver.adtechus.com" />
	<link rel="dns-prefetch" href="//api.adsnative.com" />
	<link rel="dns-prefetch" href="//mob.adnxs.com" />
	<link rel="dns-prefetch" href="//cms.springboardplatform.com" />
	<link rel="dns-prefetch" href="//c.jsrdn.com" />
	<link rel="dns-prefetch" href="//tcr.tynt.com" />
	<!--<link rel="dns-prefetch" href="//cdn-s.wahwahnetworks.com" />-->
	<link rel="dns-prefetch" href="//mmrm.qadserve.com" />
	<!--<link rel="dns-prefetch" href="//cdn.connatix.com" />-->
	
	<?php } ?>
	
	<link rel="dns-prefetch" href="//go.disqus.com" />
	<link rel="dns-prefetch" href="//route.carambo.la" />
	<link rel="dns-prefetch" href="//puckermob.disqus.com" />
	<link rel="prefetch prerender" href="http://www.puckermob.com" />
	<link rel="dns-prefetch" href="//native.sharethrough.com" />
	<link rel="dns-prefetch" href="//c.jsrdn.com/" />

	<link rel="dns-prefetch" href="//uat-net.technoratimedia.com" />
	<link rel="dns-prefetch" href="//static.adsnative.com" />
	<link rel="dns-prefetch" href="//sic-akamai.33across.com" />
	<link rel="dns-prefetch" href="//googletagservices.com" />
	<link rel="dns-prefetch" href="//dynamic.3lift.com" />
	<link rel="dns-prefetch" href="//cdn.amgdgt.com" />
	<link rel="dns-prefetch" href="//cdn.adnxs.com" />
	<link rel="dns-prefetch" href="//c.betrad.com" />
	<link rel="dns-prefetch" href="//ad-cdn.technoratimedia.com" />
	<link rel="dns-prefetch" href="//1.sic.33across.com" />

	<?php 
	
	$promotedArticle = false; $tag = 'smarties';

	if(isset($isArticle) && $isArticle && $articleInfoObj){ ?>
		<link rel="canonical" href="<?php echo 'http://puckermob.com/'.$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title']; ?>" />
	<?php 
		if($articleInfoObj['article_id'] == 4349 || $articleInfoObj['article_id'] == 4399 || $articleInfoObj['article_id'] == 4396){ $promotedArticle = true; }
	} ?>


	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob";} ?></title>
    
    <meta content='width=device-width, initial-scale=1' name='viewport'/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
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
	<meta name="author" content="Sequel Media Group">
	<meta property="og:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob: We're All Part of It.";} ?>" />
	<meta property="og:description" content="<?php echo $headDesc; ?>" />
	<meta property="og:type" content="<?php if(isset($articleInfo) && $articleInfo){echo 'article';}else{echo 'website';} ?>" />
	<meta property="og:site_name" content="<?php echo $mpArticle->data['article_page_name']; ?>" />
	<meta property="og:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />
	<meta property="og:image" content="<?php if(isset($articleInfo) && $articleInfo && isset($articleInfo['articles'][0])){echo $config['image_url'].'articlesites/puckermob/large/'.$articleInfo['articles'][0]['article_id'].'_tall.jpg';}else{echo 'http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png';}?>" />
	<?php if(isset($articleInfo) && $articleInfo){ ?>
	<meta property="article:published_time" content="<?php if (isset($articleInfo['articles'][0])) echo date('Y-m-d\TH:i', strtotime($articleInfo['articles'][0]['creation_date'])); ?>" />
	<meta property="article:section" content="<?php if (isset($categoryInfo)) echo $categoryInfo['cat_name']; ?>" />
	<meta property="article:tag" content="<?php echo $headTags; ?>" />
	<?php } ?>
	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	
	<style>	body {background: #fcf4de;} </style>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/newchangestoadd.css" />
	<!-- StyleSELECTOR.css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/styleselector.css" media="screen" />

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

<?php if(!$detect->isMobile()){?>

 <?php 
 	if(isset($isHomepage) && $isHomepage && $has_sponsored){?>
	    <!-- BEGIN GN Ad Tag for Pucker Mob 1000x1000 home -->
	    <script type="text/javascript">
	    if ((typeof(f466927)=='undefined' || f466927 > 0) ) {
	      if(typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if(typeof(gnm_tile) == 'undefined') gnm_tile=1;
	      document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=1000x1000;mtfInline=true;tile='+(gnm_tile++)+';ord='+gnm_ord+'?"></scr'+'ipt>');
	    }else{
	      //insert default static image here as default ad
	    }
	    </script>
	    <!-- END AD TAG -->

	    <!-- Distro Scale AD Tag 
		<script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>-->
		<!-- Begin comScore Tag -->
  	<?php }else{?>

	<!-- Place in head part widget:puck002 -->
	<script type="text/javascript">
	 
		var sbElementInterval = setInterval(function(){sbElementCheck()}, 50);
	 
		function sbElementCheck() {
	 
			var targetedElement = document.getElementById('ingageunit');
			if(targetedElement) {
				clearInterval(sbElementInterval);
				(function(d) {
					var js, s = d.getElementsByTagName('script')[0];
					js = d.createElement('script');
					js.async = true;
					js.onload = function(e) {
						SbInGageWidget.init({
							partnerId : 5087,
							widgetId : 'puck002',
							cmsPath : 'http://cms.springboardplatform.com'
						});
					}
					js.src = "http://www.springboardplatform.com/storage/js/ingage/apingage.min.js";
					s.parentNode.insertBefore(js, s);
				})(window.document);
			}
		}
	</script>

	<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>

	<!-- CARAMBOLA IN_IMAGE -->
	<?php //if(isset($articleInfoObj) && $articleInfoObj){ 
		//$noCarambola = false;
		//if($articleInfoObj['article_id'] == 4725 || $articleInfoObj['article_id'] == 4664 || $articleInfoObj['article_id'] == 4653 || $articleInfoObj['cat_dir_name'] == 'moblog' ) $noCarambola = true;
		//if( isset($noCarambola) && !$noCarambola){ ?>
			<!--<script src="http://route.carambo.la/inimage/getlayer?pid=spdsh12" id="carambola_proxy" type="text/javascript" ></script> 	-->
		<?php //}
	// }?>

	<?php } ?>

	<?php }?>
<?php } ?>

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

<!-- Begin comScore Tag Totally Her-->
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "6036161" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; 
    s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" />
</noscript>
<!-- End comScore Tag Totally Her -->

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
	
</head>
 <?php flush(); ?>