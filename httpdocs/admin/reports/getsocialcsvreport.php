<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	//Verify if is a content provider user
	$content_provider = false;


	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	//if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	$current_month = date('n');
	$current_year = date('Y');

	$total = 0;
	$total_rate = 0;
	$total_shares = 0;
	$total_rev = 0;

	$results = $dashboard->socialMediaSharesReport($_GET);

	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename="social_shares_report.csv"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	
	$headers=array('Contributor_Name', 'Total_Article_Rate', 'Total_Shares', 'Rate_By_Share', 'Share_Rev', 'Total_To_Pay');

	echo(implode(' ',$headers));
	echo("\n");
	echo("\n");

	if(isset($results) && $results ){
		foreach( $results as $contributor){ 
			if( $contributor['total_to_pay'] == 0) continue;
			
			$contributor_type = isset($contributor['user_type']) ? $contributor['user_type'] : '4';
				  		
			if($contributor_type == 2 ){
				$contributor['total_to_pay'] = $contributor['total_to_pay'] - $contributor['total_rate'];
				$contributor['total_rate'] = 0;
			}

			$total = $total + $contributor['total_to_pay'];
			$total_rate = $total_rate + $contributor['total_rate'];
			$total_shares = $total_shares + $contributor['total_shares'];
			$total_rev = $total_rev + $contributor['share_revenue'];

			$row=array( $contributor['contributor_seo_name'],  '$'.$contributor['total_rate'], $contributor['total_shares'], '$'.$contributor['share_rate'], '$'.$contributor['share_revenue'], '$'.$contributor['total_to_pay'] );
			echo(implode(' ',$row));
			echo("\n");
		}

		$footer = array('TOTAL', '$'.$total_rate, $total_shares, '', '$'.$total_rev, '$'.$total);
		echo("\n");
		echo("\n");
		echo(implode(' ',$footer));
		echo("\n");

	}
?>