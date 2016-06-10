<?php 
	//MOST POPULAR
	$mostReadArticlesList = $mpArticle->getMostRecentArticleListMobile();
	$article_id = isset($articleInfoObj['article_id']) ? $articleInfoObj['article_id'] : false;

	$featured_articles = $mpArticle->getFeaturedArticles();
	//var_dump(count($featured_articles), $featured_articles); 

?>
<style>
	nav.menu{ background: #78ad6c; }
	nav.slide-menu-left:after{background: #78ad6c;}

</style>
<div class="small-12" id="slide-menu-left-div">
	<nav class="menu slide-menu-left small-12" id="tap-section" >
		<h2 class="uppercase featured-title">Featured Article</h2>
		<div class="content-wrapper columns no-padding small-12">
		<?php //var_dump($featured_articles);
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
					<div class="columns small-12 padding-top featured-wrapper-div">
					
					<div id="article-featured-<?php echo $article_id; ?>" class="columns small-12 no-padding remove-border">
						<div id="article-summary" class="small-12 column ">
							
							<!-- TITLE -->
							<h1><?php echo $article_title; ?></h1>
							
							<div class="small-12">
								<?php if(!empty($article_desc) ){?><p class="description" style="margin-bottom:0;"><?php echo $article_desc; ?></p><?php }?>
								<p class="author">by <a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>"><?php echo $name; ?></a></p>
							</div>

							<!-- Article Image -->
							<div class="clear margin-bottom" style="background: black;     margin-bottom: 5px !important;">
								<div id="article-image " class=" no-padding tinted-image " style="opacity: 0.5;">
									<a href="<?php echo $link_article; ?>">
										<img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
									</a>
								</div>
								<span class="span-middle-label-img"><a href="<?php echo $link_article; ?>">Click to read full article</a></span>

							</div>
							
						</div>
						<div class="columns ad-unit hide-for-print padding-top no-padding" style="margin-bottom: 10px !important;">
								<?php if($index == 1){?>
								<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- PuckerMob mobile 300x250 Featured 1 -->
								<ins class="adsbygoogle"
								     style="display:inline-block;width:300px;height:250px"
								     data-ad-client="ca-pub-8978874786792646"
								     data-ad-slot="1688410185"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
								<?php } ?>

								<?php if($index == 2){?>
									<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
									<!-- PuckerMob 300x250 Featured Tab 2 -->
									<ins class="adsbygoogle"
									     style="display:inline-block;width:300px;height:250px"
									     data-ad-client="ca-pub-8978874786792646"
									     data-ad-slot="3165143381"></ins>
									<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
									</script>
								<?php } ?>

								<?php if($index == 3){?>
									<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
									<!-- PuckerMob 300x250 Featured Tab 3 -->
									<ins class="adsbygoogle"
									     style="display:inline-block;width:300px;height:250px"
									     data-ad-client="ca-pub-8978874786792646"
									     data-ad-slot="6118609785"></ins>
									<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
									</script>
								<?php } ?>
							</div>
					</div>
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