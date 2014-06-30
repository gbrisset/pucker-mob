<?php 
	if(isset($_POST['contributor-notification-submit']) && $adminController->checkCSRF($_POST)){
	
		$to = trim($_POST['email']);
		$fromEmailAddress = "info@simpledish.com";
		$name = "Simpledish";
		$subject = trim($_POST['subject']);
		$message = trim($_POST['message']);
		$formStatus = false;
		$hasError = false;
		$formStatusMsg = "One or more required fields are incorrect.  Please try again.";

		if(!$hasError){
			$sitename = $mpArticle->data['article_page_visible_name'];
			$subject = $subject.' - '.$sitename;
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$name.' <'.$fromEmailAddress."> \n";
			$headers .= 'Reply-To: '.$name.' <'.$fromEmailAddress."> \n\n";
			
			$body = '';
			$body .= '<html>';
				$body .= '<head></head>';
				$body .= '<body>';
					$body .= '<p>';
						$body .= 'This is an email notification from simpledish.com!';
					$body .= '</p>';
					$body .= '<p>';
						$body .= 'We\'re pleased to let you know that your recently uploaded recipe, '.$article['article_title'].', has been set to LIVE!';
					$body .= '</p>';

				$body .= '</body>';
			$body .= '</html>';
			
			if ( mail($to, $subject, $body, $headers) ) {
				$formStatus = true;
				$formStatusMsg = "Message successfully sent!";
			}else {
				$formStatusMsg ="Message delivery failed. Please try again!";
			}
		}
	}
?>