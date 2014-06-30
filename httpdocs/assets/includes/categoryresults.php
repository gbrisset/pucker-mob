<?php  if(isset($recentArticles) && $recentArticles){ 

	$articleIndex = 1;
	foreach ($recentArticles['articles'] as $article) {
		if ($hasParent){
			$linkToArticle = $config['this_url'].$parentCategorySEOName.'/'.$category['cat_dir_name'].'/'.$article['article_seo_title'];
		} else {
			$linkToArticle = $config['this_url'].$category['cat_dir_name'].'/'.$article['article_seo_title'];
		}

		$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
		$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['article_id'].'_tall.jpg';
		$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['article_id'].'_tall.jpg';
		$date = date("M d, Y", strtotime($article['creation_date']));
		$linkToContributor = $config['this_url'].'contributors/'.$article['contributor_seo_name'];
		?>
		<article class="row" id="<?php echo 'article-'.$articleIndex;?>">

			<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12">
				<?php if ( $detect->isMobile() ) {  $articleIndex++;?>
				<a class="mobile-5 small-5 medium-5 large-5 xlarge-5 half-padding-right left" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt=''>
				</a>
				<div class="mobile-7 small-7 medium-7 large-7 xlarge-7 half-padding-left mobile-vertical-center vertical-align-center">
					<p class="vertical-center">
						<span class="span-category"><?php echo $article['cat_name']?></span>
						<small><?php echo $date; ?></small>
					</p>
					<a href="<?php echo $linkToArticle; ?>">
						<h5><?php echo $article['article_title']?></h5>
					</a>
					<p><small>By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></small></p>
				</div>
				<?php }else{?>
				<?php if($articleIndex === 1 ) {$articleIndex++; ?>
				<a class="mobile-5 small-5 medium-5 large-12 xlarge-12" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt=''>
				</a>
				<div class="mobile-7 small-7 medium-7 large-12 xlarge-12 mobile-vertical-center padding-top">
					<p class="left uppercase">
						<span class="span-category"><?php echo $article['cat_name']?></span>
						<span class="span-date"><?php echo $date; ?></span>
					</p>
					<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></span></p>
					<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
						<h1 class="h1-large-article"><?php echo $article['article_title']?></h1>
					</a>

				</div>
				<?php }else{ $articleIndex++; ?>
				<a class="mobile-5 small-5 medium-5 large-6 xlarge-6 half-padding-right left" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt=''>
				</a>
				<div class="mobile-7 small-7 medium-7 large-6 xlarge-6 mobile-vertical-center vertical-align-center half-padding-left half-padding-right">
					<p class="uppercase">
						<span class="span-category"><?php echo $article['cat_name']?></span>
						<span class="span-date"><?php echo $date; ?></span>
					</p>
					<a href="<?php echo $linkToArticle; ?>">
						<h1><?php echo $article['article_title']?></h1>
					</a>
					<p class="uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></span></p>
				</div>
				<?php } }?>
			</div>
		</div>
	</article>
	<hr />
	<?php }?>

	<?php } ?>
