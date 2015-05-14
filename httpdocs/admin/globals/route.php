<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	if(!$adminController->user->checkPermission('user_permission_show_global_settings')) $adminController->redirectTo('noaccess/');

	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	
	switch($uri[1]){
		case "users":
			include_once('users.php');
			break;
		case "newsite":
			include_once('newsite.php');
			break;
		default:
			$mpShared->get404();
			break;		
	}
?>