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

$body .= '<body alink="#ffffff" bgcolor="#FFFFFF" link="#ffffff" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333333;">';
	$body .= '<table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="background-color: #157910;">';
		$body .= '<tbody>';
		$body .= '<tr>';
			$body .= '<td style="background-color:#ffffff;padding: 5px 0;margin-bottom: 0;padding-bottom: 0;">';
				$body .= '<img align="right" border="0" src="http://www.puckermob.com/assets/img/internal-mail-image.jpg" style=" width: 100%" />';
			$body .= '</td>';
		$body .= '</tr>';
		$body .= '<tr>';
			$body .= '<td width="200" style="background: #fff;padding: 10px;border: 1px solid green;border-top: none;">';
				$body .= '<div style="text-align: center;"><h2>PUCKER<span style="color: green;">MOB</span></h2></div>';
				$body .= '<div>';
			$body .= '<div id="login-email-cont" class="admin-email-cont" style="position: relative; margin: 0px auto; width: 94%; padding: 3%;">';
				$body .= '<h2 style="color:green; font: 2em Oslo,sans-serif;">'.$h2.'</h2>';
				(isset($h3)) ? $body .= '<h3 style="color:green; font: 1.2em arial,sans-serif;">'.$h3.'</h3>' : '';
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
						$body .= 'You received this email because you signed up for PuckerMob. ';
						$body .= 'Be sure to add info@sequelmediainternational.com to your address book so ';
						$body .= 'that important notices about your account don\'t get lost.';
					$body .= '</p>';
				$body .= '</div>';
			$body .= '</div>';
		$body .= '</div>';

$body .= '</td>';
$body .= '</tr>';
$body .= '<tr style=" background: #ddd;">';
			$body .= '<td width="200" style="background-color:#ffffff;padding: 10px;color: #fff;border: 1px solid green;background: green;">';
				$body .= '<div style="text-align: center;">';
					$body .= '<p style="text-align:right; margin:0" ><a style="color: #ddd; font-size: 12px; cursor: pointer;" href="http://www.puckermob.com/admin" target="blank">LOGIN</a></p>';
				$body .= '</div>	';
			$body .= '</td>';
		$body .= '</tr>';
		$body .= '</tbody>';
	$body .= '</table>';
$body .= '</body>';