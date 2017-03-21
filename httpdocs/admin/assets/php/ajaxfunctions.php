<?php
	$admin = true;
	require_once('../../../assets/php/config.php');

var_dump($_POST); 

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

		//ADD NEW ARTICLE
		case 'unfollow-author':
			$author_id = $_POST['author_id'];
			$reader_email = $_POST['reader_email'];
			echo json_encode($follow->unfollowAuthor($author_id, $reader_email));
		break;

		case 'article_ads':
			echo json_encode($mpArticleAdmin->getArticleAds($_POST));
		break;

		case 'pay_contributors':
			// echo json_encode($adminController->user->setContributorEarningsPaid($_POST));// old - flawed - GB 2017-03-20
			echo json_encode($adminController->user->smf_setContributorEarningsPaid($_POST));// new - in alignment with new payday_date field - GB 2017-03-20
			// echo("Blah Blah Blah ");// Using GET to test
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

		case 'get_chart_article_data_per_day':
			echo json_encode( $adminController->user->getContributorEarningChartArticleDataPerDay( $_POST ));
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
			
			json_encode( $promote->promoteArticles( $_POST) );

			break;

		case 'article_promoted': 
			$promote = new PromoteArticles();
			$status =  json_encode( $promote->promoteThisArticle( $_POST ) );

			if($status){
				//var_dump($status, $_POST);  
				if( $_POST['promoted'] == 'true'  ){
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

		case 'article_status':
			echo json_encode( $adminController->updateArticleStatus( $_POST ) ) ;
			break;

		case 'publish-article':
			echo json_encode( $adminController->publishNewArticle( $_POST ) );
		 	break;

		 case 'save-article':
		 	echo json_encode( $adminController->saveNewArticle( $_POST ) );
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

		//ORDERS
		case 'submit_order':
			$OrderObj = new OrderAds();
			$AdMatchingTransactions = new AdMatchingTransactions();
			$contributor = new Contributor();
			$helpers = new Helpers();
			$contributor_info = $contributor->getContributorById($_POST['contributor_id']);
			$dataTrans = [
				'contributor_id' => $_POST['contributor_id'],
				'spent'   => 0,
				'balance' => $_POST['total_commit'],
				'date'    => $_POST['date'],
				'receipt' => 1
			];

			$msg = $helpers->getEmailTemplate($config, 'ad_matching_tp', $_POST);
			$email_data = [
				'email_add' => $contributor_info->contributor_email_address,
				'email_msg' => $msg,
				'subject'   => 'Congratulations! You’ve signed up for Ad Matching.'
			];

			$order = $OrderObj->saveObj($_POST);
			if( $order ){
				if( $AdMatchingTransactions->saveObj( $dataTrans ) )
					$helpers->sendEmailToBloggers($email_data);

			}
			echo json_encode( $order ); 
		break;

		case 'get_form_history':
			$AdMatchingTransactions = new AdMatchingTransactions(); 
			$transactions = $AdMatchingTransactions->where('contributor_id = '.$_POST['contributor_id'].' ORDER BY id DESC LIMIT 1');
 			$balance = ( isset($transactions)  && $transactions ) ? $transactions->balance : 0;
			echo $AdMatchingTransactions->generateForm( $_POST['contributor_id'], $balance ); 
		break;
		
		case 'save-transaction':
			$AdMatchingTransactions = new AdMatchingTransactions();
			$data = isset($_POST['formData']) ? $_POST['formData'] : $_POST;
			$data['receipt'] = ( $data['receipt'] === "on") ? 1 : 0;
			$transactions = $AdMatchingTransactions->where('contributor_id = '.$data['contributor_id'].' ORDER BY id DESC LIMIT 1');
			$currentBalance = ( isset($transactions[0])  && $transactions[0] ) ? $transactions[0]->balance : 0;
			$spent = isset($data['spent']) ? $data['spent'] : 0;
			$newBalance = $currentBalance - $spent;
			$data['balance'] = $newBalance; 

			$result = $AdMatchingTransactions->saveObj( $data );
			$data['date'] =date("n/d/Y", strtotime($data['date']));
			$data['spent'] ='$'.number_format( $data['spent'], 2);
			$data['balance'] ='$'.number_format( $data['balance'], 2);
			$result['data'] = $data;
			echo json_encode( $result );
		break;

		default:
			echo json_encode(array_merge($mpArticleAdmin->returnStatus(500), ['hasError' => true]));
		break;
	}
?>