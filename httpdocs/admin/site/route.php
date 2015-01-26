<?php
	$admin = true;
	require_once('../../assets/php/config.php');

	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	
	switch($uri[1]){
		case "search":
			include_once('search.php');
			break;
		case "social":
			include_once('social.php');
			break;
		case "ads":
			include_once('ads.php');
			break;
		case "styling":
			include_once('styling.php');
			break;
		case "player":
			include_once('player.php');
			break;
		default:
			$mpShared->get404();
			break;		
	}
?>