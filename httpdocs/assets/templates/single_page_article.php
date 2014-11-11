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
	$article_img_credits = $articleInfoObj['article_img_credits'];
	$article_notes = $articleInfoObj['article_additional_comments'];
	$article_disclaimer = $articleInfoObj['article_disclaimer'];
}
?>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<input type="hidden" value="<?php echo $article_id; ?>" id="article-id" />
	<section id="article-summary" class="small-12 column">
		<?php if($article_disclaimer){?>
		<div class="columns no-padding">
			<p style="font-size:10pt; font-style: italic;">*The following article does not represent the viewpoints of PuckerMob, it's management or partners, but is solely 
					the opinion of the contributor.</p>
		</div>
		<?php }?>
		
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
			<?php } ?>

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
			<div id="article-image" class="small-12 columns half-padding-right-on-lg">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo $config['image_url'].'articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
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
			<!-- SMARTIES -->
			<?php if(!$promotedArticle){ ?>
			<div class="hide-for-print row no-padding padding-top ads" style="margin-bottom: -1.5rem;">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- PM-Mobile-320x50 -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:320px;height:50px"
			     data-ad-client="ca-pub-8978874786792646"
			     data-ad-slot="2412017386"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			</div>
			<?php }?>
		<?php }?>

		<!-- Article Content -->
		<?php if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -1rem;">'; }
			  else{ echo '<div class="row">'; }
		?> 
			<section id="article-content" class="small-12 column sidebar-box">
				<p><?php echo $article_body; ?></p>
				<!-- GOOGLE AD BOTTOM-->
				<?php if(!$detect->isMobile()){?>
				<div class="row padding-top padding-bottom">
					<section class="columns small-12 padding-bottom">
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
				<?php }?>

				<!-- IMAGE SOURCE -->
				<p><?php echo $article_img_credits; ?></p>

				<!-- NOTES -->
				<p><?php echo $article_notes; ?></p>
				
				<?php if($detect->isMobile() && !$detect->isTablet()){?>
				<div id="grad"></div>
				<p class="read-more"><a href="#" class="button">
					<i class="fa fa-caret-down caret-down-left"></i>Click To Read More<i class="fa fa-caret-down caret-down-right"></i></a>
				</p>
				<?php } ?>
			</section>
		</div>
		<?php if(!$detect->isMobile()){?>
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
		<?php }else{ 
			if(!$promotedArticle){ ?>
			<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->

			<div class="hide-for-print padding-top ads">
				<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			</div>

			

			<!-- GOOGLE AD UNIT MOBILE  -->
			<div class="hide-for-print row no-padding padding-top padding-bottom">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- PM-Mobile-300x250 Bottom -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="6385741786"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			</div>
			
		<?php }else{?>
		<div class="hide-for-print row half-padding padding-top padding-bottom">
	    	<!-- SMARTIES PROMOTION -->
	        <!--JavaScript Tag // Tag for network 5470: Sequel Media Group // Website: Pucker Mob // Page: 1 pg Aritcle // Placement: 300 ATF (3243114) // created at: Oct 14, 2014 11:09:55 AM-->
	        <script language="javascript"><!--
	        document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');
	        //-->
	        </script><noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="300" height="250"></a></noscript>
	        <!-- End of JavaScript Tag -->
	    </div>
    	<?php } ?>
	<?php } ?>
	<?php if(!$promotedArticle){ ?>
		<section class="nativo-ad">
			<div class="nativo"></div> 
		</section>
	<?php } ?>
	</section>
</article>

