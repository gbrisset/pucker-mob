<?php
	if(isset($article) && $article != null){
		//Article PREP && COOK TIME FORMAT CONV.
		/*$time_prep_hr = 0;
		$time_cook_hr = 0;
		$time_prep_min = 0;
		$time_cook_min = 0;
		$prep_time_label = "";
		$cook_time_label = "";
		$total_time_label = "";
		$total = 0;

		$time_prep = $article['article_prep_time'];
		$time_cook = $article['article_cook_time'];

		if(!empty($time_prep) && $time_prep > 0){
			$time_prep_hr = floor($time_prep / 60);
			$time_prep_min = $time_prep % 60;
			$total += $time_prep;

			if($time_prep_hr > 0){
				$prep_time_label = $time_prep_hr.':'.$time_prep_min;
				$prep_time_prefix = "HRS MINS";
			}else{
				$prep_time_label = $time_prep_min;
				$prep_time_prefix = "MINS";
			}
		}
		if(!empty($time_cook) && $time_cook > 0){

			$time_cook_hr = floor($time_cook / 60);
			$time_cook_min = $time_cook % 60;
			$total += $time_cook;
			if($time_cook_hr > 0){
				$cook_time_label = $time_cook_hr.':'.$time_cook_min;
				$cook_time_prefix = "HRS MINS";
			}else{
				$cook_time_label = $time_cook_min;
				$cook_time_prefix = "MINS";
			}		
		}
		$total_time_prefix = "MINS";
		if($total > 0){
			$time_total_hr = floor($total / 60);
			$time_total_min = $total % 60;
			if($time_total_hr > 0){
				$total_time_label = $time_total_hr.':'.$time_total_min;
				$total_time_prefix = "HRS MINS";
			}else{
				$total_time_label = $time_total_min;
				$total_time_prefix = "MINS";
			}
		}*/
		//END Article PREP && COOK TIME FORMAT CONV.

	$tallImageUrl = $config['image_url'].'articlesites/simpledish/tall/'.$article["article_id"].'_tall.jpg?'.time();
	$pathToTallImage = $config['image_upload_dir'].'articlesites/simpledish/tall/'.$article["article_id"].'_tall.jpg';

	$preview_article = '';
	$preview_article .='<article id="main-article-cont" itemscope itemtype="http://data-vocabulary.org/Recipe">';
		$preview_article .='<h1 itemprop="name" id="'.$article['article_id'].'">'.$article['article_title'].'</h1>';

		$preview_article .='<section id="image-description">';
			
			$preview_article .='<div id="article-image" class="left">';
			$preview_article .= '<meta property="" itemprop="photo" content="'.$tallImageUrl.'" />';
			if(file_exists($pathToTallImage)){
				$preview_article .='<img class="preview" src="'.$tallImageUrl.'" alt="'.$article['article_title'].' Post Image" />';
			} else{
				$preview_article .='<img class="preview" src="http://images.simpledish.com/articlesites/sharedimages/recipe_default_image.jpg" alt="Default Image" />';
			}
			$preview_article .='</div>';

			$preview_article .='<div class="right">';
				$preview_article .='<section id="social-buttons">';
					$preview_article .='<div class="social-button" id="facebook">';	
						$preview_article .='<a href="#">';	
							$preview_article .='<img src="'.$config['image_url'].'sharedimages/facebook-white.png" alt="Facebook Like Icon">';	
							$preview_article .='<div class="count">';
							$preview_article .='<p>0</p>';
							$preview_article .='</div>';
						$preview_article .='</a>';
					$preview_article .='</div>';
					$preview_article .='<div class="social-button" id="twitter">';	
						$preview_article .='<a href="#">';	
							$preview_article .='<img src="'.$config['image_url'].'sharedimages/twitter-white.png" alt="Twitter Tweet Icon">';	
							$preview_article .='<div class="count">';
							$preview_article .='<p>0</p>';
							$preview_article .='</div>';
						$preview_article .='</a>';
					$preview_article .='</div>';
					$preview_article .='<div class="social-button" id="pinterest">';	
						$preview_article .='<a href="#">';	
							$preview_article .='<img src="'.$config['image_url'].'sharedimages/pinterest-white.png" alt="Pinterest Pin Icon">';	
							$preview_article .='<div class="count">';
							$preview_article .='<p>0</p>';
							$preview_article .='</div>';
						$preview_article .='</a>';
					$preview_article .='</div>';
					$preview_article .='<div class="social-button" id="google-plus">';	
						$preview_article .='<a href="#">';	
							$preview_article .='<img src="'.$config['image_url'].'sharedimages/googleplus-white.png" alt="Google Plus Icon">';	
							$preview_article .='<div class="count">';
							$preview_article .='<p>0</p>';
							$preview_article .='</div>';
						$preview_article .='</a>';
					$preview_article .='</div>';
					$preview_article .='<div class="social-button" id="linked-in">';	
						$preview_article .='<a href="#">';	
							$preview_article .='<img src="'.$config['image_url'].'sharedimages/linkedin-white.png" alt="Linkedin Icon">';	
							$preview_article .='<div class="count">';
							$preview_article .='<p>0</p>';
							$preview_article .='</div>';
						$preview_article .='</a>';
					$preview_article .='</div>';
			$preview_article .='</section>';
			
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
			$preview_article .='<section class="article-description">';
					$preview_article .='<div id="preps-yields">';
						$preview_article .='<div class="timing">';
						    $preview_article .='<div class="icon ">';
						         $preview_article .='<i class="icon-time"></i>';
						    $preview_article .='</div>';
						    
					    	$preview_article .='<div class="timing-cont">';
						    	 
									if(isset($article['article_prep_time']) && strlen($article['article_prep_time'])){
										$article['article_prep_time'] = explode(" ", $article['article_prep_time'])[0];
										$preview_article .= '<span><header class="title">Prep</header><p class="value"><meta itemprop="cookTime" content="CT'.$article['article_prep_time'].'M">';
										$preview_article .= $prep_time_label;;
										$preview_article .= '<p class="minutes">'.$prep_time_prefix.'</p></span>';
									}
									if(isset($article['article_cook_time']) && strlen($article['article_cook_time']) && $time_cook > 0){
							    		$article['article_cook_time'] = explode(" ", $article['article_cook_time'])[0];
										$preview_article .='<span><header class="title">Cook</header><p class="value"><meta itemprop="prepTime" content="CT'.$article['article_cook_time'].'M">'.$cook_time_label.'</meta></p>';
										$preview_article .='<p class="minutes">'.$cook_time_prefix.'</p></span>';
									}
									$total = 0;
									if(isset($article['article_cook_time'])|| isset($article['article_prep_time'])){
										$total = $article['article_cook_time'] + $article['article_prep_time'];
							    		$preview_article .='<span><header class="title">Total</header><p class="value"><meta itemprop="totalTime" content="TT'.$total.'M">'.$total_time_label.'</meta></p><p class="minutes">'.$total_time_prefix.'</p></span>';
							    	}
						    $preview_article .='</div>';
						$preview_article .='</div>';
						$preview_article .='<div class="yield-content">';
						    $preview_article .='<div class="icon yield">';
						    	$preview_article .='<i class="icon-food"></i>';
						    $preview_article .='</div>';
						    $preview_article .='<div class="yield-cont">';
						    		//$article['article_yield'] = explode(" ", $article['article_yield'])[0];
						    		//if(isset($article['article_yield']) && strlen($article['article_yield'])){ 
									//	$preview_article .='<span><header class="title">Yield</header><p class="value"><meta itemprop="recipeYield">'.$article["article_yield"].'</meta></p><p class="minutes">servings</p></span>'; 
									//}					       
						    $preview_article .='</div>';
						$preview_article .='</div>';
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
if(isset($article["article_desc"])){
	$preview_article .='<p>';
		$preview_article .=$article["article_desc"];
	$preview_article .='</p>';
}
if(isset($article["article_ingredients"])){
	$preview_article .='<h3>Ingredients:</h3>';
	$preview_article .='<ul class="ingredients" itemprop="ingredients">';
	$preview_article .=$article["article_ingredients"];
	$preview_article .='</ul>';
}

if(isset($article["article_instructions"])){
	$preview_article .='<h3>Instructions:</h3>';
	$preview_article .='<ol itemprop="recipeInstructions">';
	$preview_article .=$article["article_instructions"];
	$preview_article .='</ol>';
}

if(isset($article["article_additional_comments"])){
	$preview_article .='<p>';
		$preview_article .=$article["article_additional_comments"];
	$preview_article .='</p>';
}
$preview_article .='</article>';
}
?>
