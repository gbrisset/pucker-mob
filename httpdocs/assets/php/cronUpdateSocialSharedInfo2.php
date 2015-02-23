<?php
	require_once('config.php');
	require_once ('class.SocialMediaManage.php');

	$socialmedia = new SocialMediaManage($config);
	var_dump($_GET, $_POST);
	$url = $_GET['urls'];
	//'http://www.puckermob.com/lifestyle/14-things-only-overthinkers-will-understand';
	echo $url;
	echo "=====================================";
	if($url){
		$results = $socialmedia->extractDataFromSocialMediaNetworks($url);
		var_dump($results);
	}
	

?>