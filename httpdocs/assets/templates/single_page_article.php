<?php

?>

<!-- *******************************************MOBILE******************************************* -->
<?php if($detect->isMobile()){?>
<style>
	div#inarticle12-ad{ display:inline; }
	#article-caption p, #article-caption li, #article-content p, #article-content li{font-size: 1rem !important;}
	.adblade-dyna ul{ max-height: 350px;}
</style>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 no-padding">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<input type="hidden" value="<?php echo $read_more_pct; ?>" id="read_more_pct" />
	<input type="hidden" value="<?php echo $detect->is('iOS'); ?>" id="IOS" />
	
	<section id="article-summary" class="small-12 column">
		
		<!-- ARTICLE INFO TOP -->
		<div class="puc-articles-top">
			<!-- TITLE -->
			<h1 id="social_catcher" class="columns padding" style="padding-bottom: 2px;"><?php echo $article_title; ?></h1>
			
			<!-- AUTHOR INFO -->
			<div class="small-12 columns puc-articles-padding">
				<p class="author"> <a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>"><?php echo 'By '.$name; ?></a></p>
			</div>

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
			<div class="clear margin-bottom">
				<div id="article-image">

							 <?php if(isset($articleInfoObj['article_id'])){ 
								 if($articleInfoObj['article_id'] == 27296 ){
								 // #27296 - http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself 
								 	/// TEST PAGE for video instead of images
								 
								 // if($articleInfoObj['article_id'] == 23564 || $articleInfoObj['article_id'] == 26139 ){ 
								 	// #23564 -- http://www.puckermob.com/relationships/dating-pitfalls-avoiding-the-freaks-geeks-and-the-thoroughly-undatable
								 	// #26139 -- http://www.puckermob.com/moblog/to-the-20-somethings-looking-for-love-check-out-inner-circle
								 	// These articles are paid content and should keep their original image
								 ?>

										<div id="vm_player"></div>
										<script>
										window._videomosh = window._videomosh || [];

										!function (e, f, u) {
										e.async = 1;
										e.src = u;
										f.parentNode.insertBefore(e, f);
										}(document.createElement('script'),
										document.getElementsByTagName('script')[0],
										'http://player.videomosh.com/players/loader/loader_final4.js');

										_videomosh.push({publisher_key:"sequelmedia",
															mode: "player",
															container: "vm_player",
															target_type: "mix",
															type:"video",
															id:231668});
										</script>

						 <?php }elseif  ($articleInfoObj['article_id'] == 23305 ){
						 // 23305 - http://www.puckermob.com/relationships/25-little-white-lies-of-every-long-distance-relationship
						 	// ******** TOUT TEST BELOW ************************************************************************************
						?>

						<script class="tout-sdk tout-sdk-script-tag">
						!function(){var TOUT=window.TOUT=window.TOUT||{},utils={getCanonicalLinkHref:function(){for(var links=document.getElementsByTagName("link"),i=0;i<links.length;i++)if("canonical"===links[i].getAttribute("rel"))return links[i].getAttribute("href");return""},getMetaTagContentByProperty:function(metaTagProperty){for(var metaTags=document.getElementsByTagName("meta"),i=0;i<metaTags.length;i++)if(metaTags[i].getAttribute("property")===metaTagProperty)return metaTags[i].getAttribute("content");return""},getWindowLocationOrigin:function(){return window.location.protocol+"//"+window.location.host},getCanonicalUrl:function(){var canonicalUrl=utils.getCanonicalLinkHref()||utils.getMetaTagContentByProperty("og:url");return canonicalUrl&&"/"===canonicalUrl[0]&&(canonicalUrl=utils.getWindowLocationOrigin()+canonicalUrl),canonicalUrl},getOgUrl:function(){var ogUrl=utils.getMetaTagContentByProperty("og:url");return ogUrl&&"/"===ogUrl[0]&&(ogUrl=utils.getWindowLocationOrigin()+ogUrl),ogUrl},getRelCanonical:function(){var relCanonical=utils.getCanonicalLinkHref();return relCanonical&&"/"===relCanonical[0]&&(relCanonical=utils.getWindowLocationOrigin()+relCanonical),relCanonical},getExternalArticleId:function(){return utils.getMetaTagContentByProperty("tout:article:id")},getCurrentProtocol:function(){return"https:"===document.location.protocol?"https:":"http:"},getPlatformHost:function(){return TOUT.SDK_HOST||"platform.tout.com"}};TOUT.mapAsyncFetchApp={init:function(brandUid,options){this.brandUid=brandUid,this.active=!0,this.productFetched=!1,this.dataLoaded=!1,this.startedSuccessfully=!1,this.options=options||{},this.options.paramsWhitelist||(this.options.paramsWhitelist=["brand_uid","external_article_id","og_url","window_location","rel_canonical","async_fetch"])},fetch:function(){var script=document.createElement("script"),src=utils.getCurrentProtocol()+"//"+utils.getPlatformHost()+"/mid_article_player.js",params=TOUT.mapAsyncFetchApp.getMidArticleQueryParams(),joinCharacter="?";for(var param in params)params.hasOwnProperty(param)&&""!==params[param]&&(src+=joinCharacter+param+"="+encodeURIComponent(params[param]),joinCharacter="&");script.src=src;var firstScript=document.getElementsByTagName("script")[0];firstScript.parentNode.insertBefore(script,firstScript)},start:function(){this.productFetched&&this.dataLoaded&&!this.startedSuccessfully&&(this.startedSuccessfully=!0,TOUT.midArticleProductLoader.start(TOUT.data.mid_article_player_experiment))},getMidArticleQueryParams:function(){var params={};return this._whitelistContains("brand_uid")&&(params.brand_uid=this.brandUid),this._whitelistContains("content_referrer")&&(params.content_referrer=document.referrer),this._whitelistContains("external_article_id")&&(params.external_article_id=utils.getExternalArticleId()),this._whitelistContains("og_url")&&(params.og_url=utils.getOgUrl()),this._whitelistContains("window_location")&&(params.window_location=document.location.href),this._whitelistContains("rel_canonical")&&(params.rel_canonical=utils.getRelCanonical()),this._whitelistContains("async_fetch")&&(params.async_fetch=!0),params},_whitelistContains:function(value){return this.options.paramsWhitelist&&this.options.paramsWhitelist.indexOf(value)>-1}}}();
						!function(){var TOUT=window.TOUT=window.TOUT||{};if(console&&console.log&&console.log("Tout SDK: "+ +new Date),!TOUT._sdkScriptTagParsedAt){TOUT._sdkScriptTagParsedAt=new Date,TOUT.EMBED_CODE_VERSION="1.2.0";var sdkHost=TOUT.SDK_HOST||"platform.tout.com",sdkProtocol=TOUT.SDK_PROTOCOL||("https:"==window.location.protocol?"https:":"http:"),analyticsHost=TOUT.SDK_ANALYTICS_HOST||"analytics.tout.com",analyticsProtocol=TOUT.SDK_ANALYTICS_PROTOCOL||sdkProtocol;TOUT.onReady=TOUT.onReady||function(func){return TOUT._onReadyQueue=TOUT._onReadyQueue||[],TOUT._onReadyQueue.push(func),TOUT},TOUT.fireSimpleAnalyticsPixel=function(trigger_name,attrs){var img=new Image,url=analyticsProtocol+"//"+analyticsHost+"/events?trigger="+trigger_name;for(var attr in attrs)attrs.hasOwnProperty(attr)&&(url+="&"+attr+"="+encodeURIComponent(attrs[attr]));return img.src=url,img},TOUT.init=function(brandUid,options){options=options||{};var sdkScriptId="tout-js-sdk";if(document.getElementById(sdkScriptId)&&!options.forceInit)return TOUT;if(brandUid=TOUT.SDK_BRAND_UID||brandUid,"undefined"==typeof brandUid||"string"!=typeof brandUid||0===brandUid.length||brandUid.length>7)return TOUT.fireSimpleAnalyticsPixel("sdk_log",{log_level:"error",log_message:"BRAND_UID_NOT_DEFINED",content_page_url:window.location.href}),console&&console.error&&console.error("TOUT - Invalid Brand UID: "+brandUid),TOUT;TOUT._initOptions=options;var script=document.createElement("script");script.type="text/javascript",script.src=sdkProtocol+"//"+sdkHost+"/sdk/v1/"+brandUid+".js",script.id=sdkScriptId,script.className="tout-sdk";var firstScript=document.getElementsByTagName("script")[0];return firstScript.parentNode.insertBefore(script,firstScript),TOUT.fireSimpleAnalyticsPixel("sdk_initialized",{content_brand_uid:brandUid,sdk_embed_code_version:TOUT.EMBED_CODE_VERSION,content_page_url:window.location.href}),TOUT}}}();
						(function(){
						  var brandUid = '8919aa';
						  TOUT.mapAsyncFetchApp.init(brandUid);
						  TOUT.init(brandUid);
						  TOUT.mapAsyncFetchApp.fetch();
						})();
						</script>
						<div class="tout-sdk tout-top-article"></div>



						 <?php 
						 	// ******** TOUT TEST ABOVE ************************************************************************************
						 }else{?>

										<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image"> 

								 <?php // }//end if($articleInfoObj['article_id'] == 23564 ...) ?>
								 <?php }//end if($articleInfoObj['article_id'] == 27296 ...) ?>
							 <?php }//end if (isset($articleInfoObj ... ) ?>




							<?php
							// OLD CODE PLAYING VIDEOS WHEN VIDEO IS ASSOCIATED WITH THE ARTICLE

							 // if( !empty($articleInfoObj['article_video_script']) ){ 
								//  	if(get_magic_quotes_gpc()) echo stripslashes($articleInfoObj['article_video_script']);
	    			// 				else echo $articleInfoObj['article_video_script'];
							 // }else { ?>
								<!-- 
								<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image"> 
								-->
							<?php // } // end if( !empty($articleInfoObj ...?>


						

				</div>
			</div>
		</div>

		<!-- DISCLAIMER -->
		<?php if($article_disclaimer){?>
		<div class="columns no-padding padding-top disclaimer">
			<p>
				*The following article does not represent the viewpoints of PuckerMob, it's management or 
				partners, but is solely the opinion of the contributor.
			</p>
		</div>
		<?php }?>

		<!-- ARTICLE CONTENT -->
		<div class="row clear" style="margin-top: -1rem;">
			<section id="article-content" class="small-12 column sidebar-box" style="padding-bottom:0.5rem !important; margin-bottom: -5px;"> 

				<!-- ARTICLE BODY -->
				<div id="article-body">
					<?php echo $article_body; ?>
				</div>

				<!-- IMAGE SOURCE -->
				<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
					<p class="padding-bottom image-source" style="font-size: 8pt !important; margin-bottom: 0rem !important; padding-bottom: 0;">
						Photo courtesy of  <a target="_blank" href="<?php echo $article_img_credits_url;?>" > <?php echo $article_img_credits; ?></a>
					</p>
				<?php }?>

				<!-- RELATED ARTICLES -->
				<?php 

			// $ddd = new debug($related_articles,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

				if(isset($related_articles) && array_sum ($related_articles)>-3){ 
					if ( $related_articles['related_article_id_1'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
					if ( $related_articles['related_article_id_2'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
					if ( $related_articles['related_article_id_3'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
					
				?>
					<div class="row small-12 clear related-articles-box half-padding margin-top columns" style="margin-top:-8px !important; margin-bottom: -10px !important;">
						
						<div class="rel-articles-wrapper remember-to-share" style="padding-top: 0;">
							<h3 style="margin-bottom: 0.5rem !important;     color: green;">RELATED ARTICLES</h3>
							<ul>
						
						<?php foreach( $related_articles_list as $k => $related_article) {
							$related_article_id = $related_article['article_id'];
							$related_article_href = $config['this_url'] . $related_article['cat_dir_name'].'/'. $related_article['article_seo_title'];
							$related_article_title = $related_article['article_title']; 
						?>

								<li class="related_to_this_article  left" id="<?php echo $related_article_id; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
									<article id="article-<?php echo $related_article_id; ?>" class="columns no-padding">
										<div class="article-image small-4 left" style="padding-right:10px">
											<a style="font-size: 16px !important;" href="<?php echo $related_article_href; ?>">
												<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $related_article_id; ?>_tall.jpg" alt="<?php echo $related_article_title; ?>">
											</a>
										</div>
										<div class="article-title small-8 left" style="padding-right:10px">
											<h1 style="margin-left: 0.5rem;font-size: 1.2rem; height: 55px; ">
												<a style="font-size: 16px !important;" href="<?php echo $related_article_href; ?>"><?php echo $related_article_title; ?></a></h1>
										</div>
									</article>
								</li>

						<?php }//end foreach   ?>

							</ul>
						</div>
						
					</div>
				<?php } ?>
				<div id="mobile-instream-branovate-ad" style="text-align: center; clear: both; padding-top: 1rem;">
					<div id="get-content" style="text-align:center; display: inline-block;">
					
						<!-- // TEST PAGE - article #27296 http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself   -->
						<?php if( $article_id == 27296 ){?>

						<?php }else{?>
						
						<?php }//end if( $article_id == 27296 ) TEST PAGE ?>


						<!-- ANSWERS 1st UNIT -->

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
						        backfill: "<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></scr"+"ipt> <ins class=\"adsbygoogle\"style=\"display:inline-block;width:300px;height:250px\"data-ad-client=\"ca-pub-8978874786792646\"data-ad-slot=\"4230568183\"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </scr"+"ipt>"
						    });   
						</script>


						<!-- AMAZON -->
						<!-- Placeholder for AMAZON  -->
						<!-- 
						<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
						<script type="text/javascript" language="javascript">
						  //<![CDATA[
							aax_getad_mpb({
							  "slot_uuid":"5eee194a-0abb-4002-b5ee-2375da3806b4"
							});
						  //]]>
						</script>
						 -->
				
					</div>
				</div>
		</div>

		<!-- READ MORE  -->
		<div class=" read-more  small-12 columns margin-bottom" style="background: white; width: 100%;">
			<div class="button" style="width: 83%; padding: 4px; border: 1px solid #72a367; background: #78AD6C;">
				<label id="read-more-img" style=" color: #fff; font-family: oslobold; font-size: 18.5px;">TAP TO READ FULL ARTICLE</label>
			</div>
		</div> 
		
		
		<!-- ADS LELO & SHARET -->
		<div class="row" style="clear: both; padding-top: 0; border: 1px solid #ddd;"></div>
			<!-- LELO -->
			<?php if( $article_id == 16562 ||  $article_id == 17425 || $article_id == 14479 || $article_id == 14576 || $article_id == 15109 || 
					   $article_id == 15271 || $article_id == 17286  ){?>
				<div id="mobile-instream-branovate-ad"  class="margin-top padding-top small-12 row no-padding">
					<div id="get-content" style="text-align:center; display: inline-block; width:100%; margin-bottom: 10px;">
						<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
							<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_320x50_white.jpg" />
						</a>
					</div>
				</div>
			<?php }elseif( $article_id != 8560 &&  $article_id != 14613  &&  $article_id != 15104 	&& $article_id != 15284  && $article_id != 15488 ){ ?>
				
				<?php if( $article_id == 27296 ){
					// TEST PAGE - article #27296 http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself  ?>

				<?php }else{?>
				
				<?php }//end if( $article_id == 27296 ) TEST PAGE ?>
						
				<!-- NATIVO 2nd UNIT -->
				<div id="mobile-instream-branovate-ad"  class="columns " style="margin-top: 13px;">	
					<div id="nativo-second-id"></div>
				</div>

				<!-- SHARETHROUGH -->

 				<div id="mobile-instream-branovate-ad"  class="columns " style="margin-top: 13px;">	
					<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
				</div>
 
				<!-- ANSWERS 2nd UNIT -->
				<div id="mobile-instream-branovate-ad" class="columns small-12 padding-top"  style="text-align: center;">
					<div id="get-content" style="text-align:center; display: inline-block;">

						<div id="vm_inbanner2"></div>
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
						        container: "vm_inbanner2",
						        ad_mobile_id: "120824",
						        ad_desktop_id: "120826",
						        target_type: "mix",
						        passback: true,
						        backfill: "<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></scr"+"ipt> <ins class=\"adsbygoogle\"style=\"display:inline-block;width:300px;height:250px\"data-ad-client=\"ca-pub-8978874786792646\"data-ad-slot=\"7184034589\"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </scr"+"ipt>"
						    });   
						</script>
		
					</div>
				</div>

			
			<?php }// end if( $article_id ... (LELO/NOT LELO) ?>
			
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
	
		</div>
	
	</section>

	<section id="article-summary" class="small-12 column">

	<!-- FEATURED ARTICLES -->

		<h3 style="margin-bottom: 0.5rem !important;  font-size: 22.4px; font-family: OswaldLight; font-weight: bold;   color: green;">FEATURED ARTICLES</h3>
		<div class="content-wrapper columns no-padding small-12">
		<?php 

		$featured_articles = $mpArticle->getFeaturedArticles();
			// $ddd = new debug($featured_articles,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

				if($featured_articles){
				
					// foreach($featured_articles as $farticle){
					 for($xx=0; $xx<3; $xx++){
					 $farticle = $featured_articles[$xx];
						$article_title = $farticle['article_title'];
						$article_seo_title = $farticle['article_seo_title'];
						$article_id = $farticle['article_id'];
						$article_desc = $farticle['article_desc'];
						$name = $farticle['contributor_name'];
						$seo_name = $farticle['contributor_seo_name'];
						$category = $farticle['cat_dir_name'];
						$link_article = $config['this_url'].$category.'/'.$article_seo_title;

					?>
					<div class="columns small-12 padding-top featured-wrapper-div">
					
					<div id="article-featured-<?php echo $article_id; ?>" class="columns small-12 no-padding remove-border">
						<div id="article-summary" class="small-12 column ">
							
							<!-- TITLE -->
							<h1 style="font-size: 1.55rem;"><?php echo $article_title; ?></h1>
							
							<div class="small-12 padding-bottom">
								<?php if(!empty($article_desc) ){?><p class="description" style="margin-bottom:0;"><?php echo $article_desc; ?></p><?php }?>
							</div>

							<!-- Article Image -->
							<div class="clear margin-bottom" style="background: black;     margin-bottom: 5px !important;">
								<div id="article-image " class=" no-padding tinted-image " style="opacity: 0.5;">
									<a href="<?php echo $link_article; ?>">
										<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
									</a>
								</div>
								<span class="span-middle-label-img"><a href="<?php echo $link_article; ?>">Click to read full article</a></span>

							</div>
							
						</div>
						
					</div>

					</div>

						<?php if($xx == 0){?>

						<!-- CARAMBOLA -->
							<div id="mobile-instream-branovate-ad"  class="columns small-12" style="margin-top: 13px; margin-bottom: 20px; min-width: 300px">
								<!-- Carambola Script   -->
								<img height='0' width='0' alt='' src='//pixel.watch/936x' style='display:block;' /> 
								<script data-cfasync="false" class="carambola_InContent" type="text/javascript" cbola_wid="2">  
								(function (i,d,s,o,m,r,c,l,w,q,y,h,g) {  
								var e=d.getElementById(r);if(e===null){  
								var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n); 
								var dt=new Date().getTime();  
								try{i[l][w+y](h,i[l][q+y](h)+'&'+dt);}catch(er){i[h]=dt;}  
								} else if(typeof i[c]!=='undefined'){i[c]++}  
								else{i[c]=1;}  
								})(window, document, 'InContent', 'script', 'mediaType', 'carambola_proxy','Cbola_IC','localStorage','set','get','Item','cbolaDt','//route.carambo.la/inimage/getlayer?pid=spdsh12&did=110233&wid=2')  
								</script>
							</div>

						<?php } ?>



					<?php }//end for ($xx ... )
				}else{
					echo '<p>No Featured article available.</p>';
				}//end if($featured_articles)
			?>
		
		</div>

		

	</section>

</article>

<!-- *******************************************END MOBILE******************************************* -->

<!-- *******************************************DESKTOP******************************************* -->
<?php }else{?>

<article id="article-<?php echo $article_id; ?>" class=" small-12 ">
	
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	
	<section id="article-summary" class="small-12 column">
		<!-- DISCLAIMER -->
		<?php if($article_disclaimer){?>
		<div class="columns no-padding padding-top disclaimer">
			<p>
				*The following article does not represent the viewpoints of PuckerMob, it's management or 
				partners, but is solely the opinion of the contributor.
			</p>
		</div>
		<?php }?>

		<!-- Article Content -->
		<div class="row clear">
			<section id="article-content" class="small-12 column sidebar-box padding-top">
			
				<!-- ARTICLE BODY -->
				<div id="article-body">
					<p><?php echo $article_body; ?></p>
				</div>
			
				<!-- LELO -->
				<?php if(  $article_id == 16562  ||  $article_id == 17425 || $article_id == 14479 || $article_id == 14576 ||  $article_id == 15109 || $article_id == 15271 || $article_id  == 17286  ){?>
				<div class="columns inarticle-ad ad-unit hide-for-print padding-top"  style="display:inline">
					<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
						<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/lelo_desk.png" />
					</a>
				</div>
				<?php } ?>

				<?php if(  $article_id != 16562 &&  $article_id != 17425 && $article_id != 15271 &&  $article_id != 15284  && $article_id != 15488 && $article_id  != 17286){?>

				<!-- NATIVO 2nd UNIT -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 row hide-for-print no-padding margin-bottom" style="padding-bottom:0; display: inline;">
					<div id="nativo-second-id"></div>
				</section>
				
				<!-- SHARETHROUGH -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 row hide-for-print no-padding margin-bottom" style="padding-bottom:0;">
					<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
				</section>
				
				
				<?php } ?>
				
				<!-- RELATED ARTICLES -->
				<?php 
	
				if(isset($related_articles) && array_sum ($related_articles)>-3){ 
					if ( $related_articles['related_article_id_1'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
					if ( $related_articles['related_article_id_2'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
					if ( $related_articles['related_article_id_3'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
					
				?>
				<div class="row small-12 clear related-articles-box half-padding">
					<hr>
					<div class="rel-articles-wrapper">
						<h3 style="margin-bottom: 0.5rem !important;">RELATED ARTICLES</h3>
						<ul>
						
						<?php foreach( $related_articles_list as $k => $related_article) {
							$related_article_id = $related_article['article_id'];
							$related_article_href = $config['this_url'] . $related_article['cat_dir_name'].'/'. $related_article['article_seo_title'];
							$related_article_title = $related_article['article_title']; 
						?>

							<li class="related_to_this_article" id="<?php echo $related_article_id; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo $related_article_href; ?>"><?php echo $related_article_title; ?></a></li>

						<?php }//end foreach   ?>

						</ul>
					</div>
					<hr>
				</div>
				<?php }?>
			
				<!-- Social Media Icons -->
				<div class="row social-media-container social-cont-1 padding-top clear" style="margin-bottom: 0rem; display:block !important;">
					<?php include($config['include_path'].'social_media_article_buttons.php'); ?>
				</div>

				<hr>

				<?php if(!$sponsored_aricle &&  $article_id != 16562 &&   $article_id != 17425  && $article_id != 14613 && $article_id != 15284  && $article_id != 15488 && $article_id  != 17286){ ?>
				
				<!-- TABOOLA -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding" style="padding-bottom:0;">
					<div id="taboola-below-article-thumbnails"></div>
					<script type="text/javascript">
					  window._taboola = window._taboola || [];
					  _taboola.push({
					    mode: 'thumbnails-a',
					    container: 'taboola-below-article-thumbnails',
					    placement: 'Below Article Thumbnails',
					    target_type: 'mix'
					  });
					</script>
				</section>
				<?php } ?>
			
				<!-- COMMENTS BOX -->
				<?php include_once($config['include_path'].'disqus.php'); ?>
				<br>
			
			<!-- IMAGE SOURCE -->
			<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
			<p class="padding-bottom image-source" style="font-size: 8pt !important; margin-bottom: 0rem !important; padding-bottom: 0;">
				Photo courtesy of  <a target="_blank" href="<?php echo $article_img_credits_url;?>" > <?php echo $article_img_credits; ?></a></p>
				<?php }?>

			</section>
		</div>
	</section>
</article>
<?php } ?>
<!-- *******************************************END DESKTOP******************************************* -->