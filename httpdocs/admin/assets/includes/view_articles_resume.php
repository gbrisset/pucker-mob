<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $current_month = date('n');
	 $current_year = date('Y');
	 $contributor_id = $userData['contributor_id'];
	
	// //GET RANK POSITION FOR CURRENT USER.
	//  $rank_list = $ManageDashboard->getTopShareWritesRankHeader( $current_month, $current_year);
	//  $rank = '9999';
	//  if(isset($rank_list) && $rank_list ){
	// 	 foreach($rank_list as $rank_pw){
	// 	 	if($contributor_id === $rank_pw['contributor_id']){
	// 	 		$rank = $rank_pw['rownum'];
	// 	 	}
	// 	 }
	// }

	//GET RANK POSITION FOR CURRENT USER.
	 $rank = $ManageDashboard-> smf_getContributorRank($contributor_id, $current_month, $current_year);


	//ARTICLES IN CURRENTLY LIVE AND DRAFT
	$onDraft = 0;
	$onLive = 0;
	$onLive = $mpArticle->countFiltered('1', '1', $userArticlesFilter, 'all');
	$onDraft = $mpArticle->countFiltered('1', '3', $userArticlesFilter, 'all');

	//GET PAGEVIEWS THIS MONTH
	$earnings = $ManageDashboard->getContributorEarningsInfo(  $contributor_id );
	$pageviews = 0;
	if(isset($earnings['total_us_pageviews'])) $pageviews = $earnings['total_us_pageviews'];

?>

<div class="small-12 columns  no-padding half-margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Live Articles</h3>
				<span class="bold"><?php echo number_format($onLive); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius valign-middle" >
			<div class="small-12 columns ">
				<h3 class="uppercase">Draft Articles</h3>
				<span class="bold"><?php echo number_format($onDraft); ?></span>
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
				<h3 class="uppercase">U.S. Visits<span style="color: #fff; font-size: 12px; top: -3px; position: relative;"> (THIS MONTH)</span></h3>
				<span class="bold"><?php echo number_format($pageviews); ?></span>
			</div>
		</div>
	</div>
</div>