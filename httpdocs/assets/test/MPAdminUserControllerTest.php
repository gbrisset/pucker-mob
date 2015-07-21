<?php 

	require_once('../php/config.php');

	$dataInfo = ['contributor_id' => 1103, 'start_date' => '2015-07-07', 'end_date' => '2015-07-19'];
	//$google = $adminController->user->getTotalPageViewsDateRange($dataInfo);
	$data = $adminController->user->getContributorEarningsData( $dataInfo );


	foreach($data as $contributor ){
	
		echo $contributor['contributor_name'].'----'.$contributor['pageviews']['us_pageviews'].'</br>';
	}

?>