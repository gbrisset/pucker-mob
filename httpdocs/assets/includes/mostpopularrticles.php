<?php 

if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList( $articleInfoObj['article_id'] );

}else{
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList();
}

if(isset($_GET['error']) && $_GET['error'] == true){
	var_dump($mostReadArticlesList);
}

if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar">
		<div class="h4-container"><h4>Most Popular</h4></div>
			<?php 
				$articleNumber = 0;
				$articleTotalNumber = 0;
				foreach($mostReadArticlesList as $article){
					$articleTotalNumber++;
				}
				foreach($mostReadArticlesList as $article){
						$linkToCategory = $config['this_url'].$article['cat_dir_name'];
						$articleUrl = $linkToCategory.'/'.$article['article_seo_title'];
						$linkToContributor = $config['this_url'].'/contributors/'.$article['contributor_seo_name'];
						//$date = date("M d, Y", strtotime($article['creation_date']));
				
						$articleNumber++;
						$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a id="article-'.$articleNumber.'" class="prefetch" href="'.$articleUrl.'">';
							$mostReadArticle .= '<div class="columns todays-favorites fade-in-out">';
								$mostReadArticle .= '<div class="row imageContainer" data-equalizer="">';
									$mostReadArticle .= '<div class="small-12 columns imageCenterer" data-equalizer-watch>';
										$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/puckermob/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
								if($articleNumber === $articleTotalNumber) { $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important; border-bottom:none !important;">';}
								else{ $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important;">'; }
								//$mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important;">';
									$mostReadArticle .= '<h5 class="left small-12 padding-top">'.$mpHelpers->truncate($article['article_title'], 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						if($articleNumber == 6 ){
							echo '<script src="http://ib.3lift.com/ttj?inv_code=puckermob_main_right"></script>';
						}
					
				}
			?>

	</section>
<?php } ?>