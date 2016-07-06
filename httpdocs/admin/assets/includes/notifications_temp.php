<?php 
	$lm = date('m', strtotime('last month'));
	$earnings_lm = $ManageDashboard->getLastMonthEarningsInfo( $contributor_id, $lm, date('Y'));

?>
<div class="columns small-12 notification-msg margin-top radius">
<?php if( $pro_blogger ){
		echo '<p>To maintain Pro status: do not let traffic fall below 25,000 for two months in a row</p>';
	}else{
		if( !is_null($earnings_lm) && $earnings_lm ){
			if( $earnings_lm['total_us_pageviews'] > 25000 ) echo '<p>Great job! You had over 25,000 visits last month. Do that again this month, and you’ll be made Pro</p>';
			else echo '<p>Get over 25,000 visits for two months in a row and be promoted to Pro level</p>';
		}
	} ?>
</div>