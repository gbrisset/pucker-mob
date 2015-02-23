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

	//MANAGE FACEBOOK LOGIN / REGISTER
	if($_POST['task'] == 'register_fb'){
		echo json_encode($adminController->user->doRegistrationFromFB($_POST));
	}

	if($_POST['task'] == 'update_w9_sent'){
		echo json_encode($adminController->user->updateUserBillingW9($_POST));
	}

	if($_POST['task'] == 'get_category_images'){
		echo json_encode($mpArticleAdmin->getImagesPerCategory($_POST));
	}
?>