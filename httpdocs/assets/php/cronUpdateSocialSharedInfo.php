<?php
	require_once('config.php');
	require_once ('class.Dashboard.php');
	require_once ('class.CronSocialMediaUpdate.php');

	$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	//1- Get All Articles Status = Live.
	$articles = $cron->getArticles();
	$month = date('n');
	$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";

	//2- Get Social Media Information From SharedCount for each Article

	foreach( $articles as $article ){
		$cat = $article['cat_dir_name'];
		$url = "http://www.puckermob.com/".$cat."/".$article['article_seo_title'];

		//var_dump($article['article_id']);


		//$url = 'http://www.puckermob.com/lifestyle/7-easy-recipes-for-20somethings-who-cant-really-cook';
		//var_dump($url);
		
		$json = file_get_contents("http://free.sharedcount.com/?url=" . rawurlencode($url) . "&apikey=" . $apikey);
		
		$counts = json_decode($json, true);
		//var_dump($url, $counts);
	//	die;
		//3- Insert or Update Social Media Information [table=> social_media_records | condition=> article_id and month ]
		$dashboard->updateSocialMediaShares($counts,  $article['article_id'], $month, $cat );

	}

	//4- End ;)
?>