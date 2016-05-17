<?php 
	if( isset($rank_list) && count($rank_list) > 0 ){


?>
<div class = "small-12 columns no-padding">
<?php 

	$index = 1;
	
?>

	<table  class="small-12 large-6 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
		</thead>
		<tbody>
			<?php 
				for( $j = 0; $j < 10; $j ++ ){ ?>
					<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
						<td style="padding-left: 20px; "><?php echo $index; ?></td>
						<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
						<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
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
		</thead>
		<tbody>
			<?php 
				for( $j = 10; $j < 20; $j++ ){ ?>
					<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
						<td style="padding-left: 20px; "><?php echo $index; ?></td>
						<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
						<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					</tr>
			<?php 
				$index++;
			} ?>
		</tbody>
	</table>
</div>
<?php } ?>