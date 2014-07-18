<?php if(isset($featuredArticle) && $featuredArticle){ ?>
	<section  id="featured-article" data-set="featured-article-append-around">
		<section class="featured-section" id="featured-article-cont">
			<header>
				<h2><?php echo $mpArticle->data['article_page_featured_article_text']; ?></h2>
			</header>
			<article class="featured-article-section">
				<?php
					$featuredArticleObj = $featuredArticle['articles'][0];
					$featuredArticleDesc = $featuredArticleObj['article_desc']; 
					if ($featuredArticleObj['parent_dir_name'] != $featuredArticleObj['cat_dir_name']){ 
						$link = $config['this_url'].$featuredArticleObj['parent_dir_name'].'/'.$featuredArticleObj['cat_dir_name'].'/'.$featuredArticleObj['article_seo_title'];
					} else {
						$link = $config['this_url'].$featuredArticleObj['cat_dir_name'].'/'.$featuredArticleObj['article_seo_title'];
					}

				?>

				<div class="featured-image">
					<a href="<?php echo $link; ?>">
						<img src="<?php echo $config['image_url'].'articlesites/'.'simpledish'.'/tall/'.$featuredArticleObj['article_id'].'_tall.jpg'; ?>" alt="<?php echo $featuredArticleObj['article_title']; ?> Preview Image" />
					</a>	
				</div>
				<div class="featured-info">
					<h2>
						<a href="<?php echo $link; ?>"><?php echo $featuredArticleObj['article_title'];?></a>
						<label class="get-recipe"><a href="<?php echo $link; ?>">Get Recipe</a></label>
					</h2>
				</div>

			</article>
		</section>
	</section>
<?php } ?>