<section id="todays-favorites" class="sidebar-right small-12 columns translate-fix">
	<h2>Today's Favorites</h2>
	<div id="lift-ad" class="row half-margin ad-unit hide-for-print"></div>
	<div class="row half-margin">
	<?php 
		$todaysFavoritesSet = $mpArticle->getTodaysFavorites();

		$recentArticleIndex = 1;				
		foreach ($todaysFavoritesSet as $todaysFavorites){
			$hasParent = false;
			if ($todaysFavorites['parent_dir_name'] != null && $todaysFavorites['parent_dir_name'] != 'categories-root') {
				$hasParent = true;
				$linkToArticle = $config['this_url'].$todaysFavorites['parent_dir_name']."/".$todaysFavorites['cat_dir_name'];
			} else {
				$linkToArticle = $config['this_url'].$todaysFavorites['cat_dir_name'];
			}
			$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/medium/'.$todaysFavorites['article_id'].'_tall.jpg';
		?>
		<?php if($recentArticleIndex === 1 || $recentArticleIndex === 2 || $recentArticleIndex === 4 || $recentArticleIndex === 5) {$recentArticleIndex++;?>
		<div class="small-6 mobile-12 medium-4 large-6 xlarge-4 columns half-padding">
			<a class="mobile-5" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><img src="<?php echo $linkToImage; ?>" alt='<?php echo $todaysFavorites['article_title']; ?>'></a>
            <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><h5><?php echo $todaysFavorites['article_title']; ?></h5></a>
        </div>
		<?php } elseif($recentArticleIndex === 3) {$recentArticleIndex++; ?>
		<?php if (!$detect->isMobile()) { ?>
		<div class="small-6 mobile-12 medium-4 large-6 xlarge-4 columns half-padding hide-for-small hide-for-large">
			<a class="mobile-5" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><img src="<?php echo $linkToImage; ?>" alt='<?php echo $todaysFavorites['article_title']; ?>'></a>
            <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><h5><?php echo $todaysFavorites['article_title']; ?></h5></a>
        </div>
        <?php } ?>
        </div><div class="row half-padding">
		<?php } elseif($recentArticleIndex === 6) {$recentArticleIndex++; ?>
		<?php if (!$detect->isMobile()) { ?>
		<div class="small-6 mobile-12 medium-4 large-6 xlarge-4 columns half-padding hide-for-small hide-for-large">
			<a class="mobile-5" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><img src="<?php echo $linkToImage; ?>" alt='<?php echo $todaysFavorites['article_title']; ?>'></a>
            <a class="mobile-vertical-center mobile-7" href="<?php echo $linkToArticle."/".$todaysFavorites['article_seo_title']; ?>"><h5><?php echo $todaysFavorites['article_title']; ?></h5></a>
        </div>
        <?php } ?>
		<?php } ?>
		<?php /* For image effects: class="shadow contrast darken-border fade-in-out translate-fix"*/} ?>
	</div>
</section>