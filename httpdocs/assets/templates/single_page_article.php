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
					<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
				</div>
			</div>
		</div>

		
		<div id="mobile-instream-branovate-ad" class="columns" style="margin-top:7px; margin-bottom: 15px;">
			<div id="get-content" style="text-align:center;">
			<?php if( $article_id == 19197 ){?>
				<!-- MEME GLOBAL -->
				<script>var ourBBBDomain = "growfoodsmart.com"; </script>
				<script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
				<div id="mvp"></div>
				<script id="tme3" type="text/javascript" src ='http://growfoodsmart.com/sas/player/avMul.php?&sPlt=Direct&sCmpID=10710&sSlr=178&creativeID=123&cb=12345&channelID=56e97118181f4655728b4618&sDmn=puckermob.com'></script>
			<?php }else{?>
				<!-- AMAZON -->
				<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
				<script type="text/javascript" language="javascript">
				 //<![CDATA[
				   aax_getad_mpb({
				     "slot_uuid":"cbed7a67-80a8-43f3-a883-1c12273cb50a"
				   });
				 //]]>
				</script>
			<?php }?>
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
				<!-- ENGAGE BDR && ADS TEST -->
				<?php if( $article_id == 8787 ){?>
					<div class="columns ad-unit hide-for-print padding-top no-padding"  style="display:inline">
					<!-- /73970039/ROS300x250 -->
						<div id='div-gpt-ad-1462440432230-0' style='height:250px; width:300px; display:inline-block;'>
						<script type='text/javascript'>
						googletag.cmd.push(function() { googletag.display('div-gpt-ad-1462440432230-0'); });
						</script>
						</div>
					</div>
				<?php }else{ ?>
					<?php if($article_id != 15284 && $article_id != 15488 ){?>
						<?php if($article_id == 13465 ){?>
							<div class="columns ad-unit hide-for-print padding-top no-padding"  style="display:inline">

							<div id="mobile-instream-branovate-ad">
								<div id="adunit-300x250-3159"></div><script src="http://4cad707bbe7099c8f3c8-1d22a0d4135badeea192d868b304eb1e.r26.cf5.rackcdn.com/ad_units/3159/unit.js?ord=%%CACHEBUSTER%%" async="true"></script>
							</div>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>

				<!-- ARTICLE BODY -->
				<div class="nmWidgetContainerArticle"><!-- News Max -->
				<style>
					.nmx_ad_prefix, .nmx_ad_slot  {
					       display: inline;
						    position: relative;
						    bottom: 10px;
					}
				</style>
				<div id="article-body">
					<?php echo $article_body; ?>
				</div>
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
				<div class="row small-12 clear related-articles-box half-padding margin-top columns" style="margin-top:-8px !important; margin-bottom:15px !important;">
					
					<div class="rel-articles-wrapper remember-to-share" style="padding-top: 0;">
						<h3 style="margin-bottom: 0.5rem !important;">RELATED ARTICLES</h3>
						<ul>
							<?php if( $related['related_article_id_1']['info'] ) {?>
							<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_1']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
								<article id="article-<?php echo $related['related_article_id_1']['info']['article_id']; ?>" class="columns no-padding">
									<div class="article-image small-5 left" style="padding-right:10px">
										<a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>">
											<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_1']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_1']['info']['article_title']; ?>">
										</a>
									</div>
									<div class="article-title small-7 left" style="padding-right:10px">
										<h1 style="margin-left: 0.5rem;font-size: 1.2rem;"><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_1']['info']['article_title']; ?></a></h1>
									</div>
								</article>
							</li>
							<?php }?>
							<?php if( $related['related_article_id_2']['info'] ) {?>
							<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_2']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
								<article id="article-<?php echo $related['related_article_id_2']['info']['article_id']; ?>" class="columns no-padding">
									<div class="article-image small-5 left" style="padding-right:10px">
										<a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>">
											<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_2']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_2']['info']['article_title']; ?>">
										</a>
									</div>
									<div class="article-title small-7 left">
										<h1 style="margin-left: 0.5rem;font-size: 1.2rem;"><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_2']['info']['article_title']; ?></a></h1>
									</div>
								</article>
							</li>
							<?php }?>
							<?php if( $related['related_article_id_3']['info'] ) {?>
							<li class="related_to_this_article  left" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;border: 1px solid #ddd;padding: 0.2rem;">
								<article id="article-<?php echo $related['related_article_id_3']['info']['article_id']; ?>" class="columns no-padding">
									<div class="article-image small-5 left" style="padding-right:10px">
										<a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>">
											<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $related['related_article_id_3']['info']['article_id']; ?>_tall.jpg" alt="<?php echo $related['related_article_id_3']['info']['article_title']; ?>">
										</a>
									</div>
									<div class="article-title small-7 left" style="padding-right:10px">
										<h1 style="margin-left: 0.5rem;font-size: 1.2rem;"><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a></h1>
									</div>
								</article>
							</li>
							<?php }?>
						</ul>
					</div>
					
				</div>
			<?php } ?>

				<?php include_once($config['include_path'].'header_social.php'); ?> 
		</div>

		<!-- READ MORE  -->
		<div class=" read-more  small-12 columns margin-bottom" style="background: white; width: 100%;">
			<div class="button" style="width: 83%; padding: 4px; border: 3px solid green;">
				<label id="read-more-img" style=" color: green; font-family: oslobold; font-size: 18.5px;">TAP TO READ FULL ARTICLE</label>
			</div>
		</div> 
		
		<!-- ADS LELO & SHARET -->
		<div class="row" style="clear: both; border-bottom: 1px solid #ddd; padding-top: 1rem;"></div>
			<!-- LELO -->
			<?php if(  $article_id == 16562 ||  $article_id == 17425 || $article_id == 14479 || $article_id == 14576 || $article_id == 15109 || $article_id == 15271 || $article_id == 17286  ){?>
				<div id="mobile-instream-branovate-ad"  class="margin-top padding-top small-12 row no-padding">
					<div id="get-content" style="text-align:center; display: inline-block; width:100%; margin-bottom: 10px;">
						<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
							<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_320x50_white.jpg" />
						</a>
					</div>
				</div>
			<?php }elseif( $article_id != 8560 &&  $article_id != 14613  &&  $article_id != 15104 	&& $article_id != 15284  && $article_id != 15488 ){ ?>
				<!-- SHARETH -->
				<div id="mobile-instream-branovate-ad"  class="columns " style="margin-top: 13px;">
					<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
				</div>
			<?php } ?>

			<?php if( !$sponsored_aricle ){ ?>
				<?php if( $article_id != 14479 &&  $article_id != 14576 && 	$article_id != 15284  && $article_id != 15488 ){?>
					<div id="NmWg4157" ></div><script type="text/javascript" src ='https://cdn.nmcdn.us/js/connectV3.js'></script><script type="text/javascript">  NM.init({WidgetID: 4157})</script>
	 			<?php } ?>
 			<?php } ?>

			
			<!-- LELO -->
			<?php if(  $article_id != 16562  &&  $article_id != 17425 &&  $article_id != 14479 &&  $article_id != 14576 && $article_id !=  15109 && $article_id != 15271  && 	$article_id != 15284  && $article_id != 15488 && $article_id != 17286  ){?>

			<!-- MEMEGLOBAL -->
			<div id="mobile-instream-branovate-ad" class="columns" style="margin-top:10px; margin-bottom: 10px;">
				<div id="get-content" style="text-align:center;">
					<script>var ourBBBDomain = "growfoodsmart.com"; </script>
					<div id="mvp"></div>
					<script id="tme3" type="text/javascript" src = 'http://growfoodsmart.com/sas/player/avMul.php?&sPlt=Direct&sCmpID=10704&sSlr=178&creativeID=123&cb=12345&channelID=56e97118181f4655728b4618&sDmn=puckermob.com'></script>
				</div>
			</div>


			<!-- AMAZON -->
			<div id="mobile-instream-branovate-ad" style="text-align: center;">
				<div id="get-content" style="text-align:center; display: inline-block;">
						<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
						<script type="text/javascript" language="javascript">
						  //<![CDATA[
						    aax_getad_mpb({
						      "slot_uuid":"2e18cb00-0578-49b4-8214-1f204e8327a2"
						    });
						  //]]>
						</script>
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
				<!--<div class="columns inarticle-ad ad-unit hide-for-print padding-top"  style="display:inline">
				
				</div>-->
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


				<?php if($article_id == 15212){?>
					<!-- /73970039/ROS1x1 
					<div id='div-gpt-ad-1462751375432-0' style='height:1px; width:1px;'>
					<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1462751375432-0'); });
					</script>
					</div> -->
				<?php }else{?>
					<?php if(  $article_id != 16562 &&  $article_id != 17425 && $article_id != 15271 &&  $article_id != 15284  && $article_id != 15488 && $article_id  != 17286){?>
					<!-- SHARETH -->
					<section id="content-ad-around-the-web" class="sidebar-right small-12 row hide-for-print no-padding margin-bottom" style="padding-bottom:0;">
						<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
					</section>
					<?php } ?>
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
									<?php if( $related['related_article_id_3']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a></li><?php }?>
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
