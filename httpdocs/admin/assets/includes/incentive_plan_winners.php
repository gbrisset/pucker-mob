<?php 
	$prev_month = date('m', strtotime('last month'));
	$author_list = $ManageDashboard->getTopShareWritesRank( $prev_month, 30);

?>
<div class="small-12 xxlarge-7 columns incentive-plan-box no-padding-left margin-bottom margin-top">
	<div class="small-12 columns main-title radius">
		<h3 class="small-12 uppercase">Congrats To the <?php echo date('F Y', strtotime('last month') )?>  Incentive plan winners</h3>
	</div>
	<div class="small-12 columns half-margin-top no-padding merge-box">
		<div class="columns small-12 xlarge-6 radius inner-box border-right">
			
				<h4>Ranked 1-5 ($100 Bonus):</h4>
				<div class="small-12 half-margin-bottom">
					<ol class="row no-margin">
					<?php for( $i = 0; $i< 5; $i++){
						$index  = $i + 1;
					?>
						<li class="small-12 columns" id="cont_id_<?php echo $author_list[$i]['contributor_id']; ?>">
							<div class="small-6 columns no-padding"><p><span><?php echo $index.'.';?></span><?php echo $author_list[$i]['contributor_name']; ?></p></div>
							<div class="small-6 columns no-padding align-right"><p><?php echo number_format($author_list[$i]['total_us_pageviews']).' Visits'; ?></p></div>
						</li>
					<?php }?>
					</ol>
				</div>
			
				
				<h4>Ranked 6-10 ($50 Bonus):</h4>
				<div class="small-12 half-margin-bottom">
				<ol class="row no-margin">
					<?php for( $i = 5; $i< 10; $i++){
						$index  = $i + 1;
					?>
						<li class="small-12 columns" id="cont_id_<?php echo $author_list[$i]['contributor_id']; ?>">
							<div class="small-6 columns no-padding"><p><span><?php echo $index.'.';?></span><?php echo $author_list[$i]['contributor_name']; ?></p></div>
							<div class="small-6 columns no-padding align-right"><p><?php echo number_format($author_list[$i]['total_us_pageviews']).' Visits'; ?></p></div>
						</li>
					<?php }?>
					</ol>
				</div>
		</div>
			<div class="columns small-12 xlarge-6 radius inner-box">
				
				<h4>Ranked 11-20 ($10 Bonus):</h4>
				<div class="small-12 half-margin-bottom">
					<ol class="row no-margin">
					<?php for( $i = 10; $i< 20; $i++){
						$index  = $i + 1;
					?>
						<li class="small-12 columns" id="cont_id_<?php echo $author_list[$i]['contributor_id']; ?>">
							<div class="small-6 columns no-padding"><p><span><?php echo $index.'.';?></span><?php echo $author_list[$i]['contributor_name']; ?></p></div>
							<div class="small-6 columns no-padding align-right"><p><?php echo number_format($author_list[$i]['total_us_pageviews']).' Visits'; ?></p></div>
						</li>
					<?php }?>
					</ol>
				</div>

		
			<div class="incentive-plan-msg">
				<p>Great Job everyone!</br>
				Don't forget to check out this month's incentive program</p>
			</div>
		</div>
	</div>
</div>