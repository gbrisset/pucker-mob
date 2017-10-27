<head>
	<meta charset="utf-8" />
	<?php 


	// $ddd = new debug($articleInfoObj,3); $ddd->show(); exit;// 0- green; 1-red; 2-grey; 3-yellow	

	
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

	<meta property="og:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob: We're All Part of It.";} ?>" />
	<meta property="og:description" content="<?php echo $headDesc; ?>" />
	<meta property="og:type" content="<?php if(isset($articleInfo) && $articleInfo){echo 'article';}else{echo 'website';} ?>" />
	<meta property="og:site_name" content="<?php echo $mpArticle->data['article_page_name']; ?>" />
	<meta property="og:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />
	<?php if(isset($articleInfo) && $articleInfo){ ?>
		<meta property="article:published_time" content="<?php if (isset($articleInfo)) echo date('Y-m-d\TH:i', strtotime($articleInfo['creation_date'])); ?>" />
		<meta property="article:section" content="<?php if (isset($categoryInfo)) echo $categoryInfo['cat_name']; ?>" />
		<meta property="article:tag" content="<?php echo $headTags; ?>" />
		<meta name="author" content="<?php echo $articleInfoObj['contributor_name']; ?>" />
		<meta property="article:author" content="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" />
		<meta property="og:image"  content="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo['article_id'].'_tall.jpg'; ?>" />
		<meta name="twitter:image" content="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo['article_id'].'_tall.jpg'; ?>" />

	<?php }elseif(isset($registration) && $registration){ ?>
		<meta property="og:image"  content="<?php echo 'http://images.puckermob.com/articlesites/featured/registration_img.jpg'; ?>" />
		<meta name="twitter:image" content="<?php echo 'http://images.puckermob.com/articlesites/featured/registration_img.jpg'; ?>" />
		<meta name="author" content="Sequel Media International" />
	<?php }else{?>
		<meta property="og:image"  content="<?php echo 'http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png'; ?>" />
		<meta name="twitter:image" content="<?php echo 'http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png'; ?>" />
		<meta name="author" content="Sequel Media International" />
	<?php } ?>
	
	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="@PuckerMob" />
	<meta name="twitter:title" content="<?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob: We're All Part of It.";} ?>" />
	<meta name="twitter:url" content="<?php echo $mpHelpers->curPageURL(); ?>" />


	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css?ver=B2986" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
	<link href="<?php echo $config['this_url']; ?>assets/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />


	<!-- GOOGLE ANALYTICS -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-6839498-81', 'auto');
	  ga('send', 'pageview');
	</script>	

	<!-- *** Zoomd: Widget Script *** --> 
	<!-- <script async="async" src="//zdwidget3-bs.sphereup.com/zoomd/SearchUi/Script?clientId=67949597"></script> -->
	<!-- *** /Zoomd *** -->
	<script type = "text/javascript">
	// this script has been provided by the advertiser but seems useless for many reasons: 
		// Jquery is not available yet
		// The elements fetching the search script are already inserted in the physical DOM - no need to append
		// the element fetching the search script in mobile is a DIV, not an IMG 
		// -- GB - 2017-02-01

	// if($(window).width() <= 1000){
	// $("ul.title-area").append('<li><img src = "http://sucdn.sphereup.com/clients/image/search_icon-white.png" alt = "Zoomd Search Widget" style = "height:1rem; margin-top:0.2rem; position:absolute; top:10px; right:20px" zoomdSearch=\'{"trigger":"OnClick"}\'/></li>');	}
	</script>
	
	<?php if( isset( $articleInfo['article_id'] ) &&  ( $articleInfo['article_id']  != 23564  ) ){
	// ARTICLE # 23564 is paid content - not subject to regular advertizing ?>
	
		<!-- Google common tage used by UNDERTONE -->
		<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
		<script>
		  var googletag = googletag || {};
		  googletag.cmd = googletag.cmd || [];
		</script>
	

		

		<?php

		$article_id = 1*$articleInfo['article_id'] ;

		// ********************************************* MOBILE BELOW *******************************************
		 if($detect->isMobile()){

		  // MOBILE select ads ----------------------------------------------------------------------------------------------------------------------------
             switch ($article_id) {
              case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
              case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
              case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
              case 4019: // TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING /relationships/how-to-date-when-you-are-broke
              case 20506: // contains explicit content - not approved for Undertone - moblog/pssy-eating-101-five-tips-to-taste-delicious

                //do nothing - we do not want other ads to interfer with the test page
                break;

              default:
                // include($config['include_path'] . 'ads/adhesion_UT_1x1.php');
                // include($config['include_path'] . 'ads/Undertone_Bilboard.php');
                // include($config['include_path'] . 'ads/Undertone_SS_FP.php');

             }//end switch ($article_id)


			}else{

		  // DESKTOP select ads ----------------------------------------------------------------------------------------------------------------------------
             switch ($article_id) {
              case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
              case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
              case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
              case 4019: // TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING /relationships/how-to-date-when-you-are-broke
              case 20506: // contains explicit content - not approved for Undertone - moblog/pssy-eating-101-five-tips-to-taste-delicious

                //do nothing - we do not want other ads to interfer with the test page
                break;


              default:
				// include($config['include_path'] . 'ads/Undertone_Bilboard.php');
    //             include($config['include_path'] . 'ads/Undertone_SS_FP.php');
             }//end switch ($article_id)

			
		  } //end  if($detect->isMobile()) ?>




	<?php } //  end of ARTICLE # 23564 is paid content - not subject to regular advertizing ?>

	<?php 
		$sponsored_aricle = true; 
	?>


	<!-- IF ARTICLE PAGE -->
	<?php
		 $current_time = new DateTime(); // Today
         $start_time = new DateTime('3:00pm');
         $end_time  = new DateTime('11:59pm');
         $branovate_on = true;
         if ( $current_time->getTimestamp() > $start_time->getTimestamp() && $current_time->getTimestamp() < $end_time->getTimestamp()){ 
          $branovate_on = true;
      	 }
	?>
	<input type="hidden" value = "<?php echo $branovate_on; ?>" id="branovate_on"/>


	<?php if (!$local){ // ----------------------------------------------------------------------------------------------- ?>
	
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

	<!-- cloudfront tracker -->
	<script>
	  !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
	  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
	  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
	  insertBefore(d,q)}(window,document,'script','_gs');
	  _gs('GSN-829786-N');
	</script>

	<?php } // end if (!$local) // ----------------------------------------------------------------------------------------------- ?>


	<!-- SHARETHROUHGH -->
	<script type="text/javascript" src="//native.sharethrough.com/assets/sfp.js"></script>

	<!-- eyeota Pixel Code -->
	<script type="text/javascript" async defer src="http://ps.eyeota.net/pixel?pid=9gdtfh1&t=ajs&sid=puckermob"></script>

	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','https://connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1637730259885401');
	fbq('track', "PageView");</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1637730259885401&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	<script>
	// ViewContent
	// Track key page views (ex: product page, landing page or article)
		fbq('track', 'ViewContent');
	</script>

	<!-- NATIVO SCRIPT -->
	<?php if( isset( $articleInfo['article_id'] ) &&   $articleInfo['article_id']  != 23564 ){
		//ARTICLE # 23564 is paid content - not subject to regular advertizing ?>
		<script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script>
	<?php }?>

	<!-- DEFY MEDIA  -->
	<script type="text/javascript" src="//pubportal.brkmd.com/tms/hbltfd41f403bd74c016c8b4ec9ca8fb241e.js"></script>

</head>
