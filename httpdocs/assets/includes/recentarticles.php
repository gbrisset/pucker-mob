<?php if(isset($recentArticles) && $recentArticles){ ?>
	<section id="recent-articles">
		<header>
			<h2>Recent Articles</h2>
		</header>

		<section id="recent-articles-cont">
			<?php
				$recentArticleIndex = 1;
				foreach ($recentArticles['articles'] as $article) {
					if ($hasParent){
						$linkToArticle = $config['this_url'].$parentCategorySEOName.'/'.$article['category_page_directory'].'/'.$article['article_seo_title'];
					} else {
						$linkToArticle = $config['this_url'].$article['category_page_directory'].'/'.$article['article_seo_title'];
					}
					
					$recentArticle = '<article class="recent-article" id="recent-article-'.$recentArticleIndex++.'">';
						$recentArticle .= '<div class="article-image">';
							$recentArticle .= '<a href="'.$linkToArticle.'">';
								$recentArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/preview/'.$article['article_preview_img'].'" alt="'.$article['article_title'].' Preview Image" />';
							$recentArticle .= '</a>';
						$recentArticle .= '</div>';

						$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
						
						$recentArticle .= '<div class="article-info" data-title="'.htmlspecialchars($article['article_title']).'" data-desc="'.htmlspecialchars(trim(strip_tags($articleDesc))).'">';
							$recentArticle .= '<h2><a href="'.$linkToArticle.'">'.$mpHelpers->truncate(trim($article['article_title']), 30).'</a></h2>';
							
							$recentArticle .= '<p>'.$mpHelpers->truncate(trim(strip_tags($articleDesc)), 100).'</p>';
						$recentArticle .= '</div>';
						
						$recentArticle .= '<div class="rating" id="rating">';
							$recentArticle .= '<div class="label">Average Rating: </div>';
							
							$recentArticle .= '<div class="star-cont">';
								$rating = $mpHelpers->roundToNearestHalf($article['rating']);
								$fulls = floor($rating);
								$half = ($rating - $fulls > 0) ? true : false;
								for($i = 0; $i < 5; $i++){
									$recentArticle .= '<span class="';
									if($i < $fulls) $recentArticle .= 'full';
									elseif(isset($half) && $half == true && $i == $fulls) $recentArticle .= 'half';
									else $recentArticle .= 'hidden';
									$recentArticle .= '">☆</span>';
								}
							$recentArticle .= '</div>';
						$recentArticle .= '</div>';
					$recentArticle .= '</article>';
					echo $recentArticle;
				}
			?>
		</section>
	</section>
<?php } ?>
