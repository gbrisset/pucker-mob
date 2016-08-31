<?php
	$admin = true;
	require_once('../../../assets/php/config.php');
	if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
	
		switch($_GET['imageType']){
			case 'articlepreview':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'currentImage' => $_GET['currentImage'],
					'updatingDatabase' => true,
					'table' => 'article_images',
					'column' => 'article_preview_img',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/preview/',
					'whereClause' => 'article_id = '.$_GET['articleId'],
					'successMessage' => 'Article preview image updated successfully!'
				)));
				break;

				case 'articlewide':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'updatingDatabase' => false,
					'placement' => '_wide',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/',
					'whereClause' => 'article_id = '.$_GET['articleId'],
					'articleId' => $_GET['articleId'],
					'successMessage' => 'Image updated successfully!',
					'resizeImage' => true
				)));
				break;
			
			/*case 'articletall':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'updatingDatabase' => false,
					'placement' => '_tall',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/',
					'whereClause' => 'article_id = '.$_GET['articleId'],
					'articleId' => $_GET['articleId'],
					'successMessage' => 'Article tall image updated successfully!',
					'resizeImage' => true,
					'newImageHeight' => '415',
					'newImageWidth' => '405'
				)));
				break;
			*/

			default:
				echo json_encode(array_merge($mpArticleAdmin->returnStatus(500), ['hasError' => true]));
				break; 
		}
	}else $adminController->redirectTo('logout/');
?>