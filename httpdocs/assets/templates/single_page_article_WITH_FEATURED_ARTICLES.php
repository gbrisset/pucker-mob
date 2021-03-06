
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

			<!-- SOCIAL MEDIA CONTENT ========================================================================================================== -->
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

			<!-- IMAGE ========================================================================================================== -->
			<div class="clear margin-bottom">
				<div id="article-image">

					 <?php



			     
					 switch ($article_id) {


						case 29816: //	how-to-heal-your-broken-heart-based-on-your-zodiac	
						
					 	
							include($config['include_path'] . 'ads/tout_glade_ad_video.php');
							break;
						
					 	default:
							echo $smf_adManager->display_tags("mbl_image", $article_id, $article_title);//passing title is optional, only needed for img ad slots
							
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
		</div>

		<!-- DISCLAIMER ========================================================================================================== -->
		<?php if($article_disclaimer){?>
		<div class="columns no-padding padding-top disclaimer">
			<p>
				*The following article does not represent the viewpoints of PuckerMob, it's management or 
				partners, but is solely the opinion of the contributor.
			</p>
		</div>
		<?php }?>

		<!-- ARTICLE CONTENT ========================================================================================================== -->
		<div class="row clear" style="margin-top: -1rem;">
			<section id="article-content" class="small-12 column sidebar-box" style="padding-bottom:0.5rem !important; margin-bottom: -5px;"> 

				<!-- AD BELOW IMAGE ========================================================================================================== -->
<!-- 
				<div id="mobile-instream-branovate-ad" style=" /*text-align: center; margin-bottom: 10px; margin-top: 5px;*/ /*style turned off when no ads is used */ ">
					<div id="get-content" style="text-align:center;width: 100%; display: inline-block;">
						<?php

							// echo $smf_adManager->display_tags("mbl_below_image", $article_id);

					     

						 ?>
					</div>
				</div> -->


				<!-- ARTICLE BODY ========================================================================================================== -->
				<div id="article-body">
					<?php echo $article_body; ?>
				</div>

				<!-- IMAGE CREDITS ========================================================================================================== -->
				<?php if( isset($article_img_credits) && !empty($article_img_credits)){?>
					<p class="padding-bottom image-source" style="font-size: 8pt !important; margin-bottom: 0rem !important; padding-bottom: 0;">
						Photo courtesy of  <a target="_blank" href="<?php echo $article_img_credits_url;?>" > <?php echo $article_img_credits; ?></a>
					</p>
				<?php }?>



		<!-- END OF ARTICLE AD ========================================================================================================== -->

		<?php


				echo $smf_adManager->display_tags("mbl_eoa", $article_id);

					 // Some ads need that wrapper to display properly
					  	// echo "<div id=\"mobile-instream-branovate-ad\" style=\"text-align: center; clear: both; padding-top: 1rem;\">";
					 	// include($config['include_path'] . 'ads/amazon_4.php');//this unit was originally in the more bar - 2017-04-04
					 	// echo "</div>";
		 ?>




				<!-- RELATED ARTICLES ========================================================================================================== -->
				<?php 

			// $ddd = new debug($related_articles,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

				if(isset($related_articles) && array_sum ($related_articles)>-3){ 
					if ( $related_articles['related_article_id_1'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_1'] );
					if ( $related_articles['related_article_id_2'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_2'] );
					if ( $related_articles['related_article_id_3'] > -1) $related_articles_list[] = $mpArticle->getRelatedToArticleInfo( $related_articles['related_article_id_3'] );
					
				?>
					<div class="row small-12 clear related-articles-box half-padding margin-top columns" style="margin-top:20px !important; margin-bottom: -10px !important;">
						
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
				<?php }// end if(isset($related_articles) ... ?>


	
				
					</div>
				</div>
		</div>


		<!-- READ MORE ========================================================================================================== -->

				<?php switch ($article_id) {
						//Loreal test - DELETE AFTER AUGUST 31 2017
						case 5338: // why-wearing-makeup-isnt-false-advertising
						case 7378: // 20-things-only-girls-who-love-makeup-understand
						case 17219: // loving-someone-you-cant-love
						case 27296: // http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself
						// Do Nothing
						break;
						
					 	default:
				?>						

					 
					 <!-- 		
					 		<div class=" read-more  small-12 columns margin-bottom" style="background: white; width: 100%;">
								<div class="button" style="width: 83%; padding: 4px; border: 1px solid #72a367; background: #497240; /*#78AD6C - original color*/ ">
									<label id="read-more-img" style=" color: #fff; font-family: oslobold; font-size: 18.5px;">TAP TO READ FULL ARTICLE</label>
								</div>
							</div>  -->

					
				<?php }//end switch ($article_id) ?>

		
		<!-- ADS STACK ========================================================================================================== -->
		<div class="row" style="clear: both; padding-top: 0; border: 1px solid #ddd;"></div>

				<?php

			  	echo $smf_adManager->display_tags("mbl_ad_stack_1", $article_id);
			  	echo $smf_adManager->display_tags("mbl_ad_stack_2", $article_id);
			  	echo $smf_adManager->display_tags("mbl_ad_stack_3", $article_id);


				?>

		
			<!-- COMMENTS BOX ========================================================================================================== -->
			
			<?php include_once($config['include_path'].'disqus.php'); ?>
	
		</div>
	
	</section>

<!-- FEATURED ARTICLES ========================================================================================================== -->
	<section id="article-summary" class="small-12 column">

		<h3 style="margin-bottom: 0.5rem !important;  font-size: 22.4px; font-family: OswaldLight; font-weight: bold;   color: green;">FEATURED ARTICLES</h3>
		<div class="content-wrapper columns no-padding small-12">
		<?php 

		$featured_articles = $mpArticle->getFeaturedArticles();
			// $ddd = new debug($featured_articles,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

				if($featured_articles){
				
					// foreach($featured_articles as $farticle){
					 for($xx=0; $xx<3; $xx++){
					 $farticle = $featured_articles[$xx];
						$farticle_title = $farticle['article_title'];
						$farticle_seo_title = $farticle['article_seo_title'];
						$farticle_id = $farticle['article_id'];
						$farticle_desc = $farticle['article_desc'];
						$farticle_category = $farticle['cat_dir_name'];
						$farticle_link = $config['this_url'].$farticle_category.'/'.$farticle_seo_title;

					?>
					<div class="columns small-12 padding-top featured-wrapper-div">
					
					<div id="article-featured-<?php echo $farticle_id; ?>" class="columns small-12 no-padding remove-border">
						<div id="article-summary" class="small-12 column ">
							
							<!-- TITLE -->
							<h1 style="font-size: 1.55rem;"><?php echo $farticle_title; ?></h1>
							
							<div class="small-12 padding-bottom">
								<?php if(!empty($farticle_desc) ){?><p class="description" style="margin-bottom:0;"><?php echo $farticle_desc; ?></p><?php }?>
							</div>

							<!-- Article Image -->
							<div class="clear margin-bottom" style="background: black;     margin-bottom: 5px !important;">
								<div id="article-image " class=" no-padding tinted-image " style="opacity: 0.5;">
									<a href="<?php echo $farticle_link; ?>">
										<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$farticle_id.'_tall.jpg'; ?>" alt="<?php echo $farticle_title; ?> Image">
									</a>
								</div>
								<span class="span-middle-label-img"><a href="<?php echo $farticle_link; ?>">Click to read full article</a></span>

							</div>
							
						</div>
						
					</div>

					</div>

						<?php if($xx == 0){

		 			  	echo $smf_adManager->display_tags("mbl_featured", $article_id);

				  

						 } // end if($xx == 0) ?>



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
			
								<div id="get-content" style="text-align:center; width: 100%; display: inline-block;">
						<?php

							echo $smf_adManager->display_tags("dsk_below_image", $article_id);

					     

						 ?>
					</div>
				<!-- ARTICLE BODY -->
				<div id="article-body">
					<p><?php echo $article_body; ?></p>
				</div>
			
				<?php 

		 			  	echo $smf_adManager->display_tags("dsk_ad_stack_1", $article_id);
		 			  	echo $smf_adManager->display_tags("dsk_ad_stack_2", $article_id);
		 			  	echo $smf_adManager->display_tags("dsk_ad_stack_3", $article_id);
		 			  	echo $smf_adManager->display_tags("dsk_ad_stack_4", $article_id);

				      
 ?>
				
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