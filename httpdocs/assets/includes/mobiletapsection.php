<?php 
	//MOST POPULAR
	$mostReadArticlesList = $mpArticle->getMostRecentArticleListMobile();
	//BLOGS
	$article_id = isset($articleInfoObj['article_id']) ? $articleInfoObj['article_id'] : false;
	$moblog_articles = $mpArticle->getMoBlogsArticles( $article_id );
?>
<div class="small-12" id="slide-menu-left-div">
	<nav class="menu slide-menu-left small-12" id="tap-section" >
		<div class="content-wrapper columns small-12 padding-top">
			<ul id="menu-options">
				<li><a id="mostpopular" class="current">Most Popular</a></li>
				<li><a id="blogs">Blogs</a></li>
			</ul>
		<div class="columns small-12 no-padding padding-top tap-articles " data-info="mostpopular">
				<?php 
				$index = 0;
				foreach( $mostReadArticlesList as $article ){
					$linkToArticle = $config['this_url'].$article['url'];
				?>
				<article id="article-<?php echo $article['article_id']; ?>" class="columns">
					<div class="article-image small-6 left">
						<a href="<?php echo $linkToArticle; ?>">
							<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['title']; ?>" />
						</a>
					</div>
					<div class="article-title small-6 left">
						<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['title'])), 55); ?></a></h1>
					</div>
				</article>
				<?php $index ++;
			}?>
		</div>
		<div class="columns small-12 no-padding padding-top tap-articles hide" data-info="blogs">
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
			</div>
		</div>
	</nav>
 	<button class="nav-toggler toggle-slide-left rotate ">MORE</button>
</div>