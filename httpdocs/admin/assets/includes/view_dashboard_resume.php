<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $current_month = date('n');
	 $current_year = date('Y');

	 $contributor_id = isset($contributor_id) ? $contributor_id : $userData['contributor_id'];



	//get rank position for this month.
	 $rank = $ManageDashboard-> smf_getContributorRank($contributor_id, $current_month, $current_year);

	//get earnings and pageviews this month
	$earnings = $ManageDashboard->smf_getContributorEarningsInfo(  $contributor_id );
	$current_earnings = isset($earnings['total_earnings']) ? $earnings['total_earnings'] : 0;
	
	$contributor_balance_due = $ManageDashboard->smf_getContributorBalanceDue(  $contributor_id );
	$balance_due = $contributor_balance_due['balance_due'];
	 // $ddd = new debug($balance_due,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

	$contributor_type = isset($contributor_type) ? $contributor_type : $userData['user_type'];

	switch( $contributor_type ){
		case 1:
		case 99:
		case 6:
		case 7:
			$contributor_type_label = 'Admin';
			break;

		case 3:
			$contributor_type_label = 'Community';
			break;
		case 8: case 9:
			$contributor_type_label = 'PRO';
			break;

		case 0: case 5:
			$contributor_type_label = 'Suspended';
			break;
		default:
			$contributor_type_label = 'Starter';
			break;
	} 
	
	//$contributor_type_label = $userData['user_type_label'];
	$rate = $dashboard->get_current_rate( $current_month, $contributor_type );
	$rate = isset($rate['rate']) ? $rate['rate'] : 0;



?>

<div class="small-12 columns no-padding-right half-margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Est. Earnings<span style="color: #fff; font-size: 12px; top: -3px; position: relative;"> (THIS MONTH)</span></h3>
				<span class="bold"><?php echo '$'.number_format($current_earnings, 2); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius valign-middle" >
			<div class="small-12 columns ">
				<h3 class="uppercase">Balance Due</h3>
				<span class="bold"><?php echo '$'.number_format( $balance_due, 2); ?></span>
			</div>
		</div>		
	</div>
	<div class="small-12 large-4 xlarge-3 columns  no-padding">
		<div style="background-color: #D79324; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Current Rank</h3>
				<span class="bold">#<?php echo $rank; ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-3 columns  show-for-xlarge-up ">
		<div style="background-color: #3593C6; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Level</h3>
				<span class="bold" style="font-size: 22px;"><?php echo $contributor_type_label.' <br/>$'. number_format($rate, 2) .' CPM' ?></span>
			</div>
		</div>
	</div>
</div>