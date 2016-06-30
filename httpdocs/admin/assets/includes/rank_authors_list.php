<?php 
	if( isset($rank_list) && count($rank_list) > 0 ){
		$index = 1;
?>
<div class = "small-12 columns no-padding">
	<table  class="small-12 large-6 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php 
				for( $j = 0; $j < 20; $j ++ ){ 
					$bonus = 100;
					if($j > 4 ) $bonus = 50;
					if($j > 9 ) $bonus = 25;
			?>

				<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
					<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					<td class="align-center" style="    color: green; font-size: 1rem;">$<?php echo $bonus; ?></td>
				</tr>
			<?php 
				$index++;
			} ?>
		</tbody>
	</table>

	<table  class="small-12 large-6 columns incentive-second-table">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php 
				for( $j = 20; $j < 40; $j++ ){ 
					$bonus = 10;
					if($j > 30 ) $bonus = 0;
				?>
				<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
					<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					<td class="align-center" style="color: green; font-size: 1rem;">$<?php echo $bonus; ?></td>
				</tr>
			<?php $index++;
			} ?>
		</tbody>
	</table>
</div>
<?php } ?>