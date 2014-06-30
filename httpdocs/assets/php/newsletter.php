<?php
	if(isset($_POST['newslettersubmit'])){
		//$firstName = trim(preg_replace('/[^A-Za-z]/', '', $_POST['fname']));
		//$lastName = trim(preg_replace('/[^A-Za-z]/', '', $_POST['lname']));
		$emailAddress = trim($_POST['emailinput']);
		$newsLetterStatus = false;
		$hasError = false;
		$newsLetterStatusMsg = "One or more required fields are incorrect.  Please try again.";
		//if(!strlen($firstName) || $firstName == "First Name"){
		//	$newsLetterStatusMsg = "Oops! Your first name is a required field.";
		//	$hasError = true;
		//}else 
		if(!strlen($emailAddress) || $emailAddress == "Email Address"){
			$newsLetterStatusMsg = "Oops! Your email address is a required field.";
			$hasError = true;
		}

		if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
		    $newsLetterStatusMsg = "Oops! Your email address is not valid.";
		    $hasError = true;
		}

		//if($lastName == 'LastName' || $lastName == 'Last Name') $lastName = '';

		if(!$hasError){
			$mailChimpAPI = new MCAPI($mpArticle->data['article_page_newletter_api_key']);
			$mergeVars = [
			//	'FNAME' => $firstName,
			//	'LNAME' => $lastName
			];
			$returnVal = $mailChimpAPI->listSubscribe($mpArticle->data['article_page_newletter_list_id'], $emailAddress, $mergeVars);
			if($mailChimpAPI->errorCode){
				if($mailChimpAPI->errorCode == 214) $newsLetterStatusMsg = "Oops! Looks like you're already signed up for our newsletter!";
				else $newsLetterStatusMsg = "Oops! Something went wrong.  Please try again.";
			}else{
				$newsLetterStatus = true;
				$newsLetterStatusMsg = "Thanks for signing up!  Please check your email.";
			}

			//$_POST['fname'] = $_POST['lname'] = 
			$_POST['emailinput'] = null;
		}
	}
?>