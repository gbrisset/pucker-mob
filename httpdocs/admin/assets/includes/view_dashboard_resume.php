<?php
	$ManageDashboard = new ManageAdminDashboard( $config );
	$current_month = date('n');
	$current_year = date('Y');

	$contributor_id = isset($contributor_id) ? $contributor_id : $userData['contributor_id'];
	$contributor_type = isset($contributor_type) ? $contributor_type : $userData['user_type'];
	$contributor_type_label = $userData['user_type_label'];



	//get rank position for this month.
	 // $rank = $ManageDashboard-> smf_getContributorRank($contributor_id, $current_month, $current_year);

	//get earnings and pageviews this month
	$earnings = $ManageDashboard->smf_getContributorEarningsInfo(  $contributor_id );
	$current_pageviews = isset($earnings['total_us_pageviews']) ? $earnings['total_us_pageviews'] : 0;

// // ****************************************************************************************************************************************************************************************
// $ddd = new debug($earnings,0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	*******************************************************************************************************
// $ddd = new debug("So far so good ... ",1); $ddd->show(); exit();// ************************************************************************************************************************
// // ****************************************************************************************************************************************************************************************
	
	// $contributor_balance_due = $ManageDashboard->smf_getContributorBalanceDue(  $contributor_id )	;
	// $balance_due = $contributor_balance_due['balance_due'];

	// $rate = $dashboard->get_current_rate( $current_month, $contributor_type );
	// $rate = isset($rate['rate']) ? $rate['rate'] : 0;

$merit_rates = $dashboard->smf_get_merit_rate($current_pageviews, $current_month, $current_year);	
$current_level =  ($merit_rates)? $merit_rates['level'] : "TBD";

?>

<div class="small-12 columns no-padding-right half-margin-bottom show-for-large-up">
	<div  class="small-12 large-6 xlarge-6 columns  no-padding ">
		<div style="background-color: #008000; height: 0; border-right: solid 5px #ffffff;" class="small-12 columns articles_resume radius valign-middle" >
			<div class="small-12 columns ">
				<h3 class="uppercase">
				Your estimated traffic to date (<?php echo date("F") ?>)
			
				<?php echo number_format($current_pageviews,0); ?></h3>
			</div>
		</div>
	</div>
	<div  class="small-12 large-6 xlarge-6 columns  no-padding ">
		<div style="background-color: #008000; height: 0;  border-left: solid 5px #ffffff; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">
				Your estimated level to date (<?php echo date("F") ?>)
			
				<?php echo $current_level; ?></h3>
			</div>
		</div>
	</div>
</div>