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
	#branovate-ad div{margin-left:-4px;}
	#branovate-ad-iframe{ border:none; height:240px;}
	div#tl_ad {margin-top: 0 !important; padding-top: 0 !important;}
	#article-content p:first-child{margin-bottom: 1.25rem !important;}
	#kikvid-3043, #vm_inline{display:inline-block !important;}
	#adunit-300x250-3159{display:inline-block;}
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
	#playerHolder{ height: 250px !important; width: 300px !important; display: inline-block !important;}
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
		<h1 id="social_catcher"style="margin: 1rem 0 0.5rem 0;"><?php echo $article_title; ?></h1>
		
		<!-- ABOUT THE AUTHOR -->
			<?php include_once($config['include_path'].'abouttheauthor.php'); ?>
			
		<section id="article-content-2">
			<div class="social-media-container  columns padding-bottom social_sticky clear ">
					<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    					<a class="a2a_button_facebook" style="
						    background: #3b5998;
						    width: 100%;
						    "><label class="label-social-button-2-mobile" style="padding:8px;"><i class="fa fa-facebook-square" ></i>SHARE</label></a>
						   <script src="//static.addtoany.com/menu/page.js async"></script>
					</div>
			</div>	
			
			
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

				<?php if( !$sponsored_aricle ){ ?>
					<?php if($article_id == 13305){ ?>
					<!-- TOTALLY HER -->
						<div id="ros_1195" style="display: inline-block;"></div> 
					<!-- LELO -->
					<?php }elseif( $article_id == 14479 || $article_id == 14576 ){?>
							<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank">
								<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/camp_banner_v1.jpg" />
							</a>
					<?php }else{ ?>
						<!-- /73970039/test_unit ENGAGE UNIT
						<div id='div-gpt-ad-1460406489796-0' style='height:250px; width:300px; display:inline-block;'>
						<script type='text/javascript'>
						googletag.cmd.push(function() { googletag.display('div-gpt-ad-1460406489796-0'); });
						</script>
						</div>-->
						<!-- PULSE POINT -->
						<script src="http://tag.contextweb.com/TagPublish/getjs.aspx?action=VIEWAD&cwrun=200&cwadformat=300X250&cwpid=560057&cwwidth=300&cwheight=250&cwpnet=1&cwtagid=442631"></script>
					<?php } ?>
				<?php } ?>
				</div>

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

				<?php include_once($config['include_path'].'header_social.php'); ?> 
			</div>

			<!-- READ MORE -->
			<div class=" read-more  small-12 columns margin-bottom" style="background: white; border: 2px solid green; padding: 5px;">
				<div class="button" style="border-top-width: 0px;  width:100%;">
					<label id="read-more-img" style="    color: green; font-family: oslobold; font-size: 20px;">READ MORE</label>
				</div>
			</div> 
			
			
			<!-- LELO -->
			<?php if( $article_id == 14479 || $article_id == 14576 ){?>
				<div id="mobile-instream-branovate-ad"  class="margin-top small-12 row no-padding" style="margin-top: 2rem;">
					<div id="get-content" style="text-align:center; display: inline-block; width:100%; margin-bottom: 10px;">
						<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank">
							<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/camp_banner_v1.jpg" />
						</a>
					</div>
				</div>
			<?php }elseif( $article_id != 8560 &&  $article_id != 14613){ ?>

			<?php //if($article_id == 14783){?>
			<!-- SHARETH -->
			<div id="mobile-instream-branovate-ad"  class="margin-top columns " style="margin-top: 2rem;">
				<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>	
			</div>
			<?php //}?>
			<?php if( !$sponsored_aricle ){ ?>
			<!-- KIXER -->
			<div id="mobile-instream-branovate-ad"  class="margin-top columns " style="margin-top: 2rem;">
				<div id="get-content" style="text-align:center; display: inline-block;">
					<div id='__kx_ad_4251'></div><script type="text/javascript" language="javascript" id="__kx_tag_4251">var __kx_ad_slots = __kx_ad_slots || []; (function () { var slot = 4251; var h = false; var doc = document; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == 'function') { __kx_ad_start(); } else { if (top == self) { var s = doc.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//cdn.kixer.com/ad/load.js'; s.onload = s.onreadystatechange = function(){ if (!h && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = doc.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x); } else { var tag = doc.getElementById('__kx_tag_'+slot); var win = window.parent; doc = win.document; var top_div = doc.createElement("div"); top_div.id = '__kx_ad_'+slot; doc.body.appendChild(top_div); var top_tag = doc.createElement("script"); top_tag.id = '__kx_top_tag_'+slot; top_tag.innerHTML = tag.innerHTML; doc.body.appendChild(top_tag); }}})();</script>
				</div>
			</div>

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

			<?php if( !$sponsored_aricle ){ ?>
				<?php if( $article_id != 14479 &&  $article_id != 14576 ){?>
					<div id="NmWg4157" ></div><script type="text/javascript" src ='https://cdn.nmcdn.us/js/connectV3.js'></script><script type="text/javascript">  NM.init({WidgetID: 4157})</script>
	 			<?php } ?>
 			<?php } ?>

			
			<!-- LELO -->
			<?php if( $article_id != 14479 &&  $article_id != 14576 ){?>

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
			<?php if( !$sponsored_aricle ){ ?>
			<!-- TOK -->
			<div id="mobile-instream-branovate-ad">
				<div id="get-content" style="text-align:center; display: inline-block;">
					<div id="tok-ad" class="columns small-12 margin-top margin-bottom IOS" >
						<iframe style="width:300px;height:250px;overflow:hidden;" src="//www.toksnn.com/ads/pkm_ent1_mob_us?pub=sqmpkmusmi" frameborder="0" scrolling="no"></iframe>
					</div>
				</div>
			</div>

			<?php if( isset($article_id) && $article_id != 8560 &&  $article_id != 14613){?>
				<!-- CARAMBOLA -->
				<!--<div id="mobile-instream-branovate-ad">
					<div id="get-content" style="text-align:center; display: inline-block;">

						<img height='0' width='0' alt='' src='http://pixel.watch/pssj' /> 

						<script data-cfasync="false" class="carambola_InContent" type="text/javascript" cbola_wid="0"> 

						(function (i,d,s,o,m,r,t,l,w,q,y,h,g) { 

						var e=d.getElementById(r);if(e===null){ 

						var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);

						var dt=new Date().getTime(); 

						try{i[l][w+y](h,i[l][q+y](h)+'&'+dt);}catch(er){i[h]=dt;} 

						} else if(typeof i[t]!=='undefined'){i[t]++} 

						else{i[t]=1;} 

						})(window, document, 'InContent', 'script', 'mediaType', 'carambola_proxy','Cbola_IC','localStorage','set','get','Item','cbolaDt','http://route.carambo.la/inimage/getlayer?pid=spdsh12&did=110233&wid=0') 

						</script>
					</div>
				</div>-->

			<?php } ?>
					
			<?php } ?>

			<?php } ?>

			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
	
			</section>

		</div>
	
	</section>
	<!-- UNDERTONE -->
	<?php if( isset($article_id) && ( $article_id == 14613)){?>
		<!-- /73970039/UT_SA -->
		<div id='div-gpt-ad-1461622964696-5' style='height:50px; width:320px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-5'); });
			</script>
		</div>

		<!-- /73970039/UT_SP -->
		<div id='div-gpt-ad-1461622964696-6' style='height:50px; width:320px;'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-6'); });
		</script>
		</div>

	<?php } ?>

	<?php if( !$sponsored_aricle ){ ?>
		<?php if( $article_id != 14479 &&  $article_id != 14576 ){?>
		<!-- News Max -->
		<div id="NmWg4156" ></div>
		<script type="text/javascript" src ='https://cdn.nmcdn.us/js/connectiaV1.js'></script>
		<script type="text/javascript">  NM.init({WidgetID: 4156,ArticleSelector: '.nmWidgetContainerArticle'})</script>
		<?php } ?>
	<?php } ?>
</article>


<?php }else{?>
<article id="article-<?php echo $article_id; ?>" class="columns small-12 ">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<section id="article-summary" class="small-12 column">
		<!-- TITLE -->
		<h1 style="margin-bottom: 0.5rem;"><?php echo $article_title; ?></h1>
		
		<!-- SOCIAL DESKTOP -->
		<div class="row social-media-container social-cont-1" style="margin-bottom: 10px; margin-top:20px; display:block !important;">
			<?php include($config['include_path'].'social_media_article_buttons.php'); ?>	
		</div>
		
		<!-- Article Image -->
		<div class="row">
			<div id="article-image" class="small-12 columns half-padding-right-on-lg padding-top">
				<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
			</div>
		</div>
			
		<!-- ABOUT THE AUTHOR -->
		<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

			
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
				<?php if( $article_id == 14479 || $article_id == 14576 ){?>
				<div class="columns inarticle-ad ad-unit hide-for-print padding-top"  style="display:inline">
					<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank">
						<img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/camp_banner_v2_desk.jpg" />
					</a>
				</div>
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

				<?php if($article_id == 14783){?>
				<!-- SHARETH -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 row hide-for-print no-padding" style="padding-bottom:0;">
					<div data-str-native-key="2cJqb8Tc1Y1neLjgLRvjK5JU" style="display: none;"></div>
				</section>
				<?php } ?>
			
			<?php if($article_id == 10079){ ?>
				<!-- 3LIFT -->
				<section id="content-ad-around-the-web" class="sidebar-right small-12 columns clear hide-for-print no-padding" style="padding-bottom:0;">
					<script src="//ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>
				</section>				
			<?php } ?>

			<!-- Social Media Icons -->
			<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
				<?php include($config['include_path'].'social_media_article_buttons.php'); ?>
			</div>

			<hr>
			<?php if(!$sponsored_aricle && $article_id != 14613){ ?>
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

	<!-- UNDERTONE -->
	<?php if( isset($article_id) && ( $article_id == 14613)){?>
		
		<!-- /73970039/UT_SS -->
		<div id='div-gpt-ad-1461622964696-2'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-2'); });
		</script>
		</div>

		<!-- /73970039/UT_SS_FP -->
		<div id='div-gpt-ad-1461622964696-3'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-3'); });
		</script>
		</div>

	<?php } ?>