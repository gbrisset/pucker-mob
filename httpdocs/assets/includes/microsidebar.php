<?php if(isset($relatedArticles) && $relatedArticles){ ?>
<aside id="micro-sidebar" class="columns small-12 hide-for-print sidebar-right">
	<h5>You Might Also Like</h5>
		<?php
			$relatedArticleIndex = -6;
			foreach($relatedArticles['articles'] as $article){$relatedArticleIndex++; if($relatedArticleIndex > 0 && $relatedArticleIndex < 6) { ?>
			<div id="microw-<?php echo $relatedArticleIndex; ?>" class="row">
			<hr>
			<div class="small-4 columns no-padding">
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/microsidebar/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>'" /></a>
			</div>
			<div class="small-8 columns no-padding vertical-center">
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><h5><?php echo $mpHelpers->truncate($article['article_title'], 50); ?></h5></a>
			</div>
			</div>
			<?php } elseif($relatedArticleIndex > 5) { ?>
			<div id="microw-<?php echo $relatedArticleIndex; ?>" class="row fadein" style="display: none;">
			<hr>
			<div class="small-4 columns no-padding">
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/microsidebar/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>'" /></a>
			</div>
			<div class="small-8 columns no-padding vertical-center">
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><h5><?php echo $mpHelpers->truncate($article['article_title'], 50); ?></h5></a>
			</div>
			</div>
			<?php }}?>
</aside>
<?php } ?>