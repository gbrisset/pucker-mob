<?php if(isset($relatedArticles) && $relatedArticles){ ?>
	<section id="related-articles">
		<header>
			<h2>Related Articles</h2>
		</header>

		<section id="related-articles-cont">
			<?php
				$realtedArticleIndex = 1;
				foreach($relatedArticles['articles'] as $article){
					$relatedArticle = '<article id="related-article-'.$realtedArticleIndex++.'">';
						$relatedArticle .= '<div class="article-image">';
							$relatedArticle .= '<a href="'.$config['this_url'].$article['category_page_directory'].'/'.$article['article_seo_title'].'">';
								$relatedArticle .= '<img src="'.$config['image_url'].'articlesites/puckermob/preview/'.$article['article_preview_img'].'" alt="'.$article['article_title'].' Preview Image" />';
							$relatedArticle .= '</a>';
						$relatedArticle .= '</div>';

						$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
						
						$relatedArticle .= '<div class="article-info" data-title="'.htmlspecialchars($article['article_title']).'" data-desc="'.htmlspecialchars(trim(strip_tags($articleDesc))).'">';
							$relatedArticle .= '<h2><a href="'.$config['this_url'].$article['category_page_directory'].'/'.$article['article_seo_title'].'">'.$mpHelpers->truncate($article['article_title'], 23).'</a></h2>';
							
							$relatedArticle .= '<p>'.$mpHelpers->truncate(trim(strip_tags($articleDesc)), 100).'</p>';
						$relatedArticle .= '</div>';
					$relatedArticle .= '</article>';
					echo $relatedArticle;
				}
			?>
		</section>
	</section>
<?php } ?>