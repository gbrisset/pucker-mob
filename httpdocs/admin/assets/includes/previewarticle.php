	<?php
		foreach($allStatuses as $statusInfo){ 
			$preview_article = '';
			$preview_article .='<article id="main-article-cont" itemscope itemtype="http://data-vocabulary.org/Recipe">';
				$preview_article .='<h1 itemprop="name" id="'.$article['article_id'].'">'.$article['article_title'].'</h1>';

				$preview_article .='<section id="image-description">';
					$preview_article .='<div id="article-image" class="left">';
						$preview_article .= '<meta property="" itemprop="photo" content="'.$tallImageUrl.'" />';
						$preview_article .='<img class="preview" src="'.$tallImageUrl.'" alt="'.$article['article_title'].' Post Image" />';
						if(count($articleImages) > 1){
							$preview_article .='<div id="numb-images">';
								$preview_article .='<p class="total-slides">0 Photos</p>';
							$preview_article .='</div>';
						}
					$preview_article .='</div>';

					$preview_article .='<div class="right">';
						$preview_article .='<section id="social-buttons">';
						if($mpArticle->data['articles_have_facebook']){
							$preview_article .='<div class="social-button" id="facebook">';	
								$preview_article .='<a href="#">';	
									$preview_article .='<img src="'.$config['image_url'].'sharedimages/facebook-white.png" alt="Facebook Like Icon">';	
									$preview_article .='<div class="count">';
									$preview_article .='<p>51</p>';
									$preview_article .='</div>';
								$preview_article .='</a>';
							$preview_article .='</div>';
						}
						if($mpArticle->data['articles_have_twitter']){
							$preview_article .='<div class="social-button" id="twitter">';	
								$preview_article .='<a href="#">';	
									$preview_article .='<img src="'.$config['image_url'].'sharedimages/twitter-white.png" alt="Twitter Tweet Icon">';	
									$preview_article .='<div class="count">';
									$preview_article .='<p>45</p>';
									$preview_article .='</div>';
								$preview_article .='</a>';
							$preview_article .='</div>';
						}
						if($mpArticle->data['articles_have_pinterest']){
							$preview_article .='<div class="social-button" id="pinterest">';	
								$preview_article .='<a href="#">';	
									$preview_article .='<img src="'.$config['image_url'].'sharedimages/pinterest-white.png" alt="Pinterest Pin Icon">';	
									$preview_article .='<div class="count">';
									$preview_article .='<p>12</p>';
									$preview_article .='</div>';
								$preview_article .='</a>';
							$preview_article .='</div>';
						}
						if($mpArticle->data['articles_have_googleplus']){
							$preview_article .='<div class="social-button" id="google-plus">';	
								$preview_article .='<a href="#">';	
									$preview_article .='<img src="'.$config['image_url'].'sharedimages/googleplus-white.png" alt="Google Plus Icon">';	
									$preview_article .='<div class="count">';
									$preview_article .='<p>7</p>';
									$preview_article .='</div>';
								$preview_article .='</a>';
							$preview_article .='</div>';
						}
						if($mpArticle->data['articles_have_linkedin']){
							$preview_article .='<div class="social-button" id="linked-in">';	
								$preview_article .='<a href="#">';	
									$preview_article .='<img src="'.$config['image_url'].'sharedimages/linkedin-white.png" alt="Linkedin Icon">';	
									$preview_article .='<div class="count">';
									$preview_article .='<p>7</p>';
									$preview_article .='</div>';
								$preview_article .='</a>';
							$preview_article .='</div>';
						}
				$preview_article .='</section>';
//Rating
				$preview_article .='<section id="article-rating" class="">';
					$preview_article .='<div class="rating" id="article-rating">';
						$preview_article .='<div class="star-cont">';
								$preview_article .='<i id="1" class="icon-star full"></i>';
								$preview_article .='<i id="2" class="icon-star full"></i>';
								$preview_article .='<i id="3" class="icon-star full"></i>';
								$preview_article .='<i id="4" class="icon-star empty"></i>';
								$preview_article .='<i id="5" class="icon-star empty"></i>';
								$preview_article .='<label class="label">Like this article? Rate it!</label>';
						$preview_article .='</div>';
					$preview_article .='</div>';
				$preview_article .='</section>';

// Descriptions
				$preview_article .='<section class="article-description">';
					$preview_article .='<div id="short-description">';
						$preview_article .='<p>'.$article['article_desc'].'</p>';
					$preview_article .='</div>';
				$preview_article .='</section>';

//right side links
				$preview_article .='<section id="shared-icons">';
					$preview_article .='<ul>';
						$preview_article .='<li>';
							$preview_article .='<div id="article-email">';
								$preview_article .='<div class="email-recipe-link">';
									$preview_article .='<a href=""> ';
										$preview_article .='<i class="icon-envelope-alt"></i>';
										$preview_article .='Email';
									$preview_article .='</a>';
								$preview_article .='</div>';
							$preview_article .='</div>';
						$preview_article .='</li>';
						$preview_article .='<li class="divider-vertical"></li>';
						$preview_article .='<li>';
							$preview_article .='<div id="article-ziplist">';
								$preview_article .='<div class="zl-recipe-link">';
									$preview_article .='<a href="javascript:void(0);" >'; 
										$preview_article .='<i class="icon-folder-open-alt"></i>';
										$preview_article .='Save to recipe box';
									$preview_article .='</a>';
								$preview_article .='</div>';
							$preview_article .='</div>';
						$preview_article .='</li>';
						$preview_article .='<li class="divider-vertical"></li>';
						$preview_article .='<li>';
							$preview_article .='<div id="article-print">';
								$preview_article .='<div class="print-recipe-link">';
									$preview_article .='<a href="javascript:window.print();">';
										$preview_article .='<i class="icon-print"></i>';
										$preview_article .='Print';
									$preview_article .='</a>';
								$preview_article .='</div>';
							$preview_article .='</div>';
						$preview_article .='</li>';
				$preview_article .='</section>';

			$preview_article .='</div>';	
			$preview_article .='';	
			$preview_article .='';	
			$preview_article .='';	

		$preview_article .='</section>';
							
		$preview_article .='<section id="article-body">';
			$preview_article .=$article['article_body'];
		$preview_article .='</section>';

	$preview_article .='</article>';

}
?>