<?php 
$recentArticles = $mpArticle->getArticlesByParams(['articleCount' => 6, 'omit' => $omits, 'pageId' => 115]);
if(isset($recentArticles) && $recentArticles){?>
<section id="top-food-articles" class="sidebar-right small-12 columns translate-fix padding-top">
	<hr>
    <h2>Top Food Articles<i class="fa fa-angle-double-right"></i><a href="http://www.simpledish.com/articles"><small>SEE ALL</small></a></h2>
    <div class="row half-padding">
		<?php
			$recentArticleIndex = 1;
			foreach ($recentArticles['articles'] as $article) {

				$linkToArticle = $config['this_url'].'articles'."/".$article['article_seo_title'];

				$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
		?>
		<?php if($recentArticleIndex === 1 || $recentArticleIndex === 2) {$recentArticleIndex++; ?>
		   	<div class="mobile-12 small-6 medium-4 large-6 xlarge-4 columns half-padding">
              <a class="mobile-5" href="<?php echo $linkToArticle; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/medium/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>"></a>
              <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle; ?>"><h5><?php echo $article['article_title']; ?></h5></a>
            </div>
		<?php } elseif($recentArticleIndex === 3) {$recentArticleIndex++; ?>
		<?php if (!$detect->isMobile()) { ?>
           	<div class="mobile-12 small-6 medium-4 large-6 xlarge-4 columns half-padding hide-for-small hide-for-large">
              <a class="mobile-5" href="<?php echo $linkToArticle; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/medium/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>"></a>
              <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle; ?>"><h5><?php echo $article['article_title']; ?></h5></a>
            </div>
            </div>
            <div class="row half-padding">
        <?php } ?>
		<?php } elseif($recentArticleIndex === 4 || $recentArticleIndex === 5) {$recentArticleIndex++; ?>
			<div class="mobile-12 small-6 medium-4 large-6 xlarge-4 columns half-padding">
              <a class="mobile-5" href="<?php echo $linkToArticle; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/medium/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>"></a>
              <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle; ?>"><h5><?php echo $article['article_title']; ?></h5></a>
            </div>
		<?php } elseif($recentArticleIndex === 6) {$recentArticleIndex++; ?>
		<?php if (!$detect->isMobile()) { ?>
			<div class="mobile-12 small-6 medium-4 large-6 xlarge-4 columns half-padding hide-for-small hide-for-large">
              <a class="mobile-5" href="<?php echo $linkToArticle; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/medium/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>"></a>
              <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle; ?>"><h5><?php echo $article['article_title']; ?></h5></a>
            </div>
        <?php } ?>
		<?php }?>
		<?php }?>
		</div>
</section>
<?php }?>