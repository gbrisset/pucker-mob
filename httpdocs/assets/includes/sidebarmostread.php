<?php if(isset($mostReadArticles) && $mostReadArticles){ ?>
	<section id="sidebar-most-viewed" data-set="most-viewed-append-around">
		<section class="sidebar-articles" id="most-viewed-articles-cont">
			<header>
				<h2>Most Viewed</h2>
			</header>

			<section id="articles-cont">
				<?php 
					foreach($mostReadArticles['articles'] as $article){
			$hasParent = false;
			if ($article['parent_category_id'] != null) {
				$hasParent = true;
				$parentCategorySet = $MPNavigation->getCategoryById($article['parent_category_id']);
				$linkToArticle = $config['this_url'].$parentCategorySet['parent_dir_name']."/".$article['cat_dir_name'];
			} else {
				$linkToArticle = $config['this_url'].$article['cat_dir_name'];			
			}
						$mostReadArticle = '<article>';
							$mostReadArticle .= '<div class="article-image">';
								$mostReadArticle .= '<a href="'.$linkToArticle."/".$article['article_seo_title'].'">';
									$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/preview/'.$article['article_preview_img'].'" alt="'.$article['article_title'].' Preview Image" />';
								$mostReadArticle .= '</a>';
							$mostReadArticle .= '</div>';
							$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
							$articleAuthor = (isset($article['contributor_name']) && strlen($article['contributor_name'])) ? $article['contributor_name'] : 'test';

							$mostReadArticle .= '<div class="article-info" data-title="'.htmlspecialchars($article['article_title']).'" data-desc="'.htmlspecialchars(trim(strip_tags($articleAuthor))).'">';
								$mostReadArticle .= '<h2><a href="'.$linkToArticle."/".$article['article_seo_title'].'">'.$mpHelpers->truncate($article['article_title'], 80).'</a></h2>';
								
								$mostReadArticle .= '<p>'.$mpHelpers->truncate(trim(strip_tags($articleAuthor)), 100).'</p>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</article>';
						echo $mostReadArticle;
					}
				?>
			</section>
		</section>
	</section>
<?php } ?>