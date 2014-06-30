<?php 

if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList( $articleInfoObj['article_id'] );

}else{
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList();
}
//$image = '<img src="http://localhost:8888/puckermob/subdomains/images/httpdocs/articlesites/puckermob/large/3860_tall.jpg">';
if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar">
		<h4>Popular Articles</h4>
			<?php 
				$articleNumber = 1;
				$articleTotalNumber = 0;
				foreach($mostReadArticlesList as $article){
					$articleTotalNumber++;
				}
				foreach($mostReadArticlesList as $article){
					if($articleNumber === $articleTotalNumber) {
						$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a href="'.$articleUrl.'"><div class="columns todays-favorites fade-in-out" id="last-trending-now"><div class="row" data-equalizer=""><div class="small-7 columns half-padding-right" data-equalizer-watch>';
						$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
							
						$mostReadArticle .= '</div><div class="small-5 columns half-padding-left vertical-center" data-equalizer-watch>';
						$mostReadArticle .= '<h5>'.$mpHelpers->truncate($article['article_title'], 80).'</h5></div></div></div></a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;
					} elseif($articleNumber === 1){
						$articleNumber++;
						$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a class="prefetch" href="'.$articleUrl.'"><div id="popular-articles-top" class="columns todays-favorites fade-in-out"><div class="row" data-equalizer=""><div class="small-7 columns half-padding-right" data-equalizer-watch>';
						$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
							
						$mostReadArticle .= '</div><div class="small-5 columns half-padding-left vertical-center" data-equalizer-watch>';
						$mostReadArticle .= '<h5>'.$mpHelpers->truncate($article['article_title'], 80).'</h5></div></div></div></a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;
					} elseif ($articleNumber === 2) {
						$articleNumber++;
						$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a class="prefetch" href="'.$articleUrl.'"><div class="columns todays-favorites fade-in-out"><div class="row" data-equalizer=""><div class="small-7 columns half-padding-right" data-equalizer-watch>';
						$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
							
						$mostReadArticle .= '</div><div class="small-5 columns half-padding-left vertical-center" data-equalizer-watch>';
						$mostReadArticle .= '<h5>'.$mpHelpers->truncate($article['article_title'], 80).'</h5></div></div></div></a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;
					} else {
						$articleNumber++;
						$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a href="'.$articleUrl.'"><div class="columns todays-favorites fade-in-out"><div class="row" data-equalizer=""><div class="small-7 columns half-padding-right" data-equalizer-watch>';
						$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
							
						$mostReadArticle .= '</div><div class="small-5 columns half-padding-left vertical-center" data-equalizer-watch>';
						$mostReadArticle .= '<h5>'.$mpHelpers->truncate($article['article_title'], 80).'</h5></div></div></div></a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;
					}
				}
			?>
	</section>
<?php } ?>