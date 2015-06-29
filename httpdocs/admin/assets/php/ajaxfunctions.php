<?php
	$admin = true;
	require_once('../../../assets/php/config.php');

	if(isset($_POST['formData'])) parse_str($_POST['formData'], $_POST['formData']);

	switch($_POST['task']){
		case 'update_status':
			echo json_encode($adminController->republishArticle($_POST));
		break;

		case 'update_avatar_img':
			echo json_encode($adminController->user->updateUserImage($_POST));
		break;

		case 'register_fb':
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
		break;

		case 'update_w9_sent':
			echo json_encode($adminController->user->updateUserBillingW9($_POST));
		break;

		case 'get_category_images':
			echo json_encode($mpArticleAdmin->getImagesPerCategory($_POST));
		break;

		case 'unfollow-author':
			$author_id = $_POST['author_id'];
			$reader_email = $_POST['reader_email'];
			echo json_encode($follow->unfollowAuthor($author_id, $reader_email));
		break;

		case 'article_ads':
			echo json_encode($mpArticleAdmin->getArticleAds($_POST));
		break;

		case 'pay_contributors':
			echo json_encode($adminController->user->setContributorEarningsPaid($_POST));
		break;

		case 'update_cont_level':
			echo json_encode($mpArticleAdmin->upgradeContributorPlan($_POST));
		break;

		case 'get_chart_data':
			echo json_encode($adminController->user->getContributorEarningChartData( $_POST ));

		break;

		default:
			echo json_encode(array_merge($mpArticleAdmin->returnStatus(500), ['hasError' => true]));
		break;
	}
?>