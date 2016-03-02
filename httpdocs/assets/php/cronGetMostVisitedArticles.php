<?php

require 'config.php';
require 'class.GoogleAnalyticsApi.php';
require 'class.GoogleAnalyticsData.php';

$GoogleAnalyticsApi = new GoogleAnalyticsApi($config);
$GoogleAnalyticsData = new GoogleAnalyticsData($config);

$client = $GoogleAnalyticsApi->connect_to_client();

// Create Google Service Analytics object with our preconfigured Google_Client
$analytics = new Google_Service_Analytics($client);

$date = date('Y-m-d');
$prev_date = date('Y-m-d', strtotime($date .' -1 day'));
$startDate = $prev_date;
$endDate = $prev_date;
$params = [
			'dimensions' => 'ga:pagePath,ga:pageTitle',
			'sort' => '-ga:pageviews',
			'max-results' => '50'
		];
?>
<html>

<head>
	<title>GOOGLE API </title>
</head>
	<body>
			<?php

				$articles = $GoogleAnalyticsData->queryGoogleAnalyticsInformation($analytics, $startDate, $endDate, $params);
				$arrArticles = [];
				if($articles){
					foreach( $articles as $article){
						echo '<br>';
						$title = $article[1];
						$path = $article[0];
						$pageviews = $article[2];
						$arr = [];
						$urlArr = explode("/", $path);
						$seo = $urlArr[2];

						$arr['title'] = $title;
						$arr['url'] = $path;
						$arr['pageviews'] = $pageviews;
						$arr['seo_title'] = $seo;

						$arrArticles[] = $arr;
						echo "THIS IS ARTICLE ".$title." WITH #PAGEVIEWS ".$pageviews;
						echo "<br>";
					}

				}
				
				$GoogleAnalyticsData->removeGoogleAnalyticsMostViewArticles();
				$insert = $GoogleAnalyticsData->saveGoogleAnalyticsMostViewArticles($arrArticles);
				

				?>

	</body>
</html>