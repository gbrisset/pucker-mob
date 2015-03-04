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
		if( isset($_POST['isReader']) ){
			$reader_email = $_POST['user']['email']; 
			$author_id = $_POST['author_id'];	
			$result = $adminController->user->doRegistrationFromFB($_POST);
			
			if(!$result['hasError']){
				echo json_encode($adminController->user->followAnAuthor($reader_email, $author_id));
			}else{
				echo json_encode($result);
			}
		}else{
			echo json_encode($adminController->user->doRegistrationFromFB($_POST));
		}
	}

	if($_POST['task'] == 'update_w9_sent'){
		echo json_encode($adminController->user->updateUserBillingW9($_POST));
	}

	if($_POST['task'] == 'get_category_images'){
		echo json_encode($mpArticleAdmin->getImagesPerCategory($_POST));
	}

	if($_POST['task'] == 'unfollow-author'){
		$author_id = $_POST['author_id'];
		$reader_email = $_POST['reader_email'];
		echo json_encode($follow->unfollowAuthor($author_id, $reader_email));
	}
?>