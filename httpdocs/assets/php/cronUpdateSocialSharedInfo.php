<?php
	require_once('config.php');
	require_once ('class.Dashboard.php');
	require_once ('class.CronSocialMediaUpdate.php');

	$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	//1- Get All Articles Status = Live.
	$articles = $cron->getArticles();
	$month = date('n');
	$year = date('Y');
	$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";
//"69cfa5b227393e90b620098c7883a89e76626fbf";//
	//2- Get Social Media Information From SharedCount for each Article

	foreach( $articles as $article ){
		$cat = $article['cat_dir_name'];
		$url = "http://www.puckermob.com/".$cat."/".$article['article_seo_title'];
		//$url = 'http://www.puckermob.com/fun/16-signs-that-youll-never-be-over-chipotle';

		$url_to_get = "http://free.sharedcount.com/?url=" . rawurlencode($url) . "&apikey=" . $apikey;
		$json = file_get_contents($url_to_get);
		
		$counts = json_decode($json, true);
		//echo $url."</br>";
		
		//3- Insert or Update Social Media Information [table=> social_media_records | condition=> article_id and month ]
		$dashboard->updateSocialMediaShares($counts,  $article['article_id'], $month, $cat);

	}

	//UPDATE CONTRIBUTOR EARNINGS TABLE
	$dashboard->updateContributorsEarnings( $month, $year );


	//4- End ;)
?>