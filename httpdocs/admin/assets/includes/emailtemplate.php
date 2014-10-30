<?php
$catBg = '#01b88a';
switch ($options['action']) {
	case 'login':
		$h2 = 'Welcome back '.$options['username'].' to '.$this->mpArticle->data['article_page_visible_name'];
		break;
	case 'reset the password for':
		$h2 = 'You are about to reset the password for the PuckerMob account with email, '.$options['email'];
		$h3 = 'Your username for this account is: '.$options['username'].'.';
		break;
	
	default:
		$h2 = 'Thank you, '.$options['username'].' for registering';
		break;
}

$body = '<html>';
	$body .= '<body>';
		$body .= '<div id="email-cont" style="margin: 0px auto; width: 100%; padding: 0px; position: relative; max-width: 500px; min-height: 600px;">';
			$body .= '<div style="position: relative; text-align: center; border-bottom: 3px solid rgb(238, 238, 238); padding: 1.5%;">';
				//$body .= '<img style="max-height:8em;" src="'. $this->config['image_url'].'articlesites/logos/'.$this->mpArticle->data['article_page_logo'].'" alt="'. $this->mpArticle->data['article_page_visible_name'].' Logo" />';
			$body .= '</div>';
	
			$body .= '<div id="login-email-cont" class="admin-email-cont" style="position: relative; margin: 0px auto; width: 94%; padding: 3%;">';
				$body .= '<h2 style="color:'.$catBg.'; font: 2em arial,sans-serif;">'.$h2.'</h2>';
				(isset($h3)) ? $body .= '<h3 style="color:'.$catBg.'; font: 1.2em arial,sans-serif;">'.$h3.'</h3>' : '';
				$body .= '<div>';
					$body .= '<p style="margin-top:6%;">Please click below to '.$options['action'].' your account.</p>';
					$body .= '<a href="'.$options['hashUrl'].'">';
						$body .= '<label style="color: #01b88a; text-decoration: underline; cursor:pointer; width:600px;">'.$options['hashUrl'].'</label>';
					$body .= '</a>';
					$body .= '<p style="margin-top:6%;">If the above link does not work, copy and paste it into the browser.</p>';
				$body .= '</div>';
				$body .= '<div class="email-info-massage">';
					$body .= '<p>Link will expire after 15 minutes.</p>';
					$body .= '<p style="color: rgb(128, 128, 128) !important;">';
						$body .= 'You received this email because you signed up for Simple Dish. ';
						$body .= 'Be sure to add info@sequelmediagroup.com to your address book so ';
						$body .= 'that important notices about your account don\'t get lost.';
					$body .= '</p>';
				$body .= '</div>';
			$body .= '</div>';
		$body .= '</div>';
	$body .= '</body>';
$body .= '</html>';
?>