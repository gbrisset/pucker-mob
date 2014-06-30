<?php if(isset($featuredContributor) && $featuredContributor){ ?>
	<section class="featured-section" id="featured-contributor">
		<header>
			<h2>Featured Contributor</h2>

			<div id="right">
				<p><a href="<?php echo $config['this_url'].'contributors/'; ?>">View All</a></p>
			</div>
		</header>

		<section>
			<?php $featuredContributorObj = $featuredContributor['contributors'][0]; ?>
			<div class="featured-image">
				<a href="<?php echo $config['this_url'].'contributors/'.$featuredContributorObj['contributor_seo_name']; ?>">
					<img src="<?php echo $config['image_url'].'articlesites/contributors/'.$featuredContributorObj['contributor_featured_img'];?>" alt="<?php echo $featuredContributorObj['contributor_name']; ?> Featured Image" />
				</a>	
			</div>

			<div class="featured-info" data-name="<?php echo htmlspecialchars($featuredContributorObj['contributor_name']); ?>" data-bio="<?php echo htmlspecialchars(trim(strip_tags($featuredContributorObj['contributor_bio']))); ?>">
				<h2>
					<a href="<?php echo $config['this_url'].'contributors/'.$featuredContributorObj['contributor_seo_name']; ?>"><?php echo $featuredContributorObj['contributor_name']; ?></a>
				</h2>

				<p class="contributor-bio"><?php echo $mpHelpers->truncate(trim(strip_tags($featuredContributorObj['contributor_bio'])), 300); ?></p>

				

				<?php if(isset($featuredContributor['articles']) && is_array($featuredContributor['articles'])){ ?>
				<div id="recent-articles">
					<?php
						foreach($featuredContributor['articles']['articles'] as $article){
							if($local) $articleUrl = $config['this_url'];
							else $articleUrl = $article['article_page_full_url'];
							$articleUrl .= $article['category_page_directory'].'/'.$article['article_seo_title'];

							$featuredContributorArticle = '<div class="contributor-article-single">';
								$featuredContributorArticle .= '<h2><a href="'.$articleUrl.'">'.$mpHelpers->truncate($article['article_title'], 40).'</a></h2>';
								
								$featuredContributorArticle .= '<div class="rating" id="article1-rating">';
									$featuredContributorArticle .= '<div class="star-cont">';
										$rating = $mpHelpers->roundToNearestHalf($article['rating']);
										$fulls = floor($rating);
										$half = ($rating - $fulls > 0) ? true : false;
										for($i = 0; $i < 5; $i++){
											$featuredContributorArticle .= '<span class="';
											if($i < $fulls) $featuredContributorArticle .= 'full';
											elseif(isset($half) && $half == true && $i == $fulls) $featuredContributorArticle .= 'half';
											else $featuredContributorArticle .= 'hidden';
											$featuredContributorArticle .= '">☆</span>';
										}
									$featuredContributorArticle .= '</div>';
								$featuredContributorArticle .= '</div>';
							$featuredContributorArticle .= '</div>';
							echo $featuredContributorArticle;
						}
					?>

					<p class="contributor-articles"><a href="<?php echo $config['this_url'].'contributors/'.$featuredContributorObj['contributor_seo_name']; ?>">See all of <?php echo explode(' ', $featuredContributorObj['contributor_name'])[0]; ?>'s Articles!</a></p>
				</div>	
				<?php } ?>
			</div>
		</section>
	</section>
<?php } ?>