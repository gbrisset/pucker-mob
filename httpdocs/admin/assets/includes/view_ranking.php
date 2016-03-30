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

var_dump($current_earnings);

?>

<div class="small-12 columns no-padding-right margin-bottom show-for-large-up">
	<div  class="small-12 large-7 xlarge-6 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius" >
			<h3 class="small-12 columns uppercase bold" style="line-height: 1.2;"><span style="color: yellow;">March Incentive:</span> Be ranked in the top 10 at the end of the month and earn and extra $100</h3>
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
			<h3 class="small-12 columns uppercase">U.S. Pageviews</h3>
			<span class="small-12 columns bold"><?php echo '1231231' ?></span>
			<span class="small-12 columns  mini-fonts uppercase show-for-xxlarge-up ">this month</span>

		</div>
	</div>
</div>