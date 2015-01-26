<?php

// $name = htmlspecialchars(trim(strip_tags($article["contributor_name"])));
$email = htmlspecialchars(trim(strip_tags($article["contributor_email_address"])));
	$preview_profile = "<section id='about-the-author' class=''>";
//	If 	The user is an admin, show the send notification form
if($adminController->user->data['user_type'] < 3){
		$preview_profile .= "<section class=''>";
			$preview_profile .= "<h2>Send Email Notification</h2>";
		$preview_profile .= "</section>";

		$preview_profile .= "<div class='author-content contributor'>";
			$preview_profile .= "<div class='contribtuor-info'>";
				$preview_profile .= "<div id='author-desc'>";
					$preview_profile .= "<form id='adv-contact-form' name='adv-contact-form' action='' method='POST'>";
						$preview_profile .= "<input type='hidden' name='email' value='".$email."'>";
						$preview_profile .= "<input type='hidden' class='hidden' id='c_t' name='c_t' value='".$_SESSION['csrf']."' >";
						
						$preview_profile .= "<fieldset>";
							$preview_profile .= "<label for='user_email'>To :</label>";
							$preview_profile .= "<p class='disabled-field'>".$email."</p>";
						$preview_profile .= "</fieldset>";
			
						$preview_profile .= "<fieldset>";
							$preview_profile .= "<label for='name'>Subject <span>*</span>:</label>";
							$preview_profile .= "<input type='text' id='subject' name='subject' value='Simpledish Recipe Notification' placeholder='Please enter the subject here.' />";
						$preview_profile .= "</fieldset>";

						$preview_profile .="<fieldset>";
							$preview_profile .="<label for='message'>Message <span>*</span>:</label>";
							$preview_profile .="<textarea name='message' id='message' rows='10' placeholder='Please enter your message here.' required >Your recipe has been approved!  Thank you for contributing to simpledish.com.</textarea>";
						$preview_profile .="</fieldset>";

						$preview_profile .="<fieldset>";
							$preview_profile .="<div class='btn-wrapper'>";
								$preview_profile .="<button type='submit' id='submit' name='contributor-notification-submit'>Send</button>";
								$preview_profile .="<div id='div-result'>";
								$preview_profile .="</div>";
							$preview_profile .="</div>";
						$preview_profile .="</fieldset>";

					$preview_profile .= "</form>";

				$preview_profile .= "</div>";

			$preview_profile .= "</div>";
		$preview_profile .= "</div>";
}
	$preview_profile .= "</section>";


?>
