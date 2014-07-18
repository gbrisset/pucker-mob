<?php
$catBg = $mpArticle->data['article_page_bar_color'];
//$h2 = 'Hi '.$options['contributor-name'].'!. You have a notification from Simple Dish';
$h2 = 'Hi! You have a notification from Simple Dish';
$url = $options['article-url'];

$body = '<html>';
	$body .= '<body>';
		$body .= '<div id="email-cont" style="margin: 0px auto; width: 100%; padding: 0px; position: relative; max-width: 500px; min-height: 600px;">';
			$body .= '<div style="position: relative; text-align: center; border-bottom: 3px solid rgb(238, 238, 238); padding: 1.5%;">';
				$body .= '<img style="max-height:8em;" src="'. $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_logo'].'" alt="'. $mpArticle->data['article_page_visible_name'].' Logo" />';
			$body .= '</div>';
	
			$body .= '<div id="login-email-cont" class="admin-email-cont" style="position: relative; margin: 0px auto; width: 94%; padding: 3%;">';
				$body .= '<h2 style="color:'.$catBg.'; font: 1.5em arial,sans-serif;">'.$h2.'</h2>';
				$body .= '<div>';
					$body .= '<p style="margin-top:6%;">Someone added a new comment to your article "'.$options['article-title'].'", please click the link below to take a look at what they are saying about it.</p>';
					$body .= '<a style="color: #d73226; text-decoration: underline; cursor:pointer;" href="'.$url.'">';
						$body .= $url;
					$body .= '</a>';
				$body .= '</div>';
				$body .= '<div class="email-info-massage">';
					$body .= '<p style="color: rgb(128, 128, 128) !important;">';
						$body .= '';
					$body .= '</p>';
				$body .= '</div>';
			$body .= '</div>';
		$body .= '</div>';
	$body .= '</body>';
$body .= '</html>';
?>