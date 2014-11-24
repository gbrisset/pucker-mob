<?php
	require_once('config.php');
	require_once ('class.Dashboard.php');
	require_once ('class.CronSocialMediaUpdate.php');

	$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	//1- Get All Articles Status = Live.
	$articles = $cron->getArticles();
	$month = date('n');


	//2- Get Social Media Information From SharedCount for each Article

	foreach( $articles as $article ){
		$url = "http://puckermob.com/".$article['cat_dir_name']."/".$article['article_seo_title'];
		//var_dump($url);
		$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";
		$json = file_get_contents("http://free.sharedcount.com/?url=" . rawurlencode($url) . "&apikey=" . $apikey);
		
		$counts = json_decode($json, true);

		//3- Insert or Update Social Media Information [table=> social_media_records | condition=> article_id and month ]
		$dashboard->updateSocialMediaShares($counts,  $article['article_id'], $month );

	}

	//4- End ;)
?>