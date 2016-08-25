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

		case 'get_chart_data_range':
			echo json_encode($adminController->user->getContributorEarningChartDataRange( $_POST ));
		break;

		case 'get_chart_article_data':
			echo json_encode( $adminController->user->getContributorEarningChartArticleData( $_POST ));
		break;

		case 'get_report_writers_data':
			echo json_encode( $adminController->user->getContributorEarningsData( $_POST ));
		break;

		//ADMIN CONTENT MANAGEMENT
		//Set Alerts
		case 'set_new_alert':
			$data  = [ 	"user_id" => $_POST['user_id'], 
						"message" => $_POST['msg'], 
						"type" => 1 , 
						"date" => date( 'Y-m-d H:s:i', strtotime('now'))
					];
			$notification_obj = new Notification(); 
			echo json_encode( $notification_obj->saveObj( $data ) );
		break;

		//Set HotTopics
		case 'set_hot_topics':
			$hotTopicsObj = new HotTopics();
			$data  = [ 	"hot_topics_id" => 1, 
						"hot_topics_message" => $_POST['hot_topics_message']
					];
			echo json_encode($hotTopicsObj->updateObj($data) );
			
			break;

		//Set HotTopics
		case 'send_email':
			$helpers = new Helpers();
			echo json_encode( $helpers->sendEmailToBloggers($_POST) );
			
			break;
		
		//Set FaceBook Articles to Promote
		case 'promote_articles':
			$promote = new PromoteArticles(); 
			$status = json_encode( $promote->promoteArticles( $_POST) );

			if($status){
			
				if( $_POST['facebook_page_id'] != 7 ){
					$data  = [ 	
							"user_id" => $_POST['user_id'], 
							"message" => "Congratulations! Your article '".$_POST['article_title']."' has been scheduled for promotion on ".$_POST['facebook_page_name'], 
							"type" => 1 , 
							"date" => date( 'Y-m-d H:s:i', strtotime('now'))
						];
					
					$notification_obj = new Notification(); 
					echo json_encode( $notification_obj->saveObj( $data ) );
				}
			}
			
			
			break;

		case 'article_promoted': 
			$promote = new PromoteArticles();
			echo json_encode( $promote->promoteThisArticle( $_POST ) );
			break;

 		//APPROVE AN ARTICLE FOR STARTER BLOGGERS
		case 'approve-article':
	
			$status =  $adminController->updateArticleStatus( $_POST ) ;

			if($status){
				$data  = [ 	"user_id" => $_POST['user_id'], 
							"message" => $_POST['reasons'], 
							"type" => 1 , 
							"date" => date( 'Y-m-d H:s:i', strtotime('now'))
					];
				$notification_obj = new Notification(); 
				
				echo json_encode( $notification_obj->saveObj( $data ) );
			}
			break;
		//REJECT AN ARTICLE FOR STARTER BLOGGERS
		case 'reject-article':
			$status =  $adminController->updateArticleStatus( $_POST ) ;
			if($status){
				$data  = [ 	"user_id" => $_POST['user_id'], 
						"message" => $_POST['msg'], 
						"type" => 1 , 
						"date" => date( 'Y-m-d H:s:i', strtotime('now'))
					];
				$notification_obj = new Notification(); 

				echo json_encode( $notification_obj->saveObj( $data ) );
			}
		break;

		default:
			echo json_encode(array_merge($mpArticleAdmin->returnStatus(500), ['hasError' => true]));
		break;
	}
?>