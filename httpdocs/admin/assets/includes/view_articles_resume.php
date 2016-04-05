<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $current_month = date('n');
	 $current_year = date('Y');
	 $contributor_id = $userData['contributor_id'];
	
	//GET RANK POSITION FOR CURRENT USER.
	 $rank_list = $ManageDashboard->getTopShareWritesRankHeader( $current_month, $current_year);
	 $rank = '9999';
	 if(isset($rank_list) && $rank_list ){
		 foreach($rank_list as $rank_pw){
		 	if($contributor_id === $rank_pw['contributor_id']){
		 		$rank = $rank_pw['rownum'];
		 	}
		 }
	}

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

<div class="small-12 columns  no-padding margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius">
		<h3 class="small-12 columns uppercase">Live Articles</h3>
			<span class="small-12 columns bold"><?php echo $onLive; ?></span>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius" >
		<h3 class="small-12 columns uppercase">Articles in Draft</h3>
		<span class="small-12 columns bold"><?php echo $onDraft; ?></span>
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
			<h3 class="small-12 columns uppercase">Total U.S. Visits</h3>
			<span class="small-12 columns bold"><?php echo money_format('%(#10n', $pageviews); ?></span>
			<span class="small-12 columns  mini-fonts uppercase show-for-xxlarge-up ">this month</span>
		</div>
	</div>
</div>