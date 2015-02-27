<?php

	require_once('../php/config.php');

	$data = [];
	if(isset($_POST) && count($_POST) > 0 ) $data = $_POST;
	elseif(isset($_GET) && count($_GET) > 0 ) $data = $_GET; 



	switch($data['task']){
		case 'login-reader': 
			$reader_email = $data['user_login_input']; 
			$author_id = $data['author_id'];			
			$login = $adminController->user->handleLogin($data);
			if(!$login['hasError']){
				echo json_encode($adminController->user->followAnAuthor($reader_email, $author_id));
			}else{
				echo json_encode($login);
			}
		break;

		case 'register-reader':
			$reader_email = $data['user_email']; 
			$author_id = $data['author_id'];	
			$register = $adminController->user->doRegistration($data);
			if(!$register['hasError']){
				echo json_encode($adminController->user->followAnAuthor($reader_email, $author_id));
			}else{
				echo json_encode($register);
			}
		break;

		default:
		break;
	}
?>