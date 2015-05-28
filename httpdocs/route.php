<?php
	require_once('assets/php/config.php');
	require_once('assets/php/newsletter.php');

	$uri = $uriHelper->getURI($mpHelpers->curPageURL()); 
	$mainCategoryArray = $uriHelper::getMainCategoryArray($MPNavigation->mainCategories);	
	if(isset($uri[2]) && strlen($uri[2]) > 0){
		include_once('article.php');
	} else if ( isset($uri[1]) && strlen($uri[1]) > 0 ){
		if (in_array($uri[0], $mainCategoryArray)) {
			include_once('article.php');
		}else if($uri['0'] == 'videos'){
			include_once('videos.php');
		}
		else {
			include_once('category.php');
		}
	} elseif($uri['0'] == 'most-recent' || $uri['0'] == 'most-popular' || $uri['0'] == 'trending'){
			include_once('articleresults.php');
		}else {
		include_once('category.php');
	}

?>