<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	
	switch($uri[1]){
		case "promote":
			if(isset($uri[2]) && strlen($uri[2])) include_once('promote/index.php');
			else $mpShared->get404();
			break;

		case "admatching":
			if(isset($uri[2]) && strlen($uri[2])) include_once('admatching/index.php');
			else $mpShared->get404();
			break;
			
		default:
			$mpShared->get404();
			break;	
	}
?>