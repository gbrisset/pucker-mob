<?php if(isset($recentArticles) && $recentArticles){ ?>
<section id="favorites-cat-dishes" class="favorites-dishes-videos">
	<!--<h1><?php //echo $categoryInfo['category_favorite_articles_title']; ?></h1>-->
	<!--<div id="sort-by">
		<a href="" id="staff-picks">Staff Picks</a>
		<a href="" id="popular">Popularity</a>
		<a href="" id="newest">Newest</a>
		<a href="" id="title">Title</a>
	</div>-->

	<section class="top-articles" id="list-results-articles-cont">
		<?php
			$recentArticleIndex = 1;
			foreach ($recentArticles['articles'] as $article) {
					if ($hasParent){
						$linkToArticle = $config['this_url'].$parentCategorySEOName.'/'.$category['cat_dir_name'].'/'.$article['article_seo_title'];
					} else {
						$linkToArticle = $config['this_url'].$category['cat_dir_name'].'/'.$article['article_seo_title'];
					}

				$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];

			?>
			<article class="list-articles" id="recent-article-<?php echo $recentArticleIndex++; ?>">
				<div class="article-image">
					<a href="<?php echo $linkToArticle; ?>">
						<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title'].' Preview Image'; ?>" />
						<span id="video-icon-span" class="<?php if(isset($article["syn_video_id"]) && $article["syn_video_id"] ) echo 'has-video'; ?>">
							<img src="<?php echo $config['image_url']; ?>sharedimages/simple_dish_play_button.png" alt="Video Image"/>
						</span>
					</a>
				</div>
							
				<div class="article-info" data-title="<?php echo htmlspecialchars($article['article_title']); ?>" data-desc="<?php echo htmlspecialchars(trim(strip_tags($articleDesc))); ?>">
					<label>
					<h2>
						<a href="<?php echo $linkToArticle; ?>">
						<?php echo $mpHelpers->truncate(trim($article['article_title']), 30); ?>
						</a>
					</h2>
					<p><?php echo $mpHelpers->truncate(trim(strip_tags($articleDesc)), 150); ?></p>
					<div class="article-rating-save">
						<div id="rating" class="rating">
							<div class="star-cont">
								<?php 
									$rating = $mpHelpers->roundToNearestHalf($article['rating']);
									$fulls = floor($rating);
									$half = ($rating - $fulls > 0) ? true : false;
									for($i = 0; $i < 5; $i++){?>
										<i class="<?php if($i < $fulls) echo 'icon-star full'; elseif(isset($half) && $half == true && $i == $fulls) echo 'icon-star-half-empty'; else echo 'icon-star empty'; ?>"></i>
								<?php } ?>
							</div>
						</div>
						<div class="save-article" id="article-ziplist">
							<div class='zl-recipe-link'>
								<a href='javascript:void(0);' onmouseup='getZRecipe(this, "<?php echo $mpArticle->data['article_page_assets_directory'];?>", ""); return false;'> 
								<i class="icon-folder-open-alt"></i>
								Save to recipe box
								</a>
							</div>
						</div>
					</div>
				</label>
				</div>
			</article>
			<?php if($recentArticleIndex == 2){?>
			<!-- 3Lift Tag -->
				<script src="http://ib.3lift.com/ttj?inv_code=simpledish_subpage"></script>
			<!-- END 3Lift Tag -->
			<?php }?>
		<?php }?>
	</section>
</section>
<?php } ?>