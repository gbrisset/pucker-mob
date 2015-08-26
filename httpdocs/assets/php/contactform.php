<?php 
	if(isset($_POST['contactsubmit'])){
		$name = trim(preg_replace('/[^A-Za-z]/', '', $_POST['name']));
		$compname = isset($_POST['companyname']) ? trim($_POST['companyname']) : NULL;
		$emailAddress = trim($_POST['email']);
		$message = trim($_POST['message']);
		$phonenumber = trim($_POST['phonenumber']);
		$formStatus = false;
		$hasError = false;
		$formStatusMsg = "One or more required fields are incorrect.  Please try again.";
		
		if(!strlen($name) || $name == "Please enter your name here"){
			$formStatusMsg = "Oops! Your name is a required field.";
			$hasError = true;
		}else if(!strlen($emailAddress) || $emailAddress == "Please enter your email address here."){
			$formStatusMsg = "Oops! Your email address is a required field.";
			$hasError = true;
		}else if(!strlen($message) || $message == "Please enter your message here.!"){
			$formStatusMsg = "Oops! Your Message is a required field.";
			$hasError = true;
		}

		if(!$hasError){
			$sitename = $mpArticle->data['article_page_visible_name'];
			$to =  'jmiletsky@sequelmediainternational.com';
			$subject = $name.' wants to contact us! - '.$sitename;
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$name.' <'.$emailAddress."> \n";
			$headers .= 'Reply-To: '.$name.' <'.$emailAddress."> \n\n";
			
			$body = '';
			$body .= '<html>';
				$body .= '<head></head>';
				$body .= '<body>';
					$body .= '<p>A new message has been received from '.$name.'</p>';
					$body .= '<p><strong>Name:</strong> '.$name.'</p>';
			
					if( isset($compname) ) $body .= '<p><strong>Company Name:</strong> '.$compname.'</p>';
			
					$body .= '<p><strong>E-mail:</strong>'.$emailAddress.'</p>';
					$body .= '<p><strong>Phone Number:</strong> '.$phonenumber.'</p>';
					$body .= '<p><strong>Message:</strong> '.$message.'</p>';
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