<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	
	switch($uri[1]){
		case "edit":
			if(isset($uri[2]) && strlen($uri[2])) include_once('editarticle.php');
			else $mpShared->get404();
			break;
		case "newarticle":
			include_once('newarticle.php');
			break;
		default:
			$mpShared->get404();
			break;	
	}
?>