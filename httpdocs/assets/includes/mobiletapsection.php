<?php 
	//MOST POPULAR
	$article_id = isset($articleInfoObj['article_id']) ? $articleInfoObj['article_id'] : false;
	$featured_articles = $mpArticle->getFeaturedArticles();

?>
<style>
	nav.menu{ background: #78ad6c; }
	nav.slide-menu-left:after{background: #78ad6c;}

</style>
<div class="small-12" id="slide-menu-left-div">
	<nav class="menu slide-menu-left small-12" id="tap-section" >
		<h2 class="uppercase featured-title">Featured Articles</h2>
		<div class="content-wrapper columns small-12" style="padding: 10px;">
		<?php 
				if($featured_articles){
					$index = 0;
					foreach($featured_articles as $farticle){
						$article_title = $farticle['article_title'];
						$article_seo_title = $farticle['article_seo_title'];
						$article_id = $farticle['article_id'];
						$article_desc = $farticle['article_desc'];
						$name = $farticle['contributor_name'];
						$seo_name = $farticle['contributor_seo_name'];
						$category = $farticle['cat_dir_name'];
						$link_article = $config['this_url'].$category.'/'.$article_seo_title;
						$index++;

					?>
					<div class="columns small-12 second-popular-articles-cont article-id" style="margin: 0 !important;">
						<div id="article-featured-<?php echo $article_id; ?>" class="columns small-12 no-padding">
							<div id="article-summary" class="small-12 column ">
								<!-- Article Image -->
								<div class="clear">
									<div id="article-image " class=" no-padding  ">
										<a href="<?php echo $link_article; ?>">
											<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
										</a>
									</div>
								</div>
								<!-- TITLE -->
								<div class="small-12 columns second-popular-article-title">
								<h2 class="left small-12 padding-top"><a href="<?php echo $link_article; ?>"><?php echo $article_title; ?></a></h2>
								</div>
							</div>
						</div>
					</div>
					<div class="columns ad-unit hide-for-print padding-top" style="margin-bottom: 3px !important;       padding-top: 5px !important;">
							<?php if($index == 1){?>
								<!--<iframe style="width:300px;height:250px;overflow:hidden;display: inline-block;" src="//www.toksnn.com/ads/pkm_ent1_mob_us?pub=sqmpkmusmi" frameborder="0" scrolling="no"></iframe>-->
							<?php } ?>

							<?php if($index == 3){?>
								<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<ins class="adsbygoogle"
								     style="display:inline-block;width:300px;height:250px"
								     data-ad-client="ca-pub-8978874786792646"
								     data-ad-slot="3165143381"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>-->
							<?php } ?>

					</div>
				
					<?php }
				}else{
					echo '<p>No Featured article available.</p>';
				}
			?>
		
		</div>
	</nav>
 	<button class="nav-toggler toggle-slide-left rotate " style="background: #78ad6c;">MORE</button>
</div>