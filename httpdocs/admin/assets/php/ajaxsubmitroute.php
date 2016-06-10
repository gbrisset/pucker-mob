<?php
	$admin = true;
	require_once('../../../assets/php/config.php');

	parse_str($_POST['formData'], $_POST['formData']);
		
	if($adminController->checkCSRF($_POST['formData'])){  //CSRF token check!!!
		
		switch($_POST['formId']){

			/* "My Account/Profile" Page */
			case "account-settings-form":
				echo json_encode($adminController->updateUserInfo($_POST['formData']));
				break;

			case "account-password-form":
				echo json_encode($adminController->updateUserPassword($_POST['formData']));
				break;

			case "paypal-form":
				echo json_encode( $adminController->editBillingInformation($_POST['formData']));
				break;

			/* Contributor" Page */
			case "contributor-info-form":
				echo json_encode($mpArticleAdmin->updateContributorInfo($_POST['formData']));
				break;

			case "contributor-add-form":
				echo json_encode($mpArticleAdmin->addContributor($_POST['formData']));
				break;

			case "contributor-delete-form":
				echo json_encode($mpArticleAdmin->deleteContributorInfo($_POST['formData']));
				break;

			/*  Article*/
			case "article-add-form":
				echo json_encode($adminController->addArticle($_POST['formData']));
				break;

			case "article-review-form":
					echo json_encode($adminController->updateArticleStatus($_POST['formData']));
				break;
/*
			case "article-preview-form":
				echo json_encode($adminController->getPreviewRecipe(array(
					'articleId' => $_POST['formData']['a_i']
				)));
				break;*/

			/* "Edit Article" Page */
			case "article-info-form":
				echo json_encode($adminController->updateArticleInfo($_POST['formData']));
				break;

			case "article-delete-form": 
				echo json_encode( $adminController->deleteArticleById($_POST['formData']));	
				break;

			/*Contributor*/
			case "contributor-wide-image-upload-form":
				echo json_encode(
						$mpArticleAdmin->uploadNewImage($_FILES, array(
							'allowedExtensions' => 'png,jpg,jpeg,gif',
							'imgType' => 'contributor',
							'contributorId' => $_POST['formData']['c_i'], 
							'currentImage' => null,
							'uploadDirectory' => $config['image_upload_dir'].'articlesites/contributors_redesign/',
							'imgData' => $_POST['formData'],
							'desWidth' => 140,
							'desHeight' => 143,
							'arrayId' => 'contributor-wide-image-upload-form'

						))
					);
				break;

			case "article-tall-image-upload-form":
				if(isset($_POST['formData']['article-id'])){
					echo json_encode(
						$mpArticleAdmin->uploadNewImage($_FILES, array(
							'allowedExtensions' => 'png,jpg,jpeg,gif',
							'imgType' => 'article',
							'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
							'articleId' => $_POST['formData']['article-id'],
							'imgData' => $_POST['formData'],
							'whereClause' => 'article_id = '.$_POST['formData']['article-id'],
							'desWidth' => 784,
							'desHeight' => 431,
							'arrayId' => 'article-tall-image-upload-form'

						))
					);
				}
				break;

			//USER ACCOUNT
			/* "Delete User Account from DB" */
			case "user-account-delete-form":
				echo json_encode($mpArticleAdmin->deleteUserAccount($_POST['formData']));
				break;
			default:
				echo json_encode($adminController->helpers->returnStatus(500));
				break;
		}
	}else $adminController->redirectTo('logout/');
?>