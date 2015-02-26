<?php

	require_once('../php/config.php');

	$data = [];
	if(isset($_POST) && count($_POST) > 0 ) $data = $_POST;
	elseif(isset($_GET) && count($_GET) > 0 ) $data = $_GET; 

	switch($data['task']){
		case 'login-reader': 
			$login = $adminController->user->handleLogin($data);
			if(!$login['hasError']){
				echo json_encode($adminController->user->followAnAuthor($data));
			}else{
				echo json_encode($login);
			}
		break;

		case 'register-reader':
		
			$register = $adminController->user->doRegistration($data);
			if(!$register['hasError']){
				echo json_encode($adminController->user->followAnAuthor($data));
			}else{
				echo json_encode($login);
			}
		break;

		default:
		break;
	}
?>