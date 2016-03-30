<?php
// Initialize variables
$article_body = $article_title = $article_category = $article_disclaimer = $article_img_credits =  $article_img_credits = $article_notes = $linkToContributor = $read_more_pct = '';
$article_id =0;
$second_image ='';
$contributor_id = 0;
$contributor_name = '';

if (isset($articleInfoObj) && $articleInfoObj ){
	$date = date("M d, Y", strtotime($articleInfoObj['date_updated']));
	$article_title = $articleInfoObj['article_title'];;
	$article_id = $articleInfoObj['article_id'];
	$article_body = $articleInfoObj['article_body'];
	$article_category = $category['cat_name'];
	$category_id = $category['cat_id'];
	$article_category_dir = $category['cat_dir_name'];
	if(!isset($articleInfoObj['date_updated']) || $articleInfoObj['date_updated'] == "0000-00-00 00:00:00") $date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
	else $date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

	
	if(isset($articleInfoObj['contributor_name']) && $articleInfoObj['contributor_name']) $contributor_name = $articleInfoObj['contributor_name'];
	
	if(isset($articleInfoObj['contributor_id']) && $articleInfoObj['contributor_id']) $contributor_id = $articleInfoObj['contributor_id'];

	$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
	$article_img_credits = $articleInfoObj['article_img_credits'];
	$article_img_credits_url = $articleInfoObj['article_img_credits_url'];

	$article_notes = $articleInfoObj['article_additional_comments'];
	$article_disclaimer = $articleInfoObj['article_disclaimer'];
	$read_more_pct = $articleInfoObj['article_read_more_pct'];
	$related_articles = $mpArticle->getRelatedToArticle( $article_id );

	if(file_exists(	$config['image_upload_dir'].'articlesites/puckermob/second_image/second_mob_img_'.$articleInfoObj["article_id"].'.jpg')){
		$second_image = $config['image_url'].'articlesites/puckermob/second_image/second_mob_img_'.$articleInfoObj["article_id"].'.jpg';	;
	}
}
?>

<?php if($detect->isMobile()){?>
<style>
	#branovate-ad div{ margin-left:-4px; }
	#branovate-ad-iframe{ border:none; height:240px;}
	div#tl_ad { margin-top: 0 !important; padding-top: 0 !important;}
	#article-content p:first-child{margin-bottom: 1.25rem !important;}
	#kikvid-3043, #vm_inline{ display:inline-block !important; }
	#adunit-300x250-3159{ display:inline-block; }
	.sumome-share-client.sumome-share-client-mobile-bottom-bar.sumome-share-client-counts.sumome-share-client-light.sumome-share-client-medium{
		width: 100%;
	}
	a.sumome-share-client-animated.sumome-share-client-share{     width: 100%; }
	a.sumome-share-client-animated.sumome-share-client-share {
    width: 100% !important;
}
	.sumome-share-client-animated.sumome-share-client-share.sumome-share-client-share-share.sumome-share-client-count{ display: none !important;}
	div#inarticle12-ad {
	    top: -20px;
	}
</style>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 no-padding">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<input type="hidden" value="<?php echo $second_image; ?>" id="second-mob-img" />
	<input type="hidden" value="<?php echo $read_more_pct; ?>" id="read_more_pct" />
	
	<section id="article-summary" class="small-12 column">
		
		<!-- Article Image -->
		<div class="row no-margin-with-tap">
			<div id="article-image" class="small-12 columns no-padding">
				<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
			</div>
		</div>
			
		<!-- TITLE -->
		<h1 id="social_catcher"style="margin: 1rem 0;"><?php echo $article_title; ?></h1>
		
		<section id="article-content-2">
			<div class="social-media-container  columns padding-bottom social_sticky clear ">
				<?php //if($article_id == 13516){?>
					<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    					<a class="a2a_button_facebook" style="
						    background: #3b5998;
						    width: 100%;
						    "><label class="label-social-button-2-mobile" style="padding:8px;"><i class="fa fa-facebook-square" ></i>SHARE</label></a>
						    			<script src="//static.addtoany.com/menu/page.js"></script>

					</div>
				<?php //}else{ ?>
				<!--<a class="addthis_button_facebook small-12 left" >
					<label class="label-social-button-2-mobile" ><i class="fa fa-facebook-square" ></i>SHARE</label>
				</a> -->
				<?php  //} ?>
				<!--<a class="addthis_button_pinterest_share small-2 left">
					<label class="label-social-button-2-mobile left"><i class="fa fa-pinterest" style="margin-right: 9%; font-size: 1.2rem;position: relative; top: 1px; left: 3px;"></i></label>
				</a>
				<div class="addthis_jumbo_share  small-4 right hide-for-print social-buttons-top" style="height: 2.2rem !important;"></div>-->
			</div>	
			
			<!-- ABOUT THE AUTHOR -->
			<?php include_once($config['include_path'].'abouttheauthor.php'); ?>
			

		</section>

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
		<div class="row clear" style="margin-top: -1rem;">
			<section id="article-content" class="small-12 column sidebar-box" style="padding-bottom:0.5rem !important; margin-bottom: -5px;"> 
			
			<div class="columns inarticle-ad ad-unit hide-for-print padding-top"  style="display:inline">
				<?php if($article_id == 13577){ //http://www.puckermob.com/relationships/signs-hes-a-keeperpsych ?>
					<!-- /73970039/engage_unit -->
					<div id='div-gpt-ad-1459184179852-0' style='height:250px; width:300px;'>
						<script type='text/javascript'>
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-1459184179852-0'); });
						</script>
					</div>
				<?php }elseif($article_id == 13305){?>
					<div id="ros_1195" style="display: inline-block;"></div> 
				<?php }?>
			</div>

			<!-- ARTICLE BODY -->
			<div id="article-body">
				<?php echo $article_body; ?>
			</div>

			

			<!-- IMAGE SOURCE -->
			<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
			<p class="padding-bottom image-source" style="font-size: 8pt !important; margin-bottom: 0rem !important; padding-bottom: 0;">
				Photo courtesy of  <a target="_blank" href="<?php echo $article_img_credits_url;?>" > <?php echo $article_img_credits; ?></a></p>
			<?php }?>


		</div>

			<!-- READ MORE -->
			<div class=" read-more  small-12 columns margin-bottom" style="background: white; border: 2px solid green; padding: 5px;">
				<div class="button" style="border-top-width: 0px;">
					<!--<img id="read-more-img" src="http://images.puckermob.com/articlesites/sharedimages/continue-reading-2.jpg" style=" width: 100%; border: 2px solid #287117;">
					-->
					<label id="read-more-img" style="    color: green; font-family: oslobold; font-size: 20px;">READ MORE</label>
				</div>
			</div>

			<div id="mobile-instream-branovate-ad"  class="margin-top columns " style="margin-top: 2rem;">
				<div id="get-content" style="text-align:center; display: inline-block;">
					<div id='__kx_ad_4251'></div><script type="text/javascript" language="javascript" id="__kx_tag_4251">var __kx_ad_slots = __kx_ad_slots || []; (function () { var slot = 4251; var h = false; var doc = document; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == 'function') { __kx_ad_start(); } else { if (top == self) { var s = doc.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//cdn.kixer.com/ad/load.js'; s.onload = s.onreadystatechange = function(){ if (!h && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = doc.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x); } else { var tag = doc.getElementById('__kx_tag_'+slot); var win = window.parent; doc = win.document; var top_div = doc.createElement("div"); top_div.id = '__kx_ad_'+slot; doc.body.appendChild(top_div); var top_tag = doc.createElement("script"); top_tag.id = '__kx_top_tag_'+slot; top_tag.innerHTML = tag.innerHTML; doc.body.appendChild(top_tag); }}})();</script>
				</div>
			</div>

			<!-- RELATED ARTICLES -->
			<?php 
			$related = [];
			if(isset($related_articles) && $related_articles && 
				($related_articles["related_article_id_1"] != '-1' || $related_articles["related_article_id_2"] != '-1' || $related_articles["related_article_id_3"] != '-1') ){ 
				
				$related['related_article_id_1']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
				$related['related_article_id_2']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
				$related['related_article_id_3']['info'] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
			?>
				<div class="row small-12 clear related-articles-box half-padding margin-top columns" style="margin-top:15px !important; margin-bottom:15px !important;">
					
					<div class="rel-articles-wrapper remember-to-share">
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


			<!-- BRANOVATE -->
			<div id="mobile-instream-branovate-ad">
				<div id="get-content" style="text-align:center; display: inline-block;">
					<?php if( $detect->is('iOS') ){ ?>
						<div id="branovate-ad" class="columns small-12 margin-top margin-bottom IOS" >
							<IFRAME SRC="http://ib.adnxs.com/tt?id=5839932&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="300" HEIGHT="250"></IFRAME>
 						</div>
					<?php }else{ ?>
					 	<div id="branovate-ad" class="columns small-12 margin-top margin-bottom" >
							<IFRAME SRC="http://ib.adnxs.com/tt?id=4408970&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="300" HEIGHT="250"></IFRAME>						
						</div>
					<?php }?>
				</div>
			</div>


			<div id="mobile-instream-branovate-ad">
				<div id="get-content" style="text-align:center; display: inline-block;">
					<div id="tok-ad" class="columns small-12 margin-top margin-bottom IOS" >
					<iframe style="width:300px;height:250px;overflow:hidden;" src="//www.toksnn.com/ads/pkm_ent1_mob_us?pub=sqmpkmusmi" frameborder="0" scrolling="no"></iframe>
					</div>
				</div>
			</div>
			
			

			<!--<section id="separator-section" class="row no-padding"></section>				
				<!-- COMMENTS BOX -->
				<?php include_once($config['include_path'].'disqus.php'); ?>
	
			</section>
		

		</div>
	
	</section>

</article>

<?php }else{?>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 ">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<section id="article-summary" class="small-12 column">
		<!-- TITLE -->
		<h1 style="margin-bottom: 0.5rem;"><?php echo $article_title; ?></h1>
		
		<!-- SOCIAL DESKTOP -->
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
			
			<a class="addthis_button_facebook">
				<img src="http://www.puckermob.com/assets/img/FacebookIconCircle3.png" alt="Facebook" />
			</a> 
			<a class="addthis_button_twitter">
				<img src="http://www.puckermob.com/assets/img/TwitterIconCircle.png" alt="Twitter" />
			</a> 
			<a class="addthis_button_pinterest_share">
				<img src="http://www.puckermob.com/assets/img/Pinterest-Icon-Circle.png" alt="Pinterest" />
			</a>
			<a href="#disqus-container" class="disqus_container">
				<img src="http://www.puckermob.com/assets/img/CommentsIconCircle.png" alt="Comments" />
			</a>
			
			<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

			<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		
		<!-- Article Image -->
		<div class="row">
			<!-- SMARTIES -->
			<?php if($promotedArticle){ 
				if($detect->isMobile()) $smartiesImagestyle = 'width:98%;'; else $smartiesImagestyle='';
				?>
				<div id="smarties-image" class="small-12 columns half-padding-right-on-lg">
					<span style="position: absolute; right: 0.45rem; z-index: 999;" >
						<img style="<?php echo $smartiesImagestyle; ?>" src="http://www.puckermob.com/assets/img/sponsoredby-smarties.png">
					</span>
				</div>
				<?php } ?>
				<div id="article-image" class="small-12 columns half-padding-right-on-lg padding-top">
					<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
				</div>
			</div>
			
			<!-- ABOUT THE AUTHOR -->
			<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

			<!-- Category, Date And Author Information 
			<div class="row padding-bottom">
				<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 half-padding-right-on-lg padding-bottom">
					<p class="left uppercase">
						<?php if(isset($category_id) && $category_id == 9){?>
						<span class="span-category <?php echo $article_category_dir; ?>"><?php echo $article_category; ?></span>
						<?php }?>
						<span class="span-date" style="top:3px;"><?php echo $date; ?></span>
					</p>
				</div>
			</div>-->
			
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
								<?php if( $related['related_article_id_1']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_1']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_1']['info']['article_title']; ?></a></li><?php }?>
									<?php if( $related['related_article_id_2']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_2']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_2']['info']['article_title']; ?></a></li><?php }?>
										<?php if( $related['related_article_id_3']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a></li><?php }?>
										</ul>
						</div>
									<hr>
					</div>
				<?php }?>

				

				<!-- CARAMBOLA
				<section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding" style="padding-bottom:0;">
					<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, 'InContent', 'script', 'mediaType', 'carambola_proxy', 'Cbola_initializeProxy', 'http://route.carambo.la/inimage/getlayer?pid=spdsh12')</script>
				</section> -->
				
				<!--	<div id="ld-6320-990"></div><script>(function(w,d,s,i){w.ldAdInit=w.ldAdInit||[];w.ldAdInit.push({slot:8158967306013287,size:[0, 0],id:"ld-6320-990"});if(!d.getElementById(i)){var j=d.createElement(s),p=d.getElementsByTagName(s)[0];j.async=true;j.src="//cdn2.lockerdome.com/_js/ajs.js";j.id=i;p.parentNode.insertBefore(j,p);}})(window,document,"script","ld-ajs");</script>
				-->
					
								
				<!-- Social Media Icons -->
				<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
					
					<a class="addthis_button_facebook">
						<img src="http://www.puckermob.com/assets/img/FacebookIconCircle3.png" alt="Facebook" />
					</a> 
					<a class="addthis_button_twitter">
						<img src="http://www.puckermob.com/assets/img/TwitterIconCircle.png" alt="Twitter" />
					</a> 
					<a class="addthis_button_pinterest_share">
						<img src="http://www.puckermob.com/assets/img/Pinterest-Icon-Circle.png" alt="Pinterest" />
					</a>
					<a href="#disqus-container" class="disqus_container">
						<img src="http://www.puckermob.com/assets/img/CommentsIconCircle.png" alt="Comments" />
					</a>
					
					<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

					<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

					<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem !important;">	
						<div class="addthis_jumbo_share  hide-for-print social-buttons-top" style="padding-top: 0rem !important;"></div>
					</div>
				</div>

				<hr>
				
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
							
		<?php if(!$promotedArticle){ ?>
		<section class="nativo-ad padding-top clear">
			<div class="nativo"></div> 
		</section>
		<?php } ?>
		
	</section>
</article>

<?php } ?>