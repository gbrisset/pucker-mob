<?php
// Initialize variables
if (isset($articleInfoObj)) {
	$article_title = $articleInfoObj['article_title'];;
	$article_id = $articleInfoObj['article_id'];
	$article_body = $articleInfoObj['article_body'];
	$article_category = $category['cat_dir_name'];
	$date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
	$contributor_name = $articleInfoObj['contributor_name'];
	$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
}
?>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<section id="article-summary" class="small-12 column">
		<h1><?php echo $article_title; ?></h1>
		
		<div class="row">
			
			 	<div class="addthis_jumbo_share small-12 xxlarge-9 columns hide-for-print social-buttons-top half-padding-right"></div>
 				<a class="addthis_button_facebook_like show-for-large-up hide-for-medium hide-for-large hide-for-xlarge-down" fb:like:send="true"></a>
			
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				<a href="#disqus_thread">0 Comments</a>
				<a href="#disqus-container" >
					<i class="fa fa-comments-o fa-2x no-margin"></i>
				</a>
				<script type="text/javascript">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_shortname = 'puckermob'; // required: replace example with your forum shortname

					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function () {
						var s = document.createElement('script'); s.async = true;
						s.type = 'text/javascript';
						s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
						(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
					}());
				</script>
			</div>
		</div>
		<!-- Sponsore UNit -->
		<?php if(!$detect->isMobile()){?>
			<div class="padding-bottom" style="">
				<div id="sponsor-ad"></div>
			</div>
			<?php }//else{
				//if($article_id == 4024){?>
				<!--<div class="padding-bottom" style="">
					<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3347316/0/6374/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"></script>
					</div>-->
				<?php //}
			//}?>

		<!-- Article Image -->
		<div class="row">
			<div id="article-image" class="small-12 columns half-padding-right-on-lg">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Post Image">
			</div>
		</div>

		<!-- Category, Date And Author Information -->
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<p class="left uppercase">
					<span class="span-category <?php echo $article_category; ?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>
			</div>
		</div>
		
		<!-- GOOGLE AD UNIT MOBILE  -->
		<?php if ( $detect->isMobile() ) {?>
		
			<div class="hide-for-print row half-padding padding-top ads" style="margin-bottom: -1.5rem;">
			<!--	<div data-str-native-key="536c62e7" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>-->
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- PM Mobile 300x90 -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:300px;height:90px"
			     data-ad-client="ca-pub-8978874786792646"
			     data-ad-slot="6565492184"></ins>
			<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			
			</div>

		<?php }?>

		<!-- Article Content -->
		<?php if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -1rem;">'; }
			  else{ echo '<div class="row">'; }
		?> 
			<section id="article-content" class="small-12 column sidebar-box">
				<p><?php echo $article_body; ?></p>
				<?php if($detect->isMobile() && !$detect->isTablet()){?>
				<div id="grad"></div>
				<p class="read-more"><a href="#" class="button">
					<i class="fa fa-caret-down caret-down-left"></i>Click To Read More<i class="fa fa-caret-down caret-down-right"></i></a>
				</p>
				<?php } ?>
			</section>
		</div>
		<?php if(!$detect->isMobile()){?>
		<!-- GOOGLE ADS UNIT -->
		<div class="row">
			<section class="columns small-12">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- PM 637x90 Bottom -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:637px;height:90px"
				     data-ad-client="ca-pub-8978874786792646"
				     data-ad-slot="3114328182"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</section>
		</div>
		<hr>
		
		<!-- Social Media Icons -->
		<div class="row padding-bottom">
			<div class="addthis_jumbo_share small-12 xxlarge-9 columns hide-for-print social-buttons-top half-padding-right"></div>
 			<a class="addthis_button_facebook_like show-for-large-up hide-for-medium hide-for-large hide-for-xlarge-down" fb:like:send="true"></a>
			
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				<a href="#disqus_thread">0 Comments</a>
				<a href="#disqus-container" >
					<i class="fa fa-comments-o fa-2x no-margin"></i>
				</a>
				<script type="text/javascript">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_shortname = 'puckermob'; // required: replace example with your forum shortname

					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function () {
						var s = document.createElement('script'); s.async = true;
						s.type = 'text/javascript';
						s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
						(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
					}());
				</script>
			</div>
		</div>
		<?php }else{ ?>
			<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->
			<div class="hide-for-print padding-top ads">
				<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			</div>

			<hr style="margin: 1.5rem 0 0rem !important">

			<!-- GOOGLE AD UNIT MOBILE  -->
			<div class="hide-for-print row half-padding padding-top padding-bottom">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- PM 300x90 Bottom -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:300px;height:90px"
			     data-ad-client="ca-pub-8978874786792646"
			     data-ad-slot="6028938587"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			
			</div>
			
		<?php }?>
		<section class="nativo-ad">
			<div class="nativo"></div> 
		</section>
	</section>
</article>

