<?php 
	
	$date = date("M d, Y", strtotime($featuredArticle['creation_date']));

	$linkToArticle = $config['this_url'].$featuredArticle['cat_dir_name'].'/'.$featuredArticle["article_seo_title"];
	$linkToACategory = $config['this_url'].$featuredArticle['cat_dir_name'];
	$linkToImage = $config['image_url'].'articlesites/puckermob/large/'.$featuredArticle['article_id'].'_tall.jpg';
	$linkToContributor = $config['this_url'].'contributors/'.$featuredArticle['contributor_seo_name'];

	if ( $detect->isMobile() ) { ?>

	<div class="columns mobile-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
				<a class="mobile-12 no-padding" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt='<?php echo $featuredArticle['article_title']?>'>
				</a>
				<div class="mobile-12 no-padding-mobile">
					<p class="mobile-12 no-padding uppercase" >
						<span class="span-category <?php echo $featuredArticle['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php echo $featuredArticle['cat_name']?></a></span>
					</p>
					<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
						<h1 class="no-margin-mobile"><?php echo $featuredArticle['article_title']?></h1>
					</a>
				</div>
			</div>

<?php } else {?>
<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding" id="article-featured-1">
	<a class="mobile-12 small-12 medium-12 large-12 xlarge-12" href="<?php echo $linkToArticle; ?>">
		<img src="<?php echo $linkToImage; ?>" alt='<?php echo $featuredArticle['article_title']?>'>
	</a>
	<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 mobile-vertical-center padding-top">
		<p class="left uppercase" >
			<span class="span-category <?php echo $featuredArticle['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php echo $featuredArticle['cat_name']?></a></span>
			<span class="span-date"><?php echo $date; ?></span>
		</p>
		<p class="right uppercase">
			<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $featuredArticle['contributor_name']; ?></a></span>
		</p>
		<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
			<h1 class="h1-large-article"><?php echo $featuredArticle['article_title']?></h1>
		</a>
	</div>
</div>

<?php } ?>
<hr class="padding-top">