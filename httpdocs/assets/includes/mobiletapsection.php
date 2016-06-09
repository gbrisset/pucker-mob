<?php 
	//MOST POPULAR
	$mostReadArticlesList = $mpArticle->getMostRecentArticleListMobile();

	//BLOGS
	$article_id = isset($articleInfoObj['article_id']) ? $articleInfoObj['article_id'] : false;
	//$moblog_articles = $mpArticle->getMoBlogsArticles( $article_id );
?>
<style>
	nav.menu{ background: #D44545; }
	nav.slide-menu-left:after{background: #D44545;}

</style>
<div class="small-12" id="slide-menu-left-div">
	<nav class="menu slide-menu-left small-12" id="tap-section" >
		<div class="content-wrapper columns small-12 padding-top">
			<ul id="menu-options">
				<li><a id="mostpopular" class="current">Latest Articles</a></li>
				<!--<li><a id="blogs">Blogs</a></li>-->
			</ul>
		<div class="columns small-12 no-padding padding-top tap-articles " data-info="mostpopular">
				<?php 
				$index = 0;
				foreach( $mostReadArticlesList as $article ){
					$linkToArticle = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
				?>
				<?php if($index == 2){?>
					<article class="columns" style="border:none; text-align:center;">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- PuckerMob mobile 320x50 Featured -->
							<ins class="adsbygoogle"
							     style="display:inline-block;width:320px;height:50px"
							     data-ad-client="ca-pub-8978874786792646"
							     data-ad-slot="1411038589"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</article>
					<?php }?>
				<article id="article-<?php echo $article['article_id']; ?>" class="columns">
					
					<div class="article-image small-6 left">
						<a href="<?php echo $linkToArticle; ?>">
							<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" />
						</a>
					</div>
					<div class="article-title small-6 left">
						<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 55); ?></a></h1>
					</div>
				</article>
				<?php $index ++;
			}?>
		</div>
		<!--<div class="columns small-12 no-padding padding-top tap-articles hide" data-info="blogs">
				<?php  
				$index = 0;
				foreach( $moblog_articles as $article ){
					$linkToArticle = $config['this_url'].'moblog/'.$article["article_seo_title"];
					?>
					<article id="article-<?php echo $article['article_id']; ?>" class="columns">
						<div class="article-image small-6 left">
							<a href="<?php echo $linkToArticle; ?>">
								<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" />
							</a>
						</div>
						<div class="article-title small-6 left">
							<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 55); ?></a></h1>
						</div>
					</article>
					<?php 	$index ++; 
				}?>
			</div>-->
		</div>
	</nav>
 	<button class="nav-toggler toggle-slide-left rotate " style="background: #D44545;">MORE</button>
</div>