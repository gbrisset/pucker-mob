<?php
// Initialize variables
$article_body = $article_title = $article_category = $article_disclaimer = $article_img_credits = $article_notes = $linkToContributor = '';
$article_id =0;
$date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

if (isset($articleInfoObj) && $articleInfoObj ){
	$article_title = $articleInfoObj['article_title'];;
	$article_id = $articleInfoObj['article_id'];
	$article_body = $articleInfoObj['article_body'];
	$article_category = $category['cat_dir_name'];
	if(!isset($articleInfoObj['date_updated']) || $articleInfoObj['date_updated'] == "0000-00-00 00:00:00") $date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
	else $date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

	$contributor_name = '';
	if(isset($articleInfoObj['contributor_name']) && $articleInfoObj['contributor_name']) $contributor_name = $articleInfoObj['contributor_name'];
	$contributor_id = 0;
	if(isset($articleInfoObj['contributor_id']) && $articleInfoObj['contributor_id']) $contributor_id = $articleInfoObj['contributor_id'];

	$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
	$article_img_credits = $articleInfoObj['article_img_credits'];
	$article_notes = $articleInfoObj['article_additional_comments'];
	$article_disclaimer = $articleInfoObj['article_disclaimer'];

	$related_articles = $mpArticle->getRelatedToArticle( $article_id );
}
?>

<?php if($detect->isMobile()){?>
<style>
	#branovate-ad div{
		margin-left:-13px;
	}
</style>
<article id="article-<?php echo $article_id; ?>" class="columns small-12 no-padding">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	
	<section id="article-summary" class="small-12 column">
		<!-- Article Image -->
		<div class="row no-margin-with-tap">
			<!-- SMARTIES -->
			<?php if($promotedArticle){ 
				if($detect->isMobile()) $smartiesImagestyle = 'width:98%;'; else $smartiesImagestyle='';
			?>
				<div id="smarties-image" class="small-12 columns">
					<span style="position: absolute; right: 0.45rem; z-index: 999;" >
						<img style="<?php echo $smartiesImagestyle; ?>" src="http://www.puckermob.com/assets/img/sponsoredby-smarties.png">
					</span>
				</div>
			<?php } ?>
			<div id="article-image" class="small-12 columns no-padding">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
			</div>
		</div>
		
		<!-- TITLE -->
		<h1 style="margin: 0.5rem 0;"><?php echo $article_title; ?></h1>
		
		<!-- SOCIAL DESKTOP -->
		<section id="article-content-2">
			<!-- Social Media Icons -->
			<div class="row social-media-container  padding-bottom" style=" display:block !important;">
				<a class="addthis_button_facebook small-4 left">
					<label class="label-social-button-2-mobile left" ><i class="fa fa-facebook-square" ></i>SHARE</label>
				</a> 
				<a class="addthis_button_twitter  small-2 left">
					<label class="label-social-button-2-mobile left"><i class="fa fa-twitter"></i></label>
				</a> 
				<div class="addthis_jumbo_share  small-4 right hide-for-print social-buttons-top" style="height: 2.2rem !important;"></div>
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
		<div class="row clear" style="margin-top: -1rem;">
		
		<section id="article-content" class="small-12 column sidebar-box" style="padding-bottom:0.5rem !important; "> 
		
		<?php  //BRANOVATE ABOVE ARTICLE 
			if(isset($article_ads) && $article_ads[0] && $article_ads[0]['mobile_branovate'] == "0" ){?>
				<div class="clear" id="branovate-ad" style="background-color:#000; min-height: 15.5rem;">
				<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>
				</div>
		<?php } ?> 
		
		<!-- ARTICLE BODY -->
		<p><?php echo $article_body; ?></p>

		<?php // BRANOVATE BELOW ARTICLE BODY
		if(isset($article_ads) && $article_ads[0] && $article_ads[0]['mobile_branovate'] == "999" ){?>
			<div class="clear" id="branovate-ad" style="background-color:#000; min-height: 15.5rem; margin-bottom:1rem;">
			<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>
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
		<div class="row small-12 clear related-articles-box padding">
			<hr>
			<div class="rel-articles-wrapper remember-to-share">
			<h3 style="margin-bottom: 0.5rem !important;">RELATED ARTICLES</h3>
			<ul>
				<?php if( $related['related_article_id_1']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_1']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_1']['info']['cat_dir_name'].'/'.$related['related_article_id_1']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_1']['info']['article_title']; ?></a></li><?php }?>
				<?php if( $related['related_article_id_2']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_2']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_2']['info']['cat_dir_name'].'/'.$related['related_article_id_2']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_2']['info']['article_title']; ?></a></li><?php }?>
				<?php if( $related['related_article_id_3']['info'] ) {?><li class="related_to_this_article" id="<?php echo $related['related_article_id_3']['info']['article_id']; ?>" style="margin-bottom: 0.3rem !important;"><i class="fa fa-caret-right"></i><a href="<?php echo 'http://www.puckermob.com/'.$related['related_article_id_3']['info']['cat_dir_name'].'/'.$related['related_article_id_3']['info']['article_seo_title']; ?>"><?php echo $related['related_article_id_3']['info']['article_title']; ?></a></li><?php }?>
			</ul>
			</div>
	
		</div>
		<?php }?>

		<div class="remember-to-share padding-top row padding">
			<h3>PLEASE REMEMBER TO SHARE</h3>
		</div>
		
		
		<!-- FROM AROUND THE WEB -->	
		<?php //include_once($config['include_path'].'fromaroundthewebmobile.php'); ?>
		
		<!-- KIXER -->
		<!-- Start Below Article 
			<div id='__kx_ad_821' class="padding-top clear"></div>
			<script type="text/javascript" language="javascript">
			var __kx_ad_slots = __kx_ad_slots || [];

			(function () {
				var slot = 821;
				var h = false;
				__kx_ad_slots.push(slot);
				if (typeof __kx_ad_start == 'function') {
					__kx_ad_start();
				} else {
					var s = document.createElement('script');
					s.type = 'text/javascript';
					s.async = true;
					s.src = 'http://cdn.kixer.com/ad/load.js';
					s.onload = s.onreadystatechange = function(){
						if (!h && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
							h = true;
							s.onload = s.onreadystatechange = null;
							__kx_ad_start();
						}
					};
					var x = document.getElementsByTagName('script')[0];
					x.parentNode.insertBefore(s, x);
				}
			})();
			</script>-->
		<!-- End Below Article -->
		
		<!-- IMAGE SOURCE -->
		<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
		<p class="padding-bottom image-source" style="font-size: 10pt !important"><?php echo $article_img_credits; ?></p>
		<?php }?>

		<!-- NOTES -->
		<?php if( isset($article_img_credits) && !empty($article_notes)){?>
		<p><?php echo $article_notes; ?></p>
		<?php }?>

		<!-- COMMENTS BOX -->
		<?php include_once($config['include_path'].'disqus.php'); ?>

		<!-- READ MORE MOBILE -->
		<div id="grad"></div>
		<p class="read-more" style="margin-bottom:0 !important;"><a href="#" class="button">CONTINUE READING</a></p>

		<!--<section id="separator-section" class="row no-padding"></section>-->
		
		</section>
	</div>
	
	<!-- SMARTIES PROMOTION -->
	<?php  if($promotedArticle){ ?>	
		<div class="hide-for-print row half-padding padding-top padding-bottom">
		    	
		<!--JavaScript Tag // Tag for network 5470: Sequel Media Group // Website: Pucker Mob // Page: 1 pg Aritcle // Placement: 300 ATF (3243114) // created at: Oct 14, 2014 11:09:55 AM-->
		<script language="javascript"><!--
		        document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');
		//-->
		</script><noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="300" height="250"></a></noscript>
		<!-- End of JavaScript Tag -->
		</div>
    <?php } ?>
	
	</section>
	
	<!--<section class="">-->
	<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->
		<!--<?php if(!$promotedArticle){ ?>
			<div class="hide-for-print margin-top ads">
				<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			</div>
		<?php }?>-->

		<!-- 10  MOST RECENT ARTICLES ADDED -->
		<?php //include_once( $config['include_path'].'most_recent_internal_articles.php'); ?>
<!--	</section> -->

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
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a class="addthis_button_pinterest_share">
					<img src="<?php echo $config['this_url'].'assets/img/Pinterest-Icon-Circle.png'; ?>" alt="Pinterest" />
				</a>
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
			
				<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		<?php //include($config['include_path'].'socialbuttonsarticles.php'); ?>
		
		<!-- Article Image -->
		<div class="row">
			<!-- SMARTIES -->
			<?php if($promotedArticle){ 
				if($detect->isMobile()) $smartiesImagestyle = 'width:98%;'; else $smartiesImagestyle='';
			?>
				<div id="smarties-image" class="small-12 columns half-padding-right-on-lg">
					<span style="position: absolute; right: 0.45rem; z-index: 999;" >
						<img style="<?php echo $smartiesImagestyle; ?>" src="http://dev.puckermob.com/assets/img/sponsoredby-smarties.png">
					</span>
				</div>
			<?php } ?>
			<div id="article-image" class="small-12 columns half-padding-right-on-lg padding-top">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
			</div>
		</div>
		
		<!-- ABOUT THE AUTHOR -->
		<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

		<!-- Category, Date And Author Information -->
		<div class="row padding-bottom">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 half-padding-right-on-lg padding-bottom">
				<p class="left uppercase">
					<span class="span-category <?php echo $articleInfoObj['cat_dir_name']?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
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

	<!-- Article Content -->
	<div class="row clear">
		<section id="article-content" class="small-12 column sidebar-box padding-top">
		
		<!-- ARTICLE BODY -->
		<p><?php echo $article_body; ?></p>

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
	
		<!-- ON DESKTOP --> 
		<?php //if(!$detect->isMobile()){?>
		<!-- GOOGLE AD BOTTOM
				<div class="row padding-top padding-bottom clear">
					<section class="columns small-12 padding-bottom">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
						<!-- PM 637x90 Bottom 
						<ins class="adsbygoogle"
						     style="display:inline-block;width:637px;height:90px"
						     data-ad-client="ca-pub-8978874786792646"
						     data-ad-slot="3114328182"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</section>
				</div>-->

		<?php //}?>
		
		<!-- ingageunit -->
		<div class="row clear" >
			<!-- Place in body part -->
			<div id="ingageunit"></div>
			<!-- Place in body part -->
		</div>
		
		<!-- Social Media Icons -->
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a class="addthis_button_pinterest_share">
					<img src="<?php echo $config['this_url'].'assets/img/Pinterest-Icon-Circle.png'; ?>" alt="Pinterest" />
				</a>
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
			
				<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem !important;">	
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top" style="padding-top: 0rem !important;"></div>
				</div>
		</div>

		<hr>
				
		<!-- ADBLADE-->
		<section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding">
			<ins class="adbladeads" data-cid="6669-1650351935" data-host="web.adblade.com" data-tag-type="2" style="display:none"></ins>
			<script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"></script>
		</section>
		<hr>

		<!-- SHARETHROUGN 2ND UNIT -->
		<?php if(!$promotedArticle  && $article_id != 4555){?>
			<div data-str-native-key="53caed05" style="display: none;"></div>
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
		<?php } ?>

		<!-- COMMENTS BOX -->
		<?php include_once($config['include_path'].'disqus.php'); ?>
		<br>
		
		<!-- IMAGE SOURCE -->
		<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
		<p class="padding-bottom image-source" style="font-size: 10pt !important"><?php echo $article_img_credits; ?></p>
		<?php }?>

		<!-- NOTES -->
		<?php if( isset($article_img_credits) && !empty($article_notes)){?>
		<p><?php echo $article_notes; ?></p>
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