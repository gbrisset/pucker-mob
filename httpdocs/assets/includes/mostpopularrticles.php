<?php 
$label = "MORE ARTICLES";
$new_layout = true;
if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMoBlogsArticles( $articleInfoObj['article_id'] );
}else{
	$mostReadArticlesList = $mpArticle->getMoBlogsArticles( );
} 

if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar  margin-bottom">
		<div class="h4-container"><h4><?php echo $label; ?></h4></div>
			<?php 
				$articleNumber = 0;
				$articleTotalNumber = 0;
				foreach($mostReadArticlesList as $article){
					$articleTotalNumber++;
				}
				foreach($mostReadArticlesList as $article){

						if($new_layout){
							$articleUrl = 'http://www.puckermob.com/moblog/'.$article['article_seo_title'];
							$article_title = $article['article_title'];
						}else{
							$articleUrl = 'http://www.puckermob.com'.$article['url'];
							$article_title = $article['title'];
						}

						$articleNumber++;
						$mostReadArticle = '';
						$mostReadArticle .= '<a id="article-'.$articleNumber.'" class="prefetch" href="'.$articleUrl.'">';
							$mostReadArticle .= '<div class="columns todays-favorites fade-in-out">';
								$mostReadArticle .= '<div class="small-5 columns imageContainer" >';
									$mostReadArticle .= '<div class="small-12 columns imageCenterer" >';
										$mostReadArticle .= '<img src="http://cdn.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg" alt="'.$article_title.'" />';

									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
					
								$mostReadArticle .= '<div class="small-7 columns article-information valign-middle" data-equalizer-watch style="padding:0 !important;">'; 
									$mostReadArticle .= '<h5 class="columns padding-top">'.$mpHelpers->truncate($article_title, 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						?>
						
						<?php 	
				}
			?>

	</section>
<?php } ?>