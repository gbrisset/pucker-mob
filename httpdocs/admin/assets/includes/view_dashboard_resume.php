<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $current_month = date('n');
	 $current_year = date('Y');
	 $contributor_id = $userData['contributor_id'];
	
	//GET RANK POSITION FOR CURRENT USER.
	 $rank_list = $ManageDashboard->getTopShareWritesRankHeader( $current_month, $current_year);
	 $rank = 'NONE';
	 if(isset($rank_list) && $rank_list ){
		 foreach($rank_list as $rank_pw){
		 	if($contributor_id === $rank_pw['contributor_id']){
		 		$rank = $rank_pw['rownum'];
		 	}
		 }
	 }

	//GET PAGEVIEWS THIS MONTH
	$earnings = $ManageDashboard->getContributorEarningsInfo(  $contributor_id );
	$current_earnings = isset($earnings['total_earnings']) ? $earnings['total_earnings'] : 0;
	$balance_due = isset($earnings['to_be_pay']) ? $earnings['to_be_pay'] : 0;

?>

<div class="small-12 columns no-padding-right margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius">
		<h3 class="small-12 columns uppercase">Current Earnings</h3>
			<span class="small-12 columns bold"><?php echo money_format('%(#10n', $current_earnings); ?></span>
			<span class="small-12 columns  mini-fonts uppercase show-for-xxlarge-up ">this month</span>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius" >
		<h3 class="small-12 columns uppercase">Balance Due</h3>
		<span class="small-12 columns bold"><?php echo money_format('%(#10n', $balance_due); ?></span>
		</div>
	</div>
	<div class="small-12 large-4 xlarge-3 columns  no-padding">
		<div style="background-color: #D79324; " class="small-12 columns articles_resume radius">
			<h3 class="small-12 columns uppercase">Current Rank</h3>
			<span class="small-12 columns bold">#<?php echo $rank; ?></span>
		</div>
	</div>
	<div  class="small-12 large-3 columns  show-for-xlarge-up ">
		<div style="background-color: #3593C6; " class="small-12 columns articles_resume radius">
			<h3 class="small-12 columns uppercase">Level</h3>
			<span class="small-12 columns bold"><?php echo 'PRO ($'. $rate .' CPM)' ?></span>
		</div>
	</div>
</div>