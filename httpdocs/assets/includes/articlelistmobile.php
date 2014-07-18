
<div class = "row half-padding">
	<?php 

	$articleIndex = 0;
	$quantity = 24;
	$omitThis = 0;
	$cat_id = $mpArticle->data['cat_id'];
	$featuredArticle = $mpArticle->getFeaturedArticle( $cat_id );
	if( $featuredArticle ){
		$articleIndex++;
		$quantity = 25;
		$omitThis =  $featuredArticle['article_id'];
		include_once($config['include_path'].'featured_article.php');
	}

	// If is HomePage Get new article List
	if( $cat_id == 1){
		$articlesList = $mpArticle->getArticles(['count' => $quantity, 'omit' => [ $omitThis ]]);
	}
	

	foreach ($articlesList['articles'] as $articles){

		$linkToArticle = $config['this_url'].$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
		$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
		$date = date("M d, Y", strtotime($articles['creation_date']));
		$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$articles['article_id'].'_tall.jpg';
		$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];

		//if($articleIndex == 0 || ($articleIndex % 6 == 0) ) { 
			$articleIndex++;
		?>
			<div class="columns mobile-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
				<a class="mobile-12 no-padding" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
				</a>
				<div class="mobile-12 no-padding-mobile">
					<p class="mobile-12 no-padding uppercase" >
						<span class="span-category <?php echo $articles['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php echo $articles['cat_name']?></a></span>
					</p>
					<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
						<h1 class="no-margin-mobile"><?php echo $articles['article_title']?></h1>
					</a>
				</div>
			</div>
			<hr>

			<?php // } else{ 	$articleIndex++; ?>

			<!--<div class="small-4 mobile-12 medium-3 large-4 xlarge-3 columns no-padding" id="<?php echo 'article-'.$articleIndex;?>">
				<a class="mobile-6" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
				</a>
				<div class="mobile-vertical-center-6  mobile-6">
					<p class="uppercase" style="margin-bottom: 0.3rem;">
						<span class="span-category <?php echo $articles['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php echo $articles['cat_name']?></a></span>
					</p>
					<a href="<?php echo $linkToArticle; ?>">
						<h1 class="h1-small-article"><?php echo $articles['article_title']?></h1>
					</a>
				</div>
			</div>
			<hr>-->
			<?php //} 
		}?>
		</div>