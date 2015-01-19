<?php
	$admin = true;
	require_once('../../../assets/php/config.php');

	parse_str($_POST['formData'], $_POST['formData']);

	if($_POST['task'] == 'update_status'){
		echo json_encode($adminController->republishArticle($_POST));
	}

	if($_POST['task'] == 'update_avatar_img'){
	
		echo json_encode($adminController->user->updateUserImage($_POST));
	}

?>