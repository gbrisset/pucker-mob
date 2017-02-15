<?php
	require_once('assets/php/config.php');
	//require_once('assets/php/newsletter.php');

	if ($local_platform == "WAMP64"){
		$uri = $uriHelper->getURI($_SERVER["REQUEST_URI"]); // local - WAMP
	}else{
		 $uri = $uriHelper->getURI($mpHelpers->curPageURL());  // Live  - ORIGINAL CODE
	}//end if

	

	$mainCategoryArray = $uriHelper::getMainCategoryArray($MPNavigation->mainCategories);	
	if(isset($uri[2]) && strlen($uri[2]) > 0){
		include_once('article.php');
	} elseif ( isset($uri[1]) && strlen($uri[1]) > 0 ){
		if (in_array($uri[0], $mainCategoryArray)) {
			include_once('article.php');
		}else {
			include_once('category.php');
		}
	} elseif( $uri['0'] == 'moblog' || $uri['0'] == 'most-recent' || $uri['0'] == 'most-popular' || $uri['0'] == 'trending'){
			include_once('articleresults.php');
		}else {
		include_once('category.php');
	}

?>