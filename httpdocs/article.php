<?php
$isHomepage = false;
$isArticle = true;
 //ISSUE WITH ANNA ARTICLE
$current_url = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : '';
if($current_url == "http://www.puckermob.com/relationships/19-things-you-forget-to-thank-your-soulmate-wifey-for"){
	header('Location: http://www.puckermob.com/relationships/19-things-you-forget-to-thank-your-soulmate-wifey-for-');
	die;
}
if($current_url == "http://www.puckermob.com/fun/21-things-only-antsy-people-do"){
	header('Location: http://www.puckermob.com/fun/21-things-only-antsy-people-do-');
	die;
}
if($current_url == "http://www.puckermob.com/lifestyle/what-all-smokers-know-7-reasons-why-pot-is-better-than-alcohol"){
	header('Location: http://www.puckermob.com/lifestyle/what-all-smokers-know-7-reasons-why-pot-is-better-than-alcohol-');
	die;
}
//END ISSUE WITH ANNA ARTICLE

// Initialize variables
$article_body = $article_link = $article_title = $article_category = $article_disclaimer = $article_img_credits =  $article_img_credits = $article_notes = $linkToContributor = $read_more_pct = '';
$article_id =0;
//$second_image ='';
$contributor_id = 0;
$contributor_name = '';
$categoryInfo = array( "cat_id" => "6",  "cat_name"=> "Lifestyle", "cat_dir_name"=> "lifestyle",
 "cat_desc" => "",  "cat_tags" => "");

//CATEGORY INFO
foreach($MPNavigation->categories as $category){

	if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
		$hasParent = false;
	} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
		$hasParent = true;
	}
}

//CHECK IF BELONG TO A CATEGORY ELSE RETURN 404 PAGE
if(!is_null($categoryInfo)){
	
	//ARTICLE INFO 
	$articleInfo = $mpArticle->getSingleArticleInfo(['articleSEOTitle' => $articleTitle]);
	
	//CHECK IF ARTICLES IN REGISTER UNDER THAT CATEGORY
	$verifyInCat = $mpArticle->verifyArticleInCategory( $articleInfo['article_id'], $categoryInfo['cat_id']);
	
	if(isset($articleInfo) &&  $articleInfo && $verifyInCat ){
		$articleInfoObj = $articleInfo;

		//PAGE NAME
		$pageName = $articleInfoObj['article_title'];
		
		//ARTICLE ADS SETTINGS
		$article_ads = $mpArticleAdmin->getArticleAds($articleInfoObj);

		//RELATE ARTICLES LIST 
		$relatedArticles = $mpArticle->getArticlesList([ 'limit'=> 6,  'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['article_id']]);
		$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
		
		//if (isset($articleInfoObj) && $articleInfoObj ){
		//ARTICLE INFO
		$date = date("M d, Y", strtotime($articleInfoObj['date_updated']));
		$article_title = $articleInfoObj['article_title'];;
		$article_id = isset($articleInfoObj) ? $articleInfoObj['article_id'] : 0 ;
		$article_body = $articleInfoObj['article_body'];
		$article_desc = $articleInfoObj['article_desc'];
		$article_img_credits = $articleInfoObj['article_img_credits'];
		$article_img_credits_url = $articleInfoObj['article_img_credits_url'];
		$article_notes = $articleInfoObj['article_additional_comments'];
		$article_disclaimer = $articleInfoObj['article_disclaimer'];
		$read_more_pct = $articleInfoObj['article_read_more_pct'];
		$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];


		//DATE UPDATED 
		if(!isset($articleInfoObj['date_updated']) || $articleInfoObj['date_updated'] == "0000-00-00 00:00:00") $date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
		else $date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

		//CATEGORY INFO
		$article_category = $category['cat_name'];
		$category_id = $category['cat_id'];
		$article_category_dir = $category['cat_dir_name'];
		
		//CONTRIBUTOR INFO
		if(isset($articleInfoObj['contributor_name']) && $articleInfoObj['contributor_name']) 
			$contributor_name = $articleInfoObj['contributor_name'];
		if(isset($articleInfoObj['contributor_id']) && $articleInfoObj['contributor_id']) 
			$contributor_id = $articleInfoObj['contributor_id'];
		$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
		$seo_name = $articleInfoObj['contributor_seo_name'];

		///RELATED ARTICLES LIST 
		$related_articles = $mpArticle->getRelatedToArticle( $article_id );
		//}

	}else $mpShared->get404();
	
}else $mpShared->get404();


?>
<!-- *******************************************MOBILE******************************************* -->
<?php if ( $detect->isMobile() ) {  ?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- BODY -->
<?php include_once($config['include_path'].'head.php');?>

<!-- UNDERTONE -->
<?php if(  $articleInfoObj['article_id'] != 16562  &&  $articleInfoObj['article_id'] != 17425 
		&&  $articleInfoObj['article_id']!= 14479 &&  $articleInfoObj['article_id']!= 14576 
		&& $articleInfoObj['article_id'] !=  15109 && $articleInfoObj['article_id'] != 15271  
		&& $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488 
		&& $articleInfoObj['article_id'] != 17286  ){?>
		
		<?php if($articleInfoObj['article_id'] == 23319 ){ ?>
			<!-- /73970039/UT_SS -->
			<div id='div-gpt-ad-1476806620904-1' style='height:1px; width:1px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1476806620904-1'); });
			</script>
			</div>

			<!-- end Undertone Ad Tag for INT00 - Screen Shift - TESTING AND CERTIFICATIONS ONLY-->
		<?php }elseif( $articleInfoObj['article_id'] == 23305 ){?>
			<!-- /73970039/UT_Flex -->
			<div id='div-gpt-ad-1476806620904-0' style='height:1px; width:1px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1476806620904-0'); });
			</script>
			</div>

			<!-- end Undertone Ad Tag for INT00 - Flex - Testing Certification Purposes Only Tag -->
		<?php }elseif( $articleInfoObj['article_id'] == 25829 ){?>
			<!-- /73970039/UT_Adhesion -->
			<div id='div-gpt-ad-1480951070701-0' style='height:1px; width:1px;'>
				<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1480951070701-0'); });
				</script>
			</div>
		<?php }else{?>
			<!-- /73970039/UT_SS_FP Screen Shift Full Page -->
			<div id='div-gpt-ad-1470934220433-0' style='height:1px; width:1px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470934220433-0'); });
			</script>
			</div>
		<?php } ?>
		
<?php } ?>

<!-- HEAD -->
<body id="article" class="mobile">
	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'header.php');?>

	<!-- ADD UNIT BELOW HEADER -->
	<?php //include_once($config['include_path'].'header_ad.php');?>

	<style>
		#nav-bar{ box-shadow: none;} 
		#articlelist-wrapper{ padding-top:0 !important;}
	</style>

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main" style="">
		<section id="puc-articles" class="sidebar-right small-12   translate-fix sidebar-main-left medium-index">
			<!-- ARTICLE CONTENT -->
			<?php include_once($config['template_path'].'single_page_article.php'); ?>
				
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
			<hr>
			
		</section>
		
		<!-- 10  MOST RECENT ARTICLES ADDED -->
		<section class="clear second-section low-index">
			<?php //include_once( $config['include_path'].'most_recent_internal_articles.php'); ?>
		</section>
	</main>
	
	

		<!-- FACEBOOK FUNCTIONS -->
		<?php include_once('admin/fb/fbfunctions.php'); ?>

		<!-- MOBILE MORE TAB -->
		<?php include_once($config['include_path'].'mobiletapsection.php'); ?>

		<!-- SCRIPTS -->
		<?php include_once($config['include_path'].'bottomscripts.php');?>

		<!-- FACEBOOK COMMENTS BOX -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
</body>
</html>
<!-- *******************************************END MOBILE***************************************** -->

<!--  *******************************************DESKTOP******************************************* -->
<?php }else{ ?>
<!DOCTYPE html>
<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 

<!-- HEAD -->
<?php include_once($config['include_path'].'head.php');?>

<!-- BODY -->
<body id="article">
	<!-- UNDERTONE -->
	<?php if(  $articleInfoObj['article_id'] != 16562  &&  $articleInfoObj['article_id'] != 17425 
			   &&  $articleInfoObj['article_id']!= 14479 &&  $articleInfoObj['article_id']!= 14576 
			   && $articleInfoObj['article_id'] !=  15109 && $articleInfoObj['article_id'] != 15271  
			   && $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488 
			   && $articleInfoObj['article_id'] != 17286  ){?>

			<?php if($articleInfoObj['article_id'] == 23319 ){ ?>
			<!-- begin Undertone Ad Tag for INT00 - Screen Shift - TESTING AND CERTIFICATIONS ONLY-->
				<!-- /73970039/UT_SS -->
				<div id='div-gpt-ad-1476806620904-1' style='height:1px; width:1px;'>
				<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1476806620904-1'); });
				</script>
				</div>

			<!-- end Undertone Ad Tag for INT00 - Screen Shift - TESTING AND CERTIFICATIONS ONLY-->
			<?php }else{?>

				<!-- CURRENT -->
				<!-- /73970039/UT_SS_FP Screen Shift Full Page -->
				<div id='div-gpt-ad-1470934220433-0' style='height:1px; width:1px;'>
				<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470934220433-0'); });
				</script>
				</div>
			<?php } ?>

	<?php } ?>

	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'new_header.php'); ?>

	<!-- HEADER AD BELOW MENU -->
	<?php include_once($config['include_path'].'header_ad.php'); ?>

	<!-- ARTICLE INFO TOP -->
		<div class="puc-articles-top" style="background:#fff !important;">
			<div class="puc-articles-top-inner small-12 padding">
				<div class="columns small-12 large-9 no-padding sidebar-right left-div">
					<!-- TITLE -->
					<h1 style="margin-bottom: 0.5rem; color: #222 !important;" class=""><?php echo $article_title; ?></h1>
					
					<!-- AUTHOR INFO -->
					<div class="small-12">
						<p class="author" style="color: #222 !important;"> 
							<a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>" style="color:#222 !important;"><?php echo 'By '.$name; ?></a>
						</p>
					</div>
				</div>
				<!-- SOCIAL MEDIA -->
				<div class="columns small-12 large-9 no-padding sidebar-right left-div">
					<!-- SOCIAL MEDIA CONTENT -->
					<div id="article-content-2" class="clear">
						<div class="social-media-container   small-12 columns no-padding social_sticky clear " style="padding-bottom: 2px;">
							<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
		    					<a class="a2a_button_facebook small-6  columns" style="background: #3b5998;">
		    						<label class="label-social-button-2-mobile" style="padding:9px 0 3px 0;">
		    							<i class="fa fa-facebook" style="margin-right: 10px; font-size: 1.8rem;" ></i></label>
		    					</a>
		    					<a class="a2a_button_pinterest small-2 columns" style="background: #cb2027;">
		    						<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-pinterest" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<a class="a2a_button_twitter small-2  columns" style="background: #00aced;">
									<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-twitter" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<a class="a2a_dd small-2 columns" style="background: #003782;" href="https://www.addtoany.com/share">
									<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-plus" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<script src="//static.addtoany.com/menu/page.js" async></script>
							</div>
						</div>
					</div>
					
					<!-- IMAGE -->
					<div id="article-image" class="small-12 clear">

					 <?php

					 switch ($article_id) {
					 	case 23564: // relationships/dating-pitfalls-avoiding-the-freaks-geeks-and-the-thoroughly-undatable
					 	case 26139: // moblog/to-the-20-somethings-looking-for-love-check-out-inner-circle
							 	// These articles are paid content and should keep their original image
							
					 		echo "<img src=\"http://images.puckermob.com/articlesites/puckermob/large/$article_id" . "_tall.jpg\" alt=\" $article_title Image\">";
					 		break;
					 	
					 	case 23305: // relationships/25-little-white-lies-of-every-long-distance-relationship
							include($config['include_path'] . 'ads/_TEST_AD_tout.php'); 
					 		break;
					 	
					 	default:
							include($config['include_path'] . 'ads/video_4chicks_bottle_2.php'); 
							
					 }//end switch ($article_id)

						// OLD CODE PLAYING VIDEOS WHEN VIDEO IS ASSOCIATED WITH THE ARTICLE

						// if( !empty($articleInfoObj['article_video_script']) ){ 
						//  	if(get_magic_quotes_gpc()) echo stripslashes($articleInfoObj['article_video_script']);
						// 				else echo $articleInfoObj['article_video_script'];
						// }else { ?>
						<!-- 
						<img src="<?php //echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php // echo $article_title; ?> Image"> 
						-->
						<?php // } // end if( !empty($articleInfoObj ...?>

						

					</div>
				</div>
				
				<!-- RIGHT SIDE SECTION -->
				<div class="columns small-3 no-padding-right right-div">
					<aside id=
"aside-top" class="fixed-width-sidebar column no-padding hide-for-print">

						<!-- LELO -->
					      <?php if(isset($articleInfoObj['article_id']) &&  $articleInfoObj['article_id'] != 17425 
					      &&  $articleInfoObj['article_id'] != 16562 &&   $articleInfoObj['article_id'] != 14479 
					      && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 
					      && $articleInfoObj['article_id'] != 15271 && $articleInfoObj['article_id']  != 17286){?>
					       
					        <?php if( $articleInfoObj['article_id'] != 25362 ){ //14613 ?>     
				              <div id="atf-ad" class="ad-unit ad300 show-on-large-up">
					             <!-- MEME GLOBAL   
								<iframe id='m_iframe' src="http://growfoodsmart.com/sas/player/iframe.php?dPath=PuckerMob&sPlatform=Direct&playerSetup=PuckerMob&width=300&height=250&brandId=41&sCampaignID=10703&sSeller=178&creativeID=123&cb=12345&sDomain=www.puckermob.com" style="width:300px;height:250px;border:0;padding:0;margin:0;overflow:hidden;" scrolling="no" padding="0" border="0"></iframe>
						  -->
						    	<div id="vm_inbanner"></div>
								<script>
								    window._videomosh = window._videomosh || [];
								    !function (e, f, u) {
								        e.async = 1;
								        e.src = u;
								        f.parentNode.insertBefore(e, f);
								    }(document.createElement('script'),
								            document.getElementsByTagName('script')[0],
								            'http://player.videomosh.com/players/loader/loader_final4.js');

								    _videomosh.push({
								        publisher_key: "sequelmedia",
								        mode: "inbanner",
								        container: "vm_inbanner",
								        ad_mobile_id: "22459",
								        ad_desktop_id: "42296",
								        target_type: "mix",
								        passback: true,
								        backfill: "<script type=\"text/javascript\">google_ad_client = \"ca-pub-9021387890731428\"; google_ad_slot = \"2317387117/3794094997\";google_ad_width = 300;google_ad_height = 250;</scr"+"ipt><script type=\"text/javascript\"src=\"//pagead2.googlesyndication.com/pagead/show_ads.js\"></scr"+"ipt>"
								    });   
								</script>
				              </div>
					        <?php }else{ ?>
					         <div id="atf-ad" class="ad-unit ad300 show-on-large-up">
					        	<iframe id='m_iframe' src="http://growfoodsmart.com/sas/player/iframe.php?dPath=PuckerMob&sPlatform=Direct&playerSetup=PuckerMob&width=300&height=250&brandId=41&sCampaignID=10703&sSeller=178&creativeID=123&cb=12345&sDomain=www.puckermob.com" style="width:300px;height:250px;border:0;padding:0;margin:0;overflow:hidden;" scrolling="no" padding="0" border="0"></iframe>
					        	</div>
					         <!-- /73970039/UT_P 
					          <div id='div-gpt-ad-1461622964696-1' style='height:1050px; width:300px;'>
					            <script type='text/javascript'>
					            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-1'); });
					            </script>
					          </div>-->
					       <?php } ?>
					      <?php }else{?>
					          <div id="atf-ad" class="ad-unit ad300">
					              <a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
					              		<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" />
					              </a>
					          </div>
					      <?php }?>

					    <div id="sub-sidebar-2" class="ad-unit ad300 show-on-large-up" style="">
					          <a href="http://www.puckermob.com/login"> 
					          	<img src="http://www.puckermob.com/assets/img/homepage/write-box.jpg" style="width: 300px; height: 200px;">
					         </a>
					    </div>

					</aside>
				</div>
			</div>
				
		</div>

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main">

		<section id="puc-articles" class="cool sidebar-right  small-12 medium-12 large-11 columns translate-fix" style=" max-width: 752px; height:auto; ">

			<!-- ARTICLE CONTENT -->
			<?php include_once($config['template_path'].'single_page_article.php'); ?>

			<!-- LIKE US ON FB --> 
			<div class="columns no-padding hide-for-print like-us-fb clear" style="margin-bottom: 2rem;">
				<p class="columns small-2">Join the Mob!
					<div class="columns small-9" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
			
			<!-- ALSO IN PM ARTICLES -->
			<?php //include_once( $config['include_path'].'similararticles.php'); ?>
		</section>

		<!-- RIGHT SIDE BAR -->
		<?php include_once($config['include_path'].'rightsidebar.php');?>

	</main>
	<!-- FACEBOOK FUNCTIONS -->
	<?php include_once('admin/fb/fbfunctions.php'); ?>

	<!-- SCRITPS -->
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>

	<!-- MODAL BOX POPUP -->
	<?php include_once($config['include_path'].'login_register_popup.php');  ?>
	<div id="openModal" class="modalDialogFollow">
		<div id="popup-content" class="follow-msg-content">
			<a href="#close" title="Close" class="close">X</a>
			<div class="small-12" id="follow-box">
				<header>PUCKERMOB</header>
				<section>
					<h1>Your are following this author!</h1>
					<p id="follow-msg" class="follow-msg" ></p>
				</section>
			</div>
		</div>
	</div>

	<!-- FACEBOOK COMMENTS BOX -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>
<?php } ?>