<?php
	require_once('config.php');

	 $options = array_merge(array(
		'emails' => '',
		'article-url' => '',
		'article-title' => '',
		'contributor-name' => '',
		'contributor-email' => ''
	), $_POST);

	if((isset($_POST['emails']))) {
	  
	   	$body='';
	   	$subject="Notification From Simple Dish";
		include_once($config['include_path'].'emailtemplate.php');
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "From: ".$mpArticle->data['article_page_visible_name']." <".$mpArticle->data['article_page_contact_email']."> \n";
		
		if(!$mailSent = mail($options['emails'], $subject, $body, $headers)) 
			$infoObj = [
				'hasError' => true
			];
		else
			$infoObj = [
				'hasError' => false
			];

		 echo json_encode( $infoObj );
		
	}
?>



