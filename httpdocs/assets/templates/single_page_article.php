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
					<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
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
			
				<!-- Ad below the image -->
				<div id="mobile-instream-branovate-ad" style="text-align: center; margin-bottom: 10px; margin-top: 5px;">
					<div id="get-content" style="text-align:center; display: inline-block;">
						<?php if( $article_id == 999999 ){
							// http://www.puckermob.com/ ... link here for test page
							// <script> or iframe here

							?>
							
						<?php }else{?>

							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
							 // PM Mobile Below Picture 
							</script>
							<ins class="adsbygoogle"
							     style="display:inline-block;width:320px;height:50px"
							     data-ad-client="ca-pub-8978874786792646"
							     data-ad-slot="5086819785"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
							
						<?php } ?>
					</div>
				</div>
			

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
				$related = [];
				if(isset($related_articles) && $related_articles && 
					($related_articles["related_article_id_1"] != '-1' || $related_articles["related_article_id_2"] != '-1' || $related_articles["related_article_id_3"] != '-1') ){ 
					
					$related['related_article_id_1']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
					$related['related_article_id_2']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
					$related['related_article_id_3']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
				?>
					<div class="row small-12 clear related-articles-box half-padding margin-top columns" style="margin-top:-8px !important; margin-bottom: -10px !important;">
						
						<div class="rel-articles-wrapper remember-to-share" style="padding-top: 0;">
							<h3 style="margin-bottom: 0.5rem !important;     color: green;">RELATED ARTICLES</h3>
							<ul>
								<?php if( $related['related_article_id_1']['info'] ) {?>
								<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_1']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
									<article id="article-<?php echo $related['related_article_id_1']['info']['article_id']; ?>" class="columns no-padding">
										<div class="article-image small-4 left" style="padding-right:10px">
											<a style="font-size: 16px !important;" href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>">
												<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_1']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_1']['info']['article_title']; ?>">
											</a>
										</div>
										<div class="article-title small-8 left" style="padding-right:10px">
											<h1 style="margin-left: 0.5rem;font-size: 1.2rem; height: 55px; ">
												<a style="font-size: 16px !important;" href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_1']['info']['article_title']; ?></a></h1>
										</div>
									</article>
								</li>
								<?php }?>
								<?php if( $related['related_article_id_2']['info'] ) {?>
								<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_2']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
									<article id="article-<?php echo $related['related_article_id_2']['info']['article_id']; ?>" class="columns no-padding">
										<div class="article-image small-4 left" style="padding-right:10px">
											<a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>">
												<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_2']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_2']['info']['article_title']; ?>">
											</a>
										</div>
										<div class="article-title small-8 left">
											<h1 style="margin-left: 0.5rem;font-size: 1.2rem; height: 55px;"><a style="font-size: 16px !important;" href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_2']['info']['article_title']; ?></a></h1>
										</div>
									</article>
								</li>
								<?php }?>
								<?php if( $related['related_article_id_3']['info'] ) {?>
								<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
									<article id="article-<?php echo $related['related_article_id_3']['info']['article_id']; ?>" class="columns no-padding">
										<div class="article-image small-4 left" style="padding-right:10px">
											<a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>">
												<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_3']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_3']['info']['article_title']; ?>">
											</a>
										</div>
										<div class="article-title small-8 left" style="padding-right:10px">
											<h1 style="margin-left: 0.5rem;font-size: 1.2rem; height: 55px;"><a style="font-size: 16px !important;" href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a></h1>
										</div>
									</article>
								</li>
								<?php }?>
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
						        backfill: "<script type=\"text/javascript\">google_ad_client = \"ca-pub-9021387890731428\"; google_ad_slot = \"2317387117/3794094997\";google_ad_width = 300;google_ad_height = 250;</scr"+"ipt><script type=\"text/javascript\"src=\"//pagead2.googlesyndication.com/pagead/show_ads.js\"></scr"+"ipt>"
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
				
				<!-- NATIVO 2nd UNIT -->
				<div id="mobile-instream-branovate-ad"  class="columns " style="margin-top: 13px;">	
					<div id="nativo-second-id"></div>
				</div>

				<!-- CARAMBOLA -->
				<div id="mobile-instream-branovate-ad"  class="columns small-12" style="margin-top: 13px; min-width: 300px">
					<!--Carambola Script --> 
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

				<div id="mobile-instream-branovate-ad" class="columns small-12 padding-top"  style="text-align: center;">
					<div id="get-content" style="text-align:center; display: inline-block;">
						<!-- // TEST PAGE - article #27296 http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself   -->
						<?php if( $article_id == 27296 ){?>

						<?php }else{?>
						
						<?php }//end if( $article_id == 27296 ) TEST PAGE ?>
						
						<!-- ANSWERS 2nd UNIT -->

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
							        backfill: "<script type=\"text/javascript\" language=\"javascript\" src=\"//c.amazon-adsystem.com/aax2/getads.js\"></scr"+"ipt><script type=\"text/javascript\" language=\"javascript\">aax_getad_mpb({\"slot_uuid\":\"26d6d4546-c110-4642-a343-a52e42bc4a17\"});</scr"+"ipt>"
							    });   
							</script>

						<!-- AMAZON -->
						<!-- Placeholder for AMAZON  -->
				
						<!-- 				
						<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
						<script type="text/javascript" language="javascript">
						//<![CDATA[
						aax_getad_mpb({
						"slot_uuid":"25fba8a5-f806-45fe-82d5-718e86f3d9f2"
						});
						//]]>
						</script>
						 -->		
		
					</div>
				</div>
			
			<?php } ?>
			
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
	
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
				
				<!-- SHARETH -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 row hide-for-print no-padding margin-bottom" style="padding-bottom:0;">
					<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
				</section>
				
				
				<?php } ?>
				
				<!-- RELATED ARTICLES -->
				<?php 
				$related = []; 
				if(isset($related_articles) && $related_articles && 
					($related_articles["related_article_id_1"] != '-1' || $related_articles["related_article_id_2"] != '-1' || $related_articles["related_article_id_3"] != '-1') ){ 
					$related['related_article_id_1']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
					$related['related_article_id_2']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
					$related['related_article_id_3']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
				?>
				<div class="row small-12 clear related-articles-box half-padding">
					<hr>
					<div class="rel-articles-wrapper">
						<h3 style="margin-bottom: 0.5rem !important;">RELATED ARTICLES</h3>
						<ul>
						<?php if( $related['related_article_id_1']['info'] ) {?>
							<li class="related_to_this_article" id="<?php echo $related['related_article_id_1']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_1']['info']['article_title']; ?></a></li><?php }?>
							<?php if( $related['related_article_id_2']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_2']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_2']['info']['article_title']; ?></a></li><?php }?>
								<?php if( $related['related_article_id_3']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a>
							</li>
						<?php }?>
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