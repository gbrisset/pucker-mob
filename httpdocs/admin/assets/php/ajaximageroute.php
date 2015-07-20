<?php
	$admin = true;
	require_once('../../../assets/php/config.php');
	if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
	
		switch($_GET['imageType']){
			/*case 'headerlogo':
				$_GET['imgType'] = 'headerlogo';
				$_GET['currentImage'] = $mpArticle->data['article_page_logo'];
				echo json_encode($mpArticleAdmin->uploadSiteImage($_FILES, $_GET));
				$mpArticle->reloadSiteData();
				break;
			case 'footerlogo':
				$_GET['imgType'] = 'footerlogo';
				$_GET['currentImage'] = $mpArticle->data['article_page_footer_logo'];
				echo json_encode($mpArticleAdmin->uploadSiteImage($_FILES, $_GET));
				$mpArticle->reloadSiteData();
				break;
			case 'playerlogo':
				$_GET['imgType'] = 'playerlogo';
				$_GET['currentImage'] = $mpArticle->data['article_page_player_logo'];
				echo json_encode($mpArticleAdmin->uploadSiteImage($_FILES, $_GET));
				$mpArticle->reloadSiteData();
				break;
			case 'featured':
				$_GET['imgType'] = 'featured';
				$_GET['currentImage'] = $mpArticle->data['featured_img'];
				echo json_encode($mpArticleAdmin->uploadSiteImage($_FILES, $_GET));
				$mpArticle->reloadSiteData();
				break;*/
				//case 'contributorwide':
			/*case 'contributortall': case 'contributorwide': case 'contributorfeatured':
				//echo json_encode($mpArticleAdmin->uploadContributorImage($_FILES, $_GET));
				echo json_encode($mpArticleAdmin->uploadNewImage($_FILES, $_POST));
				break;*/
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


//	LIST ITEM IMAGES
			case 'pageListItem':
				$page_list_item = new PageListItem;
				echo json_encode($page_list_item->update_image_record($_FILES, $_GET['pageListItemId']));
				break;
/*
			case 'sponsoredBy':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'currentImage' => $_GET['currentImage'],
					'updatingDatabase' => true,
					'table' => 'article_page_ads',
					'column' => 'sponsored_by_img',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/',
					'whereClause' => 'article_page_id = '.$_GET['articlePageId'],
					'successMessage' => 'The Sponsor Logo image updated successfully!'
				)));
				break;
			case 'sponsoredSuperBanner':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'currentImage' => $_GET['currentImage'],
					'updatingDatabase' => true,
					'table' => 'article_page_ads',
					'column' => 'sponsored_super_banner',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/campaign/',
					'whereClause' => 'article_page_id = '.$_GET['articlePageId'],
					'successMessage' => 'The Super Banner image updated successfully!'
				)));
				break;*/

			//WIDE: 370 × 275
			//TALL: 405 × 415
			//PREV: 250 × 225
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
			case 'secondArticleImage':
				//echo json_encode($mpArticleAdmin->uploadNewImage($_FILES, $_POST));

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

			case 'videowide':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'updatingDatabase' => false,
					'placement' => '-video-wide',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/',
					'whereClause' => 'video_id = '.$_GET['videoId'],
					'articleId' => $_GET['videoId'],
					'successMessage' => 'Video image updated successfully!'
				)));
				break;

			case 'serieswide':
				echo json_encode($adminController->updateImageRecord($_FILES, array(
					'currentImage' => $_GET['currentImage'],
					'updatingDatabase' => true,
					'table' => 'article_page_series',
					'column' => 'article_page_series_image',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/',
					'whereClause' => 'article_page_series_id = '.$_GET['seriesId'],
					'successMessage' => 'Series image updated successfully!'
				)));
				break;*/

			default:
				echo json_encode(array_merge($mpArticleAdmin->returnStatus(500), ['hasError' => true]));
				break; 
		}
	}else $adminController->redirectTo('logout/');
?>