<?php
require 'config.php';
require 'class.GoogleAnalyticsApi.php';
require 'class.GoogleAnalyticsData.php';

$dashboard = new Dashboard($config);

$GoogleAnalyticsData = new GoogleAnalyticsData($config);

$endDate = date('Y-m-d');
$startDate = date('Y-m').'-01';
$month = date('n');
$year = date('Y');
$data = [];
$articles_data = $dashboard->get_articlesbypageviews_daily($startDate, $endDate);

foreach( $articles_data as $article ){
		$data[] = [
			'article_id' => $article['article_id'],
			'pageviews' => $article['usa_pageviews'],
			'usa_pageviews' => $article['usa_pageviews'],
			'pct_pageviews' =>  100
		];


		$GoogleAnalyticsData->saveGoogleAnalyticsInformationNew($data, $month, $year);

	
}
?>
		
