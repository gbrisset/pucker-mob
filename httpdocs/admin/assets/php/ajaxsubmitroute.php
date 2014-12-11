<?php
	$admin = true;
	require_once('../../../assets/php/config.php');

	parse_str($_POST['formData'], $_POST['formData']);
		
	if($adminController->checkCSRF($_POST['formData'])){  //CSRF token check!!!
		switch($_POST['formId']){
			/* "Generic Settings" Page */
			case "general-settings-form":
				echo json_encode($adminController->updateSiteSettings($_POST['formData']));
				break;
			case "featured-contributor-form":
				echo json_encode( $adminController->updateSiteFeautedObject(array(
					'table' => 'article_page_featured_contributors',
					'column' => 'contributor_id',
					'post' => array_merge($_POST['formData'], array('contributor_id-n' => $_POST['formData']['article_page_featured_contributor'])),
					'successMessage' => 'Featured contributor updated successfully!'
				)));
				break;
			case "featured-article-form":
				echo json_encode($adminController->updateSiteFeautedObject(array(
					'table' => 'articles_featured',
					'column' => 'article_id',
					'additionalWhere' => ' AND feature_type = 2',
					'post' => array_merge($_POST['formData'], array('article_id-n' => $_POST['formData']['article_page_featured_article'])),
					'successMessage' => 'Featured article updated successfully!'
				)));
				break;
			case "sidebar-articles-form":
				echo json_encode($mpArticleAdmin->updateTodaysFavorites($_POST['formData']));
				break;

			case "ask-the-chef-form":
				echo json_encode($mpArticleAdmin->updateAskTheChef($_POST['formData']));
				break;
			
			/* "Search Settings" Page */
			case "search-engine-settings-form":
				echo json_encode($adminController->updateSiteSearch($_POST['formData']));
				break;

			/* "Player Settings" Page */
			case "player-settings-form":
				echo json_encode($adminController->updatePlayerSettings($_POST['formData']));
				break;

			/* "Social Network Settings" Page */
			case "social-network-settings-form":
				echo json_encode($adminController->updateSocialSettings($_POST['formData']));
				break;

			/* "Ad Placement Settings" Page */
			case "ad-code-settings-form":
				echo json_encode($adminController->updateAdCodes($_POST['formData']));
				break;
			case "ad-timing-settings-form":
				echo json_encode($adminController->updateAdTiming($_POST['formData']));
				break;

			case "ad-sponsor-settings-form":
				echo json_encode($mpArticleAdmin->updateSponsoredBy($_POST['formData']));
				break;				

			/* "Styling Settings" Page */
			case "styling-settings-form":
				echo json_encode($adminController->updateStylingSettings($_POST['formData']));
				break;
			case "featured-image-link-form":
				echo json_encode($adminController->updateFeautredImageLink($_POST['formData']));
				break;

			/* "My Account/Profile" Page */
			case "account-settings-form":
				echo json_encode($adminController->updateUserInfo($_POST['formData']));
				break;

			case "account-password-form":
				echo json_encode($adminController->updateUserPassword($_POST['formData']));
				break;

			case "account-bio-form":
				echo json_encode($adminController->updateBioInfo($_POST['formData']));
				break;

			/* "Edit Category" Page */
			case "category-info-form":
				echo json_encode($mpArticleAdmin->updateCategoryInfo($_POST['formData']));
				break;
			case "category-featured-article-form": //DropDown Featured Article
				echo json_encode($mpArticleAdmin->updateCategoryFeautedArticle($_POST['formData']));
				break;
			case "category-slideshow-article-form": //SlideShow Articles
				echo json_encode( $mpArticleAdmin->insertCategorySlideshowArticles($_POST['formData']));
				break;
			case "category-slideshow-delete": //Delete Article Slideshow Functionality
				echo json_encode( $mpArticleAdmin->deleteCatgorySlideshowArticles($_POST['formData']));	
				break;

			/*Edit Collection Page*/
			case "collection-info-form":
				echo json_encode($mpArticleAdmin->updateCollectionInfo($_POST['formData']));
				break;

			case "collection-add-form":
				echo json_encode($mpArticleAdmin->addCollection($_POST['formData']));
				break;

			case "collection-delete-form":{
				echo json_encode($mpArticleAdmin->deleteCollection($_POST['formData']));
				break;
			}

			/* "Edit Contributor" Page */
			case "contributor-info-form":
				echo json_encode($mpArticleAdmin->updateContributorInfo($_POST['formData']));
				break;

			/* "Add Contributor" Page */
			case "contributor-add-form":
				echo json_encode($mpArticleAdmin->addContributor($_POST['formData']));
				break;

			/* "Delete Contributor from DB" */
			case "contributor-delete-form":
				echo json_encode($mpArticleAdmin->deleteContributorInfo($_POST['formData']));
				break;

			/* Add Recipe/Article*/
			case "article-add-form":
				echo json_encode($adminController->addArticle($_POST['formData']));
				break;

			case "article-review-form":
					echo json_encode($adminController->updateArticleStatus($_POST['formData']));
				break;

			case "article-preview-form":
		
				echo json_encode($adminController->getPreviewRecipe(array(
					'articleId' => $_POST['formData']['a_i']
				)));
				break;

			/* "Edit Article" Page */
			case "article-info-form":
				echo json_encode($adminController->updateArticleInfo($_POST['formData']));
				break;

			case "article-delete-form": //Delete Article Functionality
				echo json_encode( $adminController->deleteArticleById($_POST['formData']));	
				break;

/***
		Page lists
***/
			//Update PageList
			case "page-list-data-form": 
				$page_list = new PageList;
				echo json_encode( $page_list->save($_POST['formData']));
				break;

			//Update PageListItem 
			case "page-list-item-data-form-".$_POST['formData']['page_list_item_id']: 
				$page_list_item = new PageListItem;
					//	Test if file name is set
					if( isset($_FILES['file']) && $_FILES['file']['name'] != null){
							//	Image name in DB = file name
							$_POST['formData']['page_list_item_image'] = $_FILES['file']['name'];
							echo json_encode($page_list_item->save($_POST['formData'], $_FILES));
					} else {
						//	Image name in db is set by hidden, updating field, 'existing_image', to accomodate AJAX
						$_POST['formData']['page_list_item_image'] = $_POST['formData']['existing_image'];
						echo json_encode($page_list_item->save($_POST['formData']));						
					}
				break;

			//Delete List 
			case "list-delete-form": 
				echo json_encode( PageList::delete($_POST['formData']));
				break;

			//Delete List ITEM 
			case "list-item-delete-form": 
				$page_list_item = new PageListItem;
				$page_list_item->delete_from_list($_POST['formData']);
				echo json_encode( PageListItem::delete($_POST['formData']));
				break;
/***
		End Page lists
***/

			/* Edit Video Media Page*/
			case "video-add-form":
				echo json_encode($mpArticleAdmin->addVideoMediaInfo($_POST['formData']));
				break;
			
			case "video-edit-form":
				echo json_encode($mpArticleAdmin->UpdateVideoMediaInfo($_POST['formData']));
				break;

			case "video-delete-form":
				echo json_encode($mpArticleAdmin->deleteVideoMediaInfo($_POST['formData']));
				break;

			case "video-add-edit-article":
				echo json_encode($mpArticleAdmin->updateVideoArticleInfo($_POST['formData']));
				break;

			/*"Edit/Add Series Pages"*/
			case "series-add-form":
				echo json_encode($mpArticleAdmin->addSeries($_POST['formData']));
				break;

			case "series-edit-form":
				echo json_encode($mpArticleAdmin->updateSeriesMediaInfo($_POST['formData']));
				break;

			case "series-add-edit-video":
				echo json_encode( $mpArticleAdmin->updateSeriesPlaylist($_POST['formData']));
				break;

			case "series-video-delete":
				echo json_encode( $mpArticleAdmin->deleteSeriesVideo($_POST['formData']));
				break;

			case "series-video-add-remove-slideshow":
					echo json_encode( $mpArticleAdmin->addRemoveSlideshowSeriesList($_POST['formData']));
				break;

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

			//Bug Functionalities
			case "bug-form":
				//	Depending on wether or not the id is sent in post,
				//	This will either create or update the record.
				$bug = new Bug;
				echo json_encode($bug->save($_POST['formData']));
				break; 
				
			case "bug-delete-form": //Delete Bug Functionality
				$bug = new Bug;
				echo json_encode( $bug->delete($_POST['formData']));	
				break;
			//End Bug Functionalities

			//Slideshow Functionalities
			//Add new / edit Slide Recipe
			case "slideshow-add-form": case "slideshow-edit-form": 
				$slideshow = new SlideShow;
				echo json_encode($slideshow->save($_POST['formData']));
				break;

			case "slider-image-upload-form":
				$slideshow = new SlideShow;
				echo json_encode($slideshow->upload_image($_FILES, array(
					'allowedExtensions' => 'png,jpg,jpeg,gif',
					'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/flex_test_images/',
					'successMessage' => 'The Slide has been updated successfully!'
				)));
				$slideshow->update_image_record($_FILES, $_POST['formData']['ss_i']);
				break;

			case "slideshow-delete":
				$slideshow = new SlideShow;
				echo json_encode( $slideshow->delete($_POST['formData']));	
				break;

			case "slideshow-update-status-form":
				$slideshow = new SlideShow;
				echo json_encode( $slideshow->update_status($_POST['formData']));	
				break;
			
			//End SlideShow functionalities

			default:
				echo json_encode($adminController->helpers->returnStatus(500));
				break;
		}
	}else $adminController->redirectTo('logout/');
?>