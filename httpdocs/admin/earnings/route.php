<?php
	$admin = true;
	require_once('../../assets/php/config.php');

	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());

	switch($uri[0]){
		case "earnings":
			if(isset($uri[1]) && strlen($uri[1])) include_once('earningsinfo.php');
			else $mpShared->get404();
			break;
		default:
			$mpShared->get404();
			break;		
	}
?>