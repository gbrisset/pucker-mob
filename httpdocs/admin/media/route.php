<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());

	switch($uri[1]){
		case "edit":
			if(isset($uri[2]) && strlen($uri[2])) include_once('editvideo.php');
			else $mpShared->get404();
			break;
		case "new":
			include_once('addvideo.php');
			break;
		case "series":
			include_once('series.php');
			break;
		case "editseries":
			include_once('editseries.php');
			break;
		case "addseries":
			include_once('addseries.php');
			break;
		default:
			$mpShared->get404();
			break;	
	}
?>