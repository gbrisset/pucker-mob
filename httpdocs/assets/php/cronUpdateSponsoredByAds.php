<?php
	require_once('config.php');
	require_once ('class.CronSocialMediaUpdate.php');

	$hasSponsored = $mpArticle->data['has_sponsored_by'];

	$cron = new CronSocialMediaInformation($config);
	
	$value = 0;
	if( $hasSponsored == 0) $value = 1;
	
	//var_dump($cron->updateSponsoredByAds($value));

?>