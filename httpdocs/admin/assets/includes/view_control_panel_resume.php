<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $ContributorEarnings = new ContributorEarnings();
	 
	 $current_month = date('n');
	 $current_year = date('Y');
	

	//WRITERS EARNINGS & EANRINGS CURRENT MONTH
 	$writers_traffic = $ContributorEarnings->getEarningsPerUserType(" 6, 7 ", " and month = $current_month and year = $current_year "); 
 	$total_tf_wr = $total_te_writers = 0;
 	foreach ($writers_traffic as $wt) {
 		$total_tf_wr+= $wt->pageviews;
 		$total_te_writers += $wt->total_earnings;
 	}
 	//BOOGLER TRAFFIC & EANRINGS CURRENT MONTH
	$bloggers_traffic = $ContributorEarnings->getEarningsPerUserType(" 3, 8, 9 ", " and month = $current_month and year = $current_year ");
 	$total_tf_bg =  $total_te_bloggers = 0;
 	foreach ($bloggers_traffic as $bt) {
 		$total_tf_bg+= $bt->pageviews;
 		$total_te_bloggers += $bt->total_earnings;
 	}
 ?>

<div class="small-12 columns no-padding-right half-margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">WRITER TRAFFIC</h3>
				<span class="bold"><?php echo number_format($total_tf_wr); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius valign-middle" >
			<div class="small-12 columns ">
				<h3 class="uppercase">Writer Earnings</h3>
				<span class="bold"><?php echo '$'.number_format( $total_te_writers, 2); ?></span>
			</div>
		</div>		
	</div>
	<div class="small-12 large-4 xlarge-3 columns  no-padding">
		<div style="background-color: #D79324; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Blogger Traffic</h3>
				<span class="bold"><?php echo number_format($total_tf_bg); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-3 columns  show-for-xlarge-up ">
		<div style="background-color: #3593C6; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Blogger Earnings</h3>
				<span class="bold" ><?php echo '$'. number_format($total_te_bloggers, 2) ?></span>
			</div>
		</div>
	</div>
</div>
