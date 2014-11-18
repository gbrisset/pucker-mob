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
		<!-- DISCLAIMER -->
		<?php if($article_disclaimer){?>
		<div class="columns no-padding">
			<p style="font-size:10pt; font-style: italic;">
				*The following article does not represent the viewpoints of PuckerMob, it's management or 
				partners, but is solely the opinion of the contributor.
			</p>
		</div>
		<?php }?>
		
		<!-- TITLE -->
		<h1 style="margin-bottom: 0.5rem;"><?php echo $article_title; ?></h1>
		
		<!-- SOCIAL DESKTOP -->
		<?php //if(!$detect->isMobile()){?>
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0.5rem; display:block !important;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
				
				<a class="facebook_like">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookLikeIconCircle.png'; ?>" alt="Facebook Like" />
				</a> 

				
				<a class="addthis_button_facebook_like show-for-large-up  hide-for-medium hide-for-large hide-for-xlarge-down" fb:like:send="true"></a>
			
				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		<?php //} ?>

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
		
		<!-- Intro Copy SubTitle -->
		<section class="row">
			<h2></h2>
		</section>
		
		<!-- GOOGLE AD UNIT MOBILE  
		<?php //if ( $detect->isMobile() ) {?>
			 SMARTIES 
			<?php //if(!$promotedArticle){ ?>
			<div class="hide-for-print row no-padding padding-top ads" style="margin-bottom: -1.5rem; text-align:center;">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			 PM-Mobile-320x50
			<ins class="adsbygoogle"
			     style="display:inline-block;width:320px;height:50px"
			     data-ad-client="ca-pub-8978874786792646"
			     data-ad-slot="2412017386"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			</div>
			<?php //}?>
		<?php //}?>
		-->

		<!-- Article Content -->
		<?php if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -1rem;">'; }
			  else{ echo '<div class="row">'; }
		?> 
			<section id="article-content" class="small-12 column sidebar-box">
				<p><?php echo $article_body; ?></p>

				<!-- IMAGE SOURCE -->
				<p><?php echo $article_img_credits; ?></p>

				<!-- NOTES -->
				<p><?php echo $article_notes; ?></p>

				<!-- ON DESKTOP --> 
				<?php if(!$detect->isMobile()){?>
				<?php if(!$promotedArticle ){?>
			     	<!-- Puckermob Instory Connatix -->
			     	<style>#connatix{ padding:0 !important;} #connatix #article-summary{ border-bottom: 0 !important;}</style>
					<script type='text/javascript' src='//cdn.connatix.com/min/connatix.renderer.infeed.min.js' data-connatix-token='1f15e94f-843f-4d31-8940-4eb181b32d73'></script>
				<?php } ?>

				<!-- GOOGLE AD BOTTOM-->
				<div class="row padding-top padding-bottom clear">
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
		<?php if(!$detect->isMobile()){?>
		<div class="row social-media-container padding-bottom">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookLikeIconCircle.png'; ?>" alt="Comments" />
				</a> 
				
				<a class="addthis_button_compact"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding show-on-medium-up" style="text-align: right;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		<br>
		<?php } ?>

		<?php }else{ 
			if(!$promotedArticle){ ?>
			<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->

			<div class="hide-for-print padding-top ads">
				<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			</div>

			<!-- GOOGLE AD UNIT MOBILE  -->
			<div class="hide-for-print row no-padding padding-top padding-bottom" style="text-align:center;">
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

