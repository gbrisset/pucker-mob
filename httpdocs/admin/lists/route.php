<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();

	if ($local_platform == "WAMP64"){
		$uri = $adminController->helpers->getURI($_SERVER["REQUEST_URI"]);// local - WAMP
	}else{
		 $uri = $adminController->helpers->getURI($mpHelpers->curPageURL()); // Live  - ORIGINAL CODE
	}//end if
	
	switch($uri[1]){
		case "edit":
			if(isset($uri[2]) && strlen($uri[2])) include_once('editlist.php');
			//else $mpShared->get404();
			break;
		case "new":
			include_once('newlist.php');
			break;
		default:
			$mpShared->get404();
			break;	
	}
?>