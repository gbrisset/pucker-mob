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
		} else {
			include_once('category.php');
		}
	} else {
		include_once('category.php');
	}

?>