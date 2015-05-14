<?php 

	require_once('../config.php');
	require_once ('../class.Dashboard.php');
	require_once ('../class.CronSocialMediaUpdate.php');

	$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);

	$month = date('n');
	$year = date('Y');

	if(isset($_POST) && $_POST ){
		$counts = $_POST['counts'];
		$article_id = $_POST['article_id'];
		$cat = $_POST['cat'];
	}

	//3- Insert or Update Social Media Information [table=> social_media_records | condition=> article_id and month ]
	$dashboard->updateSocialMediaShares($counts,  $article_id, $month, $cat);


?>